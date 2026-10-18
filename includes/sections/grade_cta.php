<?php
/**
 * 級別・最終CTA（GO）
 * @var array $grade_content
 * @var array $grade_data
 */
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../../config.php';
}

$cta = $grade_content['cta'] ?? null;
if (!is_array($cta)) {
    return;
}

$name_short = (string) ($grade_data['name_short'] ?? '英検');
$heading = (string) ($cta['heading'] ?? ($name_short . '対策を、<span class="heading-accent">今日から</span>。'));
if ($heading === '') {
    return;
}
$lead = (string) ($cta['lead'] ?? '');
$note = (string) ($cta['note'] ?? 'カード登録不要・1分で完了');
?>
<section class="border-t border-slate-100 bg-white px-4 py-16 sm:py-20" aria-labelledby="grade-cta-heading">
  <div class="mx-auto max-w-2xl text-center">
    <p class="section-badge section-badge--center" aria-hidden="true">GO</p>
    <h2 id="grade-cta-heading" class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl"><?php echo $heading; ?></h2>
    <?php if ($lead !== ''): ?>
    <p class="mt-3 text-slate-600"><?php echo br_after_period($lead); ?></p>
    <?php endif; ?>
    <div class="mt-8 flex justify-center">
      <a class="inline-flex items-center justify-center gap-2 rounded-full bg-[#50c2cb] px-10 py-4 text-lg font-semibold text-white shadow-lg shadow-[#50c2cb]/25 transition hover:bg-[#46adb5] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#50c2cb]/60 focus-visible:ring-offset-2" href="<?php echo APP_URL; ?>/signup"><?php echo lp_start_cta_inner('h-5 w-5'); ?></a>
    </div>
    <?php include __DIR__ . '/../store-cta.php'; ?>
    <?php if ($note !== ''): ?>
    <p class="mt-4 text-sm text-slate-500"><?php echo htmlspecialchars($note); ?></p>
    <?php endif; ?>
  </div>
</section>
