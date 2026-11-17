<?php if (!defined('SITE_NAME')) { require_once __DIR__ . '/../../config.php'; } ?>
<section class="relative overflow-hidden px-4 py-16 sm:py-20 md:py-24" aria-labelledby="hero-heading">
  <div class="pointer-events-none absolute inset-0" aria-hidden="true">
    <?php echo lp_picture([
        'src' => '/assets/images/hero-bg.png',
        'alt' => '',
        'width' => 1920,
        'height' => 1080,
        'class' => 'hero-bg-image h-full w-full object-cover',
        'loading' => 'eager',
        'fetchpriority' => 'high',
    ]); ?>
    <div class="hero-bg-overlay absolute inset-0"></div>
  </div>
  <div class="relative z-10 lp-container flex flex-col items-start gap-12 lg:flex-row lg:items-center lg:gap-16">
    <div class="w-full flex-1 space-y-6 text-left">
      <p class="text-sm font-medium text-[#007f89]">最終更新 <time datetime="2026-11-15">2026年11月15日</time>。11月2日にAndroidアプリを公開しました。</p>
      <h1 id="hero-heading" class="text-3xl font-bold leading-[1.4] tracking-tight sm:text-4xl md:text-5xl">
        <span class="block text-brand-accent">英検対策アプリはAiKen</span>
        <span class="hero-heading__sub block">5級〜1級を本試験形式で</span>
      </h1>
      <ul class="grade-seo-hero__chips">
        <li class="grade-seo-hero__chip">要約対応</li>
        <li class="grade-seo-hero__chip">Eメール対応</li>
        <li class="grade-seo-hero__chip">準2級プラス</li>
      </ul>
      <p class="max-w-lg text-base leading-relaxed text-[#232323] sm:text-lg"><?php echo br_after_period('<strong>単語</strong>・<strong>リーディング</strong>・<strong>リスニング</strong>・<strong>ライティング</strong>・<strong>スピーキング</strong>を本試験形式で対策。2024年度からの<strong>英文要約</strong>・<strong>Eメール</strong>にも対応。10,000問超・AI採点・復習。登録して、今日から始められます。文法は5級から2級まで、1テーマを読んで4択を5問で確認します。単語と同じく、回数の上限はありません。ブラウザ、iPhone・iPad、Android（2026年11月公開）で、同じアカウントのまま続けられます。'); ?></p>
      <div class="flex flex-col gap-3 sm:flex-row sm:justify-start">
        <a class="inline-flex items-center justify-center gap-2 rounded-full bg-[#50c2cb] px-10 py-4 text-[21px] font-semibold text-white shadow-lg shadow-[#50c2cb]/25 transition hover:bg-[#46adb5] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#50c2cb]/60 focus-visible:ring-offset-2" href="<?php echo htmlspecialchars(lp_signup_url('hero'), ENT_QUOTES, 'UTF-8'); ?>"><?php echo lp_start_cta_inner('h-5 w-5'); ?></a>
      </div>
      <?php
      $store_align = 'start';
      $store_on_hero = true;
      include __DIR__ . '/../store-cta.php';
      ?>
    </div>
    <div class="hero-mockup flex-1 w-full">
      <?php echo lp_picture([
          'src' => '/assets/images/hero-mockup.png',
          'alt' => 'AiKenアプリの画面イメージ',
          'width' => 640,
          'height' => 480,
          'class' => 'hero-mockup__image mx-auto',
          'loading' => 'eager',
      ]); ?>
    </div>
  </div>
</section>
