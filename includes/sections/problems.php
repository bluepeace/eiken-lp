<?php if (!defined('SITE_NAME')) { require_once __DIR__ . '/../../config.php'; } ?>
<?php
$problem_items = [
    '部活や塾で忙しくて、<strong>空き時間</strong>でサクッと英検の練習がしたい',
    '通学の電車の中で、<strong>スマホから</strong>英検対策を進められたらいいのに',
    '<strong>ライティング</strong>は、書いた直後に添削してもらえないかな',
    '<strong>オンライン英会話</strong>以外でも、スピーキングを特訓したい',
    '<strong>過去問</strong>だけじゃ足りない。もっといろんな練習問題を解きたい',
    '<strong>本番に近い形式</strong>の問題で、実践的に練習したい',
];
?>
<section class="problems-section border-t border-[#50c2cb]/15 px-4 py-16 sm:py-20" aria-labelledby="problems-heading">
  <div class="lp-container">
    <div class="problems-section__header mx-auto max-w-3xl text-center">
      <p class="section-badge section-badge--center" aria-hidden="true">WORRY</p>
      <h2 id="problems-heading" class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">英検対策、<span class="heading-accent">こんなお悩み</span>ありませんか？</h2>
      <p class="problems-lead mt-3"><?php echo br_after_period('部活や塾で忙しいあなたへ。英検、こんなことで止まっていませんか。'); ?></p>
    </div>
    <div class="problems-card mt-8 rounded-2xl border border-white/80 bg-white px-5 py-6 text-left shadow-sm sm:px-8 sm:py-8">
      <div class="problems-card__inner">
        <ul class="problems-list space-y-4 sm:space-y-5">
          <?php foreach ($problem_items as $text): ?>
          <li class="problems-list__item">
            <span class="problems-list__check text-[#50c2cb]" aria-hidden="true"><?php echo lp_icon('check', 'w-4 h-4'); ?></span>
            <span class="problems-lead"><?php echo $text; ?></span>
          </li>
          <?php endforeach; ?>
        </ul>
        <figure class="problems-buddy">
          <img src="/assets/images/buddy-worries.png" alt="AiKenのバディ" width="320" height="320" class="problems-buddy__image" loading="lazy">
        </figure>
      </div>
    </div>
    <div class="problems-solution">
      <div class="problems-arrow" aria-hidden="true">
        <?php echo lp_icon('chevron-down', 'problems-arrow__icon'); ?>
        <?php echo lp_icon('chevron-down', 'problems-arrow__icon'); ?>
      </div>
      <p class="problems-lead problems-solution__text mx-auto max-w-3xl text-center text-lg font-bold"><?php echo br_after_period('だからこそ、<span class="text-brand-accent">空き時間の練習</span>から<strong>AI添削</strong>・<strong>スピーキング特訓</strong>まで。本番形式の問題を、アプリひとつで。'); ?></p>
    </div>
  </div>
</section>
