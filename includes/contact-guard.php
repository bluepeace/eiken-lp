<?php
/**
 * お問い合わせの迷惑送信対策（日本語判定・回数制限・送信元記録）
 */
declare(strict_types=1);

if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../config.php';
}

function contact_client_ip(): string
{
    $ip = (string) ($_SERVER['REMOTE_ADDR'] ?? '');
    return filter_var($ip, FILTER_VALIDATE_IP) ? $ip : '';
}

function contact_user_agent(): string
{
    $ua = trim((string) ($_SERVER['HTTP_USER_AGENT'] ?? ''));
    if ($ua === '') {
        return '';
    }
    return mb_substr($ua, 0, 300);
}

/** ひらがな・カタカナを含むか（漢字のみの中国語スパムは通さない） */
function contact_has_kana(string $text): bool
{
    return (bool) preg_match('/[\x{3040}-\x{309F}\x{30A0}-\x{30FF}]/u', $text);
}

/**
 * 今回の海外ボット（特商法＋多言語の値段問い合わせ）向け。
 * 成功画面だけ出してメールは送らない。
 */
function contact_is_silent_spam(string $subject, string $message): bool
{
    return $subject === 'tokushoho' && !contact_has_kana($message);
}

function contact_submitted_too_fast(): bool
{
    $shownAt = (int) ($_SESSION['contact_shown_at'] ?? 0);
    return $shownAt === 0 || (time() - $shownAt) < 3;
}

function contact_rate_store_path(): string
{
    return dirname(__DIR__) . '/cache/contact-rate.json';
}

/**
 * @return array{ips: array<string, list<int>>, emails: array<string, list<int>>}
 */
function contact_rate_empty(): array
{
    return ['ips' => [], 'emails' => []];
}

/**
 * @param list<int|string> $timestamps
 * @return list<int>
 */
function contact_rate_prune(array $timestamps, int $window): array
{
    $now = time();
    $kept = [];
    foreach ($timestamps as $ts) {
        $ts = (int) $ts;
        if ($ts > 0 && ($now - $ts) < $window) {
            $kept[] = $ts;
        }
    }
    return $kept;
}

/**
 * @return array{ips: array<string, list<int>>, emails: array<string, list<int>>}
 */
function contact_rate_decode(string $raw): array
{
    if ($raw === '') {
        return contact_rate_empty();
    }
    $data = json_decode($raw, true);
    if (!is_array($data)) {
        return contact_rate_empty();
    }
    return [
        'ips' => is_array($data['ips'] ?? null) ? $data['ips'] : [],
        'emails' => is_array($data['emails'] ?? null) ? $data['emails'] : [],
    ];
}

/**
 * @template T
 * @param callable(array{ips: array<string, list<int>>, emails: array<string, list<int>>}): T $fn
 * @return T|null
 */
function contact_rate_with_store(callable $fn)
{
    $path = contact_rate_store_path();
    $dir = dirname($path);
    if (!is_dir($dir) && !@mkdir($dir, 0755, true) && !is_dir($dir)) {
        return null;
    }
    $fp = @fopen($path, 'c+');
    if ($fp === false) {
        return null;
    }
    if (!flock($fp, LOCK_EX)) {
        fclose($fp);
        return null;
    }
    $raw = stream_get_contents($fp);
    $data = contact_rate_decode(is_string($raw) ? $raw : '');
    $result = $fn($data);
    if (is_array($result) && array_key_exists('_store', $result)) {
        $store = $result['_store'];
        unset($result['_store']);
        rewind($fp);
        ftruncate($fp, 0);
        fwrite($fp, json_encode($store, JSON_UNESCAPED_UNICODE) ?: '{}');
    }
    flock($fp, LOCK_UN);
    fclose($fp);
    return $result;
}

function contact_email_rate_key(string $email): string
{
    return hash('sha256', strtolower($email));
}

function contact_rate_exceeded(string $ip, string $email): bool
{
    $result = contact_rate_with_store(static function (array $data) use ($ip, $email): array {
        $ipHits = $ip === '' ? [] : contact_rate_prune($data['ips'][$ip] ?? [], 1800);
        $emailHits = contact_rate_prune($data['emails'][contact_email_rate_key($email)] ?? [], 3600);
        return [
            'exceeded' => count($ipHits) >= 3 || count($emailHits) >= 2,
        ];
    });
    return is_array($result) && !empty($result['exceeded']);
}

function contact_rate_record(string $ip, string $email): void
{
    contact_rate_with_store(static function (array $data) use ($ip, $email): array {
        $now = time();
        if ($ip !== '') {
            $ipHits = contact_rate_prune($data['ips'][$ip] ?? [], 1800);
            $ipHits[] = $now;
            $data['ips'][$ip] = $ipHits;
        }
        $emailKey = contact_email_rate_key($email);
        $emailHits = contact_rate_prune($data['emails'][$emailKey] ?? [], 3600);
        $emailHits[] = $now;
        $data['emails'][$emailKey] = $emailHits;

        foreach ($data['ips'] as $key => $hits) {
            $data['ips'][$key] = contact_rate_prune(is_array($hits) ? $hits : [], 1800);
            if ($data['ips'][$key] === []) {
                unset($data['ips'][$key]);
            }
        }
        foreach ($data['emails'] as $key => $hits) {
            $data['emails'][$key] = contact_rate_prune(is_array($hits) ? $hits : [], 3600);
            if ($data['emails'][$key] === []) {
                unset($data['emails'][$key]);
            }
        }

        return ['_store' => $data];
    });
}
