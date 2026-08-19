<?php declare(strict_types=1); ?>
  </div>
</main>

<footer class="wpm-footer">
  <div class="wpm-wrap wpm-footer__grid">
    <div>
      <h5>Kategori</h5>
      <?php foreach (wpm_site_nav_categories() as $navSlug => $navLabel): ?>
      <a href="<?= wpm_esc(wpm_category_url($navSlug)) ?>"><?= wpm_esc($navLabel) ?></a>
      <?php endforeach; ?>
    </div>
    <div>
      <h5>Tentang</h5>
      <a href="<?= wpm_esc(wpm_base_url('/')) ?>">Tentang Kami</a>
      <a href="<?= wpm_esc(wpm_base_url('/')) ?>">Redaksi</a>
      <a href="<?= wpm_esc(wpm_base_url('/')) ?>">Kontak</a>
      <a href="<?= wpm_esc(wpm_base_url('/')) ?>">Kebijakan Privasi</a>
    </div>
    <div>
      <h5>Ikuti Kami</h5>
      <a href="<?= wpm_esc(wpm_base_url('/')) ?>">Instagram</a>
      <a href="<?= wpm_esc(wpm_base_url('/')) ?>">X (Twitter)</a>
      <a href="<?= wpm_esc(wpm_base_url('/')) ?>">YouTube</a>
      <a href="<?= wpm_esc(wpm_base_url('/')) ?>">Facebook</a>
    </div>
  </div>
  <div class="wpm-wrap wpm-footer__bottom">
    <span class="wpm-footer__brand"><span class="wpm-brand__b1">BOLA</span><span>UPDATE</span></span>
    <span>&copy; <?= date('Y') ?> <?= wpm_esc(WPM_SITE_NAME) ?>. Seluruh hak cipta dilindungi.</span>
  </div>
</footer>
</body>
</html>
