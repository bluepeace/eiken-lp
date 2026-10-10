<?php
/**
 * AiKenでできるライティング対策
 * @var array $writing
 */
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../../config.php';
}

$capabilities = [
    [
        'icon' => 'clipboard-list',
        'title' => '級の形式で1問出る',
        'text' => (string) ($writing['form_text'] ?? ''),
    ],
    [
        'icon' => 'book-text',
        'title' => '書く前に型を見られる',
        'text' => (string) ($writing['hint_text'] ?? ''),
    ],
    [
        'icon' => 'target',
        'title' => '語数を数えながら書ける',
        'text' => (string) ($writing['length_text'] ?? ''),
    ],
    [
        'icon' => 'smartphone',
        'title' => '写真の英文を読み取って入力できる',
        'text' => 'ノートに書いた答案を、その場で添削に回せます。音声入力もできます。',
    ],
    [
        'icon' => 'badge-check',
        'title' => '5つの観点で返る',
        'text' => '語彙、文法、内容、構成、指示遵守。各0〜5点で、総合はその平均です。レーダー、赤字の添削文、日本語コメント、折りたたみの模範解答が返ります。',
    ],
    [
        'icon' => 'headphones',
        'title' => '添削文を音声で聞ける',
        'text' => '直した英文を、その場で音読できます。添削は文法と綴りの修正だけで、意見の中身は変えません。',
    ],
    [
        'icon' => 'pencil-line',
        'title' => '別の問題で繰り返せる',
        'text' => '履歴に点数と答案が残ります。別の問題で、同じ型を書き直せます。',
    ],
];
?>
<section id="writing-practice" class="border-t border-slate-100 bg-slate-50/50 px-4 py-16 sm:py-20" aria-labelledby="writing-practice-heading">
  <div class="lp-container">
    <div class="mx-auto max-w-3xl text-center">
      <p class="section-badge section-badge--center" aria-hidden="true">PRACTICE</p>
      <h2 id="writing-practice-heading" class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">AiKenでできるライティング対策</h2>
      <p class="mt-3 text-slate-600"><?php echo br_after_period('画面にある機能に合わせて、級の形式で書いて、その場で添削を見る流れです。'); ?></p>
    </div>
    <div class="speaking-cap-grid mt-10 sm:mt-12">
      <?php foreach ($capabilities as $cap): ?>
      <?php if ($cap['text'] === '') {
          continue;
      } ?>
      <article class="speaking-cap">
        <span class="speaking-cap__icon"><?php echo lp_icon((string) $cap['icon'], 'w-6 h-6'); ?></span>
        <h3 class="speaking-cap__title"><?php echo htmlspecialchars((string) $cap['title']); ?></h3>
        <p class="speaking-cap__text"><?php echo br_after_period(htmlspecialchars((string) $cap['text'], ENT_QUOTES, 'UTF-8')); ?></p>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
