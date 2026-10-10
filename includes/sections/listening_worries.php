<?php
/**
 * こんな悩みはありませんか？
 * @var array $listening
 */
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../../config.php';
}
$worries = is_array($listening['worries'] ?? null) ? $listening['worries'] : [];
if ($worries === []) {
    return;
}
?>
<section id="listening-worries" class="border-t border-slate-100 bg-white px-4 py-16 sm:py-20" aria-labelledby="listening-worries-heading">
  <div class="lp-container">
    <div class="mx-auto max-w-3xl text-center">
      <p class="section-badge section-badge--center" aria-hidden="true">WORRIES</p>
      <h2 id="listening-worries-heading" class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">こんな悩みはありませんか？</h2>
    </div>
    <ul class="writing-worry-list mt-10 sm:mt-12">
      <?php foreach ($worries as $worry): ?>
      <li><?php echo htmlspecialchars((string) $worry); ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
