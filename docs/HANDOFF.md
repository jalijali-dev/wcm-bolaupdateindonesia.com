# HANDOFF — WCM 3 - Version 1

Dokumen ini merekam proses bootstrap WCM 3 V.1 (BolaUpdateIndonesia.com)
sesuai **Work Order 004** dari Command Center (JCC, 18 Agu 2026),
mengikuti checklist standar di
`wcm1_version1/docs/HANDOFF-CMS-ADMIN.md`. `cms-admin/` (dan pola
frontend publik) di-clone dari **WCM 2 V.1 (biangolahraga.com)**, bukan
dari wcm1_version1 langsung — beda dari pola WCM 2 yang di-clone dari
WCM 1 V.1.

## Konteks proyek

- **Nama kerja:** WCM 3 - Version 1
- **Nama brand:** **Bola Update Indonesia**
- **Domain:** **BolaUpdateIndonesia.com**
- **Peran dalam struktur PBN:** "Tentakel 3" — SEJAJAR dengan WCM 2 V.1
  (biangolahraga.com), sama-sama cabang langsung dari WCM 1 V.1
  (olahraga77.com). **BUKAN turunan dari WCM 2 V.1**, walau `cms-admin/`
  di-clone dari sana. Backlink WCM 3 V.1 mengarah ke **WCM 1 V.1
  (olahraga77.com)**, bukan ke WCM 2 V.1.
- **Topik/konten:** bola & seputar olahraga umum — niche BEDA dari WCM 2
  V.1 yang fokus multi-cabang spesifik (Bulu Tangkis/Tinju/Moto
  GP/Tips). **Kategori nav final (ditentukan operator, 19 Agu 2026):
  Liga Indonesia, Liga Eropa, Timnas, Transfer** — pola "liga & timnas
  fokus", mirip pendekatan lama wcm1_version1/olahraga77 sebelum
  di-rebrand.
- **Tema visual:** **mockup homepage V1 sudah dibuat & disetujui operator
  (19 Agu 2026)** — referensi visual NHK World (light/putih polos, logo
  merah di kiri atas), genuinely beda dari WCM 2 V.1 (dark theme,
  referensi juara.net) dan WCM 1 V.1. File: `docs/homepage-mockup-v1.html`
  (HTML statis, belum disambung ke kode PHP asli). Detail di bagian
  "Frontend Publik" di bawah.

## Checklist HANDOFF-CMS-ADMIN — status eksekusi

### 1. Isolasi Database
- [x] `cms-admin/config/database.php` diarahkan ke `DB_NAME` baru:
      `wcm3_version1` — genuinely beda nama dari
      SEMUA database gurita Skema 1 yang sudah ada (`wpm_cms_goal`,
      `wpm_cms_olahraga77`, `wpm_cms_wcm1_version2`,
      `wpm_cms_wcm2_version1`, dan DB WCM 2 V.2/arenasport77 kalau
      sudah ada).
- [ ] **BELUM DIKONFIRMASI apakah database `wcm3_version1`
      sudah benar-benar dibuat (dan kosong) di MySQL dev lokal.** Cek ke
      operator / phpMyAdmin dulu sebelum asumsi admin panel bisa jalan.
      **Ingat insiden WCM 2:** database sempat ke-copy penuh (struktur +
      data) dari sumbernya lewat fitur "Copy database" phpMyAdmin,
      ketahuan pas login pertama nampilin data situs sumber. Kalau itu
      kejadian lagi di sini, harus TRUNCATE ulang (pola sama seperti
      `_cleanup-fresh-start.php` yang pernah dipakai di WCM 2 — cek ke
      `wcm2_version1`/folder WCM 2 kalau butuh referensi scriptnya,
      JANGAN reuse langsung karena ada database-name safety-guard yang
      hardcoded ke nama DB WCM 2).
- [ ] Belum ada tabel/data — perlu jalanin schema migration begitu
      database dikonfirmasi kosong.
- [ ] Begitu hosting production untuk WCM 3 disiapkan, `database.php`
      wajib diganti lagi ke kredensial production yang juga terpisah.

### 2. Isolasi Kredensial & Secret
- [x] `CMS_AI_ENC_SECRET` di `app.php` **di-generate ulang** (bukan
      reuse punya WCM 2) — beda instance, beda secret.
- [ ] `GROWTH_AGENT_DIGEST_TOKEN` masih placeholder
      `GANTI_DENGAN_TOKEN_ACAK_ASLI` (ikut ter-clone) — **wajib diisi
      token asli baru** sebelum modul digest dipakai.
- [x] `config/app.php.example` sudah disesuaikan (contoh tagline diganti
      ke "Bola Update Indonesia").
- [ ] `.gitignore` warisan clone masih perlu dicek ulang — pastikan pola
      ignore untuk `config/app.php` dan `config/database.php` masih
      cocok di proyek ini (belum diverifikasi ulang sesi ini).
- [ ] Kalau folder ini masih punya script sekali-pakai warisan WCM 2
      (mis. `_cleanup-fresh-start.php`) — belum dicek keberadaannya di
      `cms-admin/`. Kalau ada dan isinya masih hardcoded ke DB WCM 2,
      **hapus atau tulis ulang** sebelum dipakai di sini, supaya gak
      salah TRUNCATE database yang salah.

### 3. Audit Modul yang Gak Relevan
- [x] Modul livescore/football/basketball/F1 dan konsep `sport_key`
      sudah bersih sejak sumber (dihapus di wcm1_version1, ikut bersih
      di WCM 2, ikut bersih lagi di sini).
- [ ] **Belum diaudit ulang khusus buat konteks niche WCM 3** (bola &
      olahraga umum) — perlu dijalankan begitu kategori final
      ditentukan operator, untuk pastikan gak ada modul/kolom yang masih
      terlalu spesifik ke niche Biang Olahraga (Bulu Tangkis/Tinju/Moto
      GP/Tips).

### 4. Branding & Konten Netral
- [x] **Rename brand selesai (sesi ini, 19 Agu 2026)** — `CMS_ADMIN_NAME`
      tetap `'WCM'` (standar lintas Tentakel), `CMS_ADMIN_TAGLINE`
      diganti dari `'Biang Olahraga'` ke `'Bola Update Indonesia'`.
      Tagline di `login.php` (komentar identitas admin login) juga
      diganti.
- [ ] **Logo admin panel masih warisan clone WCM 2** — `img/logo.png` +
      `img/logo-white.png` (wordmark "BO" placeholder punya Biang
      Olahraga) belum diganti ke identitas Bola Update Indonesia.
- [ ] System prompt AI di `growth-agent-service.php` — belum dicek ulang
      sesi ini, perlu diverifikasi masih netral (gak nyebut nama situs
      manapun) dan nanti disesuaikan ke konteks niche WCM 3 begitu jelas.
- [ ] **Konten (artikel, kategori) belum ada sama sekali** untuk WCM 3 —
      kategori & data warisan WCM 2 (kalau ada di database yang
      di-clone) WAJIB di-TRUNCATE, bukan dipakai langsung. Artikel wajib
      ditulis dari nol, TIDAK boleh copy-paste dari wcm1_version1,
      wcm2_version1, atau situs manapun.

### 5. Frontend Publik — Dibangun Terpisah
- [x] Kerangka frontend publik ikut ter-clone dari WCM 2: `index.php`,
      `kategori.php`, `artikel.php`, `cari.php`, `ad-click.php`,
      `includes/site-bootstrap.php`, `includes/site-header.php` /
      `includes/site-footer.php`, `includes/TimeHelpers.php`,
      `assets/css/site.css`, `.htaccess`.
- [x] Rename brand di frontend (sesi ini) — `WPM_SITE_NAME` /
      `WPM_SITE_TAGLINE` di `site-bootstrap.php`, brand mark di
      `site-header.php` (dulu "BIANG OLAHRAGA" → sekarang "BOLA
      UPDATE"), meta description di `index.php`.
- [x] **Mockup homepage V1 dibuat & disetujui operator (19 Agu 2026)** —
      `docs/homepage-mockup-v1.html` (HTML statis, mandiri, belum
      nyambung ke data CMS). Referensi visual: NHK World — dominan putih/
      light, logo "BOLA" (merah) + "UPDATE" (hitam) kiri atas, hero besar
      + panel "Terpopuler" di kanan, 3 band kategori berwarna (Liga
      Indonesia = merah, Liga Eropa = navy, Timnas = hijau), grid
      "Sorotan", widget "Find more" 3 kolom, strip promo, footer gelap.
      Font: kombinasi Space Grotesk (brand/judul band/tombol), Fraunces
      (semua headline berita — serif editorial, sengaja beda dari font
      sans generik situs berita bola kebanyakan), Manrope (body/meta).
      Semua foto masih placeholder gradient (belum ada foto asli — sesuai
      prinsip no-copy-paste-content).
- [x] **Mockup V1 sudah diimplementasikan ke kode PHP asli (19 Agu
      2026, sesi lanjutan)** — `index.php`, `includes/site-header.php`,
      `includes/site-footer.php`, dan `assets/css/site.css` ditulis ulang
      total mengikuti struktur & palet mockup, TAPI datanya nyambung ke
      database real lewat `wpm_get_articles()`, `wpm_get_popular_articles()`,
      dll di `site-bootstrap.php` — tidak ada konten hardcode. Header
      sekarang light theme (brand "BOLA"/"UPDATE" merah+hitam, nav 4
      kategori final, search, topics strip berisi chip kategori asli).
      `kategori.php` dan `artikel.php` ikut dirapikan gaya kartu/warna
      supaya konsisten (masih reuse `site-header`/`site-footer`).
      Vertical rail sidebar (warisan tema V2/dark) dihapus karena tidak
      ada di mockup V1 (NHK-style, tanpa rail).
- [x] Nav kategori di `site-header.php` dan seluruh data homepage sudah
      pakai kategori final WCM 3 (Liga Indonesia/Liga Eropa/Timnas/
      Transfer) — panggilan lama ke kategori "tips" warisan Biang
      Olahraga sudah tidak ada lagi di `index.php`.
- [ ] Struktur permalink URL masih pola sama dengan wcm1_version1 dan
      WCM 2 (`/artikel/{slug}`, `/kategori/{slug}`) — **belum final**,
      ganti begitu operator kasih struktur yang beda.
- [x] `assets/css/site.css` sudah diganti total ke light theme sesuai
      mockup V1 (tidak ada lagi sisa CSS dark theme lama).
- [ ] Logo publik (`assets/img/favicon.svg` dan brand mark) masih
      placeholder — mockup pakai wordmark teks "BOLA"/"UPDATE", belum ada
      logo grafis asli. `assets/img/placeholder.svg` sudah diganti dari
      "Biang Olahraga" (warisan WCM 2) ke wordmark netral "Bola Update
      Indonesia" dengan palet light.
- [x] **8 artikel seed berhasil dimasukkan** ke `wcm3_version1` (2 per
      kategori final, gaya evergreen/penjelasan umum, ditulis baru dari
      nol) via `cms-admin/_seed-articles.php` — **file itu sudah DIHAPUS
      dari server** setelah dipakai sesuai instruksi. Verifikasi visual
      homepage, satu halaman kategori (Timnas), dan satu halaman artikel
      sudah dilakukan di browser dan semuanya menampilkan data asli dari
      database dengan benar.
- [x] Bug kecil ikut diperbaiki sepanjang verifikasi ini (di luar
      cakupan awal tapi memblokir verifikasi):
      `cms-admin/_seed-articles.php` sempat query `SELECT id FROM admins`
      padahal primary key tabel itu `admin_id` (sudah diperbaiki sebelum
      file dihapus); `artikel.php` sempat menghasilkan title tag dobel
      ("... — Bola Update Indonesia — Bola Update Indonesia") karena
      `meta_title` di data seed sudah menyertakan nama brand sendiri —
      sekarang `$pageTitle` cuma menambahkan suffix brand kalau
      `meta_title` kosong.
- [ ] **Catatan belum dibersihkan:** 3 artikel warisan WCM 2 (topik
      Bulu Tangkis/sepak bola umum/otomotif, `category_id` NULL) masih
      ada di tabel `pages` dan ikut nongol di listing "Terbaru"/"Sorotan"
      karena query tidak filter kategori. Belum dihapus sesi ini karena
      di luar scope kerja frontend — perlu keputusan/aksi terpisah untuk
      TRUNCATE atau hapus manual artikel-artikel itu.
- [x] **Featured image 8 artikel seed sudah diisi (sesi lanjutan)** —
      sebelumnya kosong (placeholder default). Dibuatkan 4 ilustrasi SVG
      flat/gradient, satu per kategori final, disimpan di
      `assets/img/articles/{liga-indonesia,liga-eropa,timnas,transfer}.svg`:
      motif bola (Liga Indonesia, merah), lingkaran bintang (Liga Eropa,
      navy — terinspirasi pola bintang melingkar generik, BUKAN logo
      UEFA/asosiasi asli), badge/perisai (Timnas, hijau), panah tukar
      (Transfer, amber). Semua abstrak/ikonik, tanpa logo klub/asosiasi
      asli maupun foto orang sungguhan — aman dari isu hak cipta/
      misrepresentasi. Kolom `featured_image` di tabel `pages` di-update
      langsung via SQL (per kategori, bukan hardcode di kode PHP — masih
      lewat `wpm_image_url()` seperti sebelumnya). Sudah diverifikasi
      tampil di homepage, tiap halaman kategori (Liga Eropa/Timnas/
      Transfer dicek langsung), dan satu halaman artikel (Transfer).

### 6. Deploy Workflow
- [x] **Diverifikasi & dibereskan (sesi lanjutan, deploy prep):** `.git`
      lokal folder ini ternyata riwayat warisan WCM 2 murni — 1 commit
      ("Initial commit — biangolahraga.com go-live prep") dengan remote
      salah menunjuk ke `wcm-biangolahraga.com.git`. Diaudit isi commit
      itu: TIDAK ada kredensial asli ter-commit (config/database.php dan
      config/app.php sejak awal cuma `.example` yang di-track). Karena
      riwayatnya genuinely bukan riwayat WCM3 (pesan commit & remote
      salah semua), diambil opsi fallback yang sudah disetujui operator:
      `.git` lama DIPINDAH (bukan dihapus) ke
      `../wcm3_version1-old-wcm2-gitbackup-<timestamp>/` di luar folder
      proyek, lalu `git init` ulang dari nol dengan riwayat bersih milik
      WCM3.
- [x] `.gitignore` dicek ulang — masih benar: `cms-admin/config/
      database.php`, `cms-admin/config/app.php`, `uploads/*` (kecuali
      `uploads/media/index.php`), dan pola `_*.php` semua ter-exclude.
      Dikonfirmasi juga tidak ada `_seed-articles.php` atau
      `_cleanup-orphan-pages.php` tersisa di working tree.
- [x] **Commit awal WCM3 sudah di-push** ke GitHub:
      `https://github.com/jalijali-dev/wcm-bolaupdateindonesia.com.git`
      branch `main` (119 file, source code + `.example` config saja,
      tanpa kredensial asli).
- [x] **`.cpanel.yml` sudah diisi path production sungguhan** (operator
      kasih dari screenshot cPanel → Domains): `DEPLOYPATH=/home/
      bolaupdateindone/public_html/`. Komentar warisan "akun cPanel
      biangolahraga.com" sudah dihapus/diganti referensi ke
      bolaupdateindonesia.com. Repo Git Version Control di cPanel
      di-clone ke path terpisah `/home/bolaupdateindone/repositories/
      wcm-bolaupdateindonesia.com` (bukan docroot) — `.cpanel.yml` inilah
      yang rsync isinya ke `public_html` saat tombol "Deploy HEAD Commit"
      ditekan. Exclude list tetap sama: `.git`, `.cpanel.yml`,
      `cms-admin/config/database.php`, `cms-admin/config/app.php`,
      `uploads`. Perubahan ini sudah di-commit & push ke `main`.
- [x] Hosting cPanel: domain BolaUpdateIndonesia.com adalah addon domain
      di akun cPanel `bolaupdateindone` (bukan akun baru terpisah) —
      dikonfirmasi lewat path docroot di atas.
- [ ] **Config production (manual di server, TIDAK lewat git):**
      `cms-admin/config/database.php` di server perlu diisi
      `DB_NAME=bolaupdateindone_cms`, `DB_HOST=localhost` (bukan `mysql`
      seperti di Docker dev), `DB_USER`/`DB_PASS` sesuai kredensial
      cPanel MySQL Databases — operator isi manual lewat cPanel File
      Manager. `cms-admin/config/app.php` di production juga perlu
      `CMS_AI_ENC_SECRET` digenerate ULANG (jangan reuse punya dev
      lokal) — generate dengan `bin2hex(random_bytes(32))` (mis. lewat
      `php -r "echo bin2hex(random_bytes(32));"` di terminal manapun),
      lalu tempel ke `app.php` di server, upload manual lewat File
      Manager (bukan git, karena gitignored).
- [ ] **Verifikasi kategori production:** database production
      `bolaupdateindone_cms` katanya sudah di-schema-migrate dan punya
      isi tabel — operator perlu cek manual lewat phpMyAdmin cPanel
      bahwa `article_categories` isinya persis 4 kategori final (Liga
      Indonesia/Liga Eropa/Timnas/Transfer), bukan sisa kategori WCM2
      apapun, SEBELUM publish artikel pertama di production. (Kalau ada
      sisa kategori lain, `wpm_site_migrate_categories()` di
      `site-bootstrap.php` akan otomatis reassign artikelnya ke
      kategori final begitu halaman publik pertama diakses — tapi lebih
      aman dicek manual dulu daripada mengandalkan migrasi otomatis di
      data production.)

### 7. SEO Dasar
- [ ] Belum dikerjakan — robots.txt, sitemap, favicon (favicon.svg saat
      ini masih placeholder warisan clone) nunggu audit kategori & brand
      final selesai dulu.

### 8. Isolasi Infrastruktur (spesifik Work Order 004)
- [ ] **IP hosting** — usahakan beda dari tentakel lain kalau
      memungkinkan (paling wajib, paling gampang kedeteksi kalau sama).
      Belum ditentukan.
- [ ] **Akun Cloudflare** — perlu didiskusikan ulang sama operator apakah
      WCM 3 V.1 masuk akun CF yang sama dengan WCM 2 V.1 (sama-sama
      level "Tentakel 2"/anak langsung WCM 1 V.1), atau akun CF baru.
      **Belum final, jangan asumsi sendiri.**
- [ ] **GSC** — property baru terpisah untuk domain ini, belum dibuat.

### 9. Verifikasi Akhir
- [ ] Belum relevan — nunggu poin 1–8 selesai.

## Yang sudah dieksekusi sesi ini (19 Agu 2026)

1. Operator connect folder `wcm3_version1` ke Cowork — ditemukan isinya
   masih penuh proyek WCM 2 (Biang Olahraga): `CLAUDE.md`, `docs/
   HANDOFF.md`, `docs/ROADMAP.md`, config `cms-admin/` semua masih
   menyebut WCM 2 / Biang Olahraga / `wpm_cms_wcm2_version1`.
2. Dikonfirmasi ke operator: folder ini memang jadi titik kerja WCM 3,
   isi lama (warisan WCM 2) boleh diedit di tempat untuk jadi WCM 3.
3. **Rename brand/domain** (nama-nama yang masih copy dari WCM 2) ke
   Bola Update Indonesia / BolaUpdateIndonesia.com di:
   - `cms-admin/config/database.php` — `DB_NAME` →
     `wcm3_version1`.
   - `cms-admin/config/app.php` — `CMS_ADMIN_TAGLINE` → `'Bola Update
     Indonesia'`, `CMS_AI_ENC_SECRET` digenerate ulang (baru, bukan
     reuse WCM 2).
   - `cms-admin/login.php` — komentar identitas login diganti.
   - `cms-admin/config/app.php.example` — contoh tagline diganti.
   - `includes/site-bootstrap.php` — `WPM_SITE_NAME`,
     `WPM_SITE_TAGLINE`, komentar header file, catatan local-dev path.
   - `includes/site-header.php` — komentar header file, brand mark nav
     ("BIANGOLAHRAGA" → "BOLAUPDATE").
   - `index.php` — meta description.
4. `CLAUDE.md`, `docs/HANDOFF.md` (dokumen ini), `docs/ROADMAP.md`
   ditulis ulang total mencerminkan WCM 3, bukan WCM 2 lagi.
5. Nama database diganti sekali lagi dari `wpm_cms_wcm3_bolaupdateindonesia`
   ke pola konvensi asli operator di phpMyAdmin: **`wcm3_version1`**
   (grup `wcm1`/`wcm2` di phpMyAdmin pakai pola `wcm{n}_version{n}` tanpa
   prefix `wpm_cms_`).
6. **Kategori nav final ditentukan operator:** Liga Indonesia, Liga
   Eropa, Timnas, Transfer.
7. **Mockup homepage V1 dibuat & disetujui operator** —
   `docs/homepage-mockup-v1.html`, referensi visual NHK World (light,
   logo merah), font Space Grotesk + Fraunces + Manrope. Lihat poin 5.
   di checklist Frontend Publik di atas untuk detail.
8. **Belum dikerjakan sesi ini**: implementasi mockup ke kode PHP asli,
   konfirmasi status database kosong, schema migration, audit modul
   cms-admin, ganti logo grafis, isolasi infrastruktur (IP/Cloudflare/
   GSC), verifikasi Git/`.cpanel.yml`.

## Yang perlu dikonfirmasi/dikerjakan operator sebelum lanjut

1. **Database `wcm3_version1`** — sudah dibuat kosong
   di MySQL dev lokal atau belum?
2. ~~**Kategori final WCM 3**~~ — **selesai, ditentukan 19 Agu 2026: Liga
   Indonesia, Liga Eropa, Timnas, Transfer.**
3. **Detail struktur permalink** yang mau dibuat beda dari
   `/artikel/{slug}` (dipakai wcm1_version1 & WCM 2).
4. **Akun Cloudflare** — pakai akun yang sama dengan WCM 2 V.1, atau
   akun baru?
5. **Status folder ini** — `.git` dan `.cpanel.yml` yang ada di folder
   ini sekarang, itu remote/config buat WCM 3 yang baru, atau warisan
   dari setup lain yang perlu di-reset?
6. Domain BolaUpdateIndonesia.com — sudah dibeli? Kalau sudah, hosting
   cPanel & GSC bisa mulai disiapkan.
7. **Konfirmasi mockup V1** (`docs/homepage-mockup-v1.html`) — kalau
   sudah fix, lanjut diimplementasikan ke `index.php`/`site-header.php`/
   `site-footer.php`/`assets/css/site.css` sungguhan.
