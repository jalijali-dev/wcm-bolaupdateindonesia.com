# Project: WCM 3 - Version 1 — "Tentakel 3" untuk struktur PBN — brand: Bola Update Indonesia

> **STATUS: 🟢 LIVE / ONLINE sejak 19 Agustus 2026.** Situs sudah live di
> https://bolaupdateindonesia.com (homepage, 4 kategori final, artikel
> semua tampil sesuai mockup), deploy lewat cPanel Git Version Control
> sukses, config production sudah terisi manual di server, dan admin
> panel sudah bisa login. Detail lengkap ada di `docs/HANDOFF.md` dan
> `docs/ROADMAP.md`. Beberapa item non-blocking (isolasi Cloudflare/GSC,
> struktur permalink custom, audit konten warisan WCM2) masih terbuka —
> lihat checklist di `docs/HANDOFF.md`.

> **WAJIB DIBACA DI AWAL SESI, SEBELUM AKSI APAPUN.** File ini adalah
> instruksi proyek, bukan sekadar catatan — ikuti isinya. Setelah baca
> file ini, baca juga `docs/HANDOFF.md` (checklist detail) dan
> `docs/ROADMAP.md` (status per fase) sebelum mulai kerja. Kalau ada
> keputusan besar yang masih kosong di bawah (permalink, akun
> Cloudflare), TANYA operator dulu lewat chat — jangan asumsi atau
> eksekusi sendiri duluan.

## Konteks & tujuan

Situs ini adalah "Tentakel 3" dalam struktur link-building operator.
Berbeda dari WCM 2 V.1 (biangolahraga.com) yang posisinya juga
"Tentakel 2" — **WCM 3 V.1 ini SEJAJAR dengan WCM 2 V.1**, sama-sama
cabang langsung dari WCM 1 V.1 (`wcm1_version1`, sebelumnya
olahraga77.com), **BUKAN turunan dari WCM 2 V.1**. Lihat
`skema-tentakel.html` di `cc-wpm/skema-1/` (Command Center) untuk posisi
lengkap di struktur gurita.

Jadi arah backlink: **WCM 3 V.1 → WCM 1 V.1 (olahraga77.com)** — BUKAN
ke WCM 2 V.1 (biangolahraga.com) — supaya pola link konsisten dengan
diagram gurita Skema 1 yang sudah disepakati (Sagagoal.com →
olahraga77.com → dst).

**Domain: BolaUpdateIndonesia.com.** **Nama brand: Bola Update
Indonesia.** Niche: bola & seputar olahraga umum, konsisten dengan
gurita Skema 1 yang sudah ada — BUKAN niche multi-cabang spesifik
(Bulu Tangkis/Tinju/Moto GP/Tips) kepunyaan WCM 2 V.1 / Biang Olahraga.

## Sumber clone

`cms-admin/` (dan pola frontend publik) di-clone dari **WCM 2 V.1
(biangolahraga.com)** — sesuai arahan operator di Work Order 004.
Karena source-nya bukan situs kosong, ada beberapa hal warisan Biang
Olahraga yang HARUS diaudit ulang / diganti, bukan cuma nama brand:

1. **Kategori & nav** — `includes/site-bootstrap.php` dan
   `includes/site-header.php` masih pakai kategori Bulu Tangkis/Tinju/
   Moto GP/Tips (nav: BULU TANGKIS / TINJU / MOTO GP / TIPS) dan fungsi
   `wpm_get_articles($pdo, 3, 0, 'tips')` di `index.php` — ini semua
   kepunyaan niche Biang Olahraga, BUKAN niche bola/olahraga umum WCM 3.
   Belum diganti, masih dalam status "sudah direname brand-nya doang,
   belum diaudit isinya".
2. Modul cms-admin (livescore/football/basketball/F1, `sport_key`) sudah
   bersih dari sononya (dihapus sejak wcm1_version1), jadi otomatis ikut
   bersih di sini juga.

## Risiko penting yang harus diingat (jangan skip)

1. **Database HARUS terpisah** — dari SEMUA database gurita Skema 1 yang
   sudah ada (`wpm_cms_goal`, `wpm_cms_olahraga77`,
   `wpm_cms_wcm1_version2`, `wpm_cms_wcm2_version1`, dan DB WCM 2 V.2/
   arenasport77 kalau sudah ada). `cms-admin/config/database.php` sudah
   diarahkan ke `wcm3_version1` — **tapi database ini
   BELUM tentu sudah dibuat di MySQL dev lokal, cek dulu ke operator /
   phpMyAdmin sebelum asumsi admin panel bisa langsung jalan.** Jangan
   ulangi insiden yang pernah terjadi di WCM 2 (database sempat ke-copy
   penuh dari sumbernya lewat fitur "Copy database" phpMyAdmin, bukan
   dibuat kosong — kalau itu kejadian lagi di sini, harus di-TRUNCATE
   ulang, jangan dipakai langsung).
2. **Hindari duplicate content & PBN footprint** — konten harus
   digenerate/ditulis terpisah (bukan copy-paste dari wcm1_version1,
   wcm2_version1/Biang Olahraga, atau situs manapun), tema visual harus
   beda dari SEMUA tentakel lain di gurita — terutama dari WCM 2 V.1
   (biangolahraga, sesama anak WCM 1 V.1) dan WCM 1 V.1 sendiri — dan
   struktur permalink juga harus beda (detail masih menyusul dari
   operator, lihat `docs/HANDOFF.md`).
3. **Isolasi infrastruktur** (IP hosting, akun Cloudflare, GSC) — lihat
   `docs/HANDOFF.md` untuk status; akun Cloudflare masih perlu
   didiskusikan ulang sama operator, JANGAN diasumsikan sendiri.

## Yang SUDAH dikerjakan

**18–19 Agu 2026:**
- Command Center (JCC) menerbitkan Work Order 004: bootstrap WCM 3 V.1
  (BolaUpdateIndonesia.com), clone `cms-admin/` dari WCM 2 V.1.
- Operator connect folder `wcm3_version1` ke Cowork. **Catatan penting:**
  folder ini awalnya berisi penuh proyek WCM 2 (Biang Olahraga) — nama
  folder sudah `wcm3_version1` tapi isinya (docs, config, branding) masih
  WCM 2. Sesi ini mulai proses rename branding-nya ke WCM 3 / Bola
  Update Indonesia (lihat poin di bawah).
- **Rename branding domain/brand** dari Biang Olahraga → Bola Update
  Indonesia di: `cms-admin/config/database.php` (`DB_NAME` →
  `wcm3_version1`), `cms-admin/config/app.php`
  (`CMS_ADMIN_TAGLINE` → `Bola Update Indonesia`, `CMS_AI_ENC_SECRET`
  di-generate ulang — genuinely baru, bukan reuse punya WCM 2),
  `cms-admin/login.php`, `cms-admin/config/app.php.example`,
  `includes/site-bootstrap.php` (`WPM_SITE_NAME`, `WPM_SITE_TAGLINE`),
  `includes/site-header.php` (brand mark di nav), `index.php` (meta
  description).
- `docs/HANDOFF.md` dan `docs/ROADMAP.md` ditulis ulang mencerminkan
  status WCM 3 (lihat file masing-masing untuk detail checklist).

**19 Agustus 2026 (sesi lanjutan — deploy & go-live):**
- Mockup homepage V1 diimplementasikan penuh ke `index.php`,
  `includes/site-header.php`, `includes/site-footer.php`,
  `assets/css/site.css` (tema light), plus `kategori.php`/`artikel.php`
  dirapikan. 8 artikel seed (2 per kategori final) + ilustrasi SVG per
  kategori dimasukkan ke database.
- Riwayat `.git` lama (warisan WCM 2) diaudit & di-reset bersih, commit
  awal WCM3 di-push ke GitHub
  (`https://github.com/jalijali-dev/wcm-bolaupdateindonesia.com.git`).
- `.cpanel.yml` diisi `DEPLOYPATH=/home/bolaupdateindone/public_html/`.
- Config production (`database.php`, `app.php` — kredensial DB +
  `CMS_AI_ENC_SECRET` baru) dibuat manual di server via cPanel File
  Manager. Deploy via "Deploy HEAD Commit" sukses.
- Kredensial admin awal (sisa WCM2, `admin@biangolahraga.com`) direset
  via SQL manual ke `admin@bolaupdateindonesia.com` + password baru —
  login dikonfirmasi berhasil oleh operator.
- **Situs FULL LIVE di https://bolaupdateindonesia.com.**

## Yang BELUM dikerjakan — task list buat lanjut

Situs sudah LIVE (lihat status di atas). Sisa item di bawah ini
non-blocking untuk go-live, tapi masih perlu diselesaikan:

1. Audit ulang modul cms-admin (warisan clone dari WCM 2) — buang yang
   spesifik konteks Biang Olahraga dan gak relevan buat WCM 3.
2. Logo — `cms-admin/assets/img/logo.png` / `logo-white.png` masih
   placeholder/warisan clone, belum disesuaikan ke identitas Bola Update
   Indonesia. Logo publik (`assets/img/favicon.svg`) juga masih
   wordmark teks, belum ada versi grafis asli.
3. Isolasi infrastruktur: IP hosting beda dari tentakel lain (paling
   wajib), akun Cloudflare (sama dengan WCM 2 V.1 atau baru — masih
   perlu didiskusikan operator), GSC property baru.
4. Detail struktur permalink custom yang mau dibuat beda dari
   `/artikel/{slug}` punya wcm1_version1 (dan juga beda dari WCM 2) —
   saat ini masih pakai pola yang sama, belum final.
5. 3 artikel warisan WCM 2 tanpa kategori (`category_id` NULL) masih
   perlu dibersihkan dari tabel `pages` di database production.
6. Lapor ke Command Center biar status di `skema-tentakel.html`
   diupdate dari "Sedang dibangun" jadi "Sudah online".

## Cara lanjut sesi ini

Baca file ini dulu di awal sesi, lalu `docs/HANDOFF.md` buat detail
checklist, dan `docs/ROADMAP.md` buat status per fase. Kalau ada
keputusan besar yang belum jelas (permalink, akun Cloudflare), TANYA
operator dulu — jangan asumsi sendiri.
