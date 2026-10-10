<?php
/**
 * AiKenでできる単語対策
 * @var array $vocabulary
 */
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../../config.php';
}

$cards = [
    ['icon' => 'clipboard-list', 'title' => '級を選んで10問', 'text' => (string) ($vocabulary['form_text'] ?? '')],
    ['icon' => 'book-open', 'title' => '日本語の意味を4つから選ぶ', 'text' => (string) ($vocabulary['quiz_text'] ?? '')],
    ['icon' => 'badge-check', 'title' => '選んだ直後に例文が出る', 'text' => (string) ($vocabulary['after_text'] ?? '')],
    ['icon' => 'headphones', 'title' => '10問で正答数が出る', 'text' => '10問の終わりに正答数が出ます。「もう一度」で次の10問に進めます。1セットの目安は約5分です。'],
    ['icon' => 'target', 'title' => '間違えた語が次の10問に入る', 'text' => (string) ($vocabulary['priority_text'] ?? '')],
    ['icon' => 'book-text', 'title' => '履歴から振り返る', 'text' => (string) ($vocabulary['history_text'] ?? '')],
    ['icon' => 'circle-help', 'title' => '画面にないもの', 'text' => (string) ($vocabulary['limits_text'] ?? '')],
];
?>
<section id="vocabulary-practice" class="scroll-mt-24 border-t border-slate-100 bg-slate-50/50 px-4 py-16 sm:py-20" aria-labelledby="vocabulary-practice-heading">
  <div class="lp-container">
    <div class="mx-auto max-w-3xl text-center">
      <p class="section-badge section-badge--center" aria-hidden="true">PRACTICE</p>
      <h2 id="vocabulary-practice-heading" class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">AiKenでできる単語対策</h2>
      <p class="mt-3 text-slate-600"><?php echo br_after_period('画面にあるものだけを掲載しています。'); ?></p>
    </div>
    <div class="speaking-cap-grid mt-10 sm:mt-12">
      <?php foreach ($cards as $cap): ?>
      <?php if (($cap['text'] ?? '') === '') {
          continue;
      } ?>
      <article class="speaking-cap">
        <span class="speaking-cap__icon"><?php echo lp_icon((string) ($cap['icon'] ?? 'book-open'), 'w-6 h-6'); ?></span>
        <h3 class="speaking-cap__title"><?php echo htmlspecialchars((string) ($cap['title'] ?? '')); ?></h3>
        <p class="speaking-cap__text"><?php echo br_after_period(htmlspecialchars((string) $cap['text'], ENT_QUOTES, 'UTF-8')); ?></p>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
