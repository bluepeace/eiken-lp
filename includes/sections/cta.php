<?php if (!defined('SITE_NAME')) { require_once __DIR__ . '/../../config.php'; } ?>
<section class="border-t border-slate-100 bg-white px-4 py-16 sm:py-20" aria-labelledby="cta-heading">
  <div class="mx-auto max-w-2xl text-center">
    <h2 id="cta-heading" class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">英検対策、今日からはじめよう</h2>
    <p class="mt-3 text-slate-600">無料で会員登録。単語・4技能・面接対策を、ひとつのアプリで。バディが合格まで寄り添います。</p>
    <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:justify-center">
      <a class="inline-flex items-center justify-center rounded-full bg-[#50c2cb] px-10 py-4 text-lg font-semibold text-white shadow-lg shadow-[#50c2cb]/25 transition hover:bg-[#46adb5] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#50c2cb]/60 focus-visible:ring-offset-2" href="<?php echo APP_URL; ?>/signup">無料ではじめる</a>
      <a class="inline-flex items-center justify-center rounded-full border-2 border-slate-300 bg-white px-10 py-4 text-lg font-semibold text-slate-800 transition hover:border-slate-400 hover:bg-slate-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-slate-300 focus-visible:ring-offset-2" href="<?php echo APP_URL; ?>/login">ログイン</a>
    </div>
  </div>
</section>
