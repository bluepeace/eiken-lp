<?php
/**
 * WordPress 等の RSS 2.0 から記事一覧を取得（キャッシュ付き）
 */
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../config.php';
}

function aiken_http_get(string $url, int $timeout = 10): ?string
{
    if (function_exists('curl_init')) {
        $ch = curl_init($url);
        if ($ch === false) {
            return null;
        }
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_TIMEOUT => $timeout,
            CURLOPT_USERAGENT => 'AiKen-LP/1.0 (+https://aiken.life)',
        ]);
        $body = curl_exec($ch);
        $code = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($code >= 200 && $code < 300 && is_string($body) && $body !== '') {
            return $body;
        }
        return null;
    }
    $ctx = stream_context_create([
        'http' => [
            'timeout' => $timeout,
            'user_agent' => 'AiKen-LP/1.0 (+https://aiken.life)',
            'follow_location' => 1,
        ],
    ]);
    $body = @file_get_contents($url, false, $ctx);
    return ($body !== false && $body !== '') ? $body : null;
}

/**
 * @return list<array{title: string, url: string, image: ?string, pubDate: string}>
 */
function get_blog_feed_items(int $limit = 20): array
{
    $limit = max(1, min(50, $limit));
    $cacheDir = __DIR__ . '/../cache';
    $cacheFile = $cacheDir . '/blog-feed.json';
    $ttl = 3600;

    if (is_readable($cacheFile)) {
        $cached = json_decode((string) file_get_contents($cacheFile), true);
        if (is_array($cached) && isset($cached['expires'], $cached['items']) && (int) $cached['expires'] > time()) {
            return array_slice($cached['items'], 0, $limit);
        }
    }

    $xmlStr = aiken_http_get(BLOG_FEED_URL);
    $items = [];

    if ($xmlStr !== null && $xmlStr !== '') {
        $prev = libxml_use_internal_errors(true);
        $xml = simplexml_load_string($xmlStr, 'SimpleXMLElement', LIBXML_NOCDATA);
        libxml_clear_errors();
        libxml_use_internal_errors($prev);

        if ($xml !== false && isset($xml->channel->item)) {
            foreach ($xml->channel->item as $item) {
                if (count($items) >= $limit) {
                    break;
                }
                $title = trim(html_entity_decode((string) $item->title, ENT_QUOTES | ENT_HTML5, 'UTF-8'));
                $link = trim((string) $item->link);
                if ($title === '' || $link === '' || !filter_var($link, FILTER_VALIDATE_URL)) {
                    continue;
                }
                $desc = (string) $item->description;
                $image = null;
                if (preg_match('/<img[^>]+src=["\']([^"\']+)["\']/i', $desc, $m)) {
                    $img = $m[1];
                    $image = filter_var($img, FILTER_VALIDATE_URL) ? $img : null;
                }
                $items[] = [
                    'title' => $title,
                    'url' => $link,
                    'image' => $image,
                    'pubDate' => trim((string) $item->pubDate),
                ];
            }
        }
    }

    if ($items === [] && is_readable($cacheFile)) {
        $cached = json_decode((string) file_get_contents($cacheFile), true);
        if (is_array($cached) && isset($cached['items']) && is_array($cached['items'])) {
            return array_slice($cached['items'], 0, $limit);
        }
    }

    if ($items !== []) {
        if (!is_dir($cacheDir)) {
            @mkdir($cacheDir, 0755, true);
        }
        @file_put_contents(
            $cacheFile,
            json_encode(
                ['expires' => time() + $ttl, 'items' => $items],
                JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
            ),
            LOCK_EX
        );
    }

    return $items;
}
