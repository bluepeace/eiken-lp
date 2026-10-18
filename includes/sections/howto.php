<?php if (!defined('SITE_NAME')) { require_once __DIR__ . '/../../config.php'; } ?>
<section class="howto-section border-t border-slate-100 px-4 py-16 sm:py-20" aria-labelledby="howto-heading">
  <div class="lp-container">
    <div class="howto-section__header mx-auto max-w-3xl text-center">
      <p class="section-badge section-badge--center" aria-hidden="true">START</p>
      <h2 id="howto-heading" class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">英検対策アプリを、<span class="heading-accent">今日から</span>始める</h2>
      <p class="howto-section__lead mt-3"><?php echo br_after_period('カード登録なしで始められます。目標級を選び、問題を解き、フィードバックを確認して復習するまでの流れです。'); ?></p>
    </div>

    <ol class="howto-steps mt-12">
      <li class="howto-step">
        <p class="howto-step__num" aria-hidden="true">01</p>
        <span class="howto-step__icon"><?php echo lp_icon('user-plus', 'w-7 h-7'); ?></span>
        <h3 class="howto-step__title">会員登録</h3>
        <p class="howto-step__highlight">かんたん、1分で完了</p>
        <p class="howto-step__text"><?php echo br_after_period('カードの登録はありません。メールですぐにアカウント作成。準備はいらないので、今すぐはじめられます。'); ?></p>
      </li>
      <li class="howto-step">
        <p class="howto-step__num" aria-hidden="true">02</p>
        <span class="howto-step__icon"><?php echo lp_icon('id-card', 'w-7 h-7'); ?></span>
        <h3 class="howto-step__title">目標級を選ぶ</h3>
        <p class="howto-step__highlight">5級〜1級・準2級プラスに対応</p>
        <p class="howto-step__text"><?php echo br_after_period('プロフィールで対策する級と相棒の愛犬を選びます。自分の目標に合った級の問題から学習を始めます。'); ?></p>
      </li>
      <li class="howto-step">
        <p class="howto-step__num" aria-hidden="true">03</p>
        <span class="howto-step__icon"><?php echo lp_icon('rocket', 'w-7 h-7'); ?></span>
        <h3 class="howto-step__title">問題に取り組む</h3>
        <p class="howto-step__highlight">単語＋英語4技能を級別に</p>
        <p class="howto-step__text"><?php echo br_after_period('単語の4択や、級に合ったリーディング・リスニング・ライティング・スピーキングから選んで学習します。'); ?></p>
      </li>
      <li class="howto-step">
        <p class="howto-step__num" aria-hidden="true">04</p>
        <span class="howto-step__icon"><?php echo lp_icon('badge-check', 'w-7 h-7'); ?></span>
        <h3 class="howto-step__title">結果を確認</h3>
        <p class="howto-step__highlight">解説・AIフィードバック</p>
        <p class="howto-step__text"><?php echo br_after_period('正誤と解説をその場で確認。英作文とスピーキングでは、AIの採点・フィードバックを次の回答に活かせます。'); ?></p>
      </li>
      <li class="howto-step">
        <p class="howto-step__num" aria-hidden="true">05</p>
        <span class="howto-step__icon"><?php echo lp_icon('rotate-ccw', 'w-7 h-7'); ?></span>
        <h3 class="howto-step__title">弱点を復習</h3>
        <p class="howto-step__highlight">履歴から間違いをやり直す</p>
        <p class="howto-step__text"><?php echo br_after_period('学習履歴を確認し、間違えた問題をもう一度練習。解いて終わりにせず、できるまで反復します。'); ?></p>
      </li>
    </ol>

    <div class="howto-cta">
      <a class="howto-cta__button" href="<?php echo APP_URL; ?>/signup"><?php echo lp_start_cta_inner('h-5 w-5'); ?></a>
      <p class="howto-cta__note">カード登録不要・登録したその場から開始</p>
      <p class="mt-3 max-w-2xl text-center text-xs leading-relaxed text-slate-500">単語テストは回数の制限なく無料です。その他の技能の無料範囲は<a class="font-semibold text-[#008b96] underline-offset-2 hover:underline" href="/plan">料金ページ</a>にまとめています。登録時の課金はありません。</p>
    </div>
  </div>
</section>
