<?php
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../../config.php';
}
?>
<?php
$plan_heading = $plan_heading ?? '料金・プラン';
$plan_heading_id = $plan_heading_id ?? 'top-plan-heading';
?>
<section class="border-t border-slate-100 bg-[#e8fafb] px-4 py-16 sm:py-20" aria-labelledby="<?php echo htmlspecialchars($plan_heading_id); ?>">
  <div class="lp-container">
    <div class="mx-auto max-w-3xl text-center">
      <p class="section-badge section-badge--center" aria-hidden="true">PLAN</p>
      <h2 id="<?php echo htmlspecialchars($plan_heading_id); ?>" class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl"><?php echo $plan_heading; ?></h2>
      <?php if (!empty($plan_lead)): ?>
      <p class="mt-3 text-slate-600"><?php echo br_after_period($plan_lead); ?></p>
      <?php else: ?>
      <p class="mt-3 text-slate-600"><?php echo br_after_period('Freeプランは追加料金なし。単語テストは回数の制限なく続けられます。リーディング・リスニング・ライティング・スピーキングも、毎日少しずつ無料で使えます。制限なく進めるときはプレミアムプランです。'); ?></p>
      <?php endif; ?>
    </div>
    <div class="mx-auto mt-10 max-w-5xl sm:mt-12">
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
