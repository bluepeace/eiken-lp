<?php
/**
 * AiKenでできるリスニング対策
 * @var array $listening
 */
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../../config.php';
}

$cards = [
    [
        'icon' => 'clipboard-list',
        'title' => '級の形式だけが出る',
        'text' => (string) ($listening['form_text'] ?? ''),
    ],
    [
        'icon' => 'headphones',
        'title' => '音声のあとにスクリプトが出る',
        'text' => (string) ($listening['explain_text'] ?? ''),
    ],
];
$forms = is_array($listening['forms'] ?? null) ? $listening['forms'] : [];
foreach ($forms as $form) {
    if (!is_array($form) || ($form['text'] ?? '') === '') {
        continue;
    }
    $cards[] = $form;
}
$hint = (string) ($listening['hint_text'] ?? '');
if ($hint !== '') {
    $cards[] = [
        'icon' => 'target',
        'title' => '履歴から同じ問題で再演習',
        'text' => $hint,
    ];
}
?>
<section id="listening-practice" class="scroll-mt-24 border-t border-slate-100 bg-slate-50/50 px-4 py-16 sm:py-20" aria-labelledby="listening-practice-heading">
  <div class="lp-container">
    <div class="mx-auto max-w-3xl text-center">
      <p class="section-badge section-badge--center" aria-hidden="true">PRACTICE</p>
      <h2 id="listening-practice-heading" class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">AiKenでできるリスニング対策</h2>
      <p class="mt-3 text-slate-600"><?php echo br_after_period('メニューに出る形式だけを、選んですぐ演習できます。'); ?></p>
    </div>
    <div class="speaking-cap-grid mt-10 sm:mt-12">
      <?php foreach ($cards as $cap): ?>
      <?php if (($cap['text'] ?? '') === '') {
          continue;
      } ?>
      <article class="speaking-cap">
        <span class="speaking-cap__icon"><?php echo lp_icon((string) ($cap['icon'] ?? 'headphones'), 'w-6 h-6'); ?></span>
        <h3 class="speaking-cap__title"><?php echo htmlspecialchars((string) ($cap['title'] ?? '')); ?></h3>
        <p class="speaking-cap__text"><?php echo br_after_period(htmlspecialchars((string) $cap['text'], ENT_QUOTES, 'UTF-8')); ?></p>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
