<?php
/**
 * 単語対策にAiKenが向いている理由
 * @var array $vocabulary
 */
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../../config.php';
}
$reasons = [
    [
        'icon' => 'badge-check',
        'title' => '10問で覚えたつもりを確認する',
        'text' => '10問ごとに正答数が出るので、覚えたつもりをその場で確認できます。',
    ],
    [
        'icon' => 'clipboard-list',
        'title' => '1セットは約5分',
        'text' => '終わったら「もう一度」で次の10問に進めます。',
    ],
    [
        'icon' => 'target',
        'title' => '間違えた語が戻ってくる',
        'text' => 'ログインすると、間違えた語が一覧に残り、次のクイズに戻ってきます。',
    ],
    [
        'icon' => 'graduation-cap',
        'title' => 'ほかの技能も同じアカウント',
        'text' => (string) ($vocabulary['bridge'] ?? ''),
    ],
    [
        'icon' => 'smartphone',
        'title' => 'ブラウザ、iPhone、iPad',
        'text' => 'ブラウザ、iPhone、iPadで使えます。発音と例文は、その端末の読み上げです。',
    ],
];
?>
<section id="vocabulary-reasons" class="border-t border-slate-100 bg-white px-4 py-16 sm:py-20" aria-labelledby="vocabulary-reasons-heading">
  <div class="lp-container">
    <div class="mx-auto max-w-3xl text-center">
      <p class="section-badge section-badge--center" aria-hidden="true">WHY</p>
      <h2 id="vocabulary-reasons-heading" class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">単語対策にAiKenが向いている理由</h2>
    </div>
    <div class="speaking-cap-grid mt-10 sm:mt-12">
      <?php foreach ($reasons as $reason): ?>
      <?php if ($reason['text'] === '') {
          continue;
      } ?>
      <article class="speaking-cap">
        <span class="speaking-cap__icon"><?php echo lp_icon((string) $reason['icon'], 'w-6 h-6'); ?></span>
        <h3 class="speaking-cap__title"><?php echo htmlspecialchars((string) $reason['title']); ?></h3>
        <p class="speaking-cap__text"><?php echo br_after_period(htmlspecialchars((string) $reason['text'], ENT_QUOTES, 'UTF-8')); ?></p>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
