# Progress Roadmap — WCM 3 - Version 1

Status per 19 Agustus 2026.

Legenda: 🟢 Selesai · 🟠 Sebagian · ⚪ Belum mulai

> **Konteks:** WCM 3 V.1 (BolaUpdateIndonesia.com) adalah "Tentakel 3",
> SEJAJAR dengan WCM 2 V.1 (biangolahraga.com) — sama-sama cabang
> langsung dari WCM 1 V.1 (olahraga77.com), BUKAN turunan WCM 2 V.1.
> `cms-admin/` di-clone dari WCM 2 V.1 sesuai Work Order 004, tapi
> backlink WCM 3 mengarah ke WCM 1 V.1 (olahraga77.com), bukan ke WCM 2.
> Niche: bola & seputar olahraga umum — beda dari niche multi-cabang
> spesifik (Bulu Tangkis/Tinju/Moto GP/Tips) kepunyaan WCM 2 V.1.
>
> **Catatan penting:** folder kerja proyek ini (`wcm3_version1`) awalnya
> berisi penuh dokumen & config proyek WCM 2 (Biang Olahraga) — bukan
> folder WCM 3 yang genuinely baru/kosong. Sesi 19 Agu 2026 mulai proses
> rename branding (domain, tagline, DB name, secret) dari WCM 2 ke WCM 3.
> Kategori nav final sudah diputuskan (Liga Indonesia/Liga Eropa/Timnas/
> Transfer) dan mockup homepage V1 sudah dibuat & disetujui (referensi
> NHK World, light theme, logo merah). Yang masih warisan Biang Olahraga
> dan BELUM diaudit/diimplementasikan: `cms-admin/` modul-modul lain,
> tema visual di kode PHP asli (mockup masih HTML statis terpisah) —
> lihat `docs/HANDOFF.md` untuk daftar lengkap.

## Fase 0 — Pondasi ⚪ Belum mulai

Domain BolaUpdateIndonesia.com — status pembelian belum dikonfirmasi.
Belum ada Git repo yang terverifikasi milik WCM 3 (folder ini punya
`.git`/`.cpanel.yml` warisan yang belum dicek remote-nya), hosting, atau
GSC. Status database `wcm3_version1` di MySQL dev
lokal (sudah dibuat & kosong, atau belum) juga belum dikonfirmasi
operator.

## Fase 1 — Backend: Schema & Adaptasi CMS 🟠 Sebagian

`cms-admin/` di-clone dari WCM 2 V.1 (bukan dari wcm1_version1
langsung — beda pola dari WCM 2 yang di-clone dari WCM 1). Rename
branding sudah jalan: `DB_NAME` → `wcm3_version1`,
`CMS_AI_ENC_SECRET` digenerate ulang, `CMS_ADMIN_TAGLINE` → "Bola
Update Indonesia". Belum: konfirmasi database benar-benar kosong di
MySQL, schema migration, audit modul cms-admin sesuai niche bola/
olahraga umum (belum diulang khusus untuk WCM 3), `GROWTH_AGENT_
DIGEST_TOKEN` masih placeholder.

## Fase 2 — Backend: Isi Konten Struktural ⚪ Belum mulai

Niche ditentukan (bola & seputar olahraga umum) dan kategori nav final
sudah diputuskan operator (19 Agu 2026): **Liga Indonesia, Liga Eropa,
Timnas, Transfer**. Belum ada satu kategori atau artikel pun dibuat
untuk WCM 3 di database — nunggu schema migration & database
dikonfirmasi kosong dulu.

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

## Fase 5 — Pra-Launch 🟠 Sebagian

Mulai deploy prep ke GitHub + cPanel Git Version Control. **Git repo WCM3
sudah live**: riwayat `.git` lokal lama ternyata warisan WCM 2 murni (1
commit "biangolahraga.com go-live prep", remote salah ke
`wcm-biangolahraga.com.git`) — sudah diaudit (tidak ada kredensial bocor)
lalu dibuang & di-reinit bersih (backup disimpan di luar folder proyek,
bukan dihapus). Commit awal WCM3 (119 file, source only, tanpa
kredensial) sudah di-push ke
`https://github.com/jalijali-dev/wcm-bolaupdateindonesia.com.git` branch
`main`. `.gitignore` dikonfirmasi masih benar (config kredensial +
uploads + script `_*.php` ter-exclude).

Belum: `.cpanel.yml` masih placeholder DEPLOYPATH (nunggu username/path
lengkap cPanel dari operator — folder docroot addon domain sudah
dikonfirmasi bernama `bolaupdateindonesia.com`), config production
(`database.php`/`app.php` server — kredensial DB cPanel + `CMS_AI_ENC_SECRET`
baru khusus production) masih perlu diisi manual oleh operator lewat
cPanel File Manager, dan verifikasi isi `article_categories` di database
production (`bolaupdateindone_cms`) masih perlu dicek manual oleh
operator lewat phpMyAdmin sebelum publish artikel pertama di sana.
Isolasi infrastruktur (IP hosting, akun Cloudflare, GSC) masih perlu
diputuskan operator.

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
