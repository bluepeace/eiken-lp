<?php
/**
 * AiKenで英検合格の道（学習の進め方）
 */
declare(strict_types=1);

$page = 'study';
require_once __DIR__ . '/config.php';
$canonical = rtrim(SITE_URL, '/') . '/study';

$signup_url = rtrim(APP_URL, '/') . '/signup';
$toc = [
    ['id' => 'when', 'label' => '始める時期'],
    ['id' => 'primary', 'label' => '一次試験'],
    ['id' => 'day', 'label' => '一日の流れ'],
];

$windows = [
    [
        'best' => true,
        'kicker' => 'BEST',
        'when' => '3か月前',
        'tag' => 'ベストタイミング',
        'body' => '単語を毎日の習慣にしてから、リスニング・リーディング・ライティングを足す余裕があります。形式に慣れて、自分の型ができる期間です。',
    ],
    [
        'best' => false,
        'kicker' => 'MINIMUM',
        'when' => '2か月前',
        'tag' => 'ギリギリ',
        'body' => '単語は毎日。技能は、週に何度か回します。範囲を広げすぎず、一次試験の形に触れることを優先します。',
    ],
    [
        'best' => false,
        'kicker' => 'RUSH',
        'when' => '1か月前',
        'tag' => 'お急ぎ',
        'body' => '今日からでも始められます。新しいことは増やさず、単語と、いちばん不安な技能に絞って毎日続けます。',
    ],
];

$skills = [
    [
        'id' => 'word',
        'chips' => ['毎日・最初に', '10〜15分'],
        'title' => '単語',
        'body' => '勉強を開いたら、最初に単語です。4択を1セット解き、正解したあとの例文は声に出して読みます。10分ほどで終わるので、他の技能の前に置きやすいメニューです。',
        'steps' => [],
        'note' => '',
        'image' => '/assets/images/app-screen-word.png',
        'image_class' => '',
        'width' => 1440,
        'height' => 900,
        'alt' => '英検2級の単語クイズ。adaptの意味を4択から選び、正解のあと例文が表示されている画面',
        'caption' => '英検2級の単語クイズ。意味を選ぶと、例文が出ます。',
    ],
    [
        'id' => 'listening',
        'chips' => ['静かな自宅で', '20分'],
        'title' => 'リスニング',
        'body' => '音声は、静かな場所のほうが入ります。ご自宅にいるときに20分。1セット解いたあとに表示される会話や英文を、音読します。耳で聞いたあとに口を動かすと、問題の流れに慣れていきます。',
        'steps' => [],
        'note' => '',
        'image' => '/assets/images/grade/2kyu/listening-1.png',
        'image_class' => ' study-shot__img--listen',
        'width' => 1440,
        'height' => 900,
        'alt' => '英検2級リスニング第1部。正解のあと、会話の英文が表示されている画面',
        'caption' => '英検2級リスニング。正解のあと、会話の英文が出ます。ここを音読します。',
    ],
    [
        'id' => 'reading',
        'chips' => ['時間を取れる場所で', '20分'],
        'title' => 'リーディング',
        'body' => '少し時間が取れる場所で、20分だけ集中します。長文を1つ選び、最後まで解いてから解説を読みます。途中で別の技能に切り替えないほうが、読解のリズムが残ります。',
        'steps' => [],
        'note' => '',
        'image' => '/assets/images/app-screen-reading.png',
        'image_class' => '',
        'width' => 1440,
        'height' => 900,
        'alt' => '準2級の長文穴埋め。解答と解説、本文の音読ボタンが表示されている画面',
        'caption' => '準2級の長文。解答のあと、解説と本文の音読が続きます。',
    ],
    [
        'id' => 'writing',
        'chips' => ['1日1問', '解いたら型'],
        'title' => 'ライティング',
        'body' => '一度解いたら、回答の型を自分の言葉で残します。導入・理由・結論など、その級で繰り返す並びを短くメモするだけで十分です。何度か解くうちに、型が自分の中にできあがります。',
        'steps' => [
            '1問書く',
            '添削の構成を見て、型を一言で残す',
            '次の1問で、その型を使って書く',
        ],
        'note' => '4級・5級の一次試験にライティングはありません。その時間は、リーディングかリスニングにもう1セット使います。',
        'image' => '/assets/images/app-screen-writing.png',
        'image_class' => '',
        'width' => 1440,
        'height' => 900,
        'alt' => '英検準1級の英作文問題。トピックと解答欄が表示されている画面',
        'caption' => '準1級の英作文。1問を書いて、型の材料にします。',
    ],
];

$day = [
    ['num' => '01', 'name' => '単語', 'time' => '10〜15分', 'place' => 'いちばん最初に'],
    ['num' => '02', 'name' => 'リスニング', 'time' => '約20分', 'place' => '静かな自宅で'],
    ['num' => '03', 'name' => 'リーディング', 'time' => '約20分', 'place' => '集中できるときに'],
    ['num' => '04', 'name' => 'ライティング', 'time' => '1問', 'place' => '解いたら型をつくる'],
];

include __DIR__ . '/includes/header.php';
?>
<article class="study-page border-b border-slate-100 bg-white" aria-labelledby="study-heading">
  <section class="guide-hero border-b border-slate-100 px-4 py-14 sm:py-20">
    <div class="mx-auto max-w-3xl text-center">
      <p class="section-badge section-badge--center" aria-hidden="true">ROAD</p>
      <h1 id="study-heading" class="mt-3 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">AiKenで英検合格の道</h1>
      <p class="mt-4 text-lg font-semibold leading-relaxed text-slate-900 sm:text-xl">次の英検まで、一日をこう回す</p>
      <p class="mt-4 text-base leading-relaxed text-slate-700"><?php echo br_after_period('使い方の次の一歩です。試験日から逆算して、一次試験の単語・リスニング・リーディング・ライティングを、無理のない時間に分けます。'); ?></p>
      <p class="mt-6">
        <a class="guide-cta-btn" href="<?php echo htmlspecialchars($signup_url); ?>"><?php echo lp_start_cta_inner('h-4 w-4'); ?></a>
      </p>
      <p class="mt-3 text-sm text-slate-500">カード登録不要・今日の単語から</p>
    </div>
  </section>

  <nav class="border-b border-slate-100 px-4 py-6" aria-label="ページ内ナビゲーション">
    <div class="mx-auto flex max-w-3xl flex-wrap justify-center gap-x-5 gap-y-2 text-sm font-medium text-slate-600">
      <?php foreach ($toc as $item): ?>
      <a class="hover:text-[#50c2cb] hover:underline" href="#study-<?php echo htmlspecialchars($item['id']); ?>"><?php echo htmlspecialchars($item['label']); ?></a>
      <?php endforeach; ?>
    </div>
  </nav>

  <div class="lp-container px-4 py-12 sm:py-16">
    <section id="study-when" class="guide-block" aria-labelledby="study-when-heading">
      <div class="mx-auto max-w-3xl">
        <h2 id="study-when-heading" class="guide-block__title">始めるなら、試験の3か月前</h2>
        <p class="guide-block__lead"><?php echo br_after_period('たとえば、次の第3回を目指すとき。第1回・第2回でも、試験日から数える考え方は同じです。'); ?></p>
      </div>
      <div class="study-when">
        <?php foreach ($windows as $window): ?>
        <article class="study-when__card<?php echo $window['best'] ? ' study-when__card--best' : ''; ?>">
          <p class="study-when__kicker"><?php echo htmlspecialchars($window['kicker']); ?></p>
          <h3 class="study-when__when"><?php echo htmlspecialchars($window['when']); ?></h3>
          <p class="study-when__tag"><?php echo htmlspecialchars($window['tag']); ?></p>
          <p class="study-when__body"><?php echo br_after_period(htmlspecialchars($window['body'])); ?></p>
        </article>
        <?php endforeach; ?>
      </div>
    </section>

    <section id="study-primary" class="guide-block" aria-labelledby="study-primary-heading">
      <div class="mx-auto max-w-3xl">
        <h2 id="study-primary-heading" class="guide-block__title">まずは一次試験</h2>
        <p class="guide-block__lead"><?php echo br_after_period('開いたら単語。静かな自宅ではリスニング。時間を取れるときにリーディング。ライティングは1日1問で、型を残します。'); ?></p>
        <p class="mt-3 text-sm leading-relaxed text-slate-500"><?php echo br_after_period('画面は級によって違います。ここに載せているのは、それぞれの技能の一例です。'); ?></p>
      </div>

      <div class="study-skills">
        <?php foreach ($skills as $i => $skill):
            $reverse = $i % 2 === 1;
            ?>
        <article id="study-<?php echo htmlspecialchars($skill['id']); ?>" class="study-skill<?php echo $reverse ? ' study-skill--reverse' : ''; ?>">
          <div>
            <p class="study-skill__meta">
              <?php foreach ($skill['chips'] as $chip): ?>
              <span class="study-skill__chip"><?php echo htmlspecialchars($chip); ?></span>
              <?php endforeach; ?>
            </p>
            <h3 class="study-skill__title"><?php echo htmlspecialchars($skill['title']); ?></h3>
            <p class="study-skill__body"><?php echo br_after_period(htmlspecialchars($skill['body'])); ?></p>
            <?php if ($skill['steps'] !== []): ?>
            <ol class="study-skill__steps">
              <?php foreach ($skill['steps'] as $n => $step): ?>
              <li><span><?php echo (int) $n + 1; ?>.</span><?php echo htmlspecialchars($step); ?></li>
              <?php endforeach; ?>
            </ol>
            <?php endif; ?>
            <?php if ($skill['note'] !== ''): ?>
            <p class="study-skill__note"><?php echo br_after_period(htmlspecialchars($skill['note'])); ?></p>
            <?php endif; ?>
          </div>
          <figure class="study-skill__figure study-shot">
            <?php echo lp_picture([
                'src' => $skill['image'],
                'alt' => $skill['alt'],
                'width' => $skill['width'],
                'height' => $skill['height'],
                'class' => 'study-shot__img' . $skill['image_class'],
                'loading' => 'lazy',
            ]); ?>
            <figcaption><?php echo htmlspecialchars($skill['caption']); ?></figcaption>
          </figure>
        </article>
        <?php endforeach; ?>
      </div>
    </section>

    <section id="study-day" class="guide-block" aria-labelledby="study-day-heading">
      <div class="mx-auto max-w-3xl">
        <h2 id="study-day-heading" class="guide-block__title">一日の流れ</h2>
        <p class="guide-block__lead"><?php echo br_after_period('軸は、開いた最初の単語です。リスニングは自宅、リーディングは集中できるとき、ライティングは1日1問。場所と時間が合う日に足していけば、一次試験の形がそろいます。'); ?></p>
      </div>
      <ol class="study-day">
        <?php foreach ($day as $item): ?>
        <li class="study-day__item">
          <p class="study-day__num" aria-hidden="true"><?php echo htmlspecialchars($item['num']); ?></p>
          <h3 class="study-day__name"><?php echo htmlspecialchars($item['name']); ?></h3>
          <p class="study-day__time"><?php echo htmlspecialchars($item['time']); ?></p>
          <p class="study-day__place"><?php echo htmlspecialchars($item['place']); ?></p>
        </li>
        <?php endforeach; ?>
      </ol>
      <p class="mx-auto mt-5 max-w-3xl text-sm leading-relaxed text-slate-600"><?php echo br_after_period('一次の形に慣れてきたら、面接のある級はスピーキングも。今日始める軸は、一次のこの4つです。級ごとの出題は英検対策から確認できます。'); ?></p>
      <p class="mx-auto mt-3 max-w-3xl text-sm">
        <a class="font-semibold text-[#50c2cb] underline-offset-2 hover:underline" href="/eiken/">英検対策を見る</a>
        ／
        <a class="font-semibold text-[#50c2cb] underline-offset-2 hover:underline" href="/guide">はじめての使い方</a>
      </p>
    </section>

    <section class="guide-closing" aria-labelledby="study-closing-heading">
      <h2 id="study-closing-heading" class="guide-closing__title">今日の最初の10分は、単語から</h2>
      <p class="guide-closing__lead"><?php echo br_after_period('会員登録のあと、単語を1セット。それが、合格までの道の入口です。'); ?></p>
      <p class="mt-6">
        <a class="guide-cta-btn" href="<?php echo htmlspecialchars($signup_url); ?>"><?php echo lp_start_cta_inner('h-4 w-4'); ?></a>
      </p>
      <p class="mt-6 text-sm text-slate-500">
        <a class="underline-offset-2 hover:underline" href="/guide">使い方ガイド</a>
        ／
        <a class="underline-offset-2 hover:underline" href="/plan">料金</a>
        ／
        <a class="underline-offset-2 hover:underline" href="/parents">保護者の方へ</a>
      </p>
    </section>
  </div>
</article>
<?php
include __DIR__ . '/includes/footer.php';
