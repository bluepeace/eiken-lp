<?php
/**
 * スピーキング LP ヒーロー
 * @var string $grade
 * @var array $grade_data
 * @var array $speaking
 * @var string $speaking_primary_href
 */
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../../config.php';
}
require_once __DIR__ . '/../grade-data.php';
require_once __DIR__ . '/../speaking-data.php';

$name = (string) ($grade_data['name'] ?? '');
$name_short = (string) ($grade_data['name_short'] ?? '');
$lead = (string) ($speaking['lead'] ?? '');
$hero_note = (string) ($speaking['hero_note'] ?? '');
$chips = is_array($speaking['chips'] ?? null) ? $speaking['chips'] : [];
$primary_label = (string) ($speaking['primary_label'] ?? '無料で練習する');
$screen = grade_screen_url($grade, 'speaking-1');
$screen_alt = (string) ($speaking['screen_alt'] ?? ($name . 'のスピーキング練習画面'));
$hero_bg = grade_hero_bg_url($grade);
$has_scene = grade_has_hero_scene($grade);
$hero_class = 'grade-seo-hero speaking-hero relative overflow-hidden px-4 py-10 sm:py-12 md:py-16';
if ($has_scene) {
    $hero_class .= ' grade-seo-hero--scene';
}
$grade_slug = preg_replace('/[^a-z0-9-]/', '', (string) $grade);
if ($grade_slug !== '') {
    $hero_class .= ' grade-seo-hero--' . $grade_slug;
}
?>
<section class="<?php echo $hero_class; ?>" aria-labelledby="speaking-hero-heading">
  <div class="pointer-events-none absolute inset-0" aria-hidden="true">
    <img src="<?php echo htmlspecialchars($hero_bg, ENT_QUOTES, 'UTF-8'); ?>" alt="" class="hero-bg-image h-full w-full object-cover" loading="eager" fetchpriority="high" width="1920" height="1080">
    <div class="hero-bg-overlay absolute inset-0"></div>
  </div>
  <div class="relative z-10 lp-container flex flex-col items-start gap-8 lg:flex-row lg:items-center lg:gap-12">
    <div class="w-full flex-1 space-y-4 text-left sm:space-y-5">
      <p class="section-badge">SPEAKING</p>
      <h1 id="speaking-hero-heading" class="text-2xl font-bold leading-[1.4] tracking-tight sm:text-3xl md:text-4xl">
        <span class="block text-brand-accent"><?php echo htmlspecialchars($name); ?>のスピーキング対策</span>
        <span class="hero-heading__sub block">AIで面接・発話練習</span>
      </h1>
      <?php if ($chips !== []): ?>
      <ul class="grade-seo-hero__chips">
        <?php foreach ($chips as $chip): ?>
        <li class="grade-seo-hero__chip"><?php echo htmlspecialchars((string) $chip); ?></li>
        <?php endforeach; ?>
      </ul>
      <?php endif; ?>
      <p class="max-w-lg text-base leading-relaxed text-[#232323]"><?php echo br_after_period(htmlspecialchars($lead, ENT_QUOTES, 'UTF-8')); ?></p>
      <div class="flex flex-col gap-3 sm:flex-row sm:justify-start">
        <a class="inline-flex items-center justify-center rounded-full bg-[#50c2cb] px-8 py-3.5 text-base font-semibold text-white shadow-lg shadow-[#50c2cb]/25 transition hover:bg-[#46adb5] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#50c2cb]/60 focus-visible:ring-offset-2" href="<?php echo htmlspecialchars($speaking_primary_href, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($primary_label); ?></a>
        <a class="inline-flex items-center justify-center rounded-full border-2 border-[#50c2cb] bg-white px-8 py-3.5 text-base font-semibold text-slate-800 transition hover:border-[#46adb5] hover:bg-[#50c2cb]/5 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#50c2cb]/60 focus-visible:ring-offset-2" href="#speaking-practice"><?php echo htmlspecialchars($name_short); ?>の練習内容を見る</a>
      </div>
      <?php if ($hero_note !== ''): ?>
      <p class="max-w-lg text-sm leading-relaxed text-slate-600"><?php echo br_after_period(htmlspecialchars($hero_note, ENT_QUOTES, 'UTF-8')); ?></p>
      <?php endif; ?>
      <?php
      $store_align = 'start';
      $store_on_hero = true;
      include __DIR__ . '/../store-cta.php';
      ?>
    </div>
    <div class="speaking-hero__visual w-full flex-1">
      <button
        type="button"
        class="grade-capture-card__zoom speaking-hero__zoom"
        data-grade-lightbox="<?php echo htmlspecialchars($screen, ENT_QUOTES, 'UTF-8'); ?>"
        data-grade-lightbox-caption="<?php echo htmlspecialchars($name . 'のスピーキング練習', ENT_QUOTES, 'UTF-8'); ?>"
        data-grade-lightbox-alt="<?php echo htmlspecialchars($screen_alt, ENT_QUOTES, 'UTF-8'); ?>"
        aria-label="<?php echo htmlspecialchars($name . 'の練習画面を拡大表示', ENT_QUOTES, 'UTF-8'); ?>"
      >
        <span class="grade-capture-card__frame speaking-hero__frame">
          <img src="<?php echo htmlspecialchars($screen, ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($screen_alt, ENT_QUOTES, 'UTF-8'); ?>" class="speaking-hero__img" width="1024" height="638" loading="eager" decoding="async">
        </span>
        <span class="grade-capture-card__zoom-hint" aria-hidden="true">拡大</span>
      </button>
    </div>
  </div>
</section>
