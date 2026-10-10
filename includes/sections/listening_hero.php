<?php
/**
 * リスニング LP ヒーロー
 * @var string $grade
 * @var array $grade_data
 * @var array $listening
 * @var string $listening_signup_href
 */
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../../config.php';
}
require_once __DIR__ . '/../grade-data.php';
require_once __DIR__ . '/../listening-data.php';

$name = (string) ($grade_data['name'] ?? '');
$lead = (string) ($listening['lead'] ?? '');
$h1_sub = (string) ($listening['h1_sub'] ?? '実践問題で聞き取り力を鍛える');
$lines = is_array($listening['hero_lines'] ?? null) ? $listening['hero_lines'] : [];
$chips = is_array($listening['chips'] ?? null) ? $listening['chips'] : [];
$secondary = (string) ($listening['secondary_label'] ?? '出題形式を見る');
$screen = listening_shot_url($grade, 'listening-1');
$screen_alt = (string) ($listening['screen_alt'] ?? ($name . 'のリスニング練習画面'));
$screen_caption = (string) ($listening['screen_caption'] ?? '');
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
<section class="<?php echo $hero_class; ?>" aria-labelledby="listening-hero-heading">
  <div class="pointer-events-none absolute inset-0" aria-hidden="true">
    <img src="<?php echo htmlspecialchars($hero_bg, ENT_QUOTES, 'UTF-8'); ?>" alt="" class="hero-bg-image h-full w-full object-cover" loading="eager" fetchpriority="high" width="1920" height="1080">
    <div class="hero-bg-overlay absolute inset-0"></div>
  </div>
  <div class="relative z-10 lp-container flex flex-col items-start gap-8 lg:flex-row lg:items-center lg:gap-12">
    <div class="w-full flex-1 space-y-4 text-left sm:space-y-5">
      <p class="section-badge">LISTENING</p>
      <h1 id="listening-hero-heading" class="text-2xl font-bold leading-[1.4] tracking-tight sm:text-3xl md:text-4xl">
        <span class="block text-brand-accent"><?php echo htmlspecialchars($name); ?>のリスニング対策</span>
        <span class="hero-heading__sub block"><?php echo htmlspecialchars($h1_sub); ?></span>
      </h1>
      <?php if ($chips !== []): ?>
      <ul class="grade-seo-hero__chips">
        <?php foreach ($chips as $chip): ?>
        <li class="grade-seo-hero__chip"><?php echo htmlspecialchars((string) $chip); ?></li>
        <?php endforeach; ?>
      </ul>
      <?php endif; ?>
      <p class="max-w-lg text-base leading-relaxed text-[#232323]"><?php echo br_after_period(htmlspecialchars($lead, ENT_QUOTES, 'UTF-8')); ?></p>
      <?php if ($lines !== []): ?>
      <ul class="writing-hero-lines">
        <?php foreach ($lines as $line): ?>
        <li><?php echo htmlspecialchars((string) $line); ?></li>
        <?php endforeach; ?>
      </ul>
      <?php endif; ?>
      <div class="flex flex-col gap-3 sm:flex-row sm:flex-wrap sm:justify-start">
        <a class="inline-flex items-center justify-center rounded-full bg-[#50c2cb] px-8 py-3.5 text-base font-semibold text-white shadow-lg shadow-[#50c2cb]/25 transition hover:bg-[#46adb5] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#50c2cb]/60 focus-visible:ring-offset-2" href="<?php echo htmlspecialchars($listening_signup_href, ENT_QUOTES, 'UTF-8'); ?>">無料でリスニング対策を始める</a>
        <a class="inline-flex items-center justify-center rounded-full border-2 border-[#50c2cb] bg-white px-8 py-3.5 text-base font-semibold text-slate-800 transition hover:border-[#46adb5] hover:bg-[#50c2cb]/5 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#50c2cb]/60 focus-visible:ring-offset-2" href="#listening-practice"><?php echo htmlspecialchars($secondary); ?></a>
      </div>
      <?php
      $store_align = 'start';
      $store_on_hero = true;
      include __DIR__ . '/../store-cta.php';
      ?>
    </div>
    <?php if ($screen !== ''): ?>
    <div class="speaking-hero__visual w-full flex-1">
      <figure>
        <button
          type="button"
          class="grade-capture-card__zoom speaking-hero__zoom"
          data-grade-lightbox="<?php echo htmlspecialchars($screen, ENT_QUOTES, 'UTF-8'); ?>"
          data-grade-lightbox-caption="<?php echo htmlspecialchars($name . 'のリスニング', ENT_QUOTES, 'UTF-8'); ?>"
          data-grade-lightbox-alt="<?php echo htmlspecialchars($screen_alt, ENT_QUOTES, 'UTF-8'); ?>"
          aria-label="<?php echo htmlspecialchars($name . 'のリスニング画面を拡大表示', ENT_QUOTES, 'UTF-8'); ?>"
        >
          <span class="grade-capture-card__frame speaking-hero__frame">
            <img src="<?php echo htmlspecialchars($screen, ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($screen_alt, ENT_QUOTES, 'UTF-8'); ?>" class="speaking-hero__img" width="1024" height="638" loading="eager" decoding="async">
          </span>
          <span class="grade-capture-card__zoom-hint" aria-hidden="true">拡大</span>
        </button>
        <?php if ($screen_caption !== ''): ?>
        <figcaption class="speaking-example__caption"><?php echo br_after_period(htmlspecialchars($screen_caption, ENT_QUOTES, 'UTF-8')); ?></figcaption>
        <?php endif; ?>
      </figure>
    </div>
    <?php endif; ?>
  </div>
</section>
