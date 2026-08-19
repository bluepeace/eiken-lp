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
    <p class="section-badge section-badge--center" aria-hidden="true">PLAN</p>
    <h1 id="plan-heading" class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">料金・プラン</h1>
    <p class="mt-4 text-lg text-slate-700"><?php echo br_after_period(open_campaign_active()
        ? '最初の' . FREE_TRIAL_DAYS . '日間は、単語テスト・AI添削・リーディング・リスニングなど<strong>全機能が無料</strong>です。その後はOPEN記念価格の<strong>' . monthly_price_label() . '</strong>で続けられます。（定価' . monthly_price_regular_label() . '・' . open_campaign_end_label() . 'まで）'
        : '最初の' . FREE_TRIAL_DAYS . '日間は、単語テスト・AI添削・リーディング・リスニングなど<strong>全機能が無料</strong>です。その後は<strong>' . monthly_price_regular_label() . '</strong>で続けられます。'); ?></p>
  </div>
</section>

<section class="border-b border-slate-100 bg-white px-4 py-14 sm:py-20" aria-labelledby="plan-premium-heading">
  <div class="mx-auto max-w-2xl">
    <?php include __DIR__ . '/includes/sections/plan_card.php'; ?>
  </div>
</section>

<section class="border-b border-slate-100 bg-slate-50/50 px-4 py-14 sm:py-20" aria-labelledby="plan-notes-heading">
  <div class="mx-auto max-w-3xl">
    <p class="section-badge section-badge--center" aria-hidden="true">NOTE</p>
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
