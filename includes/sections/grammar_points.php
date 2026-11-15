<?php
/**
 * 文法の進め方
 * @var array $grade_data
 */
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../../config.php';
}

$name = (string) ($grade_data['name'] ?? '英検');
$cards = [
    [
        'icon' => 'book-open',
        'title' => '読んで、5問で終わる',
        'text' => 'テーマを開くと、要約、解説、基本のルール、英文と日本語の例文が出ます。そのあと4択が5問です。語句整序や英作文ではありません。',
    ],
    [
        'icon' => 'badge-check',
        'title' => 'なぜ違うかまで、日本語で',
        'text' => '選んだ直後に、正誤と日本語訳が出ます。解説は、正解が合う理由と、ほかの3つが合わない理由まで書いています。',
    ],
    [
        'icon' => 'list-checks',
        'title' => '訳を見てから選ばない',
        'text' => '英文だけで答えが一つに決まります。日本語訳は、答えたあとに出ます。',
    ],
    [
        'icon' => 'rotate-ccw',
        'title' => '回数の上限はない',
        'text' => '単語と同じく、登録後も使い放題です。リーディング、リスニング、ライティング、スピーキングの1日1セットには入りません。',
    ],
];
?>
<section id="grammar-points" class="scroll-mt-24 border-t border-slate-100 bg-slate-50/50 px-4 py-16 sm:py-20" aria-labelledby="grammar-points-heading">
  <div class="lp-container">
    <div class="mx-auto max-w-3xl text-center">
      <p class="section-badge section-badge--center" aria-hidden="true">HOW</p>
      <h2 id="grammar-points-heading" class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">文法の確認のしかた</h2>
      <p class="mt-3 text-slate-600"><?php echo br_after_period(htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . 'は、短いテーマを1つずつ確かめて終わります。'); ?></p>
    </div>
    <div class="speaking-cap-grid mt-10 sm:mt-12">
      <?php foreach ($cards as $cap): ?>
      <article class="speaking-cap">
        <span class="speaking-cap__icon"><?php echo lp_icon((string) $cap['icon'], 'w-6 h-6'); ?></span>
        <h3 class="speaking-cap__title"><?php echo htmlspecialchars($cap['title']); ?></h3>
        <p class="speaking-cap__text"><?php echo br_after_period(htmlspecialchars($cap['text'], ENT_QUOTES, 'UTF-8')); ?></p>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
