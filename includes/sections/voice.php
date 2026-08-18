<?php
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../../config.php';
}

$voice_photo_fs = __DIR__ . '/../../assets/images/developer-voice.png';
$voice_photo_url = is_file($voice_photo_fs)
    ? '/assets/images/developer-voice.png'
    : '/assets/images/developer-voice-placeholder.svg';

$voice_quote = '「自分で作ったアプリで、本当に英検に合格できるのか？」——それが気になって、思い切って第1回を受けてみました。空き時間にサッと開けるので、電車の中や夜の布団の中、会社の昼休みにもよく使っていました。初めての英検でしたが、似た形式の問題を何度も解いているうちに「いけるかも」と思えて、それが自信につながったと思います。次は準2級プラスに挑戦します！';
?>
<section class="voice-section border-t border-slate-100 px-4 py-16 sm:py-20" aria-labelledby="voice-heading">
  <div class="lp-container">
    <div class="voice-section__header mx-auto max-w-3xl text-center">
      <p class="section-badge section-badge--center" aria-hidden="true">VOICE</p>
      <h2 id="voice-heading" class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">英検<span class="heading-accent">合格者の声</span></h2>
      <p class="voice-section__lead mt-3"><?php echo br_after_period(SITE_NAME . 'はリリースしたばかりのため、まだユーザー様の合格の声はありません。その代わり、「開発者」自身が英検を受けて無事合格しました！'); ?></p>
    </div>

    <article class="voice-card mt-10 sm:mt-12">
      <figure class="voice-card__photo">
        <img
          src="<?php echo htmlspecialchars($voice_photo_url); ?>"
          alt="AiKenキャラクター（写真は後日差し替え）"
          width="400"
          height="400"
          class="voice-card__image"
          loading="lazy"
          decoding="async"
        >
      </figure>
      <div class="voice-card__body">
        <p class="voice-card__label">
          <span class="voice-card__badge" aria-hidden="true"><?php echo lp_icon('badge-check', 'w-4 h-4'); ?></span>
          開発者M
        </p>
        <h3 class="voice-card__exam">2026年第1回英検　英検準2級</h3>
        <blockquote class="voice-card__quote">
          <p><?php echo htmlspecialchars($voice_quote); ?></p>
        </blockquote>
      </div>
    </article>
  </div>
</section>
