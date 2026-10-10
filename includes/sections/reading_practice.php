<?php
/**
 * AiKenでできるリーディング対策
 * @var array $reading
 */
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../../config.php';
}

$cards = [
    [
        'icon' => 'clipboard-list',
        'title' => '級の形式だけが出る',
        'text' => (string) ($reading['form_text'] ?? ''),
    ],
    [
        'icon' => 'badge-check',
        'title' => '選んだ直後に解説が出る',
        'text' => (string) ($reading['explain_text'] ?? ''),
    ],
];
$forms = is_array($reading['forms'] ?? null) ? $reading['forms'] : [];
foreach ($forms as $form) {
    if (!is_array($form) || ($form['text'] ?? '') === '') {
        continue;
    }
    $cards[] = $form;
}
$hint = (string) ($reading['hint_text'] ?? '');
if ($hint !== '') {
    $cards[] = [
        'icon' => 'circle-help',
        'title' => 'わからないときはヒントを確認',
        'text' => $hint,
    ];
}
$cards[] = [
    'icon' => 'target',
    'title' => '間違えた問題が残る',
    'text' => '回数が多い順に一覧になり、同じ問題で再演習できます。次の短文セットでは、間違えた問題が優先されます。',
];
$cards[] = [
    'icon' => 'book-text',
    'title' => '解答履歴をあとから見られる',
    'text' => '形式、級、問題の一部、正解、解説をあとから見られます。',
];
?>
<section id="reading-practice" class="scroll-mt-24 border-t border-slate-100 bg-slate-50/50 px-4 py-16 sm:py-20" aria-labelledby="reading-practice-heading">
  <div class="lp-container">
    <div class="mx-auto max-w-3xl text-center">
      <p class="section-badge section-badge--center" aria-hidden="true">PRACTICE</p>
      <h2 id="reading-practice-heading" class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">AiKenでできるリーディング対策</h2>
      <p class="mt-3 text-slate-600"><?php echo br_after_period('メニューに出る形式だけを、選んですぐ演習できます。'); ?></p>
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
