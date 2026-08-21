<?php
/**
 * 保護者の方へ
 */
declare(strict_types=1);

$page = 'parents';
require_once __DIR__ . '/config.php';
$canonical = rtrim(SITE_URL, '/') . '/parents';

$priceLead = open_campaign_active()
    ? '最初の' . FREE_TRIAL_DAYS . '日間は全機能無料。その後はOPEN記念価格の<strong>' . monthly_price_label() . '</strong>（定価' . monthly_price_regular_label() . '・' . open_campaign_end_label() . 'まで）。'
    : '最初の' . FREE_TRIAL_DAYS . '日間は全機能無料。その後は<strong>' . monthly_price_regular_label() . '</strong>。';

include __DIR__ . '/includes/header.php';
?>
<article class="border-b border-slate-100 bg-white" aria-labelledby="parents-heading">
  <section class="border-b border-slate-100 bg-gradient-to-b from-[#e8f8f9] to-white px-4 py-14 sm:py-20">
    <div class="mx-auto max-w-3xl text-center">
      <p class="section-badge section-badge--center" aria-hidden="true">PARENTS</p>
      <h1 id="parents-heading" class="mt-3 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">保護者の方へ</h1>
      <p class="mt-4 text-base leading-relaxed text-slate-700 sm:text-lg"><?php echo br_after_period('お子さまの英検対策を、スマホひとつで。料金・安全・学習の進め方をまとめました。'); ?></p>
      <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
        <a class="inline-flex items-center justify-center rounded-full bg-[#50c2cb] px-7 py-3.5 text-sm font-semibold text-white transition hover:bg-[#46adb5]" href="<?php echo htmlspecialchars(APP_URL); ?>/signup"><?php echo FREE_TRIAL_DAYS; ?>日間無料で始める</a>
        <a class="inline-flex items-center justify-center rounded-full border border-slate-300 bg-white px-6 py-3.5 text-sm font-semibold text-slate-700 transition hover:border-[#50c2cb]/50" href="/plan">料金を見る</a>
      </div>
    </div>
  </section>

  <section class="px-4 py-14 sm:py-16" aria-labelledby="parents-price">
    <div class="mx-auto max-w-3xl">
      <h2 id="parents-price" class="text-2xl font-bold tracking-tight text-slate-900">料金がわかりやすい</h2>
      <p class="mt-3 text-slate-600"><?php echo br_after_period($priceLead . 'カード登録なしで体験を開始できます。'); ?></p>
      <ul class="mt-6 space-y-3 text-sm text-slate-700">
        <li class="flex gap-2"><span class="shrink-0 text-[#50c2cb]"><?php echo lp_icon('check', 'w-5 h-5'); ?></span>登録無料・カード不要で始められる</li>
        <li class="flex gap-2"><span class="shrink-0 text-[#50c2cb]"><?php echo lp_icon('check', 'w-5 h-5'); ?></span>解約はいつでもOK（お支払い済み期間は利用可）</li>
        <li class="flex gap-2"><span class="shrink-0 text-[#50c2cb]"><?php echo lp_icon('check', 'w-5 h-5'); ?></span>5級〜1級（準級含む）をひとつのアプリでカバー</li>
      </ul>
      <p class="mt-4 text-sm"><a class="font-semibold text-[#50c2cb] underline-offset-2 hover:underline" href="/plan">料金の詳細へ</a> ／ <a class="font-semibold text-[#50c2cb] underline-offset-2 hover:underline" href="/cancel">解約の手順へ</a></p>
    </div>
  </section>

  <section class="border-t border-slate-100 bg-slate-50/50 px-4 py-14 sm:py-16" aria-labelledby="parents-safety">
    <div class="mx-auto max-w-3xl">
      <h2 id="parents-safety" class="text-2xl font-bold tracking-tight text-slate-900">安心・安全について</h2>
      <p class="mt-3 text-slate-600"><?php echo br_after_period('学習データやお問い合わせ内容は、サービス提供に必要な範囲で取り扱います。決済のカード情報は当サービスでは保持せず、Stripe が処理します。'); ?></p>
      <ul class="mt-6 space-y-3 text-sm text-slate-700">
        <li class="flex gap-2"><span class="shrink-0 text-[#50c2cb]"><?php echo lp_icon('check', 'w-5 h-5'); ?></span>個人情報の取扱いはプライバシーポリシーで公開</li>
        <li class="flex gap-2"><span class="shrink-0 text-[#50c2cb]"><?php echo lp_icon('check', 'w-5 h-5'); ?></span>16歳未満は保護者の同意・監督のもとでの利用を推奨</li>
        <li class="flex gap-2"><span class="shrink-0 text-[#50c2cb]"><?php echo lp_icon('check', 'w-5 h-5'); ?></span>サイトの計測タグ等は外部送信に関する公表で明示</li>
      </ul>
      <p class="mt-4 text-sm"><a class="font-semibold text-[#50c2cb] underline-offset-2 hover:underline" href="/privacy">プライバシーポリシー</a> ／ <a class="font-semibold text-[#50c2cb] underline-offset-2 hover:underline" href="/external-transmission">外部送信に関する公表</a></p>
    </div>
  </section>

  <section class="border-t border-slate-100 px-4 py-14 sm:py-16" aria-labelledby="parents-study">
    <div class="mx-auto max-w-3xl">
      <h2 id="parents-study" class="text-2xl font-bold tracking-tight text-slate-900">学習の進め方（ご家庭でのコツ）</h2>
      <ol class="mt-6 space-y-5">
        <li class="rounded-xl border border-slate-200 bg-white px-5 py-4">
          <h3 class="font-semibold text-slate-900">1. 目標の級を決める</h3>
          <p class="mt-2 text-sm text-slate-600"><?php echo br_after_period('プロフィールで対策級を設定。級別ページで出題の傾向も確認できます。'); ?></p>
        </li>
        <li class="rounded-xl border border-slate-200 bg-white px-5 py-4">
          <h3 class="font-semibold text-slate-900">2. 毎日少しだけ単語から</h3>
          <p class="mt-2 text-sm text-slate-600"><?php echo br_after_period('4択クイズですぐ正誤と解説が出ます。間違えた問題は履歴から復習できます。'); ?></p>
        </li>
        <li class="rounded-xl border border-slate-200 bg-white px-5 py-4">
          <h3 class="font-semibold text-slate-900">3. 週末に読解・リスニング・作文</h3>
          <p class="mt-2 text-sm text-slate-600"><?php echo br_after_period('本試験に近い形式で反復。ライティングはAIがその場で添削するので、保護者が添削しにくい部分も続けやすいです。'); ?></p>
        </li>
      </ol>
      <p class="mt-6 text-sm"><a class="font-semibold text-[#50c2cb] underline-offset-2 hover:underline" href="/guide">使い方ガイドを見る</a> ／ <a class="font-semibold text-[#50c2cb] underline-offset-2 hover:underline" href="/faq">よくあるご質問</a></p>
    </div>
  </section>

  <section class="border-t border-slate-100 bg-[#e8f8f9] px-4 py-14 sm:py-16">
    <div class="mx-auto max-w-3xl text-center">
      <h2 class="text-2xl font-bold tracking-tight text-slate-900">まずは<?php echo FREE_TRIAL_DAYS; ?>日間、無料で試せます</h2>
      <p class="mt-3 text-slate-600"><?php echo br_after_period('カード登録は不要です。合わなければ解約もかんたんです。'); ?></p>
      <a class="mt-8 inline-flex items-center justify-center rounded-full bg-[#50c2cb] px-8 py-3.5 text-sm font-semibold text-white transition hover:bg-[#46adb5]" href="<?php echo htmlspecialchars(APP_URL); ?>/signup">無料ではじめる</a>
    </div>
  </section>
</article>
<?php
include __DIR__ . '/includes/footer.php';
