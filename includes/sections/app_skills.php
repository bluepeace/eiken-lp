<?php
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../../config.php';
}

/**
 * 画面キャプチャ画像パス（png / jpg / webp があればそれを、なければプレースホルダー）
 */
function app_skill_screen_url(string $key): string
{
    $dir = __DIR__ . '/../../assets/images/';
    foreach (['.png', '.jpg', '.jpeg', '.webp'] as $ext) {
        $file = 'app-screen-' . $key . $ext;
        if (is_file($dir . $file)) {
            return '/assets/images/' . $file;
        }
    }
    return '/assets/images/app-screen-placeholder.svg';
}

$skill_items = [
    [
        'key' => 'word',
        'icon' => 'book-text',
        'title' => '単語',
        'tagline' => '意味を選んで、その場で定着。音声と例文もセット',
        'text' => '級ごとの単語をクイズ形式で出題。選んだ直後に<span class="lp-marker">正解・解説が表示</span>され、発音や例文も聞けます。1問ずつサクッと進めるので、スキマ時間の反復学習に向いています。',
        'points' => [
            '級別の語彙を4択でサクッと練習',
            '発音・例文の音声で耳からも覚える',
            '正解直後にフィードバックが出る',
        ],
    ],
    [
        'key' => 'reading',
        'icon' => 'book-open',
        'title' => 'リーディング',
        'tagline' => '長文の空所補充など、本番に近い読解をくり返す',
        'text' => '長文の語句空所補充など、<span class="lp-marker">英検のリーディングに近い形式</span>で練習。正誤が色分けで分かり、解説や音声再生も用意しています。別の長文にもすぐ挑戦できるので、読解の型を定着させやすいです。',
        'points' => [
            '級に合わせた長文・読解問題',
            '正誤ハイライトと解説で振り返りやすい',
            '音声で聞いて音読練習もできる',
        ],
    ],
    [
        'key' => 'listening',
        'icon' => 'headphones',
        'title' => 'リスニング',
        'tagline' => 'イラストを見ながら、本番どおり音声で特訓',
        'text' => '会話の応答文選択など、<span class="lp-marker">英検リスニングに近い出題</span>に対応。イラストを見ながら音声を聞き、選択肢から答えます。放送回数も本番を意識した設計なので、試験本番の感覚を先に体感できます。',
        'points' => [
            '本番に近い音声問題とイラスト付き出題',
            '級ごとのパート構成で特訓できる',
            'イヤホンがあれば移動中にも練習可能',
        ],
    ],
    [
        'key' => 'writing',
        'icon' => 'pencil-line',
        'title' => 'ライティング',
        'tagline' => '英作文を書いて、AIがその場で添削・フィードバック',
        'text' => '意見論述など級に合った英作文をアプリ内で作成。<span class="lp-marker">音声入力や写真からの読み取り</span>にも対応し、語数目安を見ながら書けます。書いた内容はAIが添削するので、家庭でも続けやすいのが強みです。',
        'points' => [
            'AIがその場で採点・添削',
            '音声入力・写真読み取りにも対応',
            '語数目安を見ながら本番形式で練習',
        ],
    ],
    [
        'key' => 'speaking',
        'icon' => 'mic',
        'title' => 'スピーキング',
        'tagline' => 'パッセージとイラストで、面接の流れをそのまま特訓',
        'text' => 'パッセージ音読やイラスト描写、審査員の質問など、<span class="lp-marker">英検スピーキング・面接に近い構成</span>で練習できます。フレーズヒントもあるので、初めてでも取り組みやすく、二次対策をアプリ内で繰り返し特訓できます。',
        'points' => [
            '面接形式の問題カードで実践練習',
            'イラスト描写・質問応答に対応',
            'フレーズヒントで答え方の型がつかめる',
        ],
    ],
];
?>
<section class="app-skills-section border-t border-slate-100 px-4 py-16 sm:py-20" aria-labelledby="app-skills-heading">
  <div class="lp-container">
    <div class="app-skills-section__header mx-auto max-w-3xl text-center">
      <p class="section-badge section-badge--center" aria-hidden="true">SKILLS</p>
      <h2 id="app-skills-heading" class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">画面で見る、<span class="heading-accent">英語4技能＋単語</span>の学習イメージ</h2>
      <p class="app-skills-section__lead mt-3"><?php echo br_after_period('単語・リーディング・リスニング・ライティング・スピーキング。英検の本試験形式で、どんなふうに学べるかを画面イメージでご紹介します。'); ?></p>
    </div>

    <div class="app-skills-list mt-12 sm:mt-16">
      <?php foreach ($skill_items as $index => $item):
          $reverse = $index % 2 === 1;
          $screen_url = app_skill_screen_url($item['key']);
          ?>
      <article class="app-skills-row<?php echo $reverse ? ' app-skills-row--reverse' : ''; ?>" id="skill-<?php echo htmlspecialchars($item['key']); ?>">
        <div class="app-skills-row__content">
          <p class="app-skills-label">
            <span class="app-skills-label__icon" aria-hidden="true"><?php echo lp_icon($item['icon'], 'w-4 h-4'); ?></span>
            <?php echo htmlspecialchars($item['title']); ?>
          </p>
          <h3 class="app-skills-title"><?php echo htmlspecialchars($item['tagline']); ?></h3>
          <p class="app-skills-desc"><?php echo br_after_period($item['text']); ?></p>
          <ul class="app-skills-points">
            <?php foreach ($item['points'] as $point): ?>
            <li>
              <span class="app-skills-points__check" aria-hidden="true"><?php echo lp_icon('check', 'w-3.5 h-3.5'); ?></span>
              <span><?php echo htmlspecialchars($point); ?></span>
            </li>
            <?php endforeach; ?>
          </ul>
        </div>
        <figure class="app-skills-row__media">
          <div class="app-skills-window">
            <div class="app-skills-window__chrome" aria-hidden="true">
              <span></span><span></span><span></span>
            </div>
            <div class="app-skills-window__screen">
              <img
                src="<?php echo htmlspecialchars($screen_url); ?>"
                alt="<?php echo htmlspecialchars(SITE_NAME . 'の' . $item['title'] . '学習画面'); ?>"
                width="1280"
                height="800"
                class="app-skills-window__image"
                loading="lazy"
                decoding="async"
              >
            </div>
          </div>
          <figcaption class="app-skills-caption"><?php echo htmlspecialchars($item['title']); ?>の画面イメージ</figcaption>
        </figure>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
