<?php
/**
 * この級のスピーキングで大切なこと
 * @var array $grade_data
 * @var array $speaking
 */
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../../config.php';
}

$name_short = (string) ($grade_data['name_short'] ?? '');
$compare = (string) ($speaking['compare'] ?? '');
$points = is_array($speaking['points'] ?? null) ? $speaking['points'] : [];
if ($points === []) {
    return;
}
?>
<section id="speaking-points" class="border-t border-slate-100 bg-white px-4 py-16 sm:py-20" aria-labelledby="speaking-points-heading">
  <div class="lp-container">
    <div class="mx-auto max-w-3xl text-center">
      <p class="section-badge section-badge--center" aria-hidden="true">POINTS</p>
      <h2 id="speaking-points-heading" class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl"><?php echo htmlspecialchars($name_short); ?>のスピーキング対策で大切なこと</h2>
    </div>
    <?php if ($compare !== ''): ?>
    <p class="speaking-compare"><?php echo br_after_period(htmlspecialchars($compare, ENT_QUOTES, 'UTF-8')); ?></p>
    <?php endif; ?>
    <ol class="speaking-point-grid<?php echo $compare !== '' ? ' mt-8' : ' mt-10 sm:mt-12'; ?>">
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
