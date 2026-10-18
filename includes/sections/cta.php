<?php if (!defined('SITE_NAME')) { require_once __DIR__ . '/../../config.php'; } ?>
<section class="border-t border-slate-100 bg-white px-4 py-16 sm:py-20" aria-labelledby="cta-heading">
  <div class="mx-auto max-w-2xl text-center">
    <p class="section-badge section-badge--center" aria-hidden="true">GO</p>
    <h2 id="cta-heading" class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">英検対策アプリで、今日からはじめよう</h2>
    <p class="mt-3 text-slate-600"><?php echo br_after_period('単語・リーディング・リスニング・ライティング・スピーキングを、ひとつのアプリで。登録して、今日から始められます。'); ?></p>
    <div class="mt-8 flex justify-center">
      <a class="inline-flex items-center justify-center gap-2 rounded-full bg-[#50c2cb] px-10 py-4 text-lg font-semibold text-white shadow-lg shadow-[#50c2cb]/25 transition hover:bg-[#46adb5] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#50c2cb]/60 focus-visible:ring-offset-2" href="<?php echo APP_URL; ?>/signup"><?php echo lp_start_cta_inner('h-5 w-5'); ?></a>
    </div>
    <?php include __DIR__ . '/../store-cta.php'; ?>
  </div>
</section>
