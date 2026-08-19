# Progress Roadmap — WCM 3 - Version 1

Status per 19 Agustus 2026. **🟢 SITUS FULL LIVE / ONLINE** di
https://bolaupdateindonesia.com.

Legenda: 🟢 Selesai · 🟠 Sebagian · ⚪ Belum mulai

> **Konteks:** WCM 3 V.1 (BolaUpdateIndonesia.com) adalah "Tentakel 3",
> SEJAJAR dengan WCM 2 V.1 (biangolahraga.com) — sama-sama cabang
> langsung dari WCM 1 V.1 (olahraga77.com), BUKAN turunan WCM 2 V.1.
> `cms-admin/` di-clone dari WCM 2 V.1 sesuai Work Order 004, tapi
> backlink WCM 3 mengarah ke WCM 1 V.1 (olahraga77.com), bukan ke WCM 2.
> Niche: bola & seputar olahraga umum — beda dari niche multi-cabang
> spesifik (Bulu Tangkis/Tinju/Moto GP/Tips) kepunyaan WCM 2 V.1.
>
> **Status go-live (19 Agu 2026):** dimulai dari folder yang awalnya
> berisi penuh proyek WCM 2 (branding, config, docs), lalu di-rename
> total ke WCM 3, mockup homepage V1 (referensi NHK World, light theme)
> diimplementasikan ke kode PHP asli, 8 artikel seed dimasukkan, riwayat
> git direset bersih & di-push ke GitHub, deploy ke cPanel via Git
> Version Control sukses, config production diisi manual di server, dan
> admin panel sudah bisa login. Situs sekarang FULL LIVE. Item yang
> masih terbuka (non-blocking): isolasi Cloudflare/GSC/IP hosting,
> struktur permalink custom, audit modul cms-admin, logo grafis final —
> lihat `docs/HANDOFF.md` untuk daftar lengkap.

## Fase 0 — Pondasi 🟢 Selesai

Domain BolaUpdateIndonesia.com sudah live di production. Git repo WCM3
terverifikasi & bersih (`https://github.com/jalijali-dev/
wcm-bolaupdateindonesia.com.git`), `.cpanel.yml` sudah diisi DEPLOYPATH
production yang benar. Database dev lokal (`wcm3_version1`) dan
database production (`bolaupdateindone_cms`, cPanel MySQL Databases)
keduanya sudah dibuat, kosong dari awal, dan sudah di-schema-migrate.
Belum: GSC property baru untuk domain ini (lihat Fase 5).

## Fase 1 — Backend: Schema & Adaptasi CMS 🟢 Selesai (untuk go-live)

`cms-admin/` di-clone dari WCM 2 V.1 (bukan dari wcm1_version1
langsung — beda pola dari WCM 2 yang di-clone dari WCM 1). Rename
branding sudah jalan di dev & production: `DB_NAME`/`DB_HOST` sesuai
masing-masing environment, `CMS_AI_ENC_SECRET` digenerate ulang
TERPISAH untuk dev dan production (tidak reuse), `CMS_ADMIN_TAGLINE` →
"Bola Update Indonesia". Admin panel production sudah bisa diakses &
login. Belum (non-blocking): audit modul cms-admin sesuai niche bola/
olahraga umum secara menyeluruh, `GROWTH_AGENT_DIGEST_TOKEN` masih
placeholder (modul belum aktif dipakai).

## Fase 2 — Backend: Isi Konten Struktural 🟢 Selesai (untuk go-live)

Niche ditentukan (bola & seputar olahraga umum) dan kategori nav final
sudah diputuskan operator (19 Agu 2026): **Liga Indonesia, Liga Eropa,
Timnas, Transfer**. Kategori ini sudah terverifikasi ada di database
production (`article_categories`) dan 8 artikel (2 per kategori, ditulis
dari nol) sudah live di https://bolaupdateindonesia.com. Belum: 3
artikel warisan WCM 2 tanpa kategori masih perlu dibersihkan dari tabel
`pages` production.

## Fase 3 — Frontend: Bangun dari Mockup 🟢 Selesai

Mockup homepage V1 (`docs/homepage-mockup-v1.html`, referensi NHK World)
**sudah diimplementasikan penuh ke kode PHP asli** (19 Agu 2026, sesi
lanjutan): `index.php`, `includes/site-header.php`,
`includes/site-footer.php`, `assets/css/site.css` ditulis ulang total ke
tema light — hero + panel Terpopuler, 3 band kategori berwarna (Liga
Indonesia/Liga Eropa/Timnas), grid Sorotan, widget Find more, strip
promo, footer gelap — semua data nyambung ke database real lewat fungsi
di `site-bootstrap.php` (tidak ada konten hardcode). `kategori.php` dan
`artikel.php` ikut dirapikan supaya konsisten. Nav kategori sudah pakai
4 kategori final. 8 artikel seed berhasil dimasukkan dan homepage/
kategori/artikel sudah diverifikasi visual di browser. **8 artikel seed
sekarang juga sudah punya featured image** — 4 ilustrasi SVG flat/
gradient abstrak (bukan foto/logo asli), satu per kategori, di
`assets/img/articles/`, tersambung lewat kolom `featured_image` +
`wpm_image_url()`. Belum: struktur permalink URL final (masih pola
`/artikel/{slug}` & `/kategori/{slug}` sama seperti wcm1_version1/
WCM 2), 3 artikel warisan WCM 2 tanpa kategori masih perlu dibersihkan
dari tabel `pages`.

## Fase 4 — Branding & Polish 🟢 Selesai (untuk lingkup sesi ini)

Nama brand & domain sudah ditentukan: **Bola Update Indonesia /
BolaUpdateIndonesia.com**. Rename tagline/nama di admin panel & frontend
sudah jalan. Mockup V1 (tema light/putih referensi NHK World, logo
merah, tipografi Space Grotesk + Fraunces + Manrope) **sudah
diimplementasikan ke kode PHP asli** — lihat Fase 3.
`assets/img/placeholder.svg` juga sudah diganti dari wordmark "Biang
Olahraga" (warisan WCM 2) ke "Bola Update Indonesia" dengan palet light.
Belum: logo grafis final (masih wordmark teks), favicon publik grafis
asli (masih placeholder warisan clone).

## Fase 5 — Pra-Launch & Deploy 🟢 Selesai — SITUS LIVE

Deploy ke GitHub + cPanel Git Version Control sudah tuntas dan situs
**FULL LIVE** di https://bolaupdateindonesia.com. Ringkasan:
- Riwayat `.git` lokal lama (warisan WCM 2 murni, remote salah ke
  `wcm-biangolahraga.com.git`) diaudit (tidak ada kredensial bocor) lalu
  di-reset bersih (backup disimpan di luar folder proyek). Commit awal
  WCM3 di-push ke
  `https://github.com/jalijali-dev/wcm-bolaupdateindonesia.com.git`
  branch `main`.
- `.cpanel.yml` diisi `DEPLOYPATH=/home/bolaupdateindone/public_html/`
  (path production sungguhan). Repo Git Version Control cPanel di
  `/home/bolaupdateindone/repositories/wcm-bolaupdateindonesia.com`.
- Config production (`database.php` — DB `bolaupdateindone_cms`,
  `DB_HOST=localhost`; `app.php` — `CMS_AI_ENC_SECRET` baru khusus
  production) dibuat manual di server via cPanel File Manager, tidak
  lewat git.
- "Deploy HEAD Commit" dijalankan sukses; homepage, 4 kategori, dan
  artikel semua tampil benar sesuai mockup V1.
- Kredensial admin awal (warisan WCM2) direset ke
  `admin@bolaupdateindonesia.com` + password baru; login production
  dikonfirmasi berhasil.

Belum (non-blocking, follow-up): isolasi infrastruktur (IP hosting beda
dari tentakel lain, akun Cloudflare, GSC property baru) masih perlu
diputuskan/dikerjakan operator; 3 artikel warisan WCM2 tanpa kategori
masih perlu dibersihkan dari `pages` production.

## Fase 6 — AI Automation Layer ⚪ Belum mulai

Modul Growth Agent ikut ter-clone (kode-nya ada, prompt sudah netral
dari sononya) — belum aktif dipakai generate konten apapun untuk Bola
Update Indonesia. Perlu disesuaikan ke konteks niche bola/olahraga umum
begitu kategori final WCM 3 jelas.

---

*Untuk checklist detail proses clone/handoff dan hal yang masih perlu
dikonfirmasi ke operator, lihat `docs/HANDOFF.md`. Standar umum
clone/handoff admin panel ada di
`wcm1_version1/docs/HANDOFF-CMS-ADMIN.md`.*
