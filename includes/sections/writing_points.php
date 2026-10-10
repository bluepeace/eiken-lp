<?php
/**
 * この級のライティング対策のポイント
 * @var array $grade_data
 * @var array $writing
 */
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../../config.php';
}
$name_short = (string) ($grade_data['name_short'] ?? '');
$points = is_array($writing['points'] ?? null) ? $writing['points'] : [];
if ($points === []) {
    return;
}
?>
<section id="writing-points" class="border-t border-slate-100 bg-slate-50/50 px-4 py-16 sm:py-20" aria-labelledby="writing-points-heading">
  <div class="lp-container">
    <div class="mx-auto max-w-3xl text-center">
      <p class="section-badge section-badge--center" aria-hidden="true">POINTS</p>
      <h2 id="writing-points-heading" class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl"><?php echo htmlspecialchars($name_short); ?>のライティング対策のポイント</h2>
    </div>
    <ol class="speaking-point-grid mt-10 sm:mt-12">
      <?php foreach ($points as $i => $point): ?>
      <li class="speaking-point">
        <p class="speaking-point__no"><?php echo (int) ($i + 1); ?></p>
        <h3 class="speaking-point__title"><?php echo htmlspecialchars((string) ($point['title'] ?? '')); ?></h3>
        <p class="speaking-point__text"><?php echo br_after_period(htmlspecialchars((string) ($point['text'] ?? ''), ENT_QUOTES, 'UTF-8')); ?></p>
      </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>
