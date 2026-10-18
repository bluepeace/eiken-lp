<?php
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../../config.php';
}
$plan_price_note = $plan_price_note ?? '料金は予告なく変更される場合があります。最新の表示価格は本ページおよびアプリ内の案内が優先されます。';
$show_open_campaign = open_campaign_active();
$free_features = [
    '単語テストは回数の制限なく使える',
    '5級〜1級の単語に対応',
    '登録から' . FREE_TRIAL_DAYS . '日間は、リーディング・リスニング・ライティング・スピーキングも回数制限なし',
    (FREE_TRIAL_DAYS + 1) . '日目以降は、単語以外の各技能が1日1セット（ライティングはAI添削1回）',
    'カード登録は不要。登録の時点では課金されない',
];
$premium_features = [
    'リーディング・リスニング・ライティング・スピーキングが使い放題',
    'AI添削・AI採点を、回数を気にせず使える',
    '10,000問超を、1日のセット数を気にせず反復',
    '5級〜1級を、級ごとの追加料金なしで使える',
    '受験前も、セット数の上限なく進められる',
];
$start_button_class = 'mt-auto inline-flex w-full items-center justify-center gap-2 rounded-full bg-[#50c2cb] px-8 py-4 text-lg font-semibold text-white shadow-lg shadow-[#50c2cb]/25 transition hover:bg-[#46adb5] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#50c2cb]/60 focus-visible:ring-offset-2';
?>
<div class="plan-grid">
  <article class="plan-card plan-card--free flex flex-col overflow-hidden rounded-2xl border-2 bg-white shadow-lg ring-1 ring-slate-900/5">
    <div class="plan-card__header px-6 py-4 text-center">
      <h2 id="plan-free-heading" class="text-lg font-bold text-white">Freeプラン</h2>
      <p class="mt-1 text-sm text-white/90">0円で、ここまで</p>
    </div>
    <div class="flex flex-1 flex-col px-6 py-8 text-center">
      <p class="text-4xl font-bold tracking-tight text-slate-900">0円</p>
      <p class="mt-2 text-sm text-slate-600"><?php echo br_after_period('追加料金なし。単語テストはずっと無料です。'); ?></p>
      <ul class="mt-8 mb-8 space-y-3 text-left text-sm text-slate-700">
        <?php foreach ($free_features as $feature): ?>
        <li class="flex gap-2"><span class="shrink-0 text-[#50c2cb]"><?php echo lp_icon('check', 'w-5 h-5'); ?></span><span><?php echo htmlspecialchars($feature); ?></span></li>
        <?php endforeach; ?>
      </ul>
      <a class="<?php echo $start_button_class; ?>" href="<?php echo APP_URL; ?>/signup"><?php echo lp_start_cta_inner('h-5 w-5'); ?></a>
    </div>
  </article>

  <article class="plan-card plan-card--premium flex flex-col overflow-hidden rounded-2xl border-2 bg-white shadow-lg ring-1 ring-slate-900/5<?php echo $show_open_campaign ? ' plan-card--campaign' : ''; ?>">
    <div class="plan-card__header px-6 py-4 text-center">
      <h2 id="plan-premium-heading" class="text-lg font-bold text-white">プレミアムプラン</h2>
      <p class="mt-1 text-sm text-white/90">加入すると、ここまで</p>
    </div>
    <div class="flex flex-1 flex-col px-6 py-8 text-center">
      <?php if ($show_open_campaign): ?>
      <div class="plan-campaign">
        <p class="plan-campaign__badge">OPEN記念価格</p>
        <p class="mt-3 text-sm text-slate-400 line-through">定価 <?php echo htmlspecialchars(monthly_price_regular_label()); ?></p>
        <p class="mt-1 text-4xl font-bold tracking-tight text-slate-900"><?php echo htmlspecialchars(monthly_price_label()); ?></p>
        <p class="plan-campaign__until"><?php echo htmlspecialchars(open_campaign_end_label()); ?>までのキャンペーン</p>
      </div>
      <?php else: ?>
      <p class="text-4xl font-bold tracking-tight text-slate-900"><?php echo htmlspecialchars(monthly_price_regular_label()); ?></p>
      <?php endif; ?>
      <p class="mt-4 text-sm text-slate-600"><?php echo br_after_period('登録の時点では課金されません。プレミアムは、学習を始めてからアプリ内で申し込めます。'); ?></p>
      <ul class="mt-8 mb-8 space-y-3 text-left text-sm text-slate-700">
        <?php foreach ($premium_features as $feature): ?>
        <li class="flex gap-2"><span class="shrink-0 text-[#50c2cb]"><?php echo lp_icon('check', 'w-5 h-5'); ?></span><span><?php echo htmlspecialchars($feature); ?></span></li>
        <?php endforeach; ?>
      </ul>
      <a class="<?php echo $start_button_class; ?>" href="<?php echo APP_URL; ?>/signup"><?php echo lp_start_cta_inner('h-5 w-5'); ?></a>
    </div>
  </article>
</div>
<p class="mt-6 text-center text-xs leading-relaxed text-slate-500"><?php echo br_after_period($plan_price_note); ?></p>
