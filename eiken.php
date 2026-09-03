<?php
/**
 * 英検対策コンテンツ（ハブ） /eiken/
 */
declare(strict_types=1);

$page = 'eiken';
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/eiken-hub-data.php';

$canonical = rtrim(SITE_URL, '/') . '/eiken/';
$toc = eiken_hub_toc();
$grades = eiken_hub_grades();
$themes = eiken_hub_theme_links();
$official = eiken_hub_official_urls();
$signup = rtrim(APP_URL, '/') . '/signup';
$featured = null;
foreach ($grades as $g) {
    if (!empty($g['featured'])) {
        $featured = $g;
        break;
    }
}

include __DIR__ . '/includes/header.php';
?>
<article class="eiken-hub" aria-labelledby="eiken-hub-heading">
  <section class="eiken-hub__hero border-b border-slate-100 bg-gradient-to-b from-[#e8f8f9] to-white px-4 py-14 sm:py-20">
    <div class="mx-auto max-w-3xl text-center">
      <p class="section-badge section-badge--center" aria-hidden="true">GUIDE</p>
      <h1 id="eiken-hub-heading" class="mt-3 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">英検対策コンテンツ</h1>
      <p class="mt-4 text-base leading-relaxed text-slate-700 sm:text-lg"><?php echo br_after_period('英検の試験日程や各級のレベル、出題内容、勉強法、教材、過去問など、英検対策に役立つ情報をまとめています。自分の級を確認してから、試験内容・勉強法・コラム記事へ進んでください。'); ?></p>
    </div>
  </section>

  <nav class="eiken-hub__toc" aria-label="ページ内ナビゲーション">
    <div class="lp-container px-4">
      <ul class="eiken-hub__toc-list">
        <?php foreach ($toc as $item): ?>
        <li><a href="#<?php echo htmlspecialchars($item['id']); ?>"><?php echo htmlspecialchars($item['label']); ?></a></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </nav>

  <section id="eiken-schedule" class="scroll-mt-28 border-b border-slate-100 px-4 py-14 sm:py-16" aria-labelledby="eiken-schedule-heading">
    <div class="mx-auto max-w-3xl">
      <h2 id="eiken-schedule-heading" class="text-2xl font-bold tracking-tight text-slate-900">英検の日程・試験情報</h2>
      <p class="mt-3 text-slate-600"><?php echo br_after_period('英検（従来型）は年間おおむね第1回・第2回・第3回の日程があります。英検S-CBTはコンピュータで受験する方式で、日程の選択肢が広いのが特徴です。申込期間・試験日・検定料・申込方法は年度や方式で変わるため、最新情報は公式サイトで確認してください。'); ?></p>

      <ul class="mt-6 grid gap-3 sm:grid-cols-2">
        <li class="rounded-xl border border-slate-200 bg-white p-5">
          <h3 class="font-semibold text-slate-900">2026年度の日程</h3>
          <p class="mt-2 text-sm text-slate-600"><?php echo br_after_period('個人申込の第1回〜第3回の受付・試験日は、年度ごとに公式で公開されます。'); ?></p>
          <p class="mt-3 text-sm"><a class="font-semibold text-[#50c2cb] underline-offset-2 hover:underline" href="<?php echo htmlspecialchars($official['schedule_2026']); ?>" rel="noopener noreferrer" target="_blank">2026年度の試験日程（英検公式）</a></p>
        </li>
        <li class="rounded-xl border border-slate-200 bg-white p-5">
          <h3 class="font-semibold text-slate-900">英検S-CBT</h3>
          <p class="mt-2 text-sm text-slate-600"><?php echo br_after_period('コンピュータで受験する方式です。会場・日程の空き状況は公式で確認できます。'); ?></p>
          <p class="mt-3 text-sm"><a class="font-semibold text-[#50c2cb] underline-offset-2 hover:underline" href="<?php echo htmlspecialchars($official['cbt']); ?>" rel="noopener noreferrer" target="_blank">英検S-CBTのご案内（公式）</a></p>
        </li>
        <li class="rounded-xl border border-slate-200 bg-white p-5">
          <h3 class="font-semibold text-slate-900">申込・検定料</h3>
          <p class="mt-2 text-sm text-slate-600"><?php echo br_after_period('申込方法・検定料は受験方式や級によって異なります。古い金額をそのまま覚えないよう、公式の案内を見てください。'); ?></p>
          <p class="mt-3 text-sm"><a class="font-semibold text-[#50c2cb] underline-offset-2 hover:underline" href="<?php echo htmlspecialchars($official['apply']); ?>" rel="noopener noreferrer" target="_blank">お申し込み案内（英検公式）</a></p>
        </li>
        <li class="rounded-xl border border-slate-200 bg-white p-5">
          <h3 class="font-semibold text-slate-900">日程まとめ記事</h3>
          <p class="mt-2 text-sm text-slate-600"><?php echo br_after_period('AiKenコラムでも、年度の日程の見方を解説しています。'); ?></p>
          <p class="mt-3 text-sm"><a class="font-semibold text-[#50c2cb] underline-offset-2 hover:underline" href="<?php echo htmlspecialchars(eiken_blog_url('eiken-2026-schedule')); ?>">【2026年度】英検の試験日程はいつ？</a></p>
        </li>
      </ul>

      <p class="eiken-hub__note mt-6 text-sm text-slate-500"><?php echo br_after_period('最新の日程・申込期間・検定料は変更されることがあります。必ず<a class="font-semibold text-[#50c2cb] underline-offset-2 hover:underline" href="' . htmlspecialchars($official['schedule']) . '" rel="noopener noreferrer" target="_blank">英検公式サイトの試験日程</a>をご確認ください。'); ?></p>
    </div>
  </section>

  <section id="eiken-levels" class="scroll-mt-28 border-b border-slate-100 bg-slate-50/50 px-4 py-14 sm:py-16" aria-labelledby="eiken-levels-heading">
    <div class="mx-auto max-w-3xl">
      <h2 id="eiken-levels-heading" class="text-2xl font-bold tracking-tight text-slate-900">英検の各級のレベル</h2>
      <p class="mt-3 text-slate-600"><?php echo br_after_period('各級の目安レベルです。詳細な表現は英検公式の最新案内もあわせて確認してください。級名をクリックすると、AiKenの級別対策ページへ移動します。'); ?></p>

      <div class="eiken-hub__table-wrap mt-6 overflow-x-auto rounded-xl border border-slate-200 bg-white">
        <table class="eiken-hub__table">
          <thead>
            <tr>
              <th scope="col">級</th>
              <th scope="col">レベルの目安</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($grades as $g): ?>
            <tr>
              <th scope="row"><a href="<?php echo htmlspecialchars($g['lp']); ?>"><?php echo htmlspecialchars($g['name']); ?></a></th>
              <td><?php echo htmlspecialchars($g['level']); ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <p class="mt-4 text-sm"><a class="font-semibold text-[#50c2cb] underline-offset-2 hover:underline" href="<?php echo htmlspecialchars(eiken_blog_url('eiken-grade-level-guide')); ?>">英検の級とレベル一覧｜5級～1級の違い</a></p>
    </div>
  </section>

  <section id="eiken-exam" class="scroll-mt-28 border-b border-slate-100 px-4 py-14 sm:py-16" aria-labelledby="eiken-exam-heading">
    <div class="mx-auto max-w-3xl">
      <h2 id="eiken-exam-heading" class="text-2xl font-bold tracking-tight text-slate-900">英検の試験内容</h2>
      <p class="mt-3 text-slate-600"><?php echo br_after_period('級によって一次の技能構成が異なります。4級・5級の一次にライティングはありません。下の一覧から、級ごとの対策記事や公式の過去問・試験内容ページへ進めます。'); ?></p>

      <?php if ($featured !== null): ?>
      <div class="mt-8 rounded-2xl border border-[#50c2cb]/35 bg-[#e8f8f9]/70 p-5 sm:p-6">
        <h3 class="text-lg font-bold text-slate-900">英検準2級プラスの対策</h3>
        <p class="mt-2 text-sm text-slate-600"><?php echo br_after_period('準2級と2級のあいだに位置する級です。身近な社会的な話題や要約など、準2級より一段進んだ力が求められます。'); ?></p>
        <ul class="mt-4 grid gap-2 sm:grid-cols-2">
          <?php foreach ($featured['articles'] as $a): ?>
          <li><a class="text-sm font-semibold text-[#50c2cb] underline-offset-2 hover:underline" href="<?php echo htmlspecialchars($a['url']); ?>"><?php echo htmlspecialchars($a['label']); ?></a></li>
          <?php endforeach; ?>
          <li><a class="text-sm font-semibold text-[#50c2cb] underline-offset-2 hover:underline" href="<?php echo htmlspecialchars($featured['lp']); ?>">英検準2級プラスの対策アプリページ</a></li>
          <li><a class="text-sm font-semibold text-[#50c2cb] underline-offset-2 hover:underline" href="<?php echo htmlspecialchars($featured['official_exam']); ?>" rel="noopener noreferrer" target="_blank">準2級プラスの過去問・試験内容（公式）</a></li>
        </ul>
      </div>
      <?php endif; ?>

      <div class="mt-8 space-y-6">
        <?php foreach ($grades as $g): ?>
        <div class="rounded-xl border border-slate-200 bg-white p-5">
          <h3 class="text-lg font-semibold text-slate-900"><?php echo htmlspecialchars($g['name']); ?></h3>
          <p class="mt-1 text-sm text-slate-500"><?php echo htmlspecialchars($g['level']); ?> ／ <?php echo htmlspecialchars(implode('・', $g['primary_skills'])); ?></p>
          <?php if (!empty($g['speaking_note'])): ?>
          <p class="mt-2 text-sm text-slate-600"><?php echo htmlspecialchars($g['speaking_note']); ?></p>
          <?php endif; ?>
          <ul class="mt-3 flex flex-wrap gap-x-4 gap-y-2">
            <li><a class="text-sm font-semibold text-[#50c2cb] underline-offset-2 hover:underline" href="<?php echo htmlspecialchars($g['lp']); ?>"><?php echo htmlspecialchars($g['name']); ?>のアプリ対策</a></li>
            <li><a class="text-sm font-semibold text-[#50c2cb] underline-offset-2 hover:underline" href="<?php echo htmlspecialchars($g['official_exam']); ?>" rel="noopener noreferrer" target="_blank"><?php echo htmlspecialchars($g['short']); ?>の過去問・試験内容（公式）</a></li>
            <?php foreach (array_slice($g['articles'], 0, 4) as $a): ?>
            <li><a class="text-sm font-semibold text-[#50c2cb] underline-offset-2 hover:underline" href="<?php echo htmlspecialchars($a['url']); ?>"><?php echo htmlspecialchars($a['label']); ?></a></li>
            <?php endforeach; ?>
          </ul>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <section id="eiken-study" class="scroll-mt-28 border-b border-slate-100 bg-slate-50/50 px-4 py-14 sm:py-16" aria-labelledby="eiken-study-heading">
    <div class="mx-auto max-w-3xl">
      <h2 id="eiken-study-heading" class="text-2xl font-bold tracking-tight text-slate-900">英検の勉強法</h2>
      <p class="mt-3 text-slate-600"><?php echo br_after_period('英検対策は、級を決めて形式を知り、単語から技能練習、過去問確認の順で進めると迷いが減ります。'); ?></p>
      <ol class="mt-6 space-y-4">
        <li class="rounded-xl border border-slate-200 bg-white px-5 py-4">
          <h3 class="font-semibold text-slate-900">1. 受験する級を決める</h3>
          <p class="mt-2 text-sm text-slate-600"><?php echo br_after_period('レベル一覧で目安を確認し、学校や入試の要件もあわせて決めます。'); ?></p>
          <p class="mt-2 text-sm"><a class="font-semibold text-[#50c2cb] underline-offset-2 hover:underline" href="<?php echo htmlspecialchars(eiken_blog_url('eiken-grade-level-guide')); ?>">英検の級とレベル一覧を見る</a></p>
        </li>
        <li class="rounded-xl border border-slate-200 bg-white px-5 py-4">
          <h3 class="font-semibold text-slate-900">2. 試験形式を確認する</h3>
          <p class="mt-2 text-sm text-slate-600"><?php echo br_after_period('大問構成や時間配分を把握し、何を優先するか決めます。'); ?></p>
          <p class="mt-2 text-sm"><a class="font-semibold text-[#50c2cb] underline-offset-2 hover:underline" href="<?php echo htmlspecialchars($official['exam']); ?>" rel="noopener noreferrer" target="_blank">級別の試験内容（英検公式）</a></p>
        </li>
        <li class="rounded-xl border border-slate-200 bg-white px-5 py-4">
          <h3 class="font-semibold text-slate-900">3. 単語・語彙を身につける</h3>
          <p class="mt-2 text-sm text-slate-600"><?php echo br_after_period('級に合った語彙を反復し、短文空所や読解の土台をつくります。'); ?></p>
          <p class="mt-2 text-sm"><a class="font-semibold text-[#50c2cb] underline-offset-2 hover:underline" href="#eiken-by-grade">級別の単語対策記事へ</a></p>
        </li>
        <li class="rounded-xl border border-slate-200 bg-white px-5 py-4">
          <h3 class="font-semibold text-slate-900">4. リーディング・リスニングを練習する</h3>
          <p class="mt-2 text-sm text-slate-600"><?php echo br_after_period('本番に近い形式で量をこなし、解説で弱点を潰します。'); ?></p>
        </li>
        <li class="rounded-xl border border-slate-200 bg-white px-5 py-4">
          <h3 class="font-semibold text-slate-900">5. ライティング・スピーキングを練習する</h3>
          <p class="mt-2 text-sm text-slate-600"><?php echo br_after_period('3級以上はライティングと面接対策が重要です。4級・5級は一次にライティングがありません。'); ?></p>
        </li>
        <li class="rounded-xl border border-slate-200 bg-white px-5 py-4">
          <h3 class="font-semibold text-slate-900">6. 過去問で実力を確認する</h3>
          <p class="mt-2 text-sm text-slate-600"><?php echo br_after_period('公式の過去問で時間配分と正答状況を確認します。'); ?></p>
          <p class="mt-2 text-sm"><a class="font-semibold text-[#50c2cb] underline-offset-2 hover:underline" href="#eiken-past">英検の過去問セクションへ</a></p>
        </li>
        <li class="rounded-xl border border-slate-200 bg-white px-5 py-4">
          <h3 class="font-semibold text-slate-900">7. 苦手分野を繰り返し練習する</h3>
          <p class="mt-2 text-sm text-slate-600"><?php echo br_after_period('間違えた問題を履歴から復習し、本番まで積み上げます。'); ?></p>
          <p class="mt-2 text-sm"><a class="font-semibold text-[#50c2cb] underline-offset-2 hover:underline" href="#eiken-aiken">AiKenでの反復練習について</a></p>
        </li>
      </ol>

      <?php foreach ($themes as $theme): ?>
      <h3 class="mt-10 text-lg font-semibold text-slate-900"><?php echo htmlspecialchars($theme['heading']); ?></h3>
      <ul class="mt-3 grid gap-2 sm:grid-cols-2">
        <?php foreach ($theme['links'] as $link): ?>
        <li><a class="text-sm font-semibold text-[#50c2cb] underline-offset-2 hover:underline" href="<?php echo htmlspecialchars($link['url']); ?>"><?php echo htmlspecialchars($link['label']); ?></a></li>
        <?php endforeach; ?>
      </ul>
      <?php endforeach; ?>
    </div>
  </section>

  <section id="eiken-materials" class="scroll-mt-28 border-b border-slate-100 px-4 py-14 sm:py-16" aria-labelledby="eiken-materials-heading">
    <div class="mx-auto max-w-3xl">
      <h2 id="eiken-materials-heading" class="text-2xl font-bold tracking-tight text-slate-900">英検対策におすすめの教材</h2>
      <p class="mt-3 text-slate-600"><?php echo br_after_period('教材は目的で使い分けると効率が上がります。どれか一つだけが正解、というわけではありません。'); ?></p>
      <div class="mt-6 grid gap-4 sm:grid-cols-2">
        <div class="rounded-xl border border-slate-200 bg-white p-5">
          <h3 class="font-semibold text-slate-900">英検公式過去問</h3>
          <p class="mt-2 text-sm text-slate-600"><?php echo br_after_period('本番の出題形式や難易度を確認するために活用します。'); ?></p>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-5">
          <h3 class="font-semibold text-slate-900">単語帳</h3>
          <p class="mt-2 text-sm text-slate-600"><?php echo br_after_period('級に必要な語彙を効率よく身につけるための基本教材です。'); ?></p>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-5">
          <h3 class="font-semibold text-slate-900">市販の参考書</h3>
          <p class="mt-2 text-sm text-slate-600"><?php echo br_after_period('試験形式や解き方を体系的に学ぶのに向いています。'); ?></p>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-5">
          <h3 class="font-semibold text-slate-900">英検対策アプリ</h3>
          <p class="mt-2 text-sm text-slate-600"><?php echo br_after_period('スキマ時間に本番形式の問題を繰り返し解くのに便利です。選択肢のひとつとしてAiKenもあります。'); ?></p>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-5 sm:col-span-2">
          <h3 class="font-semibold text-slate-900">英語4技能別の教材</h3>
          <p class="mt-2 text-sm text-slate-600"><?php echo br_after_period('苦手な技能だけを重点的に伸ばしたいときに組み合わせます。読解・リスニング・作文・面接など、弱点に合わせて選ぶとよいでしょう。'); ?></p>
        </div>
      </div>
    </div>
  </section>

  <section id="eiken-past" class="scroll-mt-28 border-b border-slate-100 bg-slate-50/50 px-4 py-14 sm:py-16" aria-labelledby="eiken-past-heading">
    <div class="mx-auto max-w-3xl">
      <h2 id="eiken-past-heading" class="text-2xl font-bold tracking-tight text-slate-900">英検の過去問</h2>
      <p class="mt-3 text-slate-600"><?php echo br_after_period('過去問は英検公式サイトで公開されています。AiKenは公式の過去問そのものを配布するサービスではありません。本番形式の確認には公式過去問を、日々の反復には問題演習アプリや参考書を組み合わせるのがおすすめです。'); ?></p>

      <ol class="mt-6 space-y-3 text-sm text-slate-700">
        <li class="flex gap-2"><span class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-[#50c2cb] text-xs font-bold text-white">1</span>過去問で本番の形式を確認する</li>
        <li class="flex gap-2"><span class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-[#50c2cb] text-xs font-bold text-white">2</span>自分の得意・苦手を把握する</li>
        <li class="flex gap-2"><span class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-[#50c2cb] text-xs font-bold text-white">3</span>苦手分野を練習する</li>
        <li class="flex gap-2"><span class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-[#50c2cb] text-xs font-bold text-white">4</span>再度問題を解いて定着を確認する</li>
      </ol>

      <p class="mt-6 text-sm"><a class="font-semibold text-[#50c2cb] underline-offset-2 hover:underline" href="<?php echo htmlspecialchars($official['exam']); ?>" rel="noopener noreferrer" target="_blank">過去問・試験内容トップ（英検公式）</a></p>
      <ul class="mt-3 grid gap-2 sm:grid-cols-2">
        <?php foreach ($grades as $g): ?>
        <li><a class="text-sm font-semibold text-[#50c2cb] underline-offset-2 hover:underline" href="<?php echo htmlspecialchars($g['official_exam']); ?>" rel="noopener noreferrer" target="_blank"><?php echo htmlspecialchars($g['name']); ?>の過去問・試験内容（公式）</a></li>
        <?php endforeach; ?>
      </ul>
      <p class="mt-6 text-sm text-slate-600"><?php echo br_after_period('過去問で形式をつかんだあとは、日々の反復練習に英検対策アプリを使うのも一つの方法です。'); ?> <a class="font-semibold text-[#50c2cb] underline-offset-2 hover:underline" href="#eiken-aiken">AiKenの紹介へ</a></p>
    </div>
  </section>

  <section id="eiken-by-grade" class="scroll-mt-28 border-b border-slate-100 px-4 py-14 sm:py-16" aria-labelledby="eiken-by-grade-heading">
    <div class="lp-container">
      <div class="mx-auto max-w-3xl text-center">
        <h2 id="eiken-by-grade-heading" class="text-2xl font-bold tracking-tight text-slate-900">級別の英検対策</h2>
        <p class="mt-3 text-slate-600"><?php echo br_after_period('級ごとのレベル・技能別コラムと、AiKenの級別ページへのリンクです。スピーキング専用のコラムがまだない級は、アプリの級別ページや公式の試験内容をご覧ください。'); ?></p>
      </div>

      <div class="mt-10 grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
        <?php foreach ($grades as $g): ?>
        <article class="flex flex-col rounded-2xl border border-slate-200 bg-white p-5 shadow-sm<?php echo !empty($g['featured']) ? ' ring-1 ring-[#50c2cb]/40' : ''; ?>">
          <h3 class="text-lg font-bold text-slate-900"><?php echo htmlspecialchars($g['name']); ?></h3>
          <p class="mt-1 text-sm text-slate-500"><?php echo htmlspecialchars($g['level']); ?></p>
          <p class="mt-3 text-xs font-semibold uppercase tracking-wide text-[#00a2af]">試験内容の目安</p>
          <p class="mt-1 text-sm text-slate-600"><?php echo htmlspecialchars(implode('・', $g['primary_skills'])); ?></p>
          <ul class="mt-4 flex-1 space-y-2">
            <?php foreach ($g['articles'] as $a): ?>
            <li><a class="text-sm font-semibold text-[#50c2cb] underline-offset-2 hover:underline" href="<?php echo htmlspecialchars($a['url']); ?>"><?php echo htmlspecialchars($a['label']); ?></a></li>
            <?php endforeach; ?>
          </ul>
          <p class="mt-5 border-t border-slate-100 pt-4 text-sm">
            <a class="font-semibold text-slate-800 underline-offset-2 hover:text-[#50c2cb] hover:underline" href="<?php echo htmlspecialchars($g['lp']); ?>"><?php echo htmlspecialchars($g['name']); ?>の対策アプリページ</a>
          </p>
        </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <section id="eiken-aiken" class="scroll-mt-28 bg-[#e8f8f9] px-4 py-14 sm:py-16" aria-labelledby="eiken-aiken-heading">
    <div class="mx-auto max-w-3xl">
      <h2 id="eiken-aiken-heading" class="text-2xl font-bold tracking-tight text-slate-900">英検対策をアプリで効率よく進めるならAiKen</h2>
      <p class="mt-3 text-slate-600"><?php echo br_after_period(SITE_NAME . 'は、英検5級〜1級（準級含む）を本試験に近い形式で学べる英検対策アプリです。教材や過去問とあわせて、スキマ時間の反復に使えます。'); ?></p>
      <ul class="mt-6 grid gap-3 sm:grid-cols-2">
        <li class="flex gap-2 rounded-xl border border-white bg-white/80 px-4 py-3 text-sm text-slate-700"><span class="shrink-0 text-[#50c2cb]"><?php echo lp_icon('check', 'w-5 h-5'); ?></span>5級〜1級に対応</li>
        <li class="flex gap-2 rounded-xl border border-white bg-white/80 px-4 py-3 text-sm text-slate-700"><span class="shrink-0 text-[#50c2cb]"><?php echo lp_icon('check', 'w-5 h-5'); ?></span>単語・リーディング・リスニング・ライティング・スピーキング</li>
        <li class="flex gap-2 rounded-xl border border-white bg-white/80 px-4 py-3 text-sm text-slate-700"><span class="shrink-0 text-[#50c2cb]"><?php echo lp_icon('check', 'w-5 h-5'); ?></span>本試験形式・10,000問超</li>
        <li class="flex gap-2 rounded-xl border border-white bg-white/80 px-4 py-3 text-sm text-slate-700"><span class="shrink-0 text-[#50c2cb]"><?php echo lp_icon('check', 'w-5 h-5'); ?></span>AIによるライティング添削</li>
        <li class="flex gap-2 rounded-xl border border-white bg-white/80 px-4 py-3 text-sm text-slate-700"><span class="shrink-0 text-[#50c2cb]"><?php echo lp_icon('check', 'w-5 h-5'); ?></span>AIスピーキング練習</li>
        <li class="flex gap-2 rounded-xl border border-white bg-white/80 px-4 py-3 text-sm text-slate-700"><span class="shrink-0 text-[#50c2cb]"><?php echo lp_icon('check', 'w-5 h-5'); ?></span>間違えた問題の復習・スマホ学習</li>
      </ul>
      <p class="mt-4 text-sm text-slate-600"><?php echo br_after_period(FREE_TRIAL_DAYS . '日間は全機能を無料でお試しいただけます（カード登録不要）。料金は' . monthly_price_label() . 'です。'); ?></p>
      <div class="mt-8 flex flex-col gap-3 sm:flex-row">
        <a class="inline-flex items-center justify-center rounded-full bg-[#50c2cb] px-8 py-3.5 text-sm font-semibold text-white transition hover:bg-[#46adb5]" href="<?php echo htmlspecialchars($signup); ?>"><?php echo FREE_TRIAL_DAYS; ?>日間無料で試す</a>
        <a class="inline-flex items-center justify-center rounded-full border border-slate-300 bg-white px-8 py-3.5 text-sm font-semibold text-slate-700 transition hover:border-[#50c2cb]/50" href="/about">AiKenとは</a>
        <a class="inline-flex items-center justify-center rounded-full border border-slate-300 bg-white px-8 py-3.5 text-sm font-semibold text-slate-700 transition hover:border-[#50c2cb]/50" href="/plan">料金を見る</a>
      </div>
      <p class="mt-6 text-sm text-slate-500"><a class="font-semibold text-[#50c2cb] underline-offset-2 hover:underline" href="/blog/">英検コラム一覧</a> ／ <a class="font-semibold text-[#50c2cb] underline-offset-2 hover:underline" href="/guide">使い方ガイド</a></p>
    </div>
  </section>
</article>
<?php include __DIR__ . '/includes/footer.php'; ?>
