<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/site-bootstrap.php';

$navCategories = wpm_site_nav_categories();
$popular = wpm_get_popular_articles($pdo, 5);

// Hero: most recent published article overall.
$heroRows = wpm_get_articles($pdo, 1, 0, null);
$hero = $heroRows[0] ?? null;

// One color band per band category, each with its own hero + 3-item list.
$bandSlugs = ['liga-indonesia', 'liga-eropa', 'timnas'];
$bandData = [];
foreach ($bandSlugs as $slug) {
    $rows = wpm_get_articles($pdo, 4, 0, $slug);
    if ($rows) {
        $bandData[$slug] = ['hero' => $rows[0], 'list' => array_slice($rows, 1, 3)];
    }
}

// "Sorotan" feature grid: 4 latest articles overall, excluding the hero.
$featureRows = wpm_get_articles($pdo, 5, 0, null);
if ($hero) {
    $featureRows = array_values(array_filter($featureRows, static fn($a) => $a['page_id'] !== $hero['page_id']));
}
$featureRows = array_slice($featureRows, 0, 4);

// "Find more" columns: Terpopuler (already have $popular), Transfer, and a
// third latest-overall column (stands in for a Video section — no video
// content type exists in this CMS yet).
$transferRows = wpm_get_articles($pdo, 4, 0, 'transfer');
$latestRows = wpm_get_articles($pdo, 4, 0, null);

$pageTitle = WPM_SITE_NAME . ' — ' . WPM_SITE_TAGLINE;
$metaDescription = 'Berita bola dan update olahraga terkini di ' . WPM_SITE_NAME . ': Liga Indonesia, Liga Eropa, Timnas, dan Transfer.';
$activeNavSlug = 'home';
require __DIR__ . '/includes/site-header.php';
?>

<?php if ($hero): ?>
<section class="wpm-hero">
  <div class="wpm-hero-main">
    <a href="<?= wpm_esc(wpm_article_url($hero['slug'])) ?>" class="wpm-photo" style="display:block;height:340px;border-radius:6px;">
      <img src="<?= wpm_esc(wpm_image_url($hero['featured_image'])) ?>" alt="<?= wpm_esc($hero['title']) ?>">
    </a>
    <div class="wpm-hero-cap">
      <?php if ($hero['category_name']): ?><a href="<?= wpm_esc(wpm_category_url($hero['category_slug'])) ?>" class="wpm-tag"><?= wpm_esc($hero['category_name']) ?></a><?php endif; ?>
      <h1><a href="<?= wpm_esc(wpm_article_url($hero['slug'])) ?>"><?= wpm_esc($hero['title']) ?></a></h1>
      <?php if (!empty($hero['excerpt'])): ?><p><?= wpm_esc($hero['excerpt']) ?></p><?php endif; ?>
      <span class="wpm-meta"><?= wpm_esc(wpm_time_ago($hero['published_at'])) ?> &middot; Redaksi <?= wpm_esc(WPM_SITE_NAME) ?></span>
    </div>
  </div>
  <aside class="wpm-side-panel">
    <h3>Terpopuler</h3>
    <?php foreach ($popular as $i => $p): ?>
    <a href="<?= wpm_esc(wpm_article_url($p['slug'])) ?>" class="wpm-side-item"><span class="wpm-num"><?= $i + 1 ?></span><?= wpm_esc($p['title']) ?></a>
    <?php endforeach; ?>
    <?php if (!$popular): ?><p class="wpm-sidebar-empty">Belum ada data.</p><?php endif; ?>
  </aside>
</section>
<?php else: ?>
<div class="wpm-empty-state">
  <span class="wpm-empty-state__icon" aria-hidden="true">&#9917;</span>
  <h2>Belum ada artikel</h2>
  <p>Artikel yang dipublikasikan di kategori Liga Indonesia, Liga Eropa, Timnas, atau Transfer akan tampil di sini.</p>
</div>
<?php endif; ?>

<?php foreach ($bandSlugs as $slug):
  if (empty($bandData[$slug])) { continue; }
  $label = $navCategories[$slug];
  $colorClass = wpm_category_color_class($slug);
  $bandHero = $bandData[$slug]['hero'];
  $bandList = $bandData[$slug]['list'];
?>
<section class="wpm-band <?= $colorClass ?>">
  <div class="wpm-wrap">
    <div class="wpm-band-hero">
      <div class="wpm-band-title"><a href="<?= wpm_esc(wpm_category_url($slug)) ?>"><?= wpm_esc($label) ?></a> <span class="wpm-chev">&rsaquo;</span></div>
      <a href="<?= wpm_esc(wpm_article_url($bandHero['slug'])) ?>" class="wpm-photo" style="display:block;height:230px;border-radius:6px;">
        <img src="<?= wpm_esc(wpm_image_url($bandHero['featured_image'])) ?>" alt="<?= wpm_esc($bandHero['title']) ?>">
      </a>
      <h2><a href="<?= wpm_esc(wpm_article_url($bandHero['slug'])) ?>"><?= wpm_esc($bandHero['title']) ?></a></h2>
      <span class="wpm-meta"><?= wpm_esc(wpm_time_ago($bandHero['published_at'])) ?></span>
    </div>
    <div class="wpm-band-list">
      <?php foreach ($bandList as $item): ?>
      <a href="<?= wpm_esc(wpm_article_url($item['slug'])) ?>" class="wpm-item">
        <span class="wpm-photo" style="width:96px;height:64px;flex:0 0 auto;border-radius:4px;overflow:hidden;">
          <img src="<?= wpm_esc(wpm_image_url($item['featured_image'])) ?>" alt="<?= wpm_esc($item['title']) ?>">
        </span>
        <span class="wpm-txt"><h4><?= wpm_esc($item['title']) ?></h4><span class="wpm-meta"><?= wpm_esc(wpm_time_ago($item['published_at'])) ?></span></span>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endforeach; ?>

<?php if ($featureRows): ?>
<section class="wpm-features wpm-wrap">
  <h3 class="wpm-section-title">Sorotan</h3>
  <div class="wpm-feat-grid">
    <?php foreach ($featureRows as $item): ?>
    <a href="<?= wpm_esc(wpm_article_url($item['slug'])) ?>" class="wpm-feat-card">
      <span class="wpm-photo" style="display:block;height:130px;border-radius:6px;overflow:hidden;">
        <img src="<?= wpm_esc(wpm_image_url($item['featured_image'])) ?>" alt="<?= wpm_esc($item['title']) ?>">
      </span>
      <?php if ($item['category_name']): ?><div class="wpm-fcat"><?= wpm_esc($item['category_name']) ?></div><?php endif; ?>
      <h4><?= wpm_esc($item['title']) ?></h4>
      <span class="wpm-meta"><?= wpm_esc(wpm_time_ago($item['published_at'])) ?></span>
    </a>
    <?php endforeach; ?>
  </div>
  <a href="<?= wpm_esc(wpm_category_url('transfer')) ?>" class="wpm-btn-pill">Lihat Lebih Banyak</a>
</section>
<?php endif; ?>

<?php if ($popular || $transferRows || $latestRows): ?>
<section class="wpm-findmore">
  <div class="wpm-wrap wpm-fm-grid">
    <div class="wpm-fm-col">
      <h4>Terpopuler <span class="wpm-chev">&rsaquo;</span></h4>
      <?php foreach ($popular as $p): ?>
      <a href="<?= wpm_esc(wpm_article_url($p['slug'])) ?>" class="wpm-fm-item">
        <span class="wpm-photo" style="width:60px;height:44px;flex:0 0 auto;border-radius:4px;overflow:hidden;"><img src="<?= wpm_esc(wpm_image_url($p['featured_image'])) ?>" alt="<?= wpm_esc($p['title']) ?>"></span>
        <div class="wpm-txt"><?= wpm_esc($p['title']) ?><div class="wpm-meta"><?= wpm_esc(wpm_time_ago($p['published_at'] ?? null)) ?></div></div>
      </a>
      <?php endforeach; ?>
      <?php if (!$popular): ?><p class="wpm-sidebar-empty">Belum ada data.</p><?php endif; ?>
    </div>
    <div class="wpm-fm-col">
      <h4>Transfer <span class="wpm-chev">&rsaquo;</span></h4>
      <?php foreach ($transferRows as $item): ?>
      <a href="<?= wpm_esc(wpm_article_url($item['slug'])) ?>" class="wpm-fm-item">
        <span class="wpm-photo" style="width:60px;height:44px;flex:0 0 auto;border-radius:4px;overflow:hidden;"><img src="<?= wpm_esc(wpm_image_url($item['featured_image'])) ?>" alt="<?= wpm_esc($item['title']) ?>"></span>
        <div class="wpm-txt"><?= wpm_esc($item['title']) ?><div class="wpm-meta"><?= wpm_esc(wpm_time_ago($item['published_at'])) ?></div></div>
      </a>
      <?php endforeach; ?>
      <?php if (!$transferRows): ?><p class="wpm-sidebar-empty">Belum ada artikel Transfer.</p><?php endif; ?>
    </div>
    <div class="wpm-fm-col">
      <h4>Terbaru <span class="wpm-chev">&rsaquo;</span></h4>
      <?php foreach ($latestRows as $item): ?>
      <a href="<?= wpm_esc(wpm_article_url($item['slug'])) ?>" class="wpm-fm-item">
        <span class="wpm-photo" style="width:60px;height:44px;flex:0 0 auto;border-radius:4px;overflow:hidden;"><img src="<?= wpm_esc(wpm_image_url($item['featured_image'])) ?>" alt="<?= wpm_esc($item['title']) ?>"></span>
        <div class="wpm-txt"><?= wpm_esc($item['title']) ?><div class="wpm-meta"><?= wpm_esc(wpm_time_ago($item['published_at'])) ?></div></div>
      </a>
      <?php endforeach; ?>
      <?php if (!$latestRows): ?><p class="wpm-sidebar-empty">Belum ada artikel.</p><?php endif; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<div class="wpm-promo">
  <a href="<?= wpm_esc(wpm_category_url('liga-indonesia')) ?>" class="wpm-cell a">JADWAL &amp; HASIL LIGA</a>
  <a href="<?= wpm_esc(wpm_category_url('timnas')) ?>" class="wpm-cell b">TIMNAS INDONESIA HUB</a>
  <a href="<?= wpm_esc(wpm_category_url('transfer')) ?>" class="wpm-cell c">BURSA TRANSFER TERKINI</a>
</div>

<?php require __DIR__ . '/includes/site-footer.php'; ?>
