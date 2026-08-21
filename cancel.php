<?php
/**
 * 退会・解約の手順
 */
declare(strict_types=1);

$page = 'cancel';
require_once __DIR__ . '/config.php';
$canonical = rtrim(SITE_URL, '/') . '/cancel';

include __DIR__ . '/includes/header.php';
?>
<article class="border-b border-slate-100 bg-white px-4 py-12 sm:py-16" aria-labelledby="cancel-heading">
  <div class="mx-auto max-w-3xl text-slate-800">
    <p class="section-badge" aria-hidden="true">CANCEL</p>
    <h1 id="cancel-heading" class="mt-3 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">退会・解約の手順</h1>
    <p class="mt-4 text-sm leading-relaxed text-slate-600"><?php echo br_after_period('AiKen（アイケン）のプレミアムプラン解約・退会の流れをご案内します。いつでもお手続きいただけます。'); ?></p>

    <div class="mt-8 rounded-xl border border-[#50c2cb]/30 bg-[#e8f8f9] px-5 py-4 text-sm text-slate-800">
      <p class="font-semibold text-slate-900">ポイント</p>
      <ul class="mt-2 list-disc space-y-1 pl-5">
        <li>解約はアプリ内からいつでも可能です</li>
        <li>解約後も、お支払い済みの期間まではご利用いただけます</li>
        <li>解約後の返金はいたしかねます</li>
      </ul>
    </div>

    <section class="mt-12" aria-labelledby="cancel-sub-heading">
      <h2 id="cancel-sub-heading" class="text-lg font-bold text-slate-900">プレミアムプラン（サブスクリプション）の解約</h2>
      <ol class="mt-6 space-y-6">
        <li class="rounded-xl border border-slate-200 bg-slate-50/50 px-5 py-4">
          <p class="text-xs font-semibold tracking-wide text-[#50c2cb]">STEP 1</p>
          <h3 class="mt-1 font-semibold text-slate-900">アプリにログインする</h3>
          <p class="mt-2 text-sm text-slate-600"><a class="font-medium text-[#50c2cb] underline-offset-2 hover:underline" href="<?php echo htmlspecialchars(APP_URL); ?>/login">ログインページ</a>からアカウントにサインインしてください。</p>
        </li>
        <li class="rounded-xl border border-slate-200 bg-slate-50/50 px-5 py-4">
          <p class="text-xs font-semibold tracking-wide text-[#50c2cb]">STEP 2</p>
          <h3 class="mt-1 font-semibold text-slate-900">「プレミアム」ページを開く</h3>
          <p class="mt-2 text-sm text-slate-600">アプリ内のプレミアム（料金・プラン）に関する画面へ移動します。</p>
        </li>
        <li class="rounded-xl border border-slate-200 bg-slate-50/50 px-5 py-4">
          <p class="text-xs font-semibold tracking-wide text-[#50c2cb]">STEP 3</p>
          <h3 class="mt-1 font-semibold text-slate-900">「サブスクリプションを管理」から解約する</h3>
          <p class="mt-2 text-sm text-slate-600">画面の案内に従い、解約手続きを完了してください。決済は Stripe 経由のため、必要に応じて Stripe の顧客ポータルでも確認できます。</p>
        </li>
      </ol>
    </section>

    <section class="mt-12" aria-labelledby="cancel-after-heading">
      <h2 id="cancel-after-heading" class="text-lg font-bold text-slate-900">解約後について</h2>
      <ul class="mt-3 list-disc space-y-2 pl-5 text-sm text-slate-700">
        <li>解約後も、すでに支払い済みの期間が終わるまではサービスをご利用いただけます。</li>
        <li>期間終了後は、無料で使える範囲の機能のみ、またはログインのみなど、プランに応じた制限がかかります。</li>
        <li>解約後の返金は行っておりません。</li>
      </ul>
    </section>

    <section class="mt-12" aria-labelledby="cancel-account-heading">
      <h2 id="cancel-account-heading" class="text-lg font-bold text-slate-900">アカウント退会（データの削除）について</h2>
      <p class="mt-3 text-sm leading-relaxed text-slate-700"><?php echo br_after_period('サブスクリプション解約と、アカウント退会（削除）は別の手続きです。アカウント自体を削除したい場合は、アプリ内の設定、または<a class="font-medium text-[#50c2cb] underline-offset-2 hover:underline" href="/contact">お問い合わせフォーム</a>よりご連絡ください。'); ?></p>
    </section>

    <section class="mt-12" aria-labelledby="cancel-mistake-heading">
      <h2 id="cancel-mistake-heading" class="text-lg font-bold text-slate-900">誤って申し込んだ場合</h2>
      <p class="mt-3 text-sm leading-relaxed text-slate-700"><?php echo br_after_period('電子メディアを利用した役務については、契約成立後は原則クーリング・オフの対象外です。誤申込みなど、お早めにご連絡いただければ内容に応じてご相談に応じます。'); ?></p>
    </section>

    <p class="mt-10 text-sm text-slate-600">詳細な表記は<a class="font-medium text-[#50c2cb] underline-offset-2 hover:underline" href="/tokushoho">特定商取引法に基づく表記</a>、<a class="font-medium text-[#50c2cb] underline-offset-2 hover:underline" href="/plan">料金ページ</a>もご確認ください。</p>

    <div class="mt-10 flex flex-wrap gap-3">
      <a class="inline-flex items-center justify-center rounded-full bg-[#50c2cb] px-6 py-3 text-sm font-semibold text-white transition hover:bg-[#46adb5]" href="<?php echo htmlspecialchars(APP_URL); ?>/login">アプリにログイン</a>
      <a class="inline-flex items-center justify-center rounded-full border border-slate-300 bg-white px-6 py-3 text-sm font-semibold text-slate-700 transition hover:border-[#50c2cb]/50" href="/contact?subject=billing">お問い合わせ</a>
    </div>

    <p class="mt-12 text-center text-sm">
      <a class="font-medium text-[#50c2cb] underline-offset-2 hover:underline" href="/">トップに戻る</a>
    </p>
  </div>
</article>
<?php
include __DIR__ . '/includes/footer.php';
