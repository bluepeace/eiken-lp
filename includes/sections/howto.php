<?php if (!defined('SITE_NAME')) { require_once __DIR__ . '/../../config.php'; } ?>
<section class="border-t border-slate-100 bg-white px-4 py-16 sm:py-20" aria-labelledby="howto-heading">
  <div class="mx-auto max-w-3xl text-center">
    <h2 id="howto-heading" class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">まずは無料ではじめられます</h2>
    <p class="mt-3 text-slate-600">会員登録ですぐに使えます。クレジットカード不要で、英検の勉強法・単語・4技能対策を体験できます。</p>
    <ol class="mt-10 space-y-6">
      <li class="flex items-center gap-4 rounded-xl border border-slate-200 bg-slate-50/50 p-5 text-left">
        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#50c2cb] text-lg font-bold text-white" aria-hidden="true">1</span>
        <div>
          <p class="font-semibold text-slate-900">会員登録</p>
          <p class="text-sm text-slate-600">メールアドレスで無料登録。すぐに利用開始できます。</p>
        </div>
      </li>
      <li class="flex items-center gap-4 rounded-xl border border-slate-200 bg-slate-50/50 p-5 text-left">
        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#50c2cb] text-lg font-bold text-white" aria-hidden="true">2</span>
        <div>
          <p class="font-semibold text-slate-900">目標の級を選択</p>
          <p class="text-sm text-slate-600">英検5級〜1級から選択。級別の対策が始まります。</p>
        </div>
      </li>
      <li class="flex items-center gap-4 rounded-xl border border-slate-200 bg-slate-50/50 p-5 text-left">
        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#50c2cb] text-lg font-bold text-white" aria-hidden="true">3</span>
        <div>
          <p class="font-semibold text-slate-900">今日のおすすめから学習</p>
          <p class="text-sm text-slate-600">単語・ライティング・リーディングなど、提案に沿って進められます。</p>
        </div>
      </li>
    </ol>
    <a class="mt-10 inline-flex w-full max-w-sm items-center justify-center rounded-full bg-[#50c2cb] px-8 py-4 text-lg font-semibold text-white shadow-lg shadow-[#50c2cb]/25 transition hover:bg-[#46adb5] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#50c2cb]/60 focus-visible:ring-offset-2 sm:w-auto" href="<?php echo APP_URL; ?>/signup">今すぐ無料ではじめる</a>
  </div>
</section>
