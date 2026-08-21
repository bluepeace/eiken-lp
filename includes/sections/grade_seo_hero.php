<?php
/**
 * 級別SEOヒーロー
 * @var string $grade
 * @var array $grade_data from get_grade()
 * @var array $grade_content from get_grade_content()
 */
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../../config.php';
}
$name = $grade_data['name'] ?? '';
$name_short = $grade_data['name_short'] ?? '';
$level_label = $grade_content['level_label'] ?? '';
$hero_lead = $grade_content['hero_lead'] ?? ($grade_data['description'] ?? '');
?>
<section class="grade-seo-hero border-b border-slate-100 bg-gradient-to-b from-[#e8f8f9] to-white px-4 py-14 sm:py-20" aria-labelledby="grade-seo-hero-heading">
  <div class="lp-container mx-auto max-w-3xl text-center">
    <p class="section-badge section-badge--center" aria-hidden="true">GRADE</p>
    <?php if ($level_label !== ''): ?>
    <p class="mt-3 text-sm font-medium text-slate-500"><?php echo htmlspecialchars($level_label); ?>・英検対策アプリ</p>
    <?php endif; ?>
    <h1 id="grade-seo-hero-heading" class="mt-2 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">アプリで<?php echo htmlspecialchars($name); ?>対策をしよう</h1>
    <p class="mt-4 text-base leading-relaxed text-slate-700 sm:text-lg"><?php echo br_after_period($hero_lead); ?></p>
    <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
      <a class="inline-flex items-center justify-center rounded-full bg-[#50c2cb] px-7 py-3.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#46adb5]" href="<?php echo APP_URL; ?>/signup"><?php echo FREE_TRIAL_DAYS; ?>日間無料で始める</a>
      <a class="inline-flex items-center justify-center rounded-full border border-slate-300 bg-white px-6 py-3.5 text-sm font-semibold text-slate-700 transition hover:border-[#50c2cb]/50 hover:text-slate-900" href="#grade-skill-word"><?php echo htmlspecialchars($name_short); ?>の学習内容を見る</a>
    </div>
  </div>
</section>
