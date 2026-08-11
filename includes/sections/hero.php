<?php if (!defined('SITE_NAME')) { require_once __DIR__ . '/../../config.php'; } ?>
<section class="relative overflow-hidden px-4 py-16 sm:py-20 md:py-24" aria-labelledby="hero-heading">
  <div class="pointer-events-none absolute inset-0" aria-hidden="true">
    <img src="/assets/images/hero-bg.png" alt="" class="hero-bg-image h-full w-full object-cover" loading="eager" fetchpriority="high" width="1920" height="1080">
    <div class="hero-bg-overlay absolute inset-0"></div>
  </div>
  <div class="relative z-10 lp-container flex flex-col items-start gap-12 lg:flex-row lg:items-center lg:gap-16">
    <div class="w-full flex-1 space-y-6 text-left">
      <h1 id="hero-heading" class="text-3xl font-bold leading-[1.4] tracking-tight sm:text-4xl md:text-5xl">
        <span class="block text-brand-accent">英検対策アプリはAiKen</span>
        <span class="hero-heading__sub block">5級〜1級を本試験形式で</span>
      </h1>
      <p class="max-w-lg text-base leading-relaxed text-[#232323] sm:text-lg"><?php echo br_after_period('<strong>単語</strong>・<strong>リーディング</strong>・<strong>リスニング</strong>・<strong>ライティング</strong>・<strong>スピーキング</strong>を本試験形式で対策。10,000問超・AI採点・復習対応。<strong>' . monthly_price_label() . '</strong>で5級〜1級まで。'); ?></p>
      <div class="flex flex-col gap-3 sm:flex-row sm:justify-start">
        <a class="inline-flex items-center justify-center rounded-full bg-[#50c2cb] px-10 py-4 text-[21px] font-semibold text-white shadow-lg shadow-[#50c2cb]/25 transition hover:bg-[#46adb5] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#50c2cb]/60 focus-visible:ring-offset-2" href="<?php echo APP_URL; ?>/signup"><?php echo FREE_TRIAL_DAYS; ?>日間無料で試す</a>
        <a class="inline-flex items-center justify-center rounded-full border-2 border-[#50c2cb] bg-white px-10 py-4 text-[21px] font-semibold text-slate-800 transition hover:border-[#46adb5] hover:bg-[#50c2cb]/5 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#50c2cb]/60 focus-visible:ring-offset-2" href="/plan">料金を見る</a>
      </div>
    </div>
    <div class="hero-mockup flex-1 w-full">
      <img src="/assets/images/hero-mockup.png" alt="AiKenアプリの画面イメージ" width="640" height="480" class="hero-mockup__image mx-auto" loading="eager">
    </div>
  </div>
</section>
