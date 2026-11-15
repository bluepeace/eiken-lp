<?php
/**
 * 文法 LP ヒーロー
 * @var string $grade
 * @var array $grade_data
 * @var array $grammar
 * @var string $grammar_signup_href
 */
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../../config.php';
}
require_once __DIR__ . '/../grade-data.php';
require_once __DIR__ . '/../grammar-data.php';

$name = (string) ($grade_data['name'] ?? '');
$lead = (string) ($grammar['lead'] ?? '');
$note = (string) ($grammar['note'] ?? '');
$h1_sub = (string) ($grammar['h1_sub'] ?? '');
$lines = is_array($grammar['hero_lines'] ?? null) ? $grammar['hero_lines'] : [];
$chips = is_array($grammar['chips'] ?? null) ? $grammar['chips'] : [];
$screen = grammar_shot_url($grade, 'grammar-1');
$screen_alt = $name . 'の文法。テーマ一覧';
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
<section class="<?php echo $hero_class; ?>" aria-labelledby="grammar-hero-heading">
  <div class="pointer-events-none absolute inset-0" aria-hidden="true">
    <img src="<?php echo htmlspecialchars($hero_bg, ENT_QUOTES, 'UTF-8'); ?>" alt="" class="hero-bg-image h-full w-full object-cover" loading="eager" fetchpriority="high" width="1920" height="1080">
    <div class="hero-bg-overlay absolute inset-0"></div>
  </div>
  <div class="relative z-10 lp-container flex flex-col items-start gap-8 lg:flex-row lg:items-center lg:gap-12">
    <div class="w-full flex-1 space-y-4 text-left sm:space-y-5">
      <p class="section-badge">GRAMMAR</p>
      <h1 id="grammar-hero-heading" class="text-2xl font-bold leading-[1.4] tracking-tight sm:text-3xl md:text-4xl">
        <span class="block text-brand-accent"><?php echo htmlspecialchars($name); ?>の文法</span>
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
      <?php if ($note !== ''): ?>
      <p class="max-w-lg text-sm leading-relaxed text-[#232323]"><?php echo htmlspecialchars($note); ?></p>
      <?php endif; ?>
      <?php if ($lines !== []): ?>
      <ul class="writing-hero-lines">
        <?php foreach ($lines as $line): ?>
        <li><?php echo htmlspecialchars((string) $line); ?></li>
        <?php endforeach; ?>
      </ul>
      <?php endif; ?>
      <div class="flex flex-col gap-3 sm:flex-row sm:flex-wrap sm:justify-start">
        <a class="inline-flex items-center justify-center rounded-full bg-[#50c2cb] px-8 py-3.5 text-base font-semibold text-white shadow-lg shadow-[#50c2cb]/25 transition hover:bg-[#46adb5] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#50c2cb]/60 focus-visible:ring-offset-2" href="<?php echo htmlspecialchars(lp_app_link($grammar_signup_href, 'hero'), ENT_QUOTES, 'UTF-8'); ?>">無料で文法の確認を始める</a>
        <a class="inline-flex items-center justify-center rounded-full border-2 border-[#50c2cb] bg-white px-8 py-3.5 text-base font-semibold text-slate-800 transition hover:border-[#46adb5] hover:bg-[#50c2cb]/5 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#50c2cb]/60 focus-visible:ring-offset-2" href="#grammar-themes">テーマ一覧を見る</a>
      </div>
      <?php
      $store_align = 'start';
      $store_on_hero = true;
      include __DIR__ . '/../store-cta.php';
      ?>
      <?php include __DIR__ . '/../lp-exam-countdown.php'; ?>
      <?php include __DIR__ . '/../lp-latest-update.php'; ?>
    </div>
    <?php if ($screen !== ''): ?>
    <div class="speaking-hero__visual w-full flex-1">
      <figure>
        <button
          type="button"
          class="grade-capture-card__zoom speaking-hero__zoom"
          data-grade-lightbox="<?php echo htmlspecialchars($screen, ENT_QUOTES, 'UTF-8'); ?>"
          data-grade-lightbox-caption="<?php echo htmlspecialchars($name . 'の文法。テーマ一覧', ENT_QUOTES, 'UTF-8'); ?>"
          data-grade-lightbox-alt="<?php echo htmlspecialchars($screen_alt, ENT_QUOTES, 'UTF-8'); ?>"
          aria-label="<?php echo htmlspecialchars($name . 'の文法のテーマ一覧を拡大表示', ENT_QUOTES, 'UTF-8'); ?>"
        >
          <span class="grade-capture-card__frame speaking-hero__frame">
            <img src="<?php echo htmlspecialchars($screen, ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($screen_alt, ENT_QUOTES, 'UTF-8'); ?>" class="speaking-hero__img" width="1024" height="633" loading="eager" decoding="async">
          </span>
          <span class="grade-capture-card__zoom-hint" aria-hidden="true">拡大</span>
        </button>
        <figcaption class="speaking-example__caption">テーマ一覧。未学習か、正答数が残ります。</figcaption>
      </figure>
    </div>
    <?php endif; ?>
  </div>
</section>
