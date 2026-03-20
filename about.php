<?php
/**
 * AiKen とは（本文はこの1ファイルに集約／FTPでも include 漏れしにくい）
 */
$page = 'about';
require_once __DIR__ . '/config.php';
$canonical = rtrim(SITE_URL, '/') . '/about';

include __DIR__ . '/includes/header.php';
?>
<section class="border-b border-slate-100 bg-gradient-to-b from-[#e8f8f9] to-white px-4 py-14 sm:py-20" aria-labelledby="about-lead-heading">
  <div class="mx-auto max-w-3xl text-center">
    <p class="text-sm font-semibold tracking-wide text-[#3d9aa3]">はじめての方へ</p>
    <h1 id="about-lead-heading" class="mt-3 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">AiKen（アイケン）とは</h1>
    <p class="mt-4 text-lg font-medium text-slate-800">英検対策 × AI × バディ（愛犬）— 合格まで、ひとつのアプリにまとめました。</p>
    <p class="mt-5 text-left text-slate-600 sm:text-center"><?php echo br_after_period('<strong>AiKen</strong>は、英検<strong>1級から5級まで全級</strong>の出題形式に沿って、<strong>AIが練習問題を出題</strong>する英検対策アプリです。リーディング・リスニング・ライティング・スピーキングの<strong>4技能</strong>をアプリ内で鍛え、学習履歴も残るので<strong>間違えた問題の復習</strong>がかんたん。そして<strong>バディ</strong>がそばで励まし、続けやすい環境をつくります。'); ?></p>
    <div class="mt-10 flex flex-col gap-3 sm:flex-row sm:justify-center">
      <a class="inline-flex items-center justify-center rounded-full bg-[#50c2cb] px-10 py-4 text-lg font-semibold text-white shadow-lg shadow-[#50c2cb]/25 transition hover:bg-[#46adb5] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#50c2cb]/60 focus-visible:ring-offset-2" href="<?php echo APP_URL; ?>/signup">無料で会員登録する</a>
      <a class="inline-flex items-center justify-center rounded-full border-2 border-slate-300 bg-white px-10 py-4 text-lg font-semibold text-slate-800 transition hover:border-slate-400 hover:bg-slate-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-slate-300 focus-visible:ring-offset-2" href="<?php echo APP_URL; ?>/login">ログイン</a>
    </div>
    <p class="mt-6 text-sm text-slate-500"><a class="font-medium text-[#50c2cb] underline-offset-2 hover:underline" href="<?php echo rtrim(SITE_URL, '/') . '/'; ?>">トップページ</a>で級別の特徴も見る</p>
  </div>
</section>

<section class="border-b border-slate-100 bg-white px-4 py-14 sm:py-20" aria-labelledby="about-empathy-heading">
  <div class="mx-auto max-w-3xl">
    <h2 id="about-empathy-heading" class="text-center text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">英検、こんなことで止まっていませんか？</h2>
    <ul class="mt-8 space-y-4 text-slate-700">
      <li class="flex gap-3 rounded-xl border border-slate-200 bg-slate-50/80 px-4 py-3 sm:px-5">
        <span class="shrink-0 text-lg" aria-hidden="true">📚</span>
        <span><?php echo br_after_period('教材やアプリが<strong>バラバラ</strong>で、単語は別・リスニングは別…と時間がもったいない。'); ?></span>
      </li>
      <li class="flex gap-3 rounded-xl border border-slate-200 bg-slate-50/80 px-4 py-3 sm:px-5">
        <span class="shrink-0 text-lg" aria-hidden="true">✏️</span>
        <span><?php echo br_after_period('<strong>ライティングやスピーキング</strong>は、自分で直したくても添削や練習相手がいない。'); ?></span>
      </li>
      <li class="flex gap-3 rounded-xl border border-slate-200 bg-slate-50/80 px-4 py-3 sm:px-5">
        <span class="shrink-0 text-lg" aria-hidden="true">🎯</span>
        <span><?php echo br_after_period('「今日は何をする？」が決まらず、<strong>続かない・計画が立てられない</strong>。'); ?></span>
      </li>
    </ul>
    <p class="mt-10 rounded-2xl border border-[#50c2cb]/30 bg-[#50c2cb]/5 px-5 py-5 text-center text-slate-800 sm:px-8"><?php echo br_after_period('AiKen は、その<strong>「散らばり」「添削」「継続」</strong>をアプリひとつにまとめます。<strong>級に合った問題</strong>を AI が出し、履歴で復習まで回せるので、<strong>初めて英検に取り組む方</strong>でも「次にやること」がはっきりします。'); ?></p>
    <div class="mt-8 text-center">
      <a class="inline-flex items-center justify-center rounded-full bg-[#50c2cb] px-8 py-3 text-sm font-semibold text-white transition hover:bg-[#46adb5]" href="<?php echo APP_URL; ?>/signup">まずは無料で試す</a>
    </div>
  </div>
</section>

<section class="border-b border-slate-100 bg-slate-50/50 px-4 py-14 sm:py-20" aria-labelledby="about-value-heading">
  <div class="mx-auto max-w-5xl">
    <h2 id="about-value-heading" class="text-center text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">アプリで得られること（ベネフィット）</h2>
    <p class="mt-3 text-center text-slate-600"><?php echo br_after_period('英検対策で押さえたい<strong>全級・4技能・AI・履歴・バディ</strong>を、はじめての方にも分かりやすくまとめました。'); ?></p>
    <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
      <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <span class="text-2xl" aria-hidden="true">🎓</span>
        <h3 class="mt-3 font-semibold text-slate-900">英検全級に対応</h3>
        <p class="mt-2 text-sm leading-relaxed text-slate-600"><?php echo br_after_period('<strong>1級・準1級・2級・準2級・3級・4級・5級</strong>の出題内容に沿った対策ができます。級が変わっても<strong>アプリはそのまま</strong>。'); ?></p>
      </article>
      <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <span class="text-2xl" aria-hidden="true">🤖</span>
        <h3 class="mt-3 font-semibold text-slate-900">AI が級に合わせて出題</h3>
        <p class="mt-2 text-sm leading-relaxed text-slate-600"><?php echo br_after_period('形式やレベルに合わせた<strong>練習問題</strong>で、効率よく弱点に触れられます。「何を解けばいいか」に迷いにくくなります。'); ?></p>
      </article>
      <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <span class="text-2xl" aria-hidden="true">📖</span>
        <h3 class="mt-3 font-semibold text-slate-900">4 技能をアプリ内で完結</h3>
        <p class="mt-2 text-sm leading-relaxed text-slate-600"><?php echo br_after_period('<strong>リーディング・リスニング・ライティング・スピーキング</strong>をひとつの流れで。英検対策に必要な軸を<strong>オールインワン</strong>でカバーします。'); ?></p>
      </article>
      <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <span class="text-2xl" aria-hidden="true">📝</span>
        <h3 class="mt-3 font-semibold text-slate-900">学習履歴で復習しやすい</h3>
        <p class="mt-2 text-sm leading-relaxed text-slate-600"><?php echo br_after_period('学んだ内容は<strong>アプリに蓄積</strong>。間違えた問題に戻りやすく、<strong>「忘れてから拾い直す」負担</strong>を減らします。'); ?></p>
      </article>
      <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <span class="text-2xl" aria-hidden="true">🐕</span>
        <h3 class="mt-3 font-semibold text-slate-900">バディが寄り添う</h3>
        <p class="mt-2 text-sm leading-relaxed text-slate-600"><?php echo br_after_period('愛犬のようにそばにいる<strong>バディ</strong>が、励ましと継続の後押しを。ひとりで続ける英検勉強を、<strong>少し明るく</strong>します。'); ?></p>
      </article>
      <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <span class="text-2xl" aria-hidden="true">📱</span>
        <h3 class="mt-3 font-semibold text-slate-900">ブラウザですぐはじめられる</h3>
        <p class="mt-2 text-sm leading-relaxed text-slate-600"><?php echo br_after_period('スマートフォン・タブレット・PC から利用可能。<strong>会員登録後</strong>、すぐに練習をスタートできます。'); ?></p>
      </article>
    </div>
  </div>
</section>

<section class="border-b border-slate-100 bg-white px-4 py-14 sm:py-20" aria-labelledby="about-for-whom-heading">
  <div class="mx-auto max-w-5xl">
    <h2 id="about-for-whom-heading" class="text-center text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">こんな方におすすめ</h2>
    <p class="mt-3 text-center text-slate-600"><?php echo br_after_period('学習段階の目安として、よくいらっしゃるパターンを挙げています。'); ?></p>
    <div class="mt-10 grid gap-6 md:grid-cols-3">
      <div class="rounded-2xl border-l-4 border border-slate-200 border-l-[#F99F66] bg-slate-50/50 p-6 shadow-sm">
        <h3 class="font-semibold text-slate-900">小学生・中学生のお子さまと保護者の方</h3>
        <p class="mt-3 text-sm leading-relaxed text-slate-600"><?php echo br_after_period('<strong>5級〜3級</strong>あたりから英検をはじめたい。<strong>何から手を付けるか</strong>をアプリ側で整理し、続けやすい形にまとめています。'); ?></p>
      </div>
      <div class="rounded-2xl border-l-4 border border-slate-200 border-l-[#A6D472] bg-slate-50/50 p-6 shadow-sm">
        <h3 class="font-semibold text-slate-900">高校生と保護者の方</h3>
        <p class="mt-3 text-sm leading-relaxed text-slate-600"><?php echo br_after_period('<strong>準2級〜準1級</strong>など、受験や評定に向けた英検対策。<strong>4技能と単語</strong>をまとめて扱えるので、教材の切り替えコストを減らせます。'); ?></p>
      </div>
      <div class="rounded-2xl border-l-4 border border-slate-200 border-l-[#50c2cb] bg-slate-50/50 p-6 shadow-sm">
        <h3 class="font-semibold text-slate-900">社会人・上位級を目指す方</h3>
        <p class="mt-3 text-sm leading-relaxed text-slate-600"><?php echo br_after_period('<strong>2級・準1級・1級</strong>など、仕事の合間に英検を伸ばしたい。<strong>ライティングのAI添削</strong>やスピーキング練習など、独学で空きがちなパートを補います。'); ?></p>
      </div>
    </div>
    <p class="mt-8 text-center text-sm text-slate-500"><?php echo br_after_period('保護者の方には「<strong>何のアプリか</strong>」「<strong>英検のどこまでカバーするか</strong>」が伝わるよう、上記の軸で設計しています。'); ?></p>
  </div>
</section>

<section class="bg-gradient-to-b from-white to-slate-50 px-4 py-14 sm:py-20" aria-labelledby="about-steps-heading">
  <div class="mx-auto max-w-3xl text-center">
    <h2 id="about-steps-heading" class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">会員登録から、今日の練習まで</h2>
    <p class="mt-3 text-slate-600"><?php echo br_after_period('手順はシンプルです。<strong>まず登録</strong>して、アプリの中で級とメニューを選べばOK。'); ?></p>
    <ol class="mt-10 space-y-6 text-left">
      <li class="flex gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#50c2cb] text-lg font-bold text-white">1</span>
        <div>
          <h3 class="font-semibold text-slate-900">無料で会員登録</h3>
          <p class="mt-1 text-sm text-slate-600"><?php echo br_after_period('メール等でアカウントを作成し、<strong>アプリ（app.aiken.life）</strong>にログインします。'); ?></p>
        </div>
      </li>
      <li class="flex gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#50c2cb] text-lg font-bold text-white">2</span>
        <div>
          <h3 class="font-semibold text-slate-900">級と今日やるメニューを選ぶ</h3>
          <p class="mt-1 text-sm text-slate-600"><?php echo br_after_period('目標の級に合わせて、単語・リーディング・ライティングなど<strong>やりたい技能</strong>からスタート。'); ?></p>
        </div>
      </li>
      <li class="flex gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#50c2cb] text-lg font-bold text-white">3</span>
        <div>
          <h3 class="font-semibold text-slate-900">AI・履歴・バディで続ける</h3>
          <p class="mt-1 text-sm text-slate-600"><?php echo br_after_period('フィードバックと履歴を見ながら<strong>復習</strong>。バディと一緒に、合格まで積み上げましょう。'); ?></p>
        </div>
      </li>
    </ol>
    <div class="mt-12 flex flex-col gap-3 sm:flex-row sm:justify-center">
      <a class="inline-flex items-center justify-center rounded-full bg-[#50c2cb] px-10 py-4 text-lg font-semibold text-white shadow-lg shadow-[#50c2cb]/25 transition hover:bg-[#46adb5]" href="<?php echo APP_URL; ?>/signup">会員登録へ進む</a>
      <a class="inline-flex items-center justify-center rounded-full border-2 border-slate-300 bg-white px-8 py-4 text-base font-semibold text-slate-800 transition hover:bg-slate-50" href="<?php echo rtrim(SITE_URL, '/') . '/plan'; ?>">料金・プランを見る</a>
    </div>
    <p class="mt-6 text-xs text-slate-500"><?php echo br_after_period('料金やキャンペーンの詳細は<strong>料金ページ</strong>の内容が優先されます（リリース時期に合わせて更新してください）。'); ?></p>
  </div>
</section>
<?php
include __DIR__ . '/includes/sections/cta.php';
include __DIR__ . '/includes/footer.php';
