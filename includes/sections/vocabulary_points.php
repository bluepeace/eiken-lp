<?php
/**
 * この級の単語対策のポイント
 * @var array $grade_data
 * @var array $vocabulary
 */
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../../config.php';
}
$name_short = (string) ($grade_data['name_short'] ?? '');
$points = is_array($vocabulary['points'] ?? null) ? $vocabulary['points'] : [];
if ($points === []) {
    return;
}
?>
<section id="vocabulary-points" class="border-t border-slate-100 bg-slate-50/50 px-4 py-16 sm:py-20" aria-labelledby="vocabulary-points-heading">
  <div class="lp-container">
    <div class="mx-auto max-w-3xl text-center">
      <p class="section-badge section-badge--center" aria-hidden="true">POINTS</p>
      <h2 id="vocabulary-points-heading" class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl"><?php echo htmlspecialchars($name_short); ?>の単語対策のポイント</h2>
      <?php if (!empty($vocabulary['vocab_line'])): ?>
      <p class="mt-3 text-slate-600"><?php echo br_after_period(htmlspecialchars((string) $vocabulary['vocab_line'], ENT_QUOTES, 'UTF-8')); ?></p>
      <?php endif; ?>
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
