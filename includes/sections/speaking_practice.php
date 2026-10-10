<?php
/**
 * AiKenでできるスピーキング対策（共通4つ＋級のパート）
 * @var string $grade
 * @var array $grade_data
 * @var array $speaking
 */
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../../config.php';
}

$name_short = (string) ($grade_data['name_short'] ?? '');
$parts = is_array($speaking['parts'] ?? null) ? $speaking['parts'] : [];
$capabilities = [
    [
        'icon' => 'clipboard-list',
        'title' => '本番の流れで通す',
        'text' => 'フル模擬では、黙読や準備のタイマー、カードを表に出すタイミング、意見のときはカードを隠すところまで通します。',
    ],
    [
        'icon' => 'target',
        'title' => '弱いパートだけ繰り返す',
        'text' => 'ドリルでは、その級の画面にあるパートだけを切り出してやり直せます。音読だけ、3コマだけ、意見だけ、という切り出しです。',
    ],
    [
        'icon' => 'bot',
        'title' => '話したあとに日本語で返る',
        'text' => '各パート0〜3点です。足りない箇所と、合格できる水準の答えが日本語で返ります。細かい文法より、時制・because・コマ数・結論の先出しなど、形式を見ます。',
    ],
    [
        'icon' => 'book-text',
        'title' => '今のパートの言い方だけ出る',
        'text' => '折りたたみのフレーズヒントです。級で共通の型と、その問題用のヒントの両方が出ます。',
    ],
];
?>
<section id="speaking-practice" class="border-t border-slate-100 bg-white px-4 py-16 sm:py-20" aria-labelledby="speaking-practice-heading">
  <div class="lp-container">
    <div class="mx-auto max-w-3xl text-center">
      <p class="section-badge section-badge--center" aria-hidden="true">PRACTICE</p>
      <h2 id="speaking-practice-heading" class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">AiKenでできるスピーキング対策</h2>
      <p class="mt-3 text-slate-600"><?php echo br_after_period('各級3セットです。面接の流れを通すフル模擬と、弱いパートだけのドリルがあります。話したあとは、日本語で採点が返ります。'); ?></p>
    </div>
    <div class="speaking-cap-grid mt-10 sm:mt-12">
      <?php foreach ($capabilities as $cap): ?>
      <article class="speaking-cap">
        <span class="speaking-cap__icon"><?php echo lp_icon((string) $cap['icon'], 'w-6 h-6'); ?></span>
        <h3 class="speaking-cap__title"><?php echo htmlspecialchars((string) $cap['title']); ?></h3>
        <p class="speaking-cap__text"><?php echo br_after_period(htmlspecialchars((string) $cap['text'], ENT_QUOTES, 'UTF-8')); ?></p>
      </article>
      <?php endforeach; ?>
    </div>

    <?php if ($parts !== []): ?>
    <div class="mx-auto mt-16 max-w-3xl text-center sm:mt-20">
      <h3 class="text-xl font-bold tracking-tight text-slate-900 sm:text-2xl"><?php echo htmlspecialchars($name_short); ?>で練習するパート</h3>
      <p class="mt-3 text-slate-600"><?php echo br_after_period(htmlspecialchars($name_short, ENT_QUOTES, 'UTF-8') . 'の面接で出る順に、パートを切り出して練習できます。'); ?></p>
    </div>
    <ol class="speaking-part-grid mt-8">
      <?php foreach ($parts as $i => $part): ?>
      <li class="speaking-part">
        <p class="speaking-part__no"><?php echo str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT); ?></p>
        <h4 class="speaking-part__title"><?php echo htmlspecialchars((string) ($part['title'] ?? '')); ?></h4>
        <p class="speaking-part__text"><?php echo br_after_period(htmlspecialchars((string) ($part['text'] ?? ''), ENT_QUOTES, 'UTF-8')); ?></p>
      </li>
      <?php endforeach; ?>
    </ol>
    <?php endif; ?>
  </div>
</section>
