<?php
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../../config.php';
}
?>
<section class="border-t border-slate-100 bg-[#e8fafb] px-4 py-16 sm:py-20" aria-labelledby="top-plan-heading">
  <div class="lp-container">
    <div class="mx-auto max-w-3xl text-center">
      <h2 id="top-plan-heading" class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">料金・プラン</h2>
      <p class="mt-3 text-slate-600"><?php echo br_after_period(open_campaign_active()
          ? '英検5級〜1級の対策が、OPEN記念価格の<strong>' . monthly_price_label() . '</strong>で使えます。（定価' . monthly_price_regular_label() . '・' . open_campaign_end_label() . 'まで）'
          : '英検5級〜1級の対策が、<strong>' . monthly_price_regular_label() . '</strong>で使えます。'); ?></p>
    </div>
    <div class="mx-auto mt-10 max-w-lg sm:mt-12">
      <?php
      $plan_price_note = '料金は予告なく変更される場合があります。最新の表示価格は料金ページおよびアプリ内の案内が優先されます。';
      include __DIR__ . '/plan_card.php';
      ?>
    </div>
    <p class="mt-8 text-center">
      <a class="text-sm font-semibold text-[#50c2cb] underline-offset-2 hover:text-[#46adb5] hover:underline" href="/plan">お支払い方法・解約については料金ページへ</a>
    </p>
  </div>
</section>
