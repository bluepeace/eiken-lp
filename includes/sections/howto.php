<?php if (!defined('SITE_NAME')) { require_once __DIR__ . '/../../config.php'; } ?>
<section class="howto-section border-t border-slate-100 px-4 py-16 sm:py-20" aria-labelledby="howto-heading">
  <div class="lp-container">
    <div class="howto-section__header mx-auto max-w-3xl text-center">
      <p class="section-badge section-badge--center" aria-hidden="true">START</p>
      <h2 id="howto-heading" class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">英検対策アプリを、<span class="heading-accent"><?php echo FREE_TRIAL_DAYS; ?>日間無料</span>で試す</h2>
      <p class="howto-section__lead mt-3"><?php echo br_after_period('カードの登録はありません。かんたん3ステップで、今日から英検対策がスタート。'); ?></p>
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
        <h3 class="howto-step__title">プロフィール入力</h3>
        <p class="howto-step__highlight">お名前と英検対策級、そして愛犬を選んでね</p>
        <p class="howto-step__text"><?php echo br_after_period('目標の級を決めて、相棒の愛犬をセレクト。学習がいっきに楽しくなる第一歩です。'); ?></p>
      </li>
      <li class="howto-step">
        <p class="howto-step__num" aria-hidden="true">03</p>
        <span class="howto-step__icon"><?php echo lp_icon('rocket', 'w-7 h-7'); ?></span>
        <h3 class="howto-step__title">使ってみよう！</h3>
        <p class="howto-step__highlight">登録が完了したら早速スタート</p>
        <p class="howto-step__text"><?php echo br_after_period(FREE_TRIAL_DAYS . '日間無料で全機能が使えます。単語もAI採点も、まずは触ってみて。'); ?></p>
      </li>
    </ol>

    <div class="howto-cta">
      <a class="howto-cta__button" href="<?php echo APP_URL; ?>/signup"><?php echo FREE_TRIAL_DAYS; ?>日間無料で試す</a>
      <p class="howto-cta__note">カード登録不要・1分で完了・登録したらすぐに始められる</p>
    </div>
  </div>
</section>
