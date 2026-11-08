<?php
/**
 * メディア向けサービス紹介（/media）
 * 本文はこの1ファイルに集約。料金の金額は書かず、料金ページへ誘導する。
 * 見た目のルール（幅・文字・色・角丸・余白）は style.css の「メディア向けページ」にまとめている。
 */
declare(strict_types=1);

$page = 'media';
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/app-screens.php';
require_once __DIR__ . '/includes/buddy-data.php';
$canonical = rtrim(SITE_URL, '/') . '/media';
$og_image = asset('/assets/images/intro-app-screen.jpg');

$trial_days = (int) FREE_TRIAL_DAYS;
$limited_from = $trial_days + 1;
$review_url = '/contact?subject=media';
$media_email = 'info@aiken.life';
$kit_file = __DIR__ . '/assets/media-kit/aiken-media-kit.zip';
$kit_url = '/assets/media-kit/aiken-media-kit.zip?v=' . (@filemtime($kit_file) ?: '1');
$kit_size = is_file($kit_file) ? number_format(filesize($kit_file) / 1048576, 1) . 'MB' : '';
$guide_file = __DIR__ . '/assets/media-kit/aiken-media-guide.pdf';
$guide_url = '/assets/media-kit/aiken-media-guide.pdf?v=' . (@filemtime($guide_file) ?: '1');
$guide_size = is_file($guide_file) ? number_format(filesize($guide_file) / 1048576, 1) . 'MB' : '';


function mp_e(string $s): string
{
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

$toc = [
    'overview' => '基本情報',
    'screens' => 'アプリ画面',
    'buddies' => 'バディ',
    'ai' => 'AI採点・添削',
    'plans' => 'プラン',
    'access' => '利用方法',
    'operator' => '運営者',
    'request' => '取材・レビューのご依頼',
    'download' => '素材ダウンロード',
];

$facts = [
    ['対応級', '英検5級・4級・3級・準2級・準2級プラス・2級・準1級・1級。級が変わっても、同じアカウントで続けられます。'],
    ['対応技能', 'リーディング・リスニング・ライティング・スピーキングの4技能と、単語。4級・5級は一次試験にライティングと面接がないため、単語・リーディング・リスニングが中心です。'],
    ['問題数', '10,000問以上。同じ形式の問題を繰り返し解けます。'],
    ['AI採点・添削', 'ライティングは語彙・文法・内容・構成・指示遵守の5観点（各0〜5点、総合はその平均）。スピーキングは各パート0〜3点の練習採点で、発音の個別スコアは出していません。'],
    ['二次試験対策', '3級から1級（準2級プラスを含む）の面接形式を、アプリ内で練習できます。'],
    ['学習履歴・間違い直し', '学習履歴が残り、間違えた問題をあとから復習できます。'],
];

$screens = [
    [
        'id' => 'screen-word',
        'screen' => 'vocabulary',
        'title' => '単語学習',
        'text' => '目標級の単語を4択で出題します。選んだ直後に正解・発音・例文が表示され、短い時間で反復できます。',
        'href' => '/jun2kyu-plus/vocabulary/',
        'href_label' => '準2級プラスの単語',
    ],
    [
        'id' => 'screen-reading',
        'screen' => 'reading',
        'title' => 'リーディング',
        'text' => '短文・会話文・長文の空所補充と、長文の内容一致を選んで練習できます。選んだ直後に正解と解説が出ます。',
        'href' => '/jun2kyu/reading/',
        'href_label' => '準2級のリーディング',
    ],
    [
        'id' => 'screen-listening',
        'screen' => 'listening',
        'title' => 'リスニング',
        'text' => '問題文を読んでから音声を聞き、選択肢を選びます。級ごとのパートで練習でき、放送回数も本番の形式に合わせています。',
        'href' => '/jun1kyu/listening/',
        'href_label' => '準1級のリスニング',
    ],
    [
        'id' => 'screen-writing',
        'screen' => 'tablet-writing',
        'title' => 'ライティング・AI添削',
        'text' => '級に合った英作文をアプリ内で書き、「AI添削に出す」から添削します。2級では80〜100語の目安が表示されます。',
        'href' => '/2kyu/writing/',
        'href_label' => '2級のライティング',
    ],
    [
        'id' => 'screen-speaking',
        'screen' => 'speaking',
        'title' => 'スピーキング・AI評価',
        'text' => 'パッセージ、イラスト、審査員の質問が1枚のカードに並びます。録音または文字入力で答えると、AIが評価します。',
        'href' => '/jun2kyu-plus/speaking/',
        'href_label' => '準2級プラスのスピーキング',
    ],
    [
        'id' => 'screen-history',
        'screen' => 'vocabulary-history',
        'title' => '学習履歴・間違い直し',
        'text' => '単語クイズの履歴が残ります。間違えた語は、次のクイズで優先して出題されます。',
        'href' => '/guide',
        'href_label' => '使い方ガイド',
    ],
];

$free_points = [
    '単語は5級〜1級、回数の制限なし',
    '4技能は登録から' . $trial_days . '日間、回数の制限なし',
    $limited_from . '日目以降は1日1セット（AI添削は1日1回）',
];
$premium_points = [
    '単語と4技能を、回数の上限なく',
    'AI採点・添削も、回数を気にせず',
    'どの級も同じ料金（級ごとの追加料金なし）',
];
$campaign = open_campaign_active();

include __DIR__ . '/includes/header.php';
?>
<article class="media-page">
  <section class="mp-section mp-section--hero" aria-labelledby="media-heading">
    <div class="mp-container">
      <div class="mp-hero">
        <div class="mp-head">
          <p class="section-badge" aria-hidden="true">MEDIA</p>
          <p class="mp-eyebrow">メディア向けサービス紹介</p>
          <h1 id="media-heading" class="mp-h1"><span>英検5級〜1級の対策を、</span><span>ひとつのアプリで。</span></h1>
          <p class="mp-lead mp-lead--lg">AiKen（アイケン）は、単語・リーディング・リスニング・ライティング・スピーキングをまとめて学習できる英検対策アプリです。ライティングとスピーキングはAIが採点・添削します。</p>
          <div class="mp-actions">
            <a class="mp-btn mp-btn--primary" href="<?php echo mp_e($review_url); ?>">レビュー用アカウントを依頼する</a>
            <a class="mp-btn mp-btn--ghost" href="#screens">アプリ画面を見る</a>
          </div>
        </div>
        <?php $hero_shot = app_screen('skills'); ?>
        <figure class="mp-shot mp-hero__visual">
          <img src="<?php echo mp_e($hero_shot['src']); ?>" alt="<?php echo mp_e($hero_shot['alt']); ?>" width="<?php echo (int) $hero_shot['width']; ?>" height="<?php echo (int) $hero_shot['height']; ?>" decoding="async" fetchpriority="high">
          <figcaption>ホームの学習メニュー。単語と4技能から選べます。</figcaption>
        </figure>
      </div>
      <nav aria-label="このページの内容">
        <ul class="mp-toc">
          <?php foreach ($toc as $id => $label): ?>
          <li><a href="#<?php echo mp_e($id); ?>"><?php echo mp_e($label); ?></a></li>
          <?php endforeach; ?>
        </ul>
      </nav>
    </div>
  </section>

  <section id="overview" class="mp-section" aria-labelledby="overview-heading">
    <div class="mp-container">
      <div class="mp-head">
        <p class="section-badge" aria-hidden="true">OVERVIEW</p>
        <h2 id="overview-heading" class="mp-h2">AiKenの基本情報</h2>
      </div>
      <dl class="mp-grid mp-grid--3 mp-content">
        <?php foreach ($facts as [$label, $text]): ?>
        <div class="mp-card mp-fact">
          <dt><?php echo mp_e($label); ?></dt>
          <dd><?php echo mp_e($text); ?></dd>
        </div>
        <?php endforeach; ?>
      </dl>
    </div>
  </section>

  <section id="screens" class="mp-section mp-section--tint" aria-labelledby="screens-heading">
    <div class="mp-container">
      <div class="mp-head">
        <p class="section-badge" aria-hidden="true">SCREENS</p>
        <h2 id="screens-heading" class="mp-h2">アプリ画面と主な機能</h2>
        <p class="mp-lead">スマートフォンとタブレットで表示した、実際の画面です。</p>
      </div>
      <ul class="mp-grid mp-grid--3 mp-content">
        <?php foreach ($screens as $screen): ?>
        <?php $shot = app_screen($screen['screen']); ?>
        <li id="<?php echo mp_e($screen['id']); ?>" class="mp-card mp-screen">
          <div class="mp-screen__frame">
            <img
              src="<?php echo mp_e($shot['src']); ?>"
              alt="<?php echo mp_e($shot['alt']); ?>"
              width="<?php echo (int) $shot['width']; ?>"
              height="<?php echo (int) $shot['height']; ?>"
              loading="lazy"
              decoding="async"
            >
          </div>
          <div class="mp-screen__body">
            <h3 class="mp-h3"><?php echo mp_e($screen['title']); ?></h3>
            <p class="mp-body"><?php echo mp_e($screen['text']); ?></p>
            <a class="mp-more" href="<?php echo mp_e($screen['href']); ?>"><?php echo mp_e($screen['href_label']); ?></a>
          </div>
        </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </section>

  <section id="buddies" class="mp-section" aria-labelledby="buddies-heading">
    <div class="mp-container mp-buddies">
      <div>
        <div class="mp-head">
          <p class="section-badge" aria-hidden="true">BUDDIES</p>
          <h2 id="buddies-heading" class="mp-h2">一緒に学ぶバディ</h2>
          <p class="mp-lead">プロフィールで、学習のそばにいる子を10匹から選べます。選んだ子は、ホームの学習メニューのそばにも現れます。</p>
        </div>
        <ul class="buddy-cast">
          <?php foreach (buddy_cast() as $buddy): ?>
          <li>
            <div class="buddy-cast__face">
              <img class="buddy-cast__img" src="/assets/images/buddies/<?php echo mp_e($buddy['slug']); ?>.png" alt="<?php echo mp_e('バディ「' . $buddy['name'] . '」'); ?>" width="160" height="160" loading="lazy" decoding="async">
            </div>
            <p class="buddy-cast__name"><?php echo mp_e($buddy['name']); ?></p>
          </li>
          <?php endforeach; ?>
        </ul>
        <div class="mp-content">
          <?php buddy_say('shiro', 'シロ', '気に入った子を、プロフィールで選べるよ。'); ?>
        </div>
      </div>
      <?php $profile = app_screen('profile'); ?>
      <figure class="mp-shot mp-phone">
        <img
          src="<?php echo mp_e($profile['src']); ?>"
          alt="<?php echo mp_e($profile['alt']); ?>"
          width="<?php echo (int) $profile['width']; ?>"
          height="<?php echo (int) $profile['height']; ?>"
          loading="lazy"
          decoding="async"
        >
        <figcaption><?php echo mp_e($profile['caption']); ?></figcaption>
      </figure>
    </div>
  </section>

  <section id="ai" class="mp-section mp-section--tint" aria-labelledby="ai-heading">
    <div class="mp-container">
      <div class="mp-head">
        <p class="section-badge" aria-hidden="true">AI</p>
        <h2 id="ai-heading" class="mp-h2">AI採点・添削の画面</h2>
        <p class="mp-lead">どちらもアプリの実際の画面です。点数は1つの答案の結果で、平均点や合格の目安ではありません。</p>
      </div>
      <div class="mp-ai mp-content">
        <div class="mp-card">
          <figure class="mp-shot">
            <img src="/assets/images/grade/2kyu/writing-3.webp" alt="AiKenの英検2級ライティング添削結果。総合点、語彙・文法・内容・構成・指示遵守、スコア分布、添削文" width="1024" height="1400" loading="lazy" decoding="async">
            <figcaption>英検2級のライティング添削結果です。総合点、5つの観点、スコア分布、添削文（赤字・太字が修正箇所）、音声再生が表示されます。</figcaption>
          </figure>
          <a class="mp-more" href="/2kyu/writing/">2級のライティング</a>
        </div>
        <div class="mp-card">
          <figure class="mp-shot">
            <img src="/assets/images/grade/3kyu/speaking-3.png" alt="AiKenの英検3級スピーキング画面。審査員の質問、録音開始、文字起こし欄、採点するボタン" width="1024" height="800" loading="lazy" decoding="async">
            <figcaption>英検3級のスピーキング画面です。質問に答えて録音し、文字起こしを確認してから「採点する」を押します。マイクを使わず、文字入力で採点することもできます。</figcaption>
          </figure>
          <a class="mp-more" href="/3kyu/speaking/">3級のスピーキング</a>
        </div>
      </div>
    </div>
  </section>

  <section id="plans" class="mp-section" aria-labelledby="plans-heading">
    <div class="mp-container">
      <div class="mp-head">
        <p class="section-badge" aria-hidden="true">PLANS</p>
        <h2 id="plans-heading" class="mp-h2">まず無料で、続けるならプレミアム</h2>
      </div>
      <div class="mp-grid mp-grid--2 mp-content">
        <div class="mp-card mp-plan">
          <h3 class="mp-h3">Freeプラン</h3>
          <p class="mp-plan__price">0円</p>
          <p class="mp-plan__sub">カード登録なしで始められます</p>
          <ul class="mp-plan__list">
            <?php foreach ($free_points as $point): ?>
            <li><?php echo mp_e($point); ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
        <div class="mp-card mp-plan mp-plan--premium">
          <div class="mp-plan__head">
            <h3 class="mp-h3">プレミアムプラン</h3>
            <?php if ($campaign): ?><span class="mp-plan__badge">OPEN記念価格</span><?php endif; ?>
          </div>
          <p class="mp-plan__price"><?php echo mp_e(monthly_price_label(false)); ?><small>（税込）</small></p>
          <?php if ($campaign): ?>
          <p class="mp-plan__sub"><strong><?php echo mp_e(open_campaign_keep_note()); ?></strong>です。翌月からの新規申し込みは、定価の<?php echo mp_e(monthly_price_regular_label(false)); ?>になる予定です。</p>
          <?php else: ?>
          <p class="mp-plan__sub">学習を始めてから、アプリ内で申し込めます</p>
          <?php endif; ?>
          <ul class="mp-plan__list">
            <?php foreach ($premium_points as $point): ?>
            <li><?php echo mp_e($point); ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
      <p class="mp-note">価格はすべて税込です。料金は変更になる場合があります。最新の料金は<a class="mp-link" href="/plan">料金ページ</a>をご覧ください。お支払いは、Web版がクレジットカード（Stripe）、アプリ版が各ストアのアプリ内課金です（<a class="mp-link" href="/tokushoho">特定商取引法に基づく表記</a>）。</p>
    </div>
  </section>

  <section id="access" class="mp-section mp-section--tint" aria-labelledby="access-heading">
    <div class="mp-container">
      <div class="mp-head">
        <p class="section-badge" aria-hidden="true">ACCESS</p>
        <h2 id="access-heading" class="mp-h2">利用方法</h2>
        <p class="mp-lead">Web版、iOSアプリ、Androidアプリは、同じアカウントで使えます。</p>
      </div>
      <div class="mp-grid mp-grid--3 mp-content">
        <div class="mp-card mp-access">
          <h3 class="mp-h3">Web版</h3>
          <p class="mp-body">パソコンやタブレットのブラウザから利用できます。</p>
          <a class="mp-more" href="<?php echo mp_e(APP_URL); ?>"><?php echo mp_e(preg_replace('#^https?://#', '', APP_URL)); ?> を開く</a>
        </div>
        <div class="mp-card mp-access">
          <h3 class="mp-h3">iOSアプリ</h3>
          <p class="mp-body">iPhone・iPadは App Store から入手できます。</p>
          <a class="mp-access__badge" href="<?php echo mp_e(APP_STORE_URL); ?>" target="_blank" rel="noopener noreferrer">
            <img src="/assets/images/badge-app-store.svg" alt="App Store からダウンロード" width="109" height="40">
          </a>
        </div>
        <div class="mp-card mp-access">
          <h3 class="mp-h3">Androidアプリ</h3>
          <p class="mp-body">Android は Google Play から入手できます。</p>
          <a class="mp-access__badge" href="<?php echo mp_e(PLAY_STORE_URL); ?>" target="_blank" rel="noopener noreferrer">
            <img src="/assets/images/badge-google-play.png" alt="Google Play で手に入れよう" width="135" height="40">
          </a>
        </div>
      </div>

      <div class="mp-subhead">
        <h3 class="mp-h3">ストア掲載画像</h3>
        <p class="mp-body">App Store と Google Play に掲載している紹介画像です。</p>
      </div>
      <ul class="mp-store">
        <?php foreach (app_screens('store') as $store_shot): ?>
        <li>
          <figure class="mp-shot">
            <img
              src="<?php echo mp_e($store_shot['src']); ?>"
              alt="<?php echo mp_e($store_shot['alt']); ?>"
              width="<?php echo (int) $store_shot['width']; ?>"
              height="<?php echo (int) $store_shot['height']; ?>"
              loading="lazy"
              decoding="async"
            >
            <figcaption><?php echo mp_e($store_shot['caption']); ?></figcaption>
          </figure>
        </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </section>

  <section id="operator" class="mp-section" aria-labelledby="operator-heading">
    <div class="mp-container">
      <div class="mp-head">
        <p class="section-badge" aria-hidden="true">OPERATOR</p>
        <h2 id="operator-heading" class="mp-h2">運営者</h2>
      </div>
      <div class="mp-grid mp-grid--2 mp-content">
        <div class="mp-table-wrap">
          <table class="mp-table mp-table--kv">
            <tbody>
              <tr>
                <th scope="row">サービス名</th>
                <td>AiKen（アイケン）</td>
              </tr>
              <tr>
                <th scope="row">運営</th>
                <td><a class="mp-link" href="<?php echo mp_e(BLUEPIECE_LAB_URL); ?>" rel="noopener noreferrer" target="_blank">Bluepiece Lab.</a></td>
              </tr>
              <tr>
                <th scope="row">事業者氏名</th>
                <td>森山卓</td>
              </tr>
              <tr>
                <th scope="row">メール</th>
                <td><a class="mp-link" href="mailto:<?php echo mp_e($media_email); ?>"><?php echo mp_e($media_email); ?></a></td>
              </tr>
              <tr>
                <th scope="row">開発記</th>
                <td><a class="mp-link" href="https://note.com/wu_moriyama/m/mc163c29fa30b" rel="noopener noreferrer" target="_blank">noteマガジン</a></td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="mp-card">
          <h3 class="mp-h3">開発者の声</h3>
          <blockquote class="mp-quote">
            <p>「自分で作ったアプリで、本当に英検に合格できるのか？」——それが気になって、思い切って第1回を受けてみました。空き時間にサッと開けるので、電車の中や夜の布団の中、会社の昼休みにもよく使っていました。初めての英検でしたが、似た形式の問題を何度も解いているうちに「いけるかも」と思えて、それが自信につながったと思います。次は準2級プラスに挑戦します！</p>
            <cite>開発者M（2026年第1回 英検準2級）</cite>
          </blockquote>
        </div>
      </div>
      <a class="mp-more" href="/company">運営者情報</a>
    </div>
  </section>

  <section id="request" class="mp-section mp-section--tint" aria-labelledby="request-heading">
    <div class="mp-container">
      <div class="mp-request">
        <p class="section-badge" aria-hidden="true">PRESS</p>
        <h2 id="request-heading" class="mp-h2">取材・レビューのご依頼</h2>
        <p class="mp-lead">機能や学習体験を実際にお試しいただけるよう、レビュー用アカウントをご用意しています。媒体名、掲載予定、希望時期を添えてお問い合わせください。アカウント情報は個別にご案内します。</p>
        <div class="mp-actions">
          <a class="mp-btn mp-btn--primary" href="<?php echo mp_e($review_url); ?>">レビュー用アカウントを依頼する</a>
          <a class="mp-btn mp-btn--ghost" href="/contact">その他のお問い合わせ</a>
        </div>
        <p class="mp-note">メールでも受け付けています：<a class="mp-link" href="mailto:<?php echo mp_e($media_email); ?>"><?php echo mp_e($media_email); ?></a></p>
      </div>

      <div id="download" class="mp-card mp-download">
        <div>
          <h3 class="mp-h3">素材ダウンロード</h3>
          <p class="mp-body">ロゴ、アプリ画面（スマートフォン・タブレット）、ストア掲載画像、AI添削の画面、バディ10匹の画像をまとめたZIPです。ご紹介資料はPDFで別にご覧いただけます。画面に写っている名前や学習記録はサンプルです。</p>
        </div>
        <div class="mp-download__actions">
          <a class="mp-btn mp-btn--primary" href="<?php echo mp_e($kit_url); ?>" download>素材ZIP<?php echo $kit_size !== '' ? '（' . mp_e($kit_size) . '）' : ''; ?></a>
          <?php if ($guide_size !== ''): ?>
          <a class="mp-btn mp-btn--ghost" href="<?php echo mp_e($guide_url); ?>" target="_blank" rel="noopener">ご紹介資料PDF（<?php echo mp_e($guide_size); ?>）</a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </section>
</article>
<?php
include __DIR__ . '/includes/footer.php';
