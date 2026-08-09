<?php if (!defined('SITE_NAME')) { require_once __DIR__ . '/../../config.php'; } ?>
<section class="border-t border-slate-100 bg-white px-4 py-16 sm:py-20" aria-labelledby="cta-heading">
  <div class="mx-auto max-w-2xl text-center">
    <h2 id="cta-heading" class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">英検対策アプリで、今日からはじめよう</h2>
    <p class="mt-3 text-slate-600"><?php echo br_after_period(FREE_TRIAL_DAYS . '日間無料体験。単語・5技能・AI採点を、ひとつのアプリで。' . monthly_price_label() . 'で5級〜1級まで対策できます。'); ?></p>
    <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:justify-center">
      <a class="inline-flex items-center justify-center rounded-full bg-[#50c2cb] px-10 py-4 text-lg font-semibold text-white shadow-lg shadow-[#50c2cb]/25 transition hover:bg-[#46adb5] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#50c2cb]/60 focus-visible:ring-offset-2" href="<?php echo APP_URL; ?>/signup"><?php echo FREE_TRIAL_DAYS; ?>日間無料で試す</a>
      <a class="inline-flex items-center justify-center rounded-full border-2 border-slate-300 bg-white px-10 py-4 text-lg font-semibold text-slate-800 transition hover:border-slate-400 hover:bg-slate-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-slate-300 focus-visible:ring-offset-2" href="/plan">料金を見る</a>
    </div>
  </div>
</section>
