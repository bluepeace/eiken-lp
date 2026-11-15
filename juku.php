<?php
/**
 * 学習塾向け導入相談（/juku）
 * 個人向け contact.php ・学校向け school.php とは別フォーム。送信先は CONTACT_EMAIL。
 */
declare(strict_types=1);

$page = 'juku';
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/contact-guard.php';
require_once __DIR__ . '/includes/inquiry-mail.php';

$canonical = rtrim(SITE_URL, '/') . '/juku';
$og_image = asset('/assets/images/app/tablet/vocabulary.jpg');

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function juku_e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

$errors = [];
$success = false;
$form = [
    'juku' => '',
    'name' => '',
    'role' => '',
    'email' => '',
    'classrooms' => '',
    'headcount' => '',
    'timing' => '',
    'message' => '',
];

if (($_SESSION['juku_flash'] ?? '') === 'sent') {
    $success = true;
    unset($_SESSION['juku_flash']);
}

$mailFrom = inquiry_encode_address(CONTACT_FROM_NAME, inquiry_mail_from_email());

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form['juku'] = inquiry_single_line((string) ($_POST['juku'] ?? ''));
    $form['name'] = inquiry_single_line((string) ($_POST['name'] ?? ''));
    $form['role'] = inquiry_single_line((string) ($_POST['role'] ?? ''));
    $form['email'] = inquiry_single_line((string) ($_POST['email'] ?? ''));
    $form['classrooms'] = inquiry_single_line((string) ($_POST['classrooms'] ?? ''));
    $form['headcount'] = inquiry_single_line((string) ($_POST['headcount'] ?? ''));
    $form['timing'] = inquiry_single_line((string) ($_POST['timing'] ?? ''));
    $form['message'] = trim((string) ($_POST['message'] ?? ''));
    $privacy = (string) ($_POST['privacy'] ?? '');
    $honeypot = trim((string) ($_POST['website'] ?? ''));
    $token = (string) ($_POST['csrf'] ?? '');
    $clientIp = contact_client_ip();
    $userAgent = contact_user_agent();

    if ($honeypot !== '') {
        $_SESSION['juku_flash'] = 'sent';
        header('Location: /juku#juku-contact');
        exit;
    }

    $sessionToken = (string) ($_SESSION['juku_csrf'] ?? '');
    if ($sessionToken === '' || !hash_equals($sessionToken, $token)) {
        $errors[] = 'セッションの有効期限が切れたか、不正な送信です。ページを再読み込みしてから再度お試しください。';
    }

    $shownAt = (int) ($_SESSION['juku_shown_at'] ?? 0);
    if ($shownAt === 0 || (time() - $shownAt) < 3) {
        $errors[] = '送信を確認できませんでした。ページを開いてから、もう一度お試しください。';
    }

    $lastSent = (int) ($_SESSION['juku_last_sent'] ?? 0);
    if ($lastSent > 0 && (time() - $lastSent) < 60) {
        $errors[] = '連続送信を防ぐため、少し時間をおいてから再度お送りください。';
    }

    if ($form['juku'] === '' || mb_strlen($form['juku']) > 80) {
        $errors[] = '塾名を80文字以内で入力してください。';
    }
    if ($form['name'] === '' || mb_strlen($form['name']) > 80) {
        $errors[] = 'ご担当者名を80文字以内で入力してください。';
    }
    if (mb_strlen($form['role']) > 80) {
        $errors[] = '役職は80文字以内で入力してください。';
    }
    if ($form['email'] === '' || !filter_var($form['email'], FILTER_VALIDATE_EMAIL) || mb_strlen($form['email']) > 200) {
        $errors[] = '有効なメールアドレスを入力してください。';
    }
    if (mb_strlen($form['classrooms']) > 40) {
        $errors[] = '教室数は40文字以内で入力してください。';
    }
    if (mb_strlen($form['headcount']) > 40) {
        $errors[] = '想定利用人数は40文字以内で入力してください。';
    }
    if (mb_strlen($form['timing']) > 40) {
        $errors[] = '導入希望時期は40文字以内で入力してください。';
    }
    if ($form['message'] === '' || mb_strlen($form['message']) < 10) {
        $errors[] = 'お問い合わせ内容は10文字以上で入力してください。';
    }
    if (mb_strlen($form['message']) > 4000) {
        $errors[] = 'お問い合わせ内容は4000文字以内で入力してください。';
    }
    if ($privacy !== '1') {
        $errors[] = '個人情報の取り扱いへの同意が必要です。';
    }

    if ($errors === []) {
        if (!contact_has_kana($form['message'])) {
            $errors[] = 'お問い合わせ内容は日本語でご記入ください。';
        } elseif (contact_rate_exceeded($clientIp, $form['email'])) {
            $errors[] = '連続送信を防ぐため、少し時間をおいてから再度お送りください。';
        }
    }

    if ($errors === []) {
        $now = date('Y-m-d H:i:s');
        $roleLine = $form['role'] !== '' ? $form['role'] : '（未入力）';
        $classroomsLine = $form['classrooms'] !== '' ? $form['classrooms'] : '（未入力）';
        $headcountLine = $form['headcount'] !== '' ? $form['headcount'] : '（未入力）';
        $timingLine = $form['timing'] !== '' ? $form['timing'] : '（未入力）';
        $ipLine = $clientIp !== '' ? $clientIp : '-';
        $uaLine = $userAgent !== '' ? $userAgent : '-';
        $adminSubject = '【AiKen学習塾向け導入相談】' . $form['juku'];
        $adminBody = "AiKen 学習塾向け相談フォームより送信がありました。\n"
            . "この送信は相談の受付であり、契約や利用開始の確定ではありません。\n\n"
            . "日時: {$now}\n"
            . "塾名: {$form['juku']}\n"
            . "担当者名: {$form['name']}\n"
            . "役職: {$roleLine}\n"
            . "メール: {$form['email']}\n"
            . "教室数: {$classroomsLine}\n"
            . "想定利用人数: {$headcountLine}\n"
            . "導入希望時期: {$timingLine}\n"
            . "個人情報の取り扱い: 同意済み\n"
            . "IP: {$ipLine}\n"
            . "UA: {$uaLine}\n\n"
            . "---- お問い合わせ内容 ----\n"
            . $form['message'] . "\n";

        $adminOk = inquiry_send_mail(
            CONTACT_EMAIL,
            $adminSubject,
            $adminBody,
            [
                'From' => $mailFrom,
                'Reply-To' => $form['email'],
                'X-Mailer' => 'AiKen-LP-Juku',
            ]
        );

        $autoSubject = '【AiKen】学習塾向けの相談を受け付けました';
        $autoBody = $form['name'] . " 様\n\n"
            . "学習塾でのAiKen活用についてのご相談を受け付けました。\n"
            . "内容を確認し、必要に応じてご連絡します。\n"
            . "このメールは受付の確認です。契約や利用開始が確定したお知らせではありません。\n\n"
            . "---- 受付内容 ----\n"
            . "塾名: {$form['juku']}\n"
            . "担当者名: {$form['name']}\n"
            . "役職: {$roleLine}\n"
            . "教室数: {$classroomsLine}\n"
            . "想定利用人数: {$headcountLine}\n"
            . "導入希望時期: {$timingLine}\n"
            . "お問い合わせ内容:\n"
            . $form['message'] . "\n"
            . "--------------------\n\n"
            . "※このメールは自動送信です。返信いただいても内容を確認できない場合があります。\n"
            . "追加のご連絡は " . CONTACT_EMAIL . " までお願いいたします。\n\n"
            . "AiKen（アイケン）\n"
            . SITE_URL . "/juku\n";

        $autoOk = inquiry_send_mail(
            $form['email'],
            $autoSubject,
            $autoBody,
            [
                'From' => $mailFrom,
                'Reply-To' => CONTACT_EMAIL,
                'X-Mailer' => 'AiKen-LP-Juku',
            ]
        );

        if ($adminOk) {
            $_SESSION['juku_last_sent'] = time();
            contact_rate_record($clientIp, $form['email']);
            $_SESSION['juku_flash'] = 'sent';
            header('Location: /juku#juku-contact');
            exit;
        }

        $errors[] = '送信に失敗しました。時間をおいて再度お試しいただくか、' . CONTACT_EMAIL . ' まで直接メールをお送りください。';
        unset($autoOk);
    }
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['juku_shown_at'] = time();
}

$_SESSION['juku_csrf'] = bin2hex(random_bytes(16));
$csrf = $_SESSION['juku_csrf'];

$shot = static function (string $path, string $alt, int $width, int $height, string $class): string {
    $src = lp_versioned_asset($path);
    return '<img src="' . juku_e($src) . '" alt="' . juku_e($alt) . '" width="' . $width . '" height="' . $height . '" class="' . juku_e($class) . '" loading="lazy" decoding="async">';
};

$ranges = [
    ['skill' => '単語', 'grades' => '5級〜1級'],
    ['skill' => '文法', 'grades' => '5級〜2級'],
    ['skill' => 'リーディング', 'grades' => '5級〜1級'],
    ['skill' => 'リスニング', 'grades' => '5級〜1級'],
    ['skill' => 'ライティング', 'grades' => '3級〜1級'],
    ['skill' => 'スピーキング', 'grades' => '3級〜1級'],
];

$faqs = [
    [
        'q' => '個別指導塾でも利用できますか？',
        'a' => 'はい。個別指導塾での英検対策や、授業外の自主学習などに活用いただけます。生徒の目標級に合わせて学習内容を選ぶことができます。',
    ],
    [
        'q' => '集団指導塾でも利用できますか？',
        'a' => 'はい。英検対策コースの補助教材や、家庭学習用の教材としてご検討いただけます。',
    ],
    [
        'q' => '英検対策コースの教材として利用できますか？',
        'a' => 'はい。単語・文法・リーディング・リスニング・ライティング・スピーキングなど、現在提供している学習機能を組み合わせて活用できます。',
    ],
    [
        'q' => 'どの級まで対応していますか？',
        'a' => '英検5級から1級まで、準2級プラスを含む幅広い級に対応しています。なお、学習内容によって対応級が異なります。',
    ],
    [
        'q' => '生徒は自宅でも利用できますか？',
        'a' => 'はい。Web版・iOS版・Android版に対応しており、自宅などでも学習できます。',
    ],
    [
        'q' => 'スマートフォンやタブレットでも利用できますか？',
        'a' => 'はい。パソコン・タブレット・スマートフォンから利用できます。',
    ],
    [
        'q' => '料金や利用条件について相談できますか？',
        'a' => 'はい。導入人数や利用範囲、ご希望の運用方法などをお聞きしたうえでご相談いただけます。',
    ],
    [
        'q' => '塾独自のブランドで提供することはできますか？',
        'a' => '塾独自のロゴやサービス名での提供についても、ご要望をお聞きしたうえでご相談となります。',
    ],
];

$inputClass = 'school-field';

include __DIR__ . '/includes/header.php';
?>
<div class="school-page juku-page">
  <section class="school-hero" aria-labelledby="juku-heading">
    <div class="lp-container school-hero__grid">
      <div class="school-hero__copy">
        <p class="section-badge">FOR JUKU</p>
        <h1 id="juku-heading">英検対策を、もっと手軽に。塾の指導にAiKenを。</h1>
        <p class="school-lead">英検5級〜1級・準2級プラスに対応した英検対策アプリ「AiKen（アイケン）」。単語・文法からリーディング・リスニング・ライティング・スピーキングまで、AIを活用した学習機能で、生徒一人ひとりの英検合格をサポートします。</p>
        <p class="school-lead">塾の英検対策コースや授業の補助教材、家庭学習用の教材としてご活用いただけます。</p>
        <ul class="juku-chips">
          <li>英検5級〜1級・準2級プラスに対応</li>
          <li>単語・文法・4技能を幅広くカバー</li>
          <li>AIによるライティング添削・スピーキング採点</li>
          <li>パソコン・タブレット・スマートフォンに対応</li>
        </ul>
        <a class="school-btn" href="#juku-contact">塾での活用について相談する</a>
      </div>
      <div class="school-hero__screens">
        <img src="<?php echo juku_e(lp_versioned_asset('/assets/images/app/tablet/vocabulary.jpg')); ?>" alt="AiKenの単語クイズ。英単語を4択で選ぶ画面" width="2064" height="2752" class="school-shot school-shot--hero" loading="eager" decoding="async">
        <div class="school-hero__pair">
          <img src="<?php echo juku_e(lp_versioned_asset('/assets/images/app/tablet/writing.jpg')); ?>" alt="AiKenの英作文画面。書いた英文をAI添削に出すボタンがある" width="2064" height="2752" class="school-shot" loading="eager" decoding="async">
          <img src="<?php echo juku_e(lp_versioned_asset('/assets/images/app/tablet/speaking.jpg')); ?>" alt="AiKenのスピーキング画面。面接形式の問題カード" width="2064" height="2752" class="school-shot" loading="eager" decoding="async">
        </div>
      </div>
    </div>
  </section>

  <section class="school-section school-section--mist" id="juku-worries" aria-labelledby="juku-worries-heading">
    <div class="lp-container">
      <p class="section-badge section-badge--center">FOR OWNERS</p>
      <h2 id="juku-worries-heading">塾のこんなお悩みはありませんか？</h2>
      <div class="juku-worries">
        <article class="school-card">
          <h3>英検対策の教材準備に時間がかかる</h3>
          <p>英検は級によって出題内容や求められる英語力が異なります。複数の級に対応するためには、それぞれのレベルに合った教材や問題を用意する必要があります。</p>
        </article>
        <article class="school-card">
          <h3>授業以外の学習を定着させたい</h3>
          <p>英検合格には、授業だけでなく日々の継続的な学習が欠かせません。単語の暗記やリスニングなど、生徒が自宅でも取り組める学習環境を整えたいと考えている塾も多いのではないでしょうか。</p>
        </article>
        <article class="school-card">
          <h3>ライティングや面接対策まで手が回らない</h3>
          <p>ライティングの添削やスピーキングの練習には、講師による個別の指導が必要です。生徒の人数が増えるほど、一人ひとりに十分な時間を確保することが難しくなります。</p>
        </article>
        <article class="school-card">
          <h3>生徒ごとに目標級や学力が異なる</h3>
          <p>同じ教室に通う生徒でも、目指す級や現在の英語力はさまざまです。それぞれの目標に合わせた学習内容を用意することが、英検対策では重要になります。</p>
        </article>
      </div>
      <figure class="school-buddy">
        <img src="<?php echo juku_e(lp_versioned_asset('/assets/images/buddies/mame.png')); ?>" alt="AiKenの学習キャラクター「マメ」" width="900" height="900" loading="lazy" decoding="async">
        <figcaption>学習中は、相棒のキャラクターが画面に寄り添います。</figcaption>
      </figure>
    </div>
  </section>

  <section class="school-section" id="juku-support" aria-labelledby="juku-support-heading">
    <div class="lp-container">
      <p class="section-badge section-badge--center">SUPPORT</p>
      <h2 id="juku-support-heading">AiKenが塾の英検対策をサポート</h2>
      <div class="school-features">
        <article class="school-card">
          <p class="school-card__num">01</p>
          <h3>5級〜1級まで幅広い級に対応</h3>
          <p>英検5級から1級まで、準2級プラスを含む幅広い級に対応しています。生徒の目標級や現在の英語力に合わせて、単語・文法・リーディング・リスニングなどに取り組めます。</p>
          <p>複数の級の生徒が在籍する塾でも、それぞれの目標に合わせた学習に活用できます。</p>
          <div class="school-card__shots">
            <?php echo $shot('/assets/images/app/tablet/vocabulary.jpg', 'AiKenの単語クイズ。英単語と4つの日本語訳', 2064, 2752, 'school-shot'); ?>
            <?php echo $shot('/assets/images/app/tablet/reading.jpg', 'AiKenのリーディング。長文を読んで内容を選ぶ画面', 2064, 2752, 'school-shot'); ?>
          </div>
        </article>
        <article class="school-card">
          <p class="school-card__num">02</p>
          <h3>AI添削でライティング学習をサポート</h3>
          <p>英検のライティング問題に取り組んだ答案をAIが採点・添削します。語彙・文法・内容・構成などの観点からフィードバックを受けられるため、英文を書く練習を繰り返すことができます。</p>
          <p>講師による指導と組み合わせることで、授業での解説や復習にも活用できます。</p>
          <?php echo $shot('/assets/images/app/tablet/writing.jpg', 'AiKenの英作文画面。AI添削に出すボタンがある', 2064, 2752, 'school-shot'); ?>
        </article>
        <article class="school-card">
          <p class="school-card__num">03</p>
          <h3>スピーキング・面接対策にも対応</h3>
          <p>英検の二次試験を見据えたスピーキング練習にも対応しています。音読や質問への回答など、級に応じた練習に取り組めます。</p>
          <p>AIによる採点・フィードバックを活用しながら、授業以外の時間にも発話練習を進められます。</p>
          <?php echo $shot('/assets/images/app/tablet/speaking.jpg', 'AiKenのスピーキング問題カード', 2064, 2752, 'school-shot'); ?>
        </article>
        <article class="school-card">
          <p class="school-card__num">04</p>
          <h3>授業外の自主学習にも活用</h3>
          <p>AiKenはパソコン・タブレット・スマートフォンから利用できます。教室での授業だけでなく、自宅での単語学習やリスニング、試験前の復習などにも活用できます。</p>
          <p>毎日の学習に取り入れやすい環境を整えることで、継続的な英検対策をサポートします。</p>
          <?php echo $shot('/assets/images/app/phone/vocabulary.png', 'スマートフォン版AiKenの単語クイズ', 1170, 2532, 'school-shot school-shot--phone'); ?>
        </article>
      </div>
    </div>
  </section>

  <section class="school-section school-section--mist" id="juku-uses" aria-labelledby="juku-uses-heading">
    <div class="lp-container">
      <p class="section-badge section-badge--center">IN THE CLASSROOM</p>
      <h2 id="juku-uses-heading">塾での活用イメージ</h2>
      <div class="juku-uses">
        <article class="school-card juku-use juku-use--course">
          <p class="juku-use__label">授業とあわせて</p>
          <p class="school-card__num">01</p>
          <h3>英検対策コースの補助教材として</h3>
          <p>英検対策コースの授業と組み合わせ、授業で扱った内容の復習や追加演習に活用できます。</p>
          <p>講師が文法や解答のポイントを解説し、AiKenでは単語・リーディング・リスニングなどの問題に取り組むなど、授業と自主学習を組み合わせた学習が可能です。</p>
        </article>
        <article class="school-card juku-use juku-use--home">
          <p class="juku-use__label">教室の外で</p>
          <p class="school-card__num">02</p>
          <h3>授業の宿題・家庭学習として</h3>
          <p>授業で学んだ内容を自宅でも復習できるよう、AiKenを家庭学習に活用できます。</p>
          <p>単語の確認やリスニング問題など、日々の学習に取り入れやすい内容を通じて、次回の授業までの学習をサポートします。</p>
        </article>
        <article class="school-card juku-use juku-use--exam">
          <p class="juku-use__label">試験が近いとき</p>
          <p class="school-card__num">03</p>
          <h3>英検受験前の集中対策として</h3>
          <p>試験日が近づいた時期には、目標級に合わせた総合的な対策が重要です。</p>
          <p>単語やリーディングなどの基礎学習に加え、ライティングやスピーキングにも取り組むことで、一次試験から二次試験までを見据えた学習に活用できます。</p>
        </article>
      </div>
      <p class="school-cta-row"><a class="school-btn" href="#juku-contact">塾での活用について相談する</a></p>
    </div>
  </section>

  <section class="school-section" id="juku-coverage" aria-labelledby="juku-coverage-heading">
    <div class="lp-container">
      <p class="section-badge section-badge--center">GRADES</p>
      <h2 id="juku-coverage-heading">幅広い級・学習内容に対応</h2>
      <p class="school-lead school-lead--center">AiKenでは、英検の級や技能に合わせた学習コンテンツを用意しています。</p>
      <div class="juku-range-wrap">
        <table class="juku-range">
          <caption class="school-sr">学習内容ごとの対応級</caption>
          <thead>
            <tr>
              <th scope="col">学習内容</th>
              <th scope="col">対応級</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($ranges as $row): ?>
            <tr>
              <th scope="row"><?php echo juku_e($row['skill']); ?></th>
              <td><?php echo juku_e($row['grades']); ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <p class="school-note">※学習内容によって対応級が異なります。準2級プラスを含む対応です。文法は5級〜2級、ライティングとスピーキングは3級〜1級です。</p>
    </div>
  </section>

  <section class="school-section school-section--mist" id="juku-screens" aria-labelledby="juku-screens-heading">
    <div class="lp-container">
      <p class="section-badge section-badge--center">SCREENS</p>
      <h2 id="juku-screens-heading">AiKenの学習画面</h2>
      <div class="school-features">
        <article class="school-card">
          <?php echo $shot('/assets/images/app/tablet/vocabulary.jpg', 'AiKenの単語クイズ', 2064, 2752, 'school-shot'); ?>
          <h3>単語学習</h3>
          <p>英検の級に合わせた単語・熟語を4択問題などで学習。繰り返し取り組むことで、語彙力の定着を目指します。</p>
        </article>
        <article class="school-card">
          <div class="school-card__shots">
            <?php echo $shot('/assets/images/app/tablet/reading.jpg', 'AiKenのリーディング画面', 2064, 2752, 'school-shot'); ?>
            <?php echo $shot('/assets/images/app/tablet/listening.jpg', 'AiKenのリスニング画面', 2064, 2752, 'school-shot'); ?>
          </div>
          <h3>リーディング・リスニング</h3>
          <p>英検の出題形式に合わせた問題に取り組み、読解力や聞き取りの力を養います。</p>
        </article>
        <article class="school-card">
          <?php echo $shot('/assets/images/app/tablet/writing.jpg', 'AiKenのライティング画面', 2064, 2752, 'school-shot'); ?>
          <h3>ライティング</h3>
          <p>英作文の練習からAIによる採点・添削まで対応。自分の答案を振り返りながら、表現力を高めていきます。</p>
        </article>
        <article class="school-card">
          <?php echo $shot('/assets/images/app/tablet/speaking.jpg', 'AiKenのスピーキング画面', 2064, 2752, 'school-shot'); ?>
          <h3>スピーキング</h3>
          <p>音読や質問への回答など、英検の面接を見据えた練習に取り組めます。</p>
        </article>
      </div>
    </div>
  </section>

  <section class="school-section" id="juku-devices" aria-labelledby="juku-devices-heading">
    <div class="lp-container">
      <p class="section-badge section-badge--center">DEVICES</p>
      <h2 id="juku-devices-heading">パソコン・タブレット・スマートフォンに対応</h2>
      <p class="school-lead school-lead--center">AiKenはWeb版に加え、iOS版・Android版も提供しています。パソコンやタブレットを使った教室での学習はもちろん、スマートフォンを使った自宅での学習にも対応。同じアカウントで利用できるため、場所や端末に合わせて学習を進められます。</p>
      <p class="school-lead school-lead--center">授業中の補助教材としても、授業外の自主学習用としても活用いただけます。</p>
      <div class="school-devices">
        <article class="school-card">
          <?php echo $shot('/assets/images/app/tablet/listening.jpg', 'パソコンのブラウザで開いたAiKenのリスニング画面', 2064, 2752, 'school-shot'); ?>
          <h3>パソコン</h3>
          <p>教室や自宅のパソコンから、Web版のAiKenを利用できます。</p>
        </article>
        <article class="school-card">
          <?php echo $shot('/assets/images/app/tablet/reading.jpg', 'タブレット幅のAiKenリーディング画面', 2064, 2752, 'school-shot'); ?>
          <h3>タブレット</h3>
          <p>教室のタブレットから、リーディングやライティングに取り組めます。</p>
        </article>
        <article class="school-card">
          <?php echo $shot('/assets/images/app/phone/vocabulary.png', 'スマートフォン版AiKenの単語クイズ', 1170, 2532, 'school-shot school-shot--phone'); ?>
          <h3>スマートフォン</h3>
          <p>自宅などでも、Web版またはAiKenアプリで学習できます。</p>
        </article>
      </div>
      <p class="school-note">学習は、Web版 <a href="<?php echo juku_e(APP_URL); ?>/"><?php echo juku_e(APP_URL); ?>/</a>、または App Store・Google Play のAiKenアプリで行います。Web版・iOS版・Android版の名称はいずれもAiKenです。<?php echo juku_e(SITE_URL); ?>/ は紹介サイトです。</p>
      <p class="school-store">
        <a href="<?php echo juku_e(APP_STORE_URL); ?>" rel="noopener noreferrer" target="_blank">App Store</a>
        <a href="<?php echo juku_e(PLAY_STORE_URL); ?>" rel="noopener noreferrer" target="_blank">Google Play</a>
      </p>
    </div>
  </section>

  <section class="school-section school-section--mist" id="juku-consult" aria-labelledby="juku-consult-heading">
    <div class="lp-container school-consult">
      <p class="section-badge section-badge--center">CONSULTATION</p>
      <h2 id="juku-consult-heading">学習塾でのAiKen活用について</h2>
      <p class="school-lead school-lead--center">AiKenの塾での活用については、導入人数や利用範囲、塾の指導方針に応じてご相談いただけます。</p>
      <p class="school-lead school-lead--center">英検対策コースの教材としての利用や、授業外の家庭学習への活用など、ご希望の運用方法をお聞かせください。</p>
      <p class="school-lead school-lead--center">塾独自のロゴやサービス名での提供についても、ご要望をお聞きしたうえでご相談となります。</p>
      <a class="school-btn" href="#juku-contact">塾での活用について相談する</a>
      <p class="school-lead school-lead--center">学校での導入は、<a href="/school">学校向けのページ</a>でご案内しています。</p>
    </div>
  </section>

  <section class="school-section" id="juku-faq" aria-labelledby="juku-faq-heading">
    <div class="lp-container">
      <p class="section-badge section-badge--center">FAQ</p>
      <h2 id="juku-faq-heading">よくある質問</h2>
      <div class="juku-faq">
        <?php foreach ($faqs as $index => $faq): ?>
        <details<?php echo $index === 0 ? ' open' : ''; ?>>
          <summary><?php echo juku_e($faq['q']); ?></summary>
          <p><?php echo juku_e($faq['a']); ?></p>
        </details>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <section class="school-section school-section--form" id="juku-contact" aria-labelledby="juku-contact-heading">
    <div class="lp-container school-form-wrap">
      <h2 id="juku-contact-heading">学習塾でのAiKen活用について、お気軽にご相談ください。</h2>
      <p class="school-lead">英検対策コースへの導入や、授業外の家庭学習への活用など、塾での利用についてお問い合わせいただけます。導入人数や利用範囲、ご希望の運用方法などをお聞かせください。この送信で、契約や利用開始が確定するものではありません。</p>

      <?php if ($success): ?>
      <div class="school-alert school-alert--ok" role="status">
        <p class="school-alert__title">相談を受け付けました</p>
        <p>内容を確認し、ご連絡します。契約や利用開始が確定したわけではありません。受付確認のメールをお送りしています。届かない場合は、迷惑メールもご確認ください。</p>
      </div>
      <?php endif; ?>

      <?php if ($errors !== []): ?>
      <div class="school-alert school-alert--ng" role="alert">
        <p class="school-alert__title">送信できませんでした</p>
        <ul>
          <?php foreach ($errors as $err): ?>
          <li><?php echo juku_e($err); ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <?php endif; ?>

      <?php if (!$success): ?>
      <form class="school-form" method="post" action="/juku#juku-contact" novalidate>
        <input type="hidden" name="csrf" value="<?php echo juku_e($csrf); ?>">
        <div class="contact-form__hp" aria-hidden="true">
          <label for="juku-website">Website</label>
          <input type="text" id="juku-website" name="website" value="" tabindex="-1" autocomplete="off">
        </div>

        <div>
          <label for="juku-name">塾名 <span>必須</span></label>
          <input class="<?php echo $inputClass; ?>" id="juku-name" name="juku" type="text" required maxlength="80" autocomplete="organization" value="<?php echo juku_e($form['juku']); ?>">
        </div>
        <div>
          <label for="juku-person">ご担当者名 <span>必須</span></label>
          <input class="<?php echo $inputClass; ?>" id="juku-person" name="name" type="text" required maxlength="80" autocomplete="name" value="<?php echo juku_e($form['name']); ?>">
        </div>
        <div>
          <label for="juku-role">役職 <span>任意</span></label>
          <input class="<?php echo $inputClass; ?>" id="juku-role" name="role" type="text" maxlength="80" autocomplete="organization-title" value="<?php echo juku_e($form['role']); ?>">
        </div>
        <div>
          <label for="juku-email">メールアドレス <span>必須</span></label>
          <input class="<?php echo $inputClass; ?>" id="juku-email" name="email" type="email" required maxlength="200" autocomplete="email" value="<?php echo juku_e($form['email']); ?>">
        </div>
        <div>
          <label for="juku-classrooms">教室数 <span>任意</span></label>
          <input class="<?php echo $inputClass; ?>" id="juku-classrooms" name="classrooms" type="text" maxlength="40" placeholder="例：3教室" value="<?php echo juku_e($form['classrooms']); ?>">
        </div>
        <div>
          <label for="juku-headcount">想定利用人数 <span>任意</span></label>
          <input class="<?php echo $inputClass; ?>" id="juku-headcount" name="headcount" type="text" maxlength="40" placeholder="例：生徒80名" value="<?php echo juku_e($form['headcount']); ?>">
        </div>
        <div>
          <label for="juku-timing">導入希望時期 <span>任意</span></label>
          <input class="<?php echo $inputClass; ?>" id="juku-timing" name="timing" type="text" maxlength="40" placeholder="例：2027年4月" value="<?php echo juku_e($form['timing']); ?>">
        </div>
        <div>
          <label for="juku-message">お問い合わせ内容 <span>必須</span></label>
          <textarea class="<?php echo $inputClass; ?>" id="juku-message" name="message" required rows="8" maxlength="4000"><?php echo juku_e($form['message']); ?></textarea>
          <p class="school-hint">日本語でご記入ください。個別指導・集団指導の別、対象の級、教室と自宅のどちらで使う予定かが分かればあわせてお書きください。</p>
        </div>
        <div class="school-consent">
          <input id="juku-privacy" name="privacy" type="checkbox" value="1" required>
          <label for="juku-privacy"><a href="/privacy">個人情報保護方針</a>に同意する <span>必須</span></label>
        </div>
        <button class="school-btn" type="submit">お問い合わせはこちら</button>
      </form>
      <?php endif; ?>
    </div>
  </section>

  <a class="school-btn school-sticky" id="juku-sticky" href="#juku-contact">塾での活用について相談する</a>
</div>
<script>
(function () {
  var contact = document.getElementById('juku-contact');
  var bar = document.getElementById('juku-sticky');
  if (!contact || !bar) return;
  function update() {
    var hide = window.matchMedia('(min-width: 1024px)').matches || contact.getBoundingClientRect().top < window.innerHeight - 8;
    bar.hidden = hide;
    document.body.classList.toggle('juku-sticky-on', !hide);
  }
  update();
  window.addEventListener('scroll', update, { passive: true });
  window.addEventListener('resize', update);
})();
</script>
<?php
include __DIR__ . '/includes/footer.php';
