# HANDOFF — WCM 3 - Version 1

> **STATUS: 🟢 FULL LIVE sejak 19 Agustus 2026.** Situs online di
> https://bolaupdateindonesia.com — homepage, 4 kategori final, dan
> artikel semua tampil sesuai mockup. Deploy via cPanel Git Version
> Control sukses, config production sudah terisi manual di server, admin
> panel sudah bisa login. Lihat bagian "Deploy Workflow" di bawah untuk
> detail lengkap go-live.

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
- [x] Database dev lokal: `cms-admin/config/database.php` (dev, Docker)
      diarahkan ke `DB_NAME` `wcm3_version1` — genuinely beda nama dari
      SEMUA database gurita Skema 1 yang sudah ada (`wpm_cms_goal`,
      `wpm_cms_olahraga77`, `wpm_cms_wcm1_version2`,
      `wpm_cms_wcm2_version1`, dan DB WCM 2 V.2/arenasport77 kalau
      sudah ada). Dikonfirmasi kosong & sudah di-schema-migrate + diisi
      8 artikel seed untuk verifikasi visual.
- [x] **Database production sudah ada & sudah di-schema-migrate** —
      `bolaupdateindone_cms` di cPanel MySQL Databases, genuinely
      terpisah dari database dev lokal maupun database tentakel lain.
      `cms-admin/config/database.php` di SERVER (bukan repo — file ini
      gitignored) sudah diisi manual dengan `DB_HOST=localhost`,
      `DB_NAME=bolaupdateindone_cms`, dan `DB_USER`/`DB_PASS` sesuai
      kredensial cPanel MySQL Databases. Admin login di production
      dikonfirmasi berhasil, jadi koneksi DB production sudah kebukti
      jalan.

### 2. Isolasi Kredensial & Secret
- [x] `CMS_AI_ENC_SECRET` dev lokal di `app.php` **di-generate ulang**
      (bukan reuse punya WCM 2) — beda instance, beda secret.
- [x] **`CMS_AI_ENC_SECRET` production digenerate ULANG TERPISAH** dari
      punya dev lokal (`bin2hex(random_bytes(32))`), diisi manual ke
      `cms-admin/config/app.php` di server via cPanel File Manager —
      bukan reuse dev, sesuai prinsip isolasi kredensial di dokumen ini.
- [x] `config/app.php.example` sudah disesuaikan (contoh tagline diganti
      ke "Bola Update Indonesia").
- [x] `.gitignore` dicek ulang & dikonfirmasi benar (lihat bagian Deploy
      Workflow) — `config/app.php` dan `config/database.php` tetap
      ter-exclude di kedua environment (dev & production).
- [x] Script sekali-pakai warisan WCM 2 (`_cleanup-fresh-start.php` dkk)
      dikonfirmasi tidak ada di folder ini — `.gitignore` juga sudah
      punya pola blanket `_*.php` untuk mencegah script sekali-pakai
      manapun ke-commit ke git.
- [ ] `GROWTH_AGENT_DIGEST_TOKEN` masih placeholder
      `GANTI_DENGAN_TOKEN_ACAK_ASLI` (ikut ter-clone, di dev maupun
      production) — **wajib diisi token asli baru** sebelum modul digest
      dipakai. Non-blocking untuk go-live karena modul ini belum aktif
      dipakai.

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
- [x] **Konten sudah ada** — 8 artikel (2 per kategori final) ditulis
      dari nol (bukan copy-paste dari wcm1_version1/wcm2_version1/situs
      manapun), sudah dimasukkan ke database dev lokal & sudah tampil di
      production. Lihat bagian "Frontend Publik" untuk detail.
- [x] **Kredensial admin awal direset** — akun admin warisan WCM 2
      (`admin@biangolahraga.com`) di database production di-reset via
      SQL manual ke `admin@bolaupdateindonesia.com` + password baru.
      Login di `https://bolaupdateindonesia.com/cms-admin/login.php`
      dikonfirmasi berhasil oleh operator.

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
- [x] **Config production sudah dibuat manual di server** (TIDAK lewat
      git, sesuai `.gitignore`): `cms-admin/config/database.php` diisi
      `DB_NAME=bolaupdateindone_cms`, `DB_HOST=localhost` (bukan `mysql`
      seperti di Docker dev), `DB_USER`/`DB_PASS` sesuai kredensial
      cPanel MySQL Databases. `cms-admin/config/app.php` diisi
      `CMS_AI_ENC_SECRET` yang digenerate ULANG khusus production
      (bukan reuse punya dev lokal). Keduanya diupload manual lewat
      cPanel File Manager.
- [x] **Deploy dijalankan & sukses** — tombol "Deploy HEAD Commit" di
      cPanel Git Version Control (repo di
      `/home/bolaupdateindone/repositories/wcm-bolaupdateindonesia.com`)
      sudah dipencet, rsync ke `DEPLOYPATH` berhasil.
- [x] **Kategori production terverifikasi** — `article_categories` di
      `bolaupdateindone_cms` sudah berisi 4 kategori final (Liga
      Indonesia/Liga Eropa/Timnas/Transfer) dan homepage/kategori/
      artikel di production sudah dikonfirmasi tampil benar sesuai
      mockup, jadi kategorinya sudah match (kalaupun sempat ada sisa
      kategori WCM2, `wpm_site_migrate_categories()` di
      `site-bootstrap.php` sudah auto-reassign begitu halaman publik
      pertama diakses).
- [x] **Situs FULL LIVE** di https://bolaupdateindonesia.com — homepage,
      4 kategori, dan artikel semua tampil dengan benar sesuai mockup
      V1. Admin panel juga sudah bisa diakses & login (lihat bagian
      "Branding & Konten Netral" di atas untuk detail reset kredensial
      admin).

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

## Sesi lanjutan (19 Agustus 2026) — deploy & go-live

1. Mockup homepage V1 diimplementasikan penuh ke `index.php`,
   `includes/site-header.php`, `includes/site-footer.php`,
   `assets/css/site.css` (tema light), `kategori.php`/`artikel.php`
   dirapikan supaya konsisten. 8 artikel seed (2 per kategori final)
   ditulis dari nol + ilustrasi SVG per kategori dimasukkan ke database
   dev lokal, diverifikasi visual di browser.
2. `.git` lokal (riwayat warisan WCM 2, remote salah) diaudit — tidak
   ada kredensial bocor — lalu di-reset bersih (backup dipindah ke luar
   folder proyek). Commit awal WCM3 di-push ke GitHub
   (`https://github.com/jalijali-dev/wcm-bolaupdateindonesia.com.git`
   branch `main`).
3. `.cpanel.yml` diisi `DEPLOYPATH=/home/bolaupdateindone/public_html/`
   (path docroot addon domain dari operator), komentar warisan WCM2
   dibersihkan. Repo Git Version Control cPanel di-clone ke
   `/home/bolaupdateindone/repositories/wcm-bolaupdateindonesia.com`.
4. Config production dibuat manual di server (TIDAK lewat git):
   `cms-admin/config/database.php` (DB `bolaupdateindone_cms`,
   `DB_HOST=localhost`) dan `cms-admin/config/app.php`
   (`CMS_AI_ENC_SECRET` baru khusus production).
5. Tombol "Deploy HEAD Commit" dipencet — deploy sukses.
6. Kredensial admin awal (sisa WCM2, `admin@biangolahraga.com`) direset
   via SQL manual ke `admin@bolaupdateindonesia.com` + password baru —
   login dikonfirmasi berhasil oleh operator.
7. **Situs dikonfirmasi FULL LIVE** di https://bolaupdateindonesia.com —
   homepage, 4 kategori, artikel semua tampil benar sesuai mockup V1.

## Status per 19 Agustus 2026: 🟢 FULL LIVE

Semua item blocking untuk go-live sudah selesai:
- ~~Database `wcm3_version1`~~ — selesai, dev lokal & production
  (`bolaupdateindone_cms`) sudah jalan.
- ~~Kategori final WCM 3~~ — selesai, ditentukan 19 Agu 2026: Liga
  Indonesia, Liga Eropa, Timnas, Transfer, sudah terverifikasi di
  production.
- ~~Status `.git`/`.cpanel.yml`~~ — selesai, riwayat direset bersih,
  `.cpanel.yml` diisi `DEPLOYPATH` production yang benar.
- ~~Domain & hosting cPanel~~ — selesai, situs live di
  https://bolaupdateindonesia.com.
- ~~Mockup V1~~ — selesai, sudah diimplementasikan penuh ke kode PHP
  asli dan live di production.

## Yang masih perlu dikonfirmasi/dikerjakan operator (non-blocking)

1. **Detail struktur permalink custom** yang mau dibuat beda dari
   `/artikel/{slug}` (dipakai wcm1_version1 & WCM 2) — saat ini situs
   sudah live pakai pola yang sama, ganti kalau operator mau struktur
   lain nanti.
2. **Akun Cloudflare** — pakai akun yang sama dengan WCM 2 V.1, atau
   akun baru?
3. **Isolasi infrastruktur lain** — IP hosting beda dari tentakel lain,
   GSC property baru untuk domain ini.
4. **3 artikel warisan WCM 2 tanpa kategori** di tabel `pages` production
   — mau di-TRUNCATE/dihapus manual kapan?
5. Kalau semua di atas beres, lapor ke Command Center biar status di
   `skema-tentakel.html` diupdate jadi "Sudah online".
