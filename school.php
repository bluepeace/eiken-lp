<?php
/**
 * 学校向け導入相談（/school）
 * 個人向け contact.php とは別フォーム。送信先は CONTACT_EMAIL。
 */
declare(strict_types=1);

$page = 'school';
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/contact-guard.php';
require_once __DIR__ . '/includes/inquiry-mail.php';

$canonical = rtrim(SITE_URL, '/') . '/school';
$og_image = asset('/assets/images/app/tablet/vocabulary.jpg');

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function school_e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

$errors = [];
$success = false;
$form = [
    'school' => '',
    'name' => '',
    'role' => '',
    'email' => '',
    'headcount' => '',
    'timing' => '',
    'message' => '',
];

if (($_SESSION['school_flash'] ?? '') === 'sent') {
    $success = true;
    unset($_SESSION['school_flash']);
}

$mailFrom = inquiry_encode_address(CONTACT_FROM_NAME, inquiry_mail_from_email());

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form['school'] = inquiry_single_line((string) ($_POST['school'] ?? ''));
    $form['name'] = inquiry_single_line((string) ($_POST['name'] ?? ''));
    $form['role'] = inquiry_single_line((string) ($_POST['role'] ?? ''));
    $form['email'] = inquiry_single_line((string) ($_POST['email'] ?? ''));
    $form['headcount'] = inquiry_single_line((string) ($_POST['headcount'] ?? ''));
    $form['timing'] = inquiry_single_line((string) ($_POST['timing'] ?? ''));
    $form['message'] = trim((string) ($_POST['message'] ?? ''));
    $privacy = (string) ($_POST['privacy'] ?? '');
    $honeypot = trim((string) ($_POST['website'] ?? ''));
    $token = (string) ($_POST['csrf'] ?? '');
    $clientIp = contact_client_ip();
    $userAgent = contact_user_agent();

    if ($honeypot !== '') {
        $_SESSION['school_flash'] = 'sent';
        header('Location: /school#school-contact');
        exit;
    }

    $sessionToken = (string) ($_SESSION['school_csrf'] ?? '');
    if ($sessionToken === '' || !hash_equals($sessionToken, $token)) {
        $errors[] = 'セッションの有効期限が切れたか、不正な送信です。ページを再読み込みしてから再度お試しください。';
    }

    $shownAt = (int) ($_SESSION['school_shown_at'] ?? 0);
    if ($shownAt === 0 || (time() - $shownAt) < 3) {
        $errors[] = '送信を確認できませんでした。ページを開いてから、もう一度お試しください。';
    }

    $lastSent = (int) ($_SESSION['school_last_sent'] ?? 0);
    if ($lastSent > 0 && (time() - $lastSent) < 60) {
        $errors[] = '連続送信を防ぐため、少し時間をおいてから再度お送りください。';
    }

    if ($form['school'] === '' || mb_strlen($form['school']) > 80) {
        $errors[] = '学校名を80文字以内で入力してください。';
    }
    if ($form['name'] === '' || mb_strlen($form['name']) > 80) {
        $errors[] = '担当者名を80文字以内で入力してください。';
    }
    if (mb_strlen($form['role']) > 80) {
        $errors[] = '役職は80文字以内で入力してください。';
    }
    if ($form['email'] === '' || !filter_var($form['email'], FILTER_VALIDATE_EMAIL) || mb_strlen($form['email']) > 200) {
        $errors[] = '有効なメールアドレスを入力してください。';
    }
    if (mb_strlen($form['headcount']) > 40) {
        $errors[] = '想定利用人数は40文字以内で入力してください。';
    }
    if (mb_strlen($form['timing']) > 40) {
        $errors[] = '導入希望時期は40文字以内で入力してください。';
    }
    if ($form['message'] === '' || mb_strlen($form['message']) < 10) {
        $errors[] = '相談内容は10文字以上で入力してください。';
    }
    if (mb_strlen($form['message']) > 4000) {
        $errors[] = '相談内容は4000文字以内で入力してください。';
    }
    if ($privacy !== '1') {
        $errors[] = '個人情報の取り扱いへの同意が必要です。';
    }

    if ($errors === []) {
        if (!contact_has_kana($form['message'])) {
            $errors[] = '相談内容は日本語でご記入ください。';
        } elseif (contact_rate_exceeded($clientIp, $form['email'])) {
            $errors[] = '連続送信を防ぐため、少し時間をおいてから再度お送りください。';
        }
    }

    if ($errors === []) {
        $now = date('Y-m-d H:i:s');
        $roleLine = $form['role'] !== '' ? $form['role'] : '（未入力）';
        $headcountLine = $form['headcount'] !== '' ? $form['headcount'] : '（未入力）';
        $timingLine = $form['timing'] !== '' ? $form['timing'] : '（未入力）';
        $ipLine = $clientIp !== '' ? $clientIp : '-';
        $uaLine = $userAgent !== '' ? $userAgent : '-';
        $adminSubject = '【AiKen学校向け導入相談】' . $form['school'];
        $adminBody = "AiKen 学校向け導入相談フォームより送信がありました。\n"
            . "この送信は相談の受付であり、契約や利用開始の確定ではありません。\n\n"
            . "日時: {$now}\n"
            . "学校名: {$form['school']}\n"
            . "担当者名: {$form['name']}\n"
            . "役職: {$roleLine}\n"
            . "メール: {$form['email']}\n"
            . "想定利用人数: {$headcountLine}\n"
            . "導入希望時期: {$timingLine}\n"
            . "個人情報の取り扱い: 同意済み\n"
            . "IP: {$ipLine}\n"
            . "UA: {$uaLine}\n\n"
            . "---- 相談内容 ----\n"
            . $form['message'] . "\n";

        $adminOk = inquiry_send_mail(
            CONTACT_EMAIL,
            $adminSubject,
            $adminBody,
            [
                'From' => $mailFrom,
                'Reply-To' => $form['email'],
                'X-Mailer' => 'AiKen-LP-School',
            ]
        );

        $autoSubject = '【AiKen】学校向け導入相談を受け付けました';
        $autoBody = $form['name'] . " 様\n\n"
            . "学校向けの導入相談を受け付けました。\n"
            . "内容を確認し、必要に応じてご連絡します。\n"
            . "このメールは受付の確認です。契約や利用開始が確定したお知らせではありません。\n\n"
            . "---- 受付内容 ----\n"
            . "学校名: {$form['school']}\n"
            . "担当者名: {$form['name']}\n"
            . "役職: {$roleLine}\n"
            . "想定利用人数: {$headcountLine}\n"
            . "導入希望時期: {$timingLine}\n"
            . "相談内容:\n"
            . $form['message'] . "\n"
            . "--------------------\n\n"
            . "※このメールは自動送信です。返信いただいても内容を確認できない場合があります。\n"
            . "追加のご連絡は " . CONTACT_EMAIL . " までお願いいたします。\n\n"
            . "AiKen（アイケン）\n"
            . SITE_URL . "/school\n";

        $autoOk = inquiry_send_mail(
            $form['email'],
            $autoSubject,
            $autoBody,
            [
                'From' => $mailFrom,
                'Reply-To' => CONTACT_EMAIL,
                'X-Mailer' => 'AiKen-LP-School',
            ]
        );

        if ($adminOk) {
            $_SESSION['school_last_sent'] = time();
            contact_rate_record($clientIp, $form['email']);
            $_SESSION['school_flash'] = 'sent';
            header('Location: /school#school-contact');
            exit;
        }

        $errors[] = '送信に失敗しました。時間をおいて再度お試しいただくか、' . CONTACT_EMAIL . ' まで直接メールをお送りください。';
        unset($autoOk);
    }
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['school_shown_at'] = time();
}

$_SESSION['school_csrf'] = bin2hex(random_bytes(16));
$csrf = $_SESSION['school_csrf'];

$shot = static function (string $path, string $alt, int $width, int $height, string $class): string {
    $src = lp_versioned_asset($path);
    return '<img src="' . school_e($src) . '" alt="' . school_e($alt) . '" width="' . $width . '" height="' . $height . '" class="' . school_e($class) . '" loading="lazy" decoding="async">';
};

/** 学校のイメージ写真（WebP＋JPG）。$name は assets/images/school/ のファイル名（拡張子なし） */
$photo = static function (string $name, string $alt, string $class = ''): string {
    $base = '/assets/images/school/' . $name;
    return '<picture class="school-photo' . ($class !== '' ? ' ' . school_e($class) : '') . '">'
        . '<source type="image/webp" srcset="' . school_e(lp_versioned_asset($base . '.webp')) . '">'
        . '<img src="' . school_e(lp_versioned_asset($base . '.jpg')) . '" alt="' . school_e($alt) . '" width="900" height="600" loading="lazy" decoding="async">'
        . '</picture>';
};

$gradeRows = [
    ['slug' => '5kyu', 'word' => true, 'grammar' => true, 'reading' => true, 'listening' => true, 'writing' => false, 'speaking' => false],
    ['slug' => '4kyu', 'word' => true, 'grammar' => true, 'reading' => true, 'listening' => true, 'writing' => false, 'speaking' => false],
    ['slug' => '3kyu', 'word' => true, 'grammar' => true, 'reading' => true, 'listening' => true, 'writing' => true, 'speaking' => true],
    ['slug' => 'jun2kyu', 'word' => true, 'grammar' => true, 'reading' => true, 'listening' => true, 'writing' => true, 'speaking' => true],
    ['slug' => 'jun2kyu-plus', 'word' => true, 'grammar' => true, 'reading' => true, 'listening' => true, 'writing' => true, 'speaking' => true],
    ['slug' => '2kyu', 'word' => true, 'grammar' => true, 'reading' => true, 'listening' => true, 'writing' => true, 'speaking' => true],
    ['slug' => 'jun1kyu', 'word' => true, 'grammar' => false, 'reading' => true, 'listening' => true, 'writing' => true, 'speaking' => true],
    ['slug' => '1kyu', 'word' => true, 'grammar' => false, 'reading' => true, 'listening' => true, 'writing' => true, 'speaking' => true],
];
$skillKeys = [
    'word' => '単語',
    'grammar' => '文法',
    'reading' => 'リーディング',
    'listening' => 'リスニング',
    'writing' => 'ライティング',
    'speaking' => 'スピーキング',
];

$inputClass = 'school-field';

include __DIR__ . '/includes/header.php';
?>
<div class="school-page">
  <section class="school-hero school-hero--photo" aria-labelledby="school-heading">
    <picture class="school-hero__photo">
      <source type="image/webp" srcset="<?php echo school_e(lp_versioned_asset('/assets/images/school/hero-classroom.webp')); ?>">
      <img src="<?php echo school_e(lp_versioned_asset('/assets/images/school/hero-classroom.jpg')); ?>" alt="教室でタブレットを見ながら笑顔で学習する高校生" width="1600" height="1066" loading="eager" fetchpriority="high" decoding="async">
    </picture>
    <div class="lp-container school-hero__inner">
      <div class="school-hero__copy">
        <p class="section-badge">FOR SCHOOLS</p>
        <h1 id="school-heading"><span class="school-hero__nowrap">2027年度の英検対策を、</span><span class="school-hero__nowrap">もっと手軽に。</span></h1>
        <p class="school-lead">英検5級から1級（準2級プラスを含む）に対応しています。単語、文法、リーディング、リスニング、ライティング、スピーキングを学習できます。AIによる添削と採点は、生徒の自主学習を支え、先生の指導を補完します。スマートフォン、タブレット、PCから利用できます。2027年度に向けた、学校向けの導入相談を受け付けています。</p>
        <a class="school-btn" href="#school-contact">学校向け導入を相談する</a>
      </div>
    </div>
  </section>

  <section class="school-section school-section--mist" id="school-issues" aria-labelledby="school-issues-heading">
    <div class="lp-container">
      <p class="section-badge section-badge--center">CURRENT SITUATION</p>
      <h2 id="school-issues-heading">学校が抱える課題</h2>
      <p class="school-lead school-lead--center">英語科の授業と補習だけでは、生徒一人ひとりの級に合わせた練習量を確保しきれないことがあります。</p>
      <div class="school-issues-wrap">
        <?php echo $photo('exam-hall', '英検の試験会場で、問題に向かう高校生', 'school-photo--exam'); ?>
        <ul class="school-issues">
          <li>授業外でも、英検対策に取り組める環境を整えたい</li>
          <li>生徒ごとに異なる英検の級へ対応したい</li>
          <li>ライティングやスピーキングの練習機会を増やしたい</li>
          <li>生徒が自分で繰り返し学習できる教材を用意したい</li>
          <li>教員の指導を補完する学習ツールを探している</li>
        </ul>
      </div>
      <figure class="school-buddy">
        <img src="<?php echo school_e(lp_versioned_asset('/assets/images/buddies/mame.png')); ?>" alt="AiKenの学習キャラクター「マメ」" width="900" height="900" loading="lazy" decoding="async">
        <figcaption>学習中は、相棒のキャラクターが画面に寄り添います。</figcaption>
      </figure>
    </div>
  </section>

  <section class="school-section" id="school-features" aria-labelledby="school-features-heading">
    <div class="lp-container">
      <p class="section-badge section-badge--center">LEARNING</p>
      <h2 id="school-features-heading">AiKenで学習できること</h2>
      <p class="school-lead school-lead--center">ここで紹介するのは、現在のAiKenで生徒が利用できる学習内容です。学校向けの専用機能として、別に用意しているものではありません。</p>
      <div class="school-features">
        <article class="school-card">
          <p class="school-card__num">01</p>
          <h3>英検5級〜1級（準2級プラスを含む）</h3>
          <p>5級、4級、3級、準2級、準2級プラス、2級、準1級、1級に対応しています。級が上がっても、同じサービスで続けられます。</p>
        </article>
        <article class="school-card">
          <p class="school-card__num">02</p>
          <h3>全級の単語学習</h3>
          <?php echo $shot('/assets/images/app/tablet/vocabulary.jpg', 'AiKenの単語クイズ。英単語と4つの日本語訳', 2064, 2752, 'school-shot'); ?>
          <p>5級から1級まで、単語を4択で練習します。</p>
        </article>
        <article class="school-card">
          <p class="school-card__num">03</p>
          <h3>5級〜2級の文法学習</h3>
          <p class="school-stat">108テーマ<span>1テーマは解説を読み、4択を5問</span></p>
          <p>文法は5級から2級までです。1級と準1級の文法テーマはありません。英検協会が公式に定めた文法項目の一覧ではありません。</p>
        </article>
        <article class="school-card">
          <p class="school-card__num">04</p>
          <h3>全級のリーディング・リスニング</h3>
          <div class="school-card__shots">
            <?php echo $shot('/assets/images/app/tablet/reading.jpg', 'AiKenのリーディング。長文を読んで内容を選ぶ画面', 2064, 2752, 'school-shot'); ?>
            <?php echo $shot('/assets/images/app/tablet/listening.jpg', 'AiKenのリスニング。放送を聞いて選択肢を選ぶ画面', 2064, 2752, 'school-shot'); ?>
          </div>
          <p>リーディングとリスニングは、5級から1級までです。級ごとの出題形式で練習します。</p>
        </article>
        <article class="school-card">
          <p class="school-card__num">05</p>
          <h3>3級〜1級のライティング・スピーキング</h3>
          <div class="school-card__shots">
            <?php echo $shot('/assets/images/app/tablet/writing.jpg', 'AiKenの英作文画面', 2064, 2752, 'school-shot'); ?>
            <?php echo $shot('/assets/images/app/tablet/speaking.jpg', 'AiKenのスピーキング問題カード', 2064, 2752, 'school-shot'); ?>
          </div>
          <p>ライティングとスピーキングの練習は、3級から1級までです。4級と5級の範囲は、次の説明のとおりです。</p>
        </article>
        <article class="school-card">
          <p class="school-card__num">06</p>
          <h3>AIによる添削・練習採点</h3>
          <p>ライティングは5つの観点で添削します。スピーキングは、パートごとの練習採点です。いずれも日々の練習用で、英検本番のスコアや学校の成績そのものではありません。</p>
          <p><a class="school-textlink" href="#school-ai">採点の内容を見る</a></p>
        </article>
      </div>
    </div>
  </section>

  <section class="school-section school-section--mist" id="school-coverage" aria-labelledby="school-coverage-heading">
    <div class="lp-container">
      <p class="section-badge section-badge--center">COVERAGE</p>
      <h2 id="school-coverage-heading">対応級・技能一覧</h2>
      <p class="school-lead school-lead--center">単語は5級〜1級、文法は5級〜2級、リーディングとリスニングは5級〜1級、ライティングとスピーキングは3級〜1級です。</p>
      <div class="school-table-wrap">
        <table class="school-table">
          <caption class="school-sr">級ごとの単語、文法、リーディング、リスニング、ライティング、スピーキングの対応</caption>
          <thead>
            <tr>
              <th scope="col">級</th>
              <?php foreach ($skillKeys as $label): ?>
              <th scope="col"><?php echo school_e($label); ?></th>
              <?php endforeach; ?>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($gradeRows as $row):
                $gradeName = (string) ($GRADES[$row['slug']]['name'] ?? $row['slug']);
                ?>
            <tr>
              <th scope="row"><a href="/<?php echo school_e($row['slug']); ?>/"><?php echo school_e($gradeName); ?></a></th>
              <?php foreach ($skillKeys as $key => $label): ?>
              <td><?php echo $row[$key] ? '対応' : 'なし'; ?></td>
              <?php endforeach; ?>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <div class="school-acc">
        <?php foreach ($gradeRows as $index => $row):
            $gradeName = (string) ($GRADES[$row['slug']]['name'] ?? $row['slug']);
            ?>
        <details class="school-acc__item"<?php echo $index === 0 ? ' open' : ''; ?>>
          <summary><?php echo school_e($gradeName); ?></summary>
          <dl>
            <?php foreach ($skillKeys as $key => $label): ?>
            <div>
              <dt><?php echo school_e($label); ?></dt>
              <dd><?php echo $row[$key] ? '対応' : 'なし'; ?></dd>
            </div>
            <?php endforeach; ?>
          </dl>
          <p><a href="/<?php echo school_e($row['slug']); ?>/"><?php echo school_e($gradeName); ?>のページ</a></p>
        </details>
        <?php endforeach; ?>
      </div>
      <p class="school-note">4級と5級の一次にライティングはありません。AiKenで用意している練習も、単語・リーディング・リスニングが中心です。4級の二次は録音型として案内していますが、その練習画面はAiKenにはありません。</p>
    </div>
  </section>

  <section class="school-section" id="school-ai" aria-labelledby="school-ai-heading">
    <div class="lp-container">
      <p class="section-badge section-badge--center">AI SUPPORT</p>
      <h2 id="school-ai-heading">AIによる添削・採点</h2>
      <p class="school-lead school-lead--center">AIが返すのは、生徒が自分で取り組んだあとの練習用フィードバックです。授業の目標や評価は、先生が行います。</p>
      <figure class="school-figure">
        <?php echo $photo('classroom-speaking', 'タブレットを手に、黒板の前で英語を話す高校生', 'school-photo--speaking'); ?>
        <figcaption>スピーキングは、マイクで声に出して答える練習ができます。</figcaption>
      </figure>
      <div class="school-ai">
        <article class="school-card">
          <?php echo $shot('/assets/images/app/tablet/writing.jpg', '英作文を書き、AI添削に出す画面', 2064, 2752, 'school-shot'); ?>
          <h3>ライティング</h3>
          <p>語彙、文法、内容、構成、指示遵守の5観点で評価します。各観点は0〜5点で、総合評価はその平均です。</p>
        </article>
        <article class="school-card">
          <?php echo $shot('/assets/images/app/tablet/speaking.jpg', 'スピーキングの問題カード', 2064, 2752, 'school-shot'); ?>
          <h3>スピーキング</h3>
          <p>各パート0〜3点の練習採点です。独立した発音スコアはありません。</p>
          <p>マイクで答えると採点されます。声を出しにくい場所では、文字入力でも採点できます。</p>
        </article>
      </div>
      <p class="school-note">いずれも英検本番のスコアを保証するものではなく、日々の練習をサポートする機能です。学校の成績として扱うものでもありません。</p>
    </div>
  </section>

  <section class="school-section school-section--mist" id="school-devices" aria-labelledby="school-devices-heading">
    <div class="lp-container">
      <p class="section-badge section-badge--center">DEVICES</p>
      <h2 id="school-devices-heading">利用する端末</h2>
      <p class="school-lead school-lead--center">学習は、ブラウザ版 <a href="<?php echo school_e(APP_URL); ?>/"><?php echo school_e(APP_URL); ?>/</a>、または各ストアのAiKenアプリで行います。<?php echo school_e(SITE_URL); ?>/ は紹介サイトであり、学習画面ではありません。</p>
      <figure class="school-figure">
        <?php echo $photo('home-study', '家でタブレットを使って英語を学習する高校生', 'school-photo--home'); ?>
        <figcaption>学校で使うのと同じアカウントで、家庭のタブレットやPCからも学習できます。</figcaption>
      </figure>
      <div class="school-devices">
        <article class="school-card">
          <?php echo $shot('/assets/images/app/phone/vocabulary.png', 'スマートフォン版AiKenの単語クイズ', 1170, 2532, 'school-shot school-shot--phone'); ?>
          <h3>スマートフォン</h3>
          <p>生徒のスマートフォンのブラウザ、またはAiKenアプリから単語やリスニングに取り組めます。</p>
        </article>
        <article class="school-card">
          <?php echo $shot('/assets/images/app/tablet/reading.jpg', 'タブレット幅のリーディング画面', 2064, 2752, 'school-shot'); ?>
          <h3>タブレット</h3>
          <p>学校にあるタブレットのブラウザから、リーディングやライティングに取り組めます。</p>
        </article>
        <article class="school-card">
          <?php echo $shot('/assets/images/app/tablet/listening.jpg', 'ブラウザのリスニング画面', 2064, 2752, 'school-shot'); ?>
          <h3>PC</h3>
          <p>コンピュータ室や家庭のPCから、同じアカウントでブラウザ版を利用できます。</p>
        </article>
      </div>
      <p class="school-note">今あるスマートフォン、タブレット、PCを使って始められます。iPhone・iPadは App Store、Androidは Google Play のAiKenアプリです。アプリの名称はAiKenのままです。学校名義でのストア公開は、標準のサービスには含まれません。対応ブラウザ、音声、マイク、学校のネットワークによって動作が異なることがあります。導入前に、使う端末とネットワークで画面と音声をご確認ください。</p>
      <p class="school-store">
        <a href="<?php echo school_e(APP_STORE_URL); ?>" rel="noopener noreferrer" target="_blank">App Store</a>
        <a href="<?php echo school_e(PLAY_STORE_URL); ?>" rel="noopener noreferrer" target="_blank">Google Play</a>
      </p>
    </div>
  </section>

  <section class="school-section" id="school-consult" aria-labelledby="school-consult-heading">
    <div class="lp-container school-consult">
      <p class="section-badge section-badge--center">CONSULTATION</p>
      <h2 id="school-consult-heading">学校向けの導入相談</h2>
      <p class="school-lead school-lead--center">導入人数や利用範囲に応じてご相談いただけます。</p>
      <p class="school-lead school-lead--center">学校独自のロゴやサービス名での利用についても、対応範囲を確認したうえでご相談いただけます。すでに用意された標準機能として、ロゴの差し替えや専用ドメインの提供ができるわけではありません。学校名義で App Store や Google Play にアプリを公開することは、標準のサービスには含まれません。</p>
      <p class="school-lead school-lead--center">学習塾での活用は、<a href="/juku">学習塾向けのページ</a>でご案内しています。</p>
      <a class="school-btn" href="#school-contact">学校向け導入を相談する</a>
    </div>
  </section>

  <section class="school-section school-section--form" id="school-contact" aria-labelledby="school-contact-heading">
    <div class="lp-container school-form-wrap">
      <h2 id="school-contact-heading">導入相談フォーム</h2>
      <p class="school-lead">学校名、ご担当者、相談内容をお送りください。内容を確認し、数営業日以内を目安にご連絡します。この送信で、契約や利用開始が確定するものではありません。</p>

      <?php if ($success): ?>
      <div class="school-alert school-alert--ok" role="status">
        <p class="school-alert__title">導入相談を受け付けました</p>
        <p>内容を確認し、ご連絡します。契約や利用開始が確定したわけではありません。受付確認のメールをお送りしています。届かない場合は、迷惑メールもご確認ください。</p>
      </div>
      <?php endif; ?>

      <?php if ($errors !== []): ?>
      <div class="school-alert school-alert--ng" role="alert">
        <p class="school-alert__title">送信できませんでした</p>
        <ul>
          <?php foreach ($errors as $err): ?>
          <li><?php echo school_e($err); ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <?php endif; ?>

      <?php if (!$success): ?>
      <form class="school-form" method="post" action="/school#school-contact" novalidate>
        <input type="hidden" name="csrf" value="<?php echo school_e($csrf); ?>">
        <div class="contact-form__hp" aria-hidden="true">
          <label for="school-website">Website</label>
          <input type="text" id="school-website" name="website" value="" tabindex="-1" autocomplete="off">
        </div>

        <div>
          <label for="school-name">学校名 <span>必須</span></label>
          <input class="<?php echo $inputClass; ?>" id="school-name" name="school" type="text" required maxlength="80" autocomplete="organization" value="<?php echo school_e($form['school']); ?>">
        </div>
        <div>
          <label for="school-person">担当者名 <span>必須</span></label>
          <input class="<?php echo $inputClass; ?>" id="school-person" name="name" type="text" required maxlength="80" autocomplete="name" value="<?php echo school_e($form['name']); ?>">
        </div>
        <div>
          <label for="school-role">役職 <span>任意</span></label>
          <input class="<?php echo $inputClass; ?>" id="school-role" name="role" type="text" maxlength="80" value="<?php echo school_e($form['role']); ?>">
        </div>
        <div>
          <label for="school-email">メールアドレス <span>必須</span></label>
          <input class="<?php echo $inputClass; ?>" id="school-email" name="email" type="email" required maxlength="200" autocomplete="email" value="<?php echo school_e($form['email']); ?>">
        </div>
        <div>
          <label for="school-headcount">想定利用人数 <span>任意</span></label>
          <input class="<?php echo $inputClass; ?>" id="school-headcount" name="headcount" type="text" maxlength="40" placeholder="例：中学3年 120名" value="<?php echo school_e($form['headcount']); ?>">
        </div>
        <div>
          <label for="school-timing">導入希望時期 <span>任意</span></label>
          <input class="<?php echo $inputClass; ?>" id="school-timing" name="timing" type="text" maxlength="40" placeholder="例：2027年4月" value="<?php echo school_e($form['timing']); ?>">
        </div>
        <div>
          <label for="school-message">相談内容 <span>必須</span></label>
          <textarea class="<?php echo $inputClass; ?>" id="school-message" name="message" required rows="8" maxlength="4000"><?php echo school_e($form['message']); ?></textarea>
          <p class="school-hint">日本語でご記入ください。対象学年、希望する級、利用する端末が分かればあわせてお書きください。</p>
        </div>
        <div class="school-consent">
          <input id="school-privacy" name="privacy" type="checkbox" value="1" required>
          <label for="school-privacy"><a href="/privacy">プライバシーポリシー</a>に同意する <span>必須</span></label>
        </div>
        <button class="school-btn" type="submit">導入相談を送る</button>
      </form>
      <?php endif; ?>
    </div>
  </section>

  <a class="school-btn school-sticky" id="school-sticky" href="#school-contact">学校向け導入を相談する</a>
</div>
<script>
(function () {
  var contact = document.getElementById('school-contact');
  var bar = document.getElementById('school-sticky');
  if (!contact || !bar) return;
  function update() {
    var hide = window.matchMedia('(min-width: 1024px)').matches || contact.getBoundingClientRect().top < window.innerHeight - 8;
    bar.hidden = hide;
    document.body.classList.toggle('school-sticky-on', !hide);
  }
  update();
  window.addEventListener('scroll', update, { passive: true });
  window.addEventListener('resize', update);
})();
</script>
<?php
include __DIR__ . '/includes/footer.php';
