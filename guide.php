<?php
/**
 * 使い方ガイド（初回登録向け）
 */
declare(strict_types=1);

$page = 'guide';
require_once __DIR__ . '/config.php';
$canonical = rtrim(SITE_URL, '/') . '/guide';

/**
 * ガイド用キャプチャ（専用画像がなければ共通アプリ画面へフォールバック）
 */
function guide_screen_url(string $key): string
{
    $dir = __DIR__ . '/assets/images/guide/';
    foreach (['.png', '.jpg', '.jpeg', '.webp'] as $ext) {
        if (is_file($dir . $key . $ext)) {
            return '/assets/images/guide/' . $key . $ext;
        }
    }
    $fallback = [
        'signup' => 'word',
        'profile' => 'word',
        'word' => 'word',
        'reading' => 'reading',
        'listening' => 'listening',
        'writing' => 'writing',
        'premium' => 'writing',
    ];
    $skill = $fallback[$key] ?? 'word';
    $common = __DIR__ . '/assets/images/';
    foreach (['.png', '.jpg', '.jpeg', '.webp'] as $ext) {
        $file = 'app-screen-' . $skill . $ext;
        if (is_file($common . $file)) {
            return '/assets/images/' . $file;
        }
    }
    return '/assets/images/app-screen-placeholder.svg';
}

$signup_url = rtrim(APP_URL, '/') . '/signup';
$toc = [
    ['id' => 'start', 'label' => 'はじめ方'],
    ['id' => 'skills', 'label' => '4つの学習'],
    ['id' => 'ten-min', 'label' => '最初の10分'],
    ['id' => 'habit', 'label' => '続くしかけ'],
    ['id' => 'trial', 'label' => '無料で試す'],
    ['id' => 'faq', 'label' => 'よくある質問'],
];

$start_steps = [
    [
        'num' => '1',
        'title' => '会員登録する',
        'body' => 'メールアドレスか Google で、1分ほどでアカウントができます。カードの登録はありません。登録したその日から学習を始められます。',
        'image' => 'signup',
        'caption' => '会員登録のイメージ',
    ],
    [
        'num' => '2',
        'title' => '名前・バディ・目標級を決める',
        'body' => 'ニックネームと、一緒に学ぶバディ、目指す英検の級を選びます。選んだ級の問題が、最初からそろいます。',
        'image' => 'profile',
        'caption' => 'プロフィール設定のイメージ',
    ],
    [
        'num' => '3',
        'title' => '今日のメニューをタップ',
        'body' => 'ダッシュボードに「今日の学習メニュー」が出ます。気になるカードを押せば、すぐに問題が始まります。',
        'image' => 'word',
        'caption' => '今日の学習メニューのイメージ',
    ],
];

$skills = [
    [
        'en' => 'Vocabulary',
        'title' => '単語',
        'lead' => '10問の4択クイズ。毎日のウォームアップにぴったりです。',
        'body' => '級を確認してスタートを押すだけ。間違えた単語は、忘れそうなタイミングでまた出てきます。',
        'image' => 'word',
    ],
    [
        'en' => 'Reading',
        'title' => 'リーディング',
        'lead' => '本番と同じ形式で解いて、すぐ解説が読めます。',
        'body' => '短文・長文など、今日やりたい形式を選べます。答え合わせのあと「なぜ違うか」を読むと、次から選び方が変わります。',
        'image' => 'reading',
    ],
    [
        'en' => 'Writing',
        'title' => 'ライティング',
        'lead' => '書いて送ると、AIが文法・構成・語彙を添削します。',
        'body' => '英作文・Eメール・要約など、級に合った形式で提出できます。4級・5級にはライティングはありません。',
        'image' => 'writing',
    ],
    [
        'en' => 'Listening',
        'title' => 'リスニング',
        'lead' => '本番に近い放送回数で、会話や英文を聞き取ります。',
        'body' => '級を選ぶと、その級の部だけが出ます。通学中の1セットでも十分。まずは短い会話から。',
        'image' => 'listening',
    ],
];

$habits = [
    ['title' => '連続学習', 'body' => '毎日続けると日数が積み上がります。1日空いても、また今日から数え直せます。'],
    ['title' => 'バッジ', 'body' => '学習の節目でバッジがもらえます。集めた記録は「バッジ」ページで見られます。'],
    ['title' => 'バディ', 'body' => '選んだバディが、学習のようすに合わせて応援してくれます。'],
    ['title' => '試験日カウントダウン', 'body' => 'プロフィールで受験回を登録すると、ダッシュボードにあと何日かが出ます。'],
];

$faqs = [
    [
        'q' => '級はあとから変えられますか？',
        'a' => 'はい。プロフィールの「目標級」から、5級〜1級（準2級プラス含む）にいつでも変更できます。単語や各技能の問題も、選んだ級に合わせて切り替わります。',
    ],
    [
        'q' => 'スマートフォンでも使えますか？',
        'a' => 'はい。Safari や Chrome など、いつものブラウザから使えます。画面の大きさに合わせて表示されます。アプリのインストールは不要です。',
    ],
    [
        'q' => 'わからないことがあったら？',
        'a' => 'ログイン後の「ヘルプ」から、よくある質問を探せます。FAQにない内容は、ヘルプ内のAI質問か、お問い合わせフォームをご利用ください。',
    ],
];

include __DIR__ . '/includes/header.php';
?>
<article class="guide-page border-b border-slate-100 bg-white" aria-labelledby="guide-heading">
  <section class="guide-hero border-b border-slate-100 px-4 py-14 sm:py-20">
    <div class="mx-auto max-w-3xl text-center">
      <p class="section-badge section-badge--center" aria-hidden="true">GUIDE</p>
      <h1 id="guide-heading" class="mt-3 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">はじめての使い方</h1>
      <p class="mt-4 text-lg font-semibold leading-relaxed text-slate-900 sm:text-xl">今日から、英検の勉強が始まります</p>
      <p class="mt-4 text-base leading-relaxed text-slate-700"><?php echo br_after_period('AiKenは、単語・リーディング・ライティング・リスニングをひとつにまとめた英検対策アプリです。まずは3つのステップ。最初の10分で、自分の級の問題に触れられます。'); ?></p>
      <p class="mt-6">
        <a class="guide-cta-btn" href="<?php echo htmlspecialchars($signup_url); ?>"><?php echo FREE_TRIAL_DAYS; ?>日間無料で試す</a>
      </p>
      <p class="mt-3 text-sm text-slate-500">カード登録不要・1分で完了</p>
    </div>
  </section>

  <nav class="border-b border-slate-100 px-4 py-6" aria-label="ガイド目次">
    <div class="mx-auto flex max-w-3xl flex-wrap justify-center gap-x-5 gap-y-2 text-sm font-medium text-slate-600">
      <?php foreach ($toc as $item): ?>
      <a class="hover:text-[#50c2cb] hover:underline" href="#guide-<?php echo htmlspecialchars($item['id']); ?>"><?php echo htmlspecialchars($item['label']); ?></a>
      <?php endforeach; ?>
    </div>
  </nav>

  <div class="mx-auto max-w-3xl px-4 py-12 sm:py-16">
    <section id="guide-start" class="guide-block" aria-labelledby="guide-start-heading">
      <h2 id="guide-start-heading" class="guide-block__title">はじめ方は、3ステップ</h2>
      <p class="guide-block__lead"><?php echo br_after_period('難しい設定はありません。決めるのは「名前」と「目指す級」だけです。'); ?></p>

      <ol class="guide-start-list">
        <?php foreach ($start_steps as $i => $step):
            $src = guide_screen_url($step['image']);
            $reverse = $i % 2 === 1;
            ?>
        <li class="guide-start-item">
          <div class="guide-step__grid<?php echo $reverse ? ' guide-step__grid--reverse' : ''; ?>">
            <div>
              <p class="guide-start-item__num" aria-hidden="true"><?php echo htmlspecialchars($step['num']); ?></p>
              <h3 class="guide-start-item__title"><?php echo htmlspecialchars($step['title']); ?></h3>
              <p class="guide-start-item__body"><?php echo br_after_period(htmlspecialchars($step['body'])); ?></p>
            </div>
            <figure class="guide-step__figure">
              <div class="guide-step__frame">
                <img src="<?php echo htmlspecialchars($src); ?>" alt="" class="guide-step__img" loading="lazy" decoding="async" width="360" height="640">
              </div>
              <figcaption class="mt-3 text-center text-xs text-slate-500"><?php echo htmlspecialchars($step['caption']); ?></figcaption>
            </figure>
          </div>
        </li>
        <?php endforeach; ?>
      </ol>
    </section>

    <section id="guide-skills" class="guide-block" aria-labelledby="guide-skills-heading">
      <h2 id="guide-skills-heading" class="guide-block__title">4つの学習。迷ったら単語から</h2>
      <p class="guide-block__lead"><?php echo br_after_period('今日やりたいものを1つ選べば大丈夫です。級を選ぶと、その級の形式だけが見えます。'); ?></p>

      <div class="guide-skill-grid">
        <?php foreach ($skills as $skill):
            $src = guide_screen_url($skill['image']);
            ?>
        <article class="guide-skill-card">
          <div class="guide-skill-card__media">
            <img src="<?php echo htmlspecialchars($src); ?>" alt="" class="guide-skill-card__img" loading="lazy" decoding="async" width="640" height="400">
          </div>
          <p class="guide-skill-card__en"><?php echo htmlspecialchars($skill['en']); ?></p>
          <h3 class="guide-skill-card__title"><?php echo htmlspecialchars($skill['title']); ?></h3>
          <p class="guide-skill-card__lead"><?php echo htmlspecialchars($skill['lead']); ?></p>
          <p class="guide-skill-card__body"><?php echo br_after_period(htmlspecialchars($skill['body'])); ?></p>
        </article>
        <?php endforeach; ?>
      </div>
      <p class="mt-5 text-sm leading-relaxed text-slate-600"><?php echo br_after_period('準2級ではスピーキング（面接形式）の練習にも対応しています。'); ?></p>
    </section>

    <section id="guide-ten-min" class="guide-block" aria-labelledby="guide-ten-min-heading">
      <h2 id="guide-ten-min-heading" class="guide-block__title">最初の10分、こう使うと気持ちよく始められます</h2>
      <ol class="guide-ten-min">
        <li><span class="guide-ten-min__label">1.</span> 単語クイズを1セット（約5分）</li>
        <li><span class="guide-ten-min__label">2.</span> リーディングかリスニングを、好きな形式で1つ</li>
      </ol>
      <p class="mt-4 text-sm leading-relaxed text-slate-600"><?php echo br_after_period('ライティングは、少し落ち着いて書けるときに。書いた英文は履歴に残るので、あとから見返せます。'); ?></p>
    </section>

    <section id="guide-habit" class="guide-block" aria-labelledby="guide-habit-heading">
      <h2 id="guide-habit-heading" class="guide-block__title">続くしかけ</h2>
      <p class="guide-block__lead"><?php echo br_after_period('がんばりを見える形にしておくと、翌日も開きやすくなります。'); ?></p>
      <ul class="guide-habit-list">
        <?php foreach ($habits as $habit): ?>
        <li class="guide-habit-item">
          <h3 class="guide-habit-item__title"><?php echo htmlspecialchars($habit['title']); ?></h3>
          <p class="guide-habit-item__body"><?php echo br_after_period(htmlspecialchars($habit['body'])); ?></p>
        </li>
        <?php endforeach; ?>
      </ul>
      <p class="mt-5 text-sm leading-relaxed text-slate-600"><?php echo br_after_period('各技能のページには「履歴」があります。昨日どこでつまずいたかを見てから、今日の1セットを始めるのもおすすめです。'); ?></p>
    </section>

    <section id="guide-trial" class="guide-block guide-trial" aria-labelledby="guide-trial-heading">
      <h2 id="guide-trial-heading" class="guide-block__title">まずは、無料で試せます</h2>
      <div class="guide-trial__grid">
        <div class="guide-trial__card">
          <h3 class="guide-trial__card-title">登録から<?php echo FREE_TRIAL_DAYS; ?>日間</h3>
          <p class="guide-trial__card-body"><?php echo br_after_period('単語・リーディング・ライティング・リスニングを、回数の制限なく使えます。自分に合うか、じっくり見てみてください。'); ?></p>
        </div>
        <div class="guide-trial__card">
          <h3 class="guide-trial__card-title"><?php echo FREE_TRIAL_DAYS + 1; ?>日目以降も、毎日お試しできます</h3>
          <p class="guide-trial__card-body"><?php echo br_after_period('各技能を1日1セットまで（ライティングはAI添削1回まで）無料で続けられます。受験までしっかり取り組みたいときは、プレミアムプランをご検討ください。'); ?></p>
          <p class="mt-3"><a class="text-sm font-semibold text-[#50c2cb] underline-offset-2 hover:underline" href="/plan">料金プランを見る</a></p>
        </div>
      </div>
      <p class="mt-8 text-center">
        <a class="guide-cta-btn" href="<?php echo htmlspecialchars($signup_url); ?>"><?php echo FREE_TRIAL_DAYS; ?>日間無料で試す</a>
      </p>
    </section>

    <section id="guide-faq" class="guide-block" aria-labelledby="guide-faq-heading">
      <h2 id="guide-faq-heading" class="guide-block__title">よくある質問</h2>
      <div class="guide-faq-list">
        <?php foreach ($faqs as $faq): ?>
        <details class="guide-faq-item">
          <summary class="guide-faq-item__q"><?php echo htmlspecialchars($faq['q']); ?></summary>
          <div class="guide-faq-item__a"><?php echo br_after_period(htmlspecialchars($faq['a'])); ?></div>
        </details>
        <?php endforeach; ?>
      </div>
      <p class="mt-5 text-sm text-slate-600">
        ほかの質問は
        <a class="font-semibold text-[#50c2cb] underline-offset-2 hover:underline" href="/faq">よくあるご質問</a>
        ／
        <a class="font-semibold text-[#50c2cb] underline-offset-2 hover:underline" href="/contact">お問い合わせ</a>
        もご利用ください。
      </p>
    </section>

    <section class="guide-closing" aria-labelledby="guide-closing-heading">
      <h2 id="guide-closing-heading" class="guide-closing__title">最初の1問は、すぐそこです</h2>
      <p class="guide-closing__lead"><?php echo br_after_period('会員登録が終わったら、ダッシュボードの単語カードを押してみてください。10問終わったころには、今日の学習リズムができています。'); ?></p>
      <p class="mt-6">
        <a class="guide-cta-btn" href="<?php echo htmlspecialchars($signup_url); ?>"><?php echo FREE_TRIAL_DAYS; ?>日間無料で試す</a>
      </p>
      <p class="mt-6 text-sm text-slate-500">
        <a class="underline-offset-2 hover:underline" href="/cancel">退会・解約の手順</a>
        ／
        <a class="underline-offset-2 hover:underline" href="/parents">保護者の方へ</a>
      </p>
    </section>
  </div>
</article>
<?php
include __DIR__ . '/includes/footer.php';
