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
    <?php include __DIR__ . '/includes/sections/plan_card.php'; ?>
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
