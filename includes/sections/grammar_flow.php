<?php
/**
 * 文法の画面（一覧・解説・確認問題）
 * @var string $grade
 * @var array $grade_data
 * @var string $grammar_signup_href
 */
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../../config.php';
}
require_once __DIR__ . '/../grammar-data.php';

$name = (string) ($grade_data['name'] ?? '');
$name_short = (string) ($grade_data['name_short'] ?? '');
$shots = [
    [
        'key' => 'grammar-1',
        'kicker' => 'テーマ一覧',
        'caption' => '未学習か、これまでの正答数と正答率が出ます。',
        'note' => '級を選ぶと、カテゴリごとにテーマが並びます。目標の級が用意されていれば、最初からその級が入っています。',
    ],
    [
        'key' => 'grammar-2',
        'kicker' => '解説と例文',
        'caption' => '要約、解説、基本のルール、英文と日本語の例文です。',
        'note' => '用語だけで始めません。ルールを読んだあと、例文で形を確認してから問題に進みます。',
    ],
    [
        'key' => 'grammar-3',
        'kicker' => '確認問題',
        'caption' => '選ぶと、訳と、ほかの選択肢が合わない理由が出ます。',
        'note' => '4択が5問です。5問終わると結果になり、間違えた問題を振り返れます。',
    ],
];
?>
<section id="grammar-flow" class="border-t border-slate-100 bg-white px-4 py-16 sm:py-20" aria-labelledby="grammar-flow-heading">
  <div class="lp-container">
    <div class="mx-auto max-w-3xl text-center">
      <p class="section-badge section-badge--center" aria-hidden="true">SCREEN</p>
      <h2 id="grammar-flow-heading" class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl"><?php echo htmlspecialchars($name_short); ?>の文法画面</h2>
      <p class="mt-3 text-slate-600"><?php echo br_after_period('ブラウザの画面です。過去問の転載ではありません。'); ?></p>
    </div>

    <?php foreach ($shots as $i => $shot):
        $src = grammar_shot_url((string) $grade, $shot['key']);
        if ($src === '') {
            continue;
        }
        $kicker = $shot['kicker'];
        $alt = $name . 'の文法。' . $kicker;
        $margin = $i === 0 ? 'mt-10 sm:mt-12' : 'mt-12 sm:mt-16';
        ?>
    <div class="speaking-example <?php echo $margin; ?>">
      <figure class="speaking-example__shot">
        <button
          type="button"
          class="grade-capture-card__zoom"
          data-grade-lightbox="<?php echo htmlspecialchars($src, ENT_QUOTES, 'UTF-8'); ?>"
          data-grade-lightbox-caption="<?php echo htmlspecialchars($kicker, ENT_QUOTES, 'UTF-8'); ?>"
          data-grade-lightbox-alt="<?php echo htmlspecialchars($alt, ENT_QUOTES, 'UTF-8'); ?>"
          aria-label="<?php echo htmlspecialchars($kicker . 'の画面を拡大表示', ENT_QUOTES, 'UTF-8'); ?>"
        >
          <span class="grade-capture-card__frame">
            <img src="<?php echo htmlspecialchars($src, ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($alt, ENT_QUOTES, 'UTF-8'); ?>" class="speaking-example__img" width="1024" height="633" loading="lazy" decoding="async">
          </span>
          <span class="grade-capture-card__zoom-hint" aria-hidden="true">拡大</span>
        </button>
        <figcaption class="speaking-example__caption"><?php echo br_after_period(htmlspecialchars($shot['caption'], ENT_QUOTES, 'UTF-8')); ?></figcaption>
      </figure>
      <div class="speaking-example__body writing-stack">
        <p class="speaking-example__kicker"><?php echo htmlspecialchars($kicker); ?></p>
        <article class="speaking-fb speaking-fb--high">
          <p class="speaking-fb__score">この画面ですること</p>
          <p class="speaking-fb__text"><?php echo br_after_period(htmlspecialchars($shot['note'], ENT_QUOTES, 'UTF-8')); ?></p>
        </article>
      </div>
    </div>
    <?php endforeach; ?>

    <div class="speaking-after">
      <p><?php echo br_after_period('登録したその日から、この級のテーマを確認できます。文法は登録後も回数の制限がありません。'); ?></p>
      <a class="speaking-after__button" href="<?php echo htmlspecialchars(lp_app_link($grammar_signup_href, 'example'), ENT_QUOTES, 'UTF-8'); ?>">無料で文法の確認を始める</a>
    </div>
  </div>
</section>
