<?php if (!defined('SITE_NAME')) { require_once __DIR__ . '/../../config.php'; } ?>
<section class="relative overflow-hidden px-4 py-16 sm:py-20 md:py-24" aria-labelledby="hero-heading">
  <div class="pointer-events-none absolute inset-0" aria-hidden="true">
    <img src="/assets/images/hero-bg.png" alt="" class="hero-bg-image h-full w-full object-cover" loading="eager" fetchpriority="high" width="1920" height="1080">
    <div class="hero-bg-overlay absolute inset-0"></div>
  </div>
  <div class="relative z-10 lp-container flex flex-col items-center gap-12 lg:flex-row lg:items-center lg:gap-16">
    <div class="flex-1 space-y-6 text-center lg:text-left">
      <span class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-3 py-1 text-[11px] font-medium text-slate-600 shadow-sm">英検対策アプリ｜5級〜1級｜本試験形式</span>
      <h1 id="hero-heading" class="text-3xl font-bold leading-[1.4] tracking-tight text-slate-900 sm:text-4xl md:text-5xl">
        英検対策、<span class="block text-brand-accent">本試験形式で全部そろう。</span>
      </h1>
      <p class="max-w-lg text-base leading-relaxed text-slate-600 sm:text-lg"><?php echo br_after_period('<strong>単語</strong>・<strong>リーディング</strong>・<strong>リスニング</strong>・<strong>ライティング</strong>・<strong>スピーキング</strong>を、英検の本番に近い形式で出題。収録<strong>10,000問超</strong>、<strong>AI</strong>がライティングとスピーキングをその場で採点。間違えた問題は履歴から復習でき、通学時間にも使えます。<strong>' . monthly_price_label() . '</strong>で、5級から1級までひとつのアプリで対策できます。'); ?></p>
      <div class="flex flex-col gap-3 sm:flex-row sm:justify-center lg:justify-start">
        <a class="inline-flex items-center justify-center rounded-full bg-[#50c2cb] px-8 py-3.5 text-base font-semibold text-white shadow-lg shadow-[#50c2cb]/25 transition hover:bg-[#46adb5] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#50c2cb]/60 focus-visible:ring-offset-2" href="<?php echo APP_URL; ?>/signup"><?php echo FREE_TRIAL_DAYS; ?>日間無料で試す</a>
        <a class="inline-flex items-center justify-center rounded-full border-2 border-slate-300 bg-white px-8 py-3.5 text-base font-semibold text-slate-800 transition hover:border-slate-400 hover:bg-slate-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-slate-300 focus-visible:ring-offset-2" href="/plan">料金を見る</a>
      </div>
    </div>
    <div class="flex-1">
      <div class="mx-auto max-w-sm lg:max-w-md">
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-xl ring-1 ring-slate-900/5">
          <div class="flex items-center justify-between border-b border-slate-100 bg-slate-50/80 px-4 py-2">
            <img alt="<?php echo htmlspecialchars(SITE_NAME); ?>" width="80" height="24" class="h-6 w-auto" src="<?php echo asset('assets/images/logo-aiken.png'); ?>">
          </div>
          <div class="space-y-3 p-4">
            <div class="flex items-center gap-3">
              <div class="h-10 w-10 shrink-0 rounded-full bg-slate-200" aria-hidden="true"></div>
              <div>
                <p class="text-xs font-semibold text-slate-800">こんにちは、ゲスト さん</p>
                <p class="text-[10px] text-slate-500">英検準2級に向けて、今日の学習を。</p>
              </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-slate-50/50 p-3">
              <p class="mb-2 text-[10px] font-semibold text-slate-500">今日のおすすめ学習</p>
              <div class="space-y-1.5">
                <div class="flex items-center gap-2 rounded-lg border-l-4 border-[#F99F66] border-slate-200 bg-white px-2 py-1.5 text-[10px]">
                  <span class="h-1.5 w-1.5 rounded-full bg-[#F99F66]" aria-hidden="true"></span>
                  <span>単語クイズ</span>
                  <span class="ml-auto text-slate-400">約1分</span>
                </div>
                <div class="flex items-center gap-2 rounded-lg border-l-4 border-[#A6D472] border-slate-200 bg-white px-2 py-1.5 text-[10px]">
                  <span class="h-1.5 w-1.5 rounded-full bg-[#A6D472]" aria-hidden="true"></span>
                  <span>ライティング</span>
                  <span class="ml-auto text-slate-400">約15分</span>
                </div>
              </div>
            </div>
            <div class="grid grid-cols-3 gap-2">
              <div class="rounded-lg border-l-4 border border-slate-200 bg-white p-2 border-l-[#F99F66]">
                <span class="inline-block rounded px-1.5 py-0.5 text-[9px] font-medium bg-[#F99F66]/20 text-[#C77A3D] border border-[#F99F66]/40">毎日の基本</span>
                <p class="mt-1 text-[10px] font-semibold text-slate-800">単語学習</p>
              </div>
              <div class="rounded-lg border-l-4 border border-slate-200 bg-white p-2 border-l-[#A6D472]">
                <span class="inline-block rounded px-1.5 py-0.5 text-[9px] font-medium bg-[#A6D472]/25 text-[#5A8A3A] border border-[#A6D472]/50">AI 添削</span>
                <p class="mt-1 text-[10px] font-semibold text-slate-800">ライティング</p>
              </div>
              <div class="rounded-lg border-l-4 border border-slate-200 bg-white p-2 border-l-[#50c2cb]">
                <span class="inline-block rounded px-1.5 py-0.5 text-[9px] font-medium bg-[#50c2cb]/20 text-[#2a6e73] border border-[#50c2cb]/40">長文対策</span>
                <p class="mt-1 text-[10px] font-semibold text-slate-800">リーディング</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
