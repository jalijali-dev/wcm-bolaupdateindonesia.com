<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/auth.php';
require_once dirname(__DIR__) . '/config/database.php';

/**
 * AJAX image upload for the Media Library picker modal
 * (includes/tinymce-media-picker.php). Same validation rules as the
 * upload branch in pages/media-library.php (extension + finfo MIME check,
 * 5 MB cap, random-suffixed filename under /uploads/media/YYYY/MM/) and the
 * same media_library row shape — but images only, and answers with JSON so
 * the modal can add the new thumbnail to its grid without a reload.
 *
 * POST multipart: media_file (+ X-CSRF-Token header, verified by auth.php).
 */

header('Content-Type: application/json');

$fail = static function (string $message, int $status = 400): never {
    http_response_code($status);
    echo json_encode(['ok' => false, 'error' => $message]);
    exit;
};

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    $fail('Method not allowed', 405);
}

$file = $_FILES['media_file'] ?? null;
if (!is_array($file) || (int) ($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
    $fail('Tidak ada file yang dikirim.');
}
if ((int) $file['error'] !== UPLOAD_ERR_OK) {
    $fail('Upload gagal (kode error ' . (int) $file['error'] . ').');
}

$tmpName  = (string) ($file['tmp_name'] ?? '');
$origName = (string) ($file['name'] ?? '');
$bytes    = (int) ($file['size'] ?? 0);

if ($tmpName === '' || !is_uploaded_file($tmpName) || $bytes <= 0) {
    $fail('File upload tidak valid atau kosong.');
}
if ($bytes > 5 * 1024 * 1024) {
    $fail('Ukuran gambar melebihi batas 5 MB.');
}

$clientExt = strtolower(pathinfo($origName, PATHINFO_EXTENSION));
if (!in_array($clientExt, ['jpg', 'jpeg', 'png', 'webp', 'gif'], true)) {
    $fail('Format tidak didukung. Gunakan JPG, PNG, WebP, atau GIF.');
}

$mimeExtMap = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp', 'image/gif' => 'gif'];
$detectedMime = (string) ((new finfo(FILEINFO_MIME_TYPE))->file($tmpName) ?: '');
if (!isset($mimeExtMap[$detectedMime])) {
    $fail('Isi file bukan gambar yang didukung.');
}
$ext = $mimeExtMap[$detectedMime];

$projectRoot  = CMS_PROJECT_ROOT;
$guardContent = "<?php\ndeclare(strict_types=1);\n\nhttp_response_code(403);\nexit('Forbidden');\n";
$relBase = 'uploads/media';
$relYear = $relBase . '/' . date('Y');
$relDir  = $relYear . '/' . date('m');
$diskDir = $projectRoot . '/' . $relDir;

if (!is_dir($diskDir) && !mkdir($diskDir, 0755, true) && !is_dir($diskDir)) {
    $fail('Folder upload tidak bisa dibuat.', 500);
}
foreach ([$relBase, $relYear, $relDir] as $level) {
    $guardFile = $projectRoot . '/' . $level . '/index.php';
    if (!file_exists($guardFile)) {
        file_put_contents($guardFile, $guardContent);
        @chmod($guardFile, 0644);
    }
}

$base = trim((string) (preg_replace('/[^a-z0-9_-]+/', '-', strtolower(pathinfo($origName, PATHINFO_FILENAME))) ?? ''), '-');
if ($base === '') {
    $base = 'upload';
}
do {
    $safeName   = $base . '-' . bin2hex(random_bytes(8)) . '.' . $ext;
    $targetPath = $diskDir . '/' . $safeName;
} while (file_exists($targetPath));

if (!move_uploaded_file($tmpName, $targetPath)) {
    $fail('File tidak bisa disimpan.', 500);
}
@chmod($targetPath, 0644);

$storedPath = '/' . $relDir . '/' . $safeName;

try {
    $pdo->prepare(
        'INSERT INTO media_library (file_name, file_path, file_type, mime_type, file_size_kb, alt_text, caption, is_active, created_at, updated_at)
         VALUES (:name, :path, \'image\', :mime, :kb, \'\', \'\', 1, NOW(), NOW())'
    )->execute([
        'name' => $safeName,
        'path' => $storedPath,
        'mime' => $detectedMime,
        'kb'   => (int) ceil($bytes / 1024),
    ]);
    $newId = (int) $pdo->lastInsertId();
} catch (PDOException $e) {
    @unlink($targetPath);
    $fail('Gagal menyimpan ke Media Library.', 500);
}

$dim = @getimagesize($targetPath);

echo json_encode([
    'ok'   => true,
    'item' => [
        'id'     => $newId,
        'name'   => $safeName,
        'path'   => $storedPath,
        'src'    => app_asset_preview_url($storedPath),
        'alt'    => '',
        'width'  => is_array($dim) ? (int) $dim[0] : 0,
        'height' => is_array($dim) ? (int) $dim[1] : 0,
    ],
], JSON_UNESCAPED_SLASHES);
