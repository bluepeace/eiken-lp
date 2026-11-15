<?php
/**
 * 学校向け・学習塾向けの相談メール。本文の組み立ては各ページ側。
 */
declare(strict_types=1);

if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../config.php';
}

/**
 * @param array<string, string> $headers
 */
function inquiry_send_mail(string $to, string $subject, string $body, array $headers): bool
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

function inquiry_encode_address(string $name, string $email): string
{
    return '=?UTF-8?B?' . base64_encode($name) . '?= <' . $email . '>';
}

function inquiry_mail_from_email(): string
{
    $host = parse_url(SITE_URL, PHP_URL_HOST);
    if (!is_string($host) || $host === '') {
        return CONTACT_EMAIL;
    }
    return 'noreply@' . $host;
}

function inquiry_single_line(string $value): string
{
    $value = str_replace(["\r", "\n", "\0"], ' ', $value);
    return trim($value);
}
