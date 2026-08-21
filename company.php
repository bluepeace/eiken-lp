<?php
/**
 * 会社・運営者情報
 */
declare(strict_types=1);

$page = 'company';
require_once __DIR__ . '/config.php';
$canonical = rtrim(SITE_URL, '/') . '/company';

include __DIR__ . '/includes/header.php';
?>
<article class="border-b border-slate-100 bg-white px-4 py-12 sm:py-16" aria-labelledby="company-heading">
  <div class="mx-auto max-w-3xl text-slate-800">
    <p class="section-badge" aria-hidden="true">COMPANY</p>
    <h1 id="company-heading" class="mt-3 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">会社・運営者情報</h1>
    <p class="mt-4 text-sm leading-relaxed text-slate-600"><?php echo br_after_period('英検対策アプリ AiKen（アイケン）および公式サイトの運営についてご案内します。'); ?></p>

    <div class="mt-10 overflow-x-auto rounded-xl border border-slate-200 shadow-sm">
      <table class="w-full min-w-[280px] border-collapse text-left text-sm">
        <tbody>
          <tr class="border-b border-slate-200">
            <th scope="row" class="w-[min(36%,11rem)] bg-slate-50 px-4 py-3 font-semibold text-slate-900 sm:px-5">サービス名</th>
            <td class="px-4 py-3 sm:px-5">AiKen（アイケン）</td>
          </tr>
          <tr class="border-b border-slate-200">
            <th scope="row" class="bg-slate-50 px-4 py-3 font-semibold text-slate-900 sm:px-5">公式サイト</th>
            <td class="px-4 py-3 sm:px-5"><a class="font-medium text-[#50c2cb] underline-offset-2 hover:underline" href="<?php echo htmlspecialchars(SITE_URL); ?>"><?php echo htmlspecialchars(SITE_URL); ?></a></td>
          </tr>
          <tr class="border-b border-slate-200">
            <th scope="row" class="bg-slate-50 px-4 py-3 font-semibold text-slate-900 sm:px-5">アプリ</th>
            <td class="px-4 py-3 sm:px-5"><a class="font-medium text-[#50c2cb] underline-offset-2 hover:underline" href="<?php echo htmlspecialchars(APP_URL); ?>"><?php echo htmlspecialchars(APP_URL); ?></a></td>
          </tr>
          <tr class="border-b border-slate-200">
            <th scope="row" class="bg-slate-50 px-4 py-3 font-semibold text-slate-900 sm:px-5">運営</th>
            <td class="px-4 py-3 sm:px-5">
              <a class="font-medium text-[#50c2cb] underline-offset-2 hover:underline" href="<?php echo htmlspecialchars(BLUEPIECE_LAB_URL); ?>" rel="noopener noreferrer" target="_blank">Bluepiece Lab.</a>
            </td>
          </tr>
          <tr class="border-b border-slate-200">
            <th scope="row" class="bg-slate-50 px-4 py-3 font-semibold text-slate-900 sm:px-5">事業者氏名</th>
            <td class="px-4 py-3 sm:px-5">森山卓</td>
          </tr>
          <tr class="border-b border-slate-200">
            <th scope="row" class="bg-slate-50 px-4 py-3 font-semibold text-slate-900 sm:px-5">所在地・電話</th>
            <td class="px-4 py-3 sm:px-5">請求があった場合は遅滞なく開示いたします。<a class="font-medium text-[#50c2cb] underline-offset-2 hover:underline" href="/contact?subject=tokushoho">お問い合わせフォーム</a>よりご請求ください。</td>
          </tr>
          <tr>
            <th scope="row" class="bg-slate-50 px-4 py-3 font-semibold text-slate-900 sm:px-5">お問い合わせ</th>
            <td class="px-4 py-3 sm:px-5"><a class="font-medium text-[#50c2cb] underline-offset-2 hover:underline" href="/contact">お問い合わせフォーム</a></td>
          </tr>
        </tbody>
      </table>
    </div>

    <section class="mt-12" aria-labelledby="company-mission">
      <h2 id="company-mission" class="text-lg font-bold text-slate-900">AiKen について</h2>
      <p class="mt-3 text-sm leading-relaxed text-slate-700"><?php echo br_after_period('AiKen は、英検5級から1級までを本試験に近い形式で対策できる学習アプリです。単語・リーディング・リスニング・ライティング・スピーキングをひとつにまとめ、AI添削や学習履歴で続けやすさを大切にしています。'); ?></p>
    </section>

    <section class="mt-10" aria-labelledby="company-links">
      <h2 id="company-links" class="text-lg font-bold text-slate-900">関連ページ</h2>
      <ul class="mt-3 list-disc space-y-2 pl-5 text-sm">
        <li><a class="font-medium text-[#50c2cb] underline-offset-2 hover:underline" href="/about">AiKenとは</a></li>
        <li><a class="font-medium text-[#50c2cb] underline-offset-2 hover:underline" href="/tokushoho">特定商取引法に基づく表記</a></li>
        <li><a class="font-medium text-[#50c2cb] underline-offset-2 hover:underline" href="/privacy">プライバシーポリシー</a></li>
        <li><a class="font-medium text-[#50c2cb] underline-offset-2 hover:underline" href="/terms">利用規約</a></li>
      </ul>
    </section>

    <p class="mt-12 text-center text-sm">
      <a class="font-medium text-[#50c2cb] underline-offset-2 hover:underline" href="/">トップに戻る</a>
    </p>
  </div>
</article>
<?php
include __DIR__ . '/includes/footer.php';
