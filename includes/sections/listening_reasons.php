<?php
/**
 * リスニング対策にAiKenが向いている理由
 * @var array $listening
 */
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../../config.php';
}
$reasons = [
    [
        'icon' => 'clipboard-list',
        'title' => '短い区切りで終わる',
        'text' => (string) ($listening['repeat_text'] ?? ''),
    ],
    [
        'icon' => 'headphones',
        'title' => '聞き流しで終わらない',
        'text' => '答えた直後にスクリプトと解説が出ます。行ごとに聞き直せます。',
    ],
    [
        'icon' => 'book-open',
        'title' => '単語学習と組み合わせられる',
        'text' => (string) ($listening['vocab_text'] ?? ''),
    ],
    [
        'icon' => 'graduation-cap',
        'title' => 'ほかの技能も同じアカウント',
        'text' => (string) ($listening['bridge'] ?? ''),
    ],
    [
        'icon' => 'smartphone',
        'title' => 'ブラウザ、iPhone、iPad',
        'text' => 'ブラウザ、iPhone、iPadで使えます。音声は、その端末の読み上げです。',
    ],
];
?>
<section id="listening-reasons" class="border-t border-slate-100 bg-white px-4 py-16 sm:py-20" aria-labelledby="listening-reasons-heading">
  <div class="lp-container">
    <div class="mx-auto max-w-3xl text-center">
      <p class="section-badge section-badge--center" aria-hidden="true">WHY</p>
      <h2 id="listening-reasons-heading" class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">リスニング対策にAiKenが向いている理由</h2>
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
