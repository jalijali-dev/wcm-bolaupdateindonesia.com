<?php
declare(strict_types=1);
/**
 * includes/site-header.php — shared header partial for Bola Update Indonesia.
 * Implements the approved mockup (docs/homepage-mockup-v1.html): light/white
 * theme (referensi visual NHK World), brand "BOLA" (merah) + "UPDATE" (hitam)
 * kiri atas, nav kategori, search kanan, topics strip. Opens
 * <main class="wpm-content"><div class="wpm-wrap"> — every page using this
 * partial MUST close both before site-footer.php (site-footer.php closes
 * them for you, mirroring the old contract).
 *
 * Expects (optional): $pageTitle, $metaDescription, $activeNavSlug.
 */
$pageTitle = $pageTitle ?? WPM_SITE_NAME;
$metaDescription = $metaDescription ?? WPM_SITE_TAGLINE;
$activeNavSlug = $activeNavSlug ?? '';
$navCategories = wpm_site_nav_categories();
?><!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= wpm_esc($pageTitle) ?></title>
<meta name="description" content="<?= wpm_esc($metaDescription) ?>">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,500;0,9..144,600;0,9..144,700;1,9..144,600&family=Space+Grotesk:wght@500;700&family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= wpm_esc(wpm_base_url('/assets/css/site.css')) ?>">
<link rel="icon" type="image/svg+xml" href="<?= wpm_esc(wpm_base_url('/assets/img/favicon.svg')) ?>">
<link rel="alternate icon" href="<?= wpm_esc(wpm_base_url('/assets/img/favicon.ico')) ?>">
</head>
<body>

<header class="wpm-header">
  <div class="wpm-wrap wpm-topbar">
    <a href="<?= wpm_esc(wpm_base_url('/')) ?>" class="wpm-brand">
      <img src="<?= wpm_esc(wpm_base_url('/assets/img/favicon.svg')) ?>" alt="" class="wpm-brand__icon" width="28" height="28">
      <span class="wpm-brand__b1">BOLA</span><span class="wpm-brand__b2">UPDATE</span>
    </a>
    <nav class="wpm-nav" aria-label="Navigasi utama">
      <a href="<?= wpm_esc(wpm_base_url('/')) ?>" class="<?= $activeNavSlug === 'home' ? 'is-active' : '' ?>">Home</a>
      <?php foreach ($navCategories as $navSlug => $navLabel): ?>
      <a href="<?= wpm_esc(wpm_category_url($navSlug)) ?>" class="<?= $activeNavSlug === $navSlug ? 'is-active' : '' ?>"><?= wpm_esc($navLabel) ?></a>
      <?php endforeach; ?>
    </nav>
    <form class="wpm-search" action="<?= wpm_esc(wpm_base_url('/cari.php')) ?>" method="get" role="search">
      <svg width="14" height="14" viewBox="0 0 24 24" aria-hidden="true"><path d="m21 21-4.35-4.35m1.35-5.65a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
      <input type="text" name="q" placeholder="Cari berita bola&hellip;" aria-label="Cari berita">
    </form>
  </div>
  <?php
    // Topics strip: real category chips (linked), not hardcoded hashtags.
  ?>
  <div class="wpm-wrap wpm-topics">
    <b>Topik:</b>
    <?php foreach ($navCategories as $navSlug => $navLabel): ?>
      <a href="<?= wpm_esc(wpm_category_url($navSlug)) ?>">#<?= wpm_esc(str_replace(' ', '', $navLabel)) ?></a>
    <?php endforeach; ?>
  </div>
</header>

<main class="wpm-content">
  <div class="wpm-wrap">
