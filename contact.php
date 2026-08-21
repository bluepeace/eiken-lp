<?php
/**
 * お問い合わせフォーム
 * 送信先: CONTACT_EMAIL / 自動返信あり
 */
declare(strict_types=1);

$page = 'contact';
require_once __DIR__ . '/config.php';
$canonical = rtrim(SITE_URL, '/') . '/contact';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$subjects = [
    'service' => 'サービス内容について',
    'billing' => '料金・解約について',
    'bug' => '不具合・技術的なご質問',
    'tokushoho' => '特定商取引法に関する開示請求',
    'other' => 'その他',
];

$errors = [];
$success = false;
$form = [
    'name' => '',
    'email' => '',
    'subject' => 'service',
    'message' => '',
];

// 特商法などからの遷移で種別を初期選択
$presetSubject = trim((string) ($_GET['subject'] ?? ''));
if (isset($subjects[$presetSubject])) {
    $form['subject'] = $presetSubject;
}

/**
 * @param array<string, string> $headers
 */
function contact_send_mail(string $to, string $subject, string $body, array $headers): bool
{
    $headerLines = [];
    foreach ($headers as $key => $value) {
        $headerLines[] = $key . ': ' . $value;
    }
    $headerLines[] = 'MIME-Version: 1.0';
    $headerLines[] = 'Content-Type: text/plain; charset=UTF-8';
    $headerLines[] = 'Content-Transfer-Encoding: base64';

    $encodedSubject = '=?UTF-8?B?' . base64_encode($subject) . '?=';
    $encodedBody = chunk_split(base64_encode($body));

    return @mail($to, $encodedSubject, $encodedBody, implode("\r\n", $headerLines));
}

function contact_encode_address(string $name, string $email): string
{
    return '=?UTF-8?B?' . base64_encode($name) . '?= <' . $email . '>';
}

/** サーバー送信に使える From（ドメインメール）。受信・返信先は CONTACT_EMAIL */
function contact_mail_from_email(): string
{
    $host = parse_url(SITE_URL, PHP_URL_HOST);
    if (!is_string($host) || $host === '') {
        return CONTACT_EMAIL;
    }
    return 'noreply@' . $host;
}

$mailFrom = contact_encode_address(CONTACT_FROM_NAME, contact_mail_from_email());

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form['name'] = trim((string) ($_POST['name'] ?? ''));
    $form['email'] = trim((string) ($_POST['email'] ?? ''));
    $form['subject'] = trim((string) ($_POST['subject'] ?? 'service'));
    $form['message'] = trim((string) ($_POST['message'] ?? ''));
    $honeypot = trim((string) ($_POST['website'] ?? ''));
    $token = (string) ($_POST['csrf'] ?? '');

    if ($honeypot !== '') {
        // ボットは成功風に見せて終わる
        $success = true;
        $form = ['name' => '', 'email' => '', 'subject' => 'service', 'message' => ''];
    } else {
        $sessionToken = (string) ($_SESSION['contact_csrf'] ?? '');
        if ($sessionToken === '' || !hash_equals($sessionToken, $token)) {
            $errors[] = 'セッションの有効期限が切れたか、不正な送信です。ページを再読み込みしてから再度お試しください。';
        }

        $lastSent = (int) ($_SESSION['contact_last_sent'] ?? 0);
        if ($lastSent > 0 && (time() - $lastSent) < 60) {
            $errors[] = '連続送信を防ぐため、少し時間をおいてから再度お送りください。';
        }

        if ($form['name'] === '' || mb_strlen($form['name']) > 80) {
            $errors[] = 'お名前を80文字以内で入力してください。';
        }
        if ($form['email'] === '' || !filter_var($form['email'], FILTER_VALIDATE_EMAIL) || mb_strlen($form['email']) > 200) {
            $errors[] = '有効なメールアドレスを入力してください。';
        }
        if (!isset($subjects[$form['subject']])) {
            $errors[] = 'お問い合わせ種別を選択してください。';
        }
        if ($form['message'] === '' || mb_strlen($form['message']) < 10) {
            $errors[] = 'お問い合わせ内容は10文字以上で入力してください。';
        }
        if (mb_strlen($form['message']) > 4000) {
            $errors[] = 'お問い合わせ内容は4000文字以内で入力してください。';
        }

        if ($errors === []) {
            $subjectLabel = $subjects[$form['subject']];
            $now = date('Y-m-d H:i:s');
            $adminSubject = '【AiKenお問い合わせ】' . $subjectLabel;
            $adminBody = "AiKen LP お問い合わせフォームより送信がありました。\n\n"
                . "日時: {$now}\n"
                . "お名前: {$form['name']}\n"
                . "メール: {$form['email']}\n"
                . "種別: {$subjectLabel}\n\n"
                . "---- 内容 ----\n"
                . $form['message'] . "\n";

            $adminOk = contact_send_mail(
                CONTACT_EMAIL,
                $adminSubject,
                $adminBody,
                [
                    'From' => $mailFrom,
                    'Reply-To' => $form['email'],
                    'X-Mailer' => 'AiKen-LP-Contact',
                ]
            );

            $autoSubject = '【AiKen】お問い合わせを受け付けました';
            $autoBody = $form['name'] . " 様\n\n"
                . "この度は英検対策アプリ AiKen（アイケン）へお問い合わせいただき、ありがとうございます。\n"
                . "以下の内容で受け付けました。内容を確認のうえ、必要に応じてご連絡いたします。\n\n"
                . "---- 受付内容 ----\n"
                . "種別: {$subjectLabel}\n"
                . "お問い合わせ内容:\n"
                . $form['message'] . "\n"
                . "--------------------\n\n"
                . "※このメールは自動送信です。返信いただいても内容を確認できない場合があります。\n"
                . "追加のご連絡は " . CONTACT_EMAIL . " までお願いいたします。\n\n"
                . "AiKen（アイケン）\n"
                . SITE_URL . "\n";

            $autoOk = contact_send_mail(
                $form['email'],
                $autoSubject,
                $autoBody,
                [
                    'From' => $mailFrom,
                    'Reply-To' => CONTACT_EMAIL,
                    'X-Mailer' => 'AiKen-LP-Contact',
                ]
            );

            if ($adminOk && $autoOk) {
                $success = true;
                $_SESSION['contact_last_sent'] = time();
                $form = ['name' => '', 'email' => '', 'subject' => 'service', 'message' => ''];
            } elseif ($adminOk) {
                // 管理者には届いたが自動返信だけ失敗した場合も受付完了扱い
                $success = true;
                $_SESSION['contact_last_sent'] = time();
                $form = ['name' => '', 'email' => '', 'subject' => 'service', 'message' => ''];
            } else {
                $errors[] = '送信に失敗しました。時間をおいて再度お試しいただくか、' . CONTACT_EMAIL . ' まで直接メールをお送りください。';
            }
        }
    }
}

$_SESSION['contact_csrf'] = bin2hex(random_bytes(16));
$csrf = $_SESSION['contact_csrf'];

include __DIR__ . '/includes/header.php';
?>
<article class="border-b border-slate-100 bg-white px-4 py-12 sm:py-16" aria-labelledby="contact-heading">
  <div class="mx-auto max-w-xl">
    <h1 id="contact-heading" class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">お問い合わせ</h1>
    <p class="mt-3 text-sm leading-relaxed text-slate-600"><?php echo br_after_period('英検対策アプリAiKen（アイケン）に関するご質問・ご要望は、以下のフォームよりご連絡ください。通常、数営業日以内に確認いたします。'); ?></p>

    <?php if ($success): ?>
    <div class="mt-8 rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm text-emerald-900" role="status">
      <p class="font-semibold">送信が完了しました</p>
      <p class="mt-2 leading-relaxed">お問い合わせありがとうございます。受付確認の自動返信メールをお送りしています。届かない場合は迷惑メールフォルダもご確認ください。</p>
    </div>
    <?php endif; ?>

    <?php if ($errors !== []): ?>
    <div class="mt-8 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-900" role="alert">
      <p class="font-semibold">送信できませんでした</p>
      <ul class="mt-2 list-disc space-y-1 pl-5">
        <?php foreach ($errors as $err): ?>
        <li><?php echo htmlspecialchars($err, ENT_QUOTES, 'UTF-8'); ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <?php endif; ?>

    <?php if (!$success): ?>
    <form class="contact-form mt-8 space-y-5" method="post" action="/contact" novalidate>
      <input type="hidden" name="csrf" value="<?php echo htmlspecialchars($csrf, ENT_QUOTES, 'UTF-8'); ?>">
      <div class="contact-form__hp" aria-hidden="true">
        <label for="contact-website">Website</label>
        <input type="text" id="contact-website" name="website" value="" tabindex="-1" autocomplete="off">
      </div>

      <div>
        <label for="contact-name" class="block text-sm font-semibold text-slate-900">お名前 <span class="font-normal text-slate-500">必須</span></label>
        <input id="contact-name" name="name" type="text" required maxlength="80" autocomplete="name" value="<?php echo htmlspecialchars($form['name'], ENT_QUOTES, 'UTF-8'); ?>" class="mt-1.5 w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-900 shadow-sm outline-none transition focus:border-[#50c2cb] focus:ring-2 focus:ring-[#50c2cb]/25">
      </div>

      <div>
        <label for="contact-email" class="block text-sm font-semibold text-slate-900">メールアドレス <span class="font-normal text-slate-500">必須</span></label>
        <input id="contact-email" name="email" type="email" required maxlength="200" autocomplete="email" value="<?php echo htmlspecialchars($form['email'], ENT_QUOTES, 'UTF-8'); ?>" class="mt-1.5 w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-900 shadow-sm outline-none transition focus:border-[#50c2cb] focus:ring-2 focus:ring-[#50c2cb]/25">
      </div>

      <div>
        <label for="contact-subject" class="block text-sm font-semibold text-slate-900">お問い合わせ種別 <span class="font-normal text-slate-500">必須</span></label>
        <select id="contact-subject" name="subject" required class="mt-1.5 w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-900 shadow-sm outline-none transition focus:border-[#50c2cb] focus:ring-2 focus:ring-[#50c2cb]/25">
          <?php foreach ($subjects as $key => $label): ?>
          <option value="<?php echo htmlspecialchars($key, ENT_QUOTES, 'UTF-8'); ?>"<?php echo $form['subject'] === $key ? ' selected' : ''; ?>><?php echo htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div>
        <label for="contact-message" class="block text-sm font-semibold text-slate-900">お問い合わせ内容 <span class="font-normal text-slate-500">必須</span></label>
        <textarea id="contact-message" name="message" required rows="8" maxlength="4000" class="mt-1.5 w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-900 shadow-sm outline-none transition focus:border-[#50c2cb] focus:ring-2 focus:ring-[#50c2cb]/25"><?php echo htmlspecialchars($form['message'], ENT_QUOTES, 'UTF-8'); ?></textarea>
      </div>

      <p class="text-xs leading-relaxed text-slate-500"><?php echo br_after_period('送信いただいた内容は、お問い合わせ対応の目的で利用します。詳細は<a class="font-medium text-[#50c2cb] underline-offset-2 hover:underline" href="/privacy">プライバシーポリシー</a>をご確認ください。'); ?></p>

      <button type="submit" class="inline-flex w-full items-center justify-center rounded-full bg-[#50c2cb] px-6 py-3 text-sm font-semibold text-white transition hover:bg-[#46adb5] sm:w-auto">送信する</button>
    </form>
    <?php else: ?>
    <p class="mt-8 text-center text-sm">
      <a class="font-medium text-[#50c2cb] underline-offset-2 hover:underline" href="/contact">別のお問い合わせを送る</a>
    </p>
    <?php endif; ?>

    <p class="mt-10 text-center text-sm">
      <a class="font-medium text-[#50c2cb] underline-offset-2 hover:underline" href="/">トップに戻る</a>
    </p>
  </div>
</article>
<?php
include __DIR__ . '/includes/footer.php';
