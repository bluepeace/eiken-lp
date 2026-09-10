<?php
/**
 * 級別SEOヒーロー（TOPヒーローのコンパクト版）
 * @var string $grade
 * @var array $grade_data from get_grade()
 * @var array $grade_content from get_grade_content()
 */
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../../config.php';
}
require_once __DIR__ . '/../grade-data.php';
$name = $grade_data['name'] ?? '';
$name_short = $grade_data['name_short'] ?? '';
$level_label = $grade_content['level_label'] ?? '';
$hero_kicker = $grade_content['hero_kicker'] ?? '英検対策アプリ';
$hero_headline = $grade_content['hero_headline'] ?? ($name_short . '対策を、本試験形式で。');
$hero_lead = $grade_content['hero_lead'] ?? ($grade_data['description'] ?? '');
$hero_chips = $grade_content['hero_chips'] ?? [];
if ($hero_chips === []) {
    if ($level_label !== '') {
        $hero_chips[] = $level_label;
    }
    $hero_chips[] = '本試験形式';
}
$hero_bg = grade_hero_bg_url($grade);
$has_scene = grade_has_hero_scene($grade);
$hero_section_class = 'grade-seo-hero relative overflow-hidden px-4 py-10 sm:py-12 md:py-16';
if ($has_scene) {
    $hero_section_class .= ' grade-seo-hero--scene';
}
$hero_mockup_alt = $name !== ''
    ? htmlspecialchars(SITE_NAME, ENT_QUOTES, 'UTF-8') . 'の' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '対策画面'
    : htmlspecialchars(SITE_NAME, ENT_QUOTES, 'UTF-8') . 'アプリの画面イメージ';
?>
<section class="<?php echo $hero_section_class; ?>" aria-labelledby="grade-seo-hero-heading">
  <div class="pointer-events-none absolute inset-0" aria-hidden="true">
    <img src="<?php echo htmlspecialchars($hero_bg, ENT_QUOTES, 'UTF-8'); ?>" alt="" class="hero-bg-image h-full w-full object-cover" loading="eager" fetchpriority="high" width="1920" height="1080">
    <div class="hero-bg-overlay absolute inset-0"></div>
  </div>
  <div class="relative z-10 lp-container flex flex-col items-start gap-8 lg:flex-row lg:items-center lg:gap-12">
    <div class="w-full flex-1 space-y-4 text-left sm:space-y-5">
      <h1 id="grade-seo-hero-heading" class="text-2xl font-bold leading-[1.4] tracking-tight sm:text-3xl md:text-4xl">
        <span class="block text-brand-accent"><?php echo htmlspecialchars($hero_kicker); ?></span>
        <span class="hero-heading__sub block"><?php echo htmlspecialchars($hero_headline); ?></span>
      </h1>
      <?php if ($hero_chips !== []): ?>
      <ul class="grade-seo-hero__chips">
        <?php foreach ($hero_chips as $chip): ?>
        <li class="grade-seo-hero__chip"><?php echo htmlspecialchars((string) $chip); ?></li>
        <?php endforeach; ?>
      </ul>
      <?php endif; ?>
      <p class="max-w-lg text-base leading-relaxed text-[#232323]"><?php echo br_after_period($hero_lead); ?></p>
      <div class="flex flex-col gap-3 sm:flex-row sm:justify-start">
        <a class="inline-flex items-center justify-center rounded-full bg-[#50c2cb] px-8 py-3.5 text-base font-semibold text-white shadow-lg shadow-[#50c2cb]/25 transition hover:bg-[#46adb5] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#50c2cb]/60 focus-visible:ring-offset-2" href="<?php echo APP_URL; ?>/signup"><?php echo FREE_TRIAL_DAYS; ?>日間無料で試す</a>
        <a class="inline-flex items-center justify-center rounded-full border-2 border-[#50c2cb] bg-white px-8 py-3.5 text-base font-semibold text-slate-800 transition hover:border-[#46adb5] hover:bg-[#50c2cb]/5 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#50c2cb]/60 focus-visible:ring-offset-2" href="#grade-skill-word"><?php echo htmlspecialchars($name_short); ?>の学習内容を見る</a>
      </div>
    </div>
    <div class="grade-seo-hero__mockup hero-mockup flex-1 w-full">
      <img src="/assets/images/hero-mockup.png" alt="<?php echo $hero_mockup_alt; ?>" width="640" height="480" class="hero-mockup__image mx-auto" loading="eager">
    </div>
  </div>
</section>
