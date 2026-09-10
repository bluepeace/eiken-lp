<?php
/**
 * 級別・中間CTA（強みの直後＝証拠を全部読む前）
 * @var array $grade_content
 */
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../../config.php';
}

$mid = $grade_content['mid_cta'] ?? null;
if (!is_array($mid)) {
    return;
}

$heading = (string) ($mid['heading'] ?? '');
if ($heading === '') {
    return;
}

$lead = (string) ($mid['lead'] ?? '');
$note = (string) ($mid['note'] ?? 'カード登録不要・1分で完了');
$button = (string) ($mid['button'] ?? (FREE_TRIAL_DAYS . '日間無料で試す'));
$secondary_label = (string) ($mid['secondary_label'] ?? '');
$secondary_href = (string) ($mid['secondary_href'] ?? '');
?>
<section class="grade-mid-cta px-4 py-12 sm:py-14" aria-labelledby="grade-mid-cta-heading">
  <div class="grade-mid-cta__inner">
    <p class="section-badge section-badge--center" aria-hidden="true">NOW</p>
    <h2 id="grade-mid-cta-heading" class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl"><?php echo $heading; ?></h2>
    <?php if ($lead !== ''): ?>
    <p class="grade-mid-cta__lead"><?php echo br_after_period($lead); ?></p>
    <?php endif; ?>
    <div class="grade-mid-cta__actions">
      <a class="grade-mid-cta__button" href="<?php echo APP_URL; ?>/signup"><?php echo htmlspecialchars($button); ?></a>
      <?php if ($secondary_label !== '' && $secondary_href !== ''): ?>
      <a class="grade-mid-cta__secondary" href="<?php echo htmlspecialchars($secondary_href); ?>"><?php echo htmlspecialchars($secondary_label); ?></a>
      <?php endif; ?>
    </div>
    <?php if ($note !== ''): ?>
    <p class="grade-mid-cta__note"><?php echo htmlspecialchars($note); ?></p>
    <?php endif; ?>
  </div>
</section>
