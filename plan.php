<?php
/**
 * 料金・プラン（本文はこの1ファイルに集約）
 */
$page = 'plan';
require_once __DIR__ . '/config.php';
$canonical = rtrim(SITE_URL, '/') . '/plan';

include __DIR__ . '/includes/header.php';
?>
<section class="border-b border-slate-100 bg-gradient-to-b from-[#e8f8f9] to-white px-4 py-14 sm:py-20" aria-labelledby="plan-heading">
  <div class="mx-auto max-w-3xl text-center">
    <p class="text-sm font-semibold tracking-wide text-[#3d9aa3]">保護者の方へ</p>
    <h1 id="plan-heading" class="mt-3 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">料金・プラン</h1>
    <p class="mt-4 text-lg text-slate-700"><?php echo br_after_period('英検5級〜1級の対策が、<strong>' . monthly_price_label() . '</strong>で使えます。'); ?></p>
  </div>
</section>

<section class="border-b border-slate-100 bg-white px-4 py-14 sm:py-20" aria-labelledby="plan-premium-heading">
  <div class="mx-auto max-w-lg">
    <div class="overflow-hidden rounded-2xl border-2 border-[#50c2cb]/40 bg-white shadow-lg ring-1 ring-slate-900/5">
      <div class="bg-[#50c2cb] px-6 py-4 text-center">
        <h2 id="plan-premium-heading" class="text-lg font-bold text-white">プレミアムプラン</h2>
        <p class="mt-1 text-sm text-white/90">英検対策のすべての機能</p>
      </div>
      <div class="px-6 py-8 text-center">
        <p class="text-4xl font-bold tracking-tight text-slate-900"><?php echo htmlspecialchars(monthly_price_label()); ?></p>
        <p class="mt-2 text-sm text-slate-600"><?php echo FREE_TRIAL_DAYS; ?>日間無料体験ののち、自動更新</p>
        <ul class="mt-8 space-y-3 text-left text-sm text-slate-700">
          <li class="flex gap-2"><span class="shrink-0 text-[#50c2cb]"><?php echo lp_icon('check', 'w-5 h-5'); ?></span>英検5級〜1級（準1級・準2級含む）すべて対応</li>
          <li class="flex gap-2"><span class="shrink-0 text-[#50c2cb]"><?php echo lp_icon('check', 'w-5 h-5'); ?></span>単語・リーディング・リスニング・ライティング・スピーキング</li>
          <li class="flex gap-2"><span class="shrink-0 text-[#50c2cb]"><?php echo lp_icon('check', 'w-5 h-5'); ?></span>本試験形式の出題・AI採点・即時フィードバック</li>
          <li class="flex gap-2"><span class="shrink-0 text-[#50c2cb]"><?php echo lp_icon('check', 'w-5 h-5'); ?></span>学習履歴・間違えた問題の復習</li>
          <li class="flex gap-2"><span class="shrink-0 text-[#50c2cb]"><?php echo lp_icon('check', 'w-5 h-5'); ?></span>収録問題数 10,000 問突破</li>
        </ul>
        <a class="mt-8 inline-flex w-full items-center justify-center rounded-full bg-[#50c2cb] px-8 py-4 text-lg font-semibold text-white shadow-lg shadow-[#50c2cb]/25 transition hover:bg-[#46adb5] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#50c2cb]/60 focus-visible:ring-offset-2" href="<?php echo APP_URL; ?>/signup"><?php echo FREE_TRIAL_DAYS; ?>日間無料で試す</a>
      </div>
    </div>
    <p class="mt-6 text-center text-xs leading-relaxed text-slate-500"><?php echo br_after_period('料金は予告なく変更される場合があります。最新の表示価格は本ページおよびアプリ内の案内が優先されます。'); ?></p>
  </div>
</section>

<section class="border-b border-slate-100 bg-slate-50/50 px-4 py-14 sm:py-20" aria-labelledby="plan-notes-heading">
  <div class="mx-auto max-w-3xl">
    <h2 id="plan-notes-heading" class="text-center text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">ご利用にあたって</h2>
    <dl class="mt-8 space-y-4">
      <div class="rounded-xl border border-slate-200 bg-white px-5 py-4 shadow-sm">
        <dt class="font-semibold text-slate-900">お支払い方法</dt>
        <dd class="mt-2 text-sm leading-relaxed text-slate-600"><?php echo br_after_period('クレジットカード決済（Stripe）。毎月の契約日に自動課金されます。'); ?></dd>
      </div>
      <div class="rounded-xl border border-slate-200 bg-white px-5 py-4 shadow-sm">
        <dt class="font-semibold text-slate-900">解約・退会</dt>
        <dd class="mt-2 text-sm leading-relaxed text-slate-600"><?php echo br_after_period('いつでも解約可能です。解約後も、お支払い済みの期間まではご利用いただけます。'); ?></dd>
      </div>
      <div class="rounded-xl border border-slate-200 bg-white px-5 py-4 shadow-sm">
        <dt class="font-semibold text-slate-900">特定商取引法に基づく表記</dt>
        <dd class="mt-2 text-sm leading-relaxed text-slate-600"><a class="font-medium text-[#50c2cb] underline-offset-2 hover:underline" href="/tokushoho">表記を見る</a></dd>
      </div>
    </dl>
  </div>
</section>
<?php
include __DIR__ . '/includes/sections/cta.php';
include __DIR__ . '/includes/footer.php';
