<?php
/**
 * AiKenがライティング学習に向いている理由
 * @var array $writing
 */
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../../config.php';
}
$bridge = (string) ($writing['bridge'] ?? '同じアカウントで、単語、リーディング、リスニング、スピーキングも続けられます。');
$reasons = [
    ['icon' => 'pencil-line', 'title' => '英文は自分で書く', 'text' => 'AIが答案を代わりに作る機能はありません。書く練習そのものが残ります。'],
    ['icon' => 'badge-check', 'title' => '直し方と次に足すことが同時に見える', 'text' => '赤字の修正と、日本語のコメントが一緒に返ります。どこを足せば語数と形式に合うかが見えます。'],
    ['icon' => 'book-open', 'title' => 'ほかの技能も同じアカウント', 'text' => $bridge],
    ['icon' => 'smartphone', 'title' => 'ブラウザ、iPhone、iPad', 'text' => 'ノートの写真からも入力できます。手書きの答案を、その場で添削に回せます。'],
];
?>
<section id="writing-reasons" class="border-t border-slate-100 bg-white px-4 py-16 sm:py-20" aria-labelledby="writing-reasons-heading">
  <div class="lp-container">
    <div class="mx-auto max-w-3xl text-center">
      <p class="section-badge section-badge--center" aria-hidden="true">WHY</p>
      <h2 id="writing-reasons-heading" class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">AiKenがライティング学習に向いている理由</h2>
    </div>
    <div class="speaking-cap-grid mt-10 sm:mt-12">
      <?php foreach ($reasons as $reason): ?>
      <article class="speaking-cap">
        <span class="speaking-cap__icon"><?php echo lp_icon((string) $reason['icon'], 'w-6 h-6'); ?></span>
        <h3 class="speaking-cap__title"><?php echo htmlspecialchars((string) $reason['title']); ?></h3>
        <p class="speaking-cap__text"><?php echo br_after_period(htmlspecialchars((string) $reason['text'], ENT_QUOTES, 'UTF-8')); ?></p>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
