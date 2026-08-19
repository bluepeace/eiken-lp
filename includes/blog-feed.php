<?php
/**
 * WordPress からコラム記事一覧を取得（更新日順・キャッシュ付き）
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

function aiken_blog_featured_image_from_embed(array $post): ?string
{
    $media = $post['_embedded']['wp:featuredmedia'][0] ?? null;
    if (!is_array($media)) {
        return null;
    }
    $sizes = is_array($media['media_details']['sizes'] ?? null) ? $media['media_details']['sizes'] : [];
    foreach (['medium_large', 'large', 'medium'] as $size) {
        $url = $sizes[$size]['source_url'] ?? '';
        if (is_string($url) && filter_var($url, FILTER_VALIDATE_URL)) {
            return $url;
        }
    }
    $url = $media['source_url'] ?? '';
    return (is_string($url) && filter_var($url, FILTER_VALIDATE_URL)) ? $url : null;
}

/**
 * @return list<array{title: string, url: string, image: ?string, modified: string}>
 */
function aiken_blog_items_from_rest(int $limit): array
{
    $query = http_build_query([
        'per_page' => $limit,
        'orderby' => 'modified',
        'order' => 'desc',
        '_embed' => 'wp:featuredmedia',
        '_fields' => 'title,link,modified,featured_media,_links,_embedded',
    ]);
    $jsonStr = aiken_http_get(rtrim(BLOG_API_URL, '/') . '?' . $query);
    if ($jsonStr === null || $jsonStr === '') {
        return [];
    }
    $rows = json_decode($jsonStr, true);
    if (!is_array($rows)) {
        return [];
    }

    $items = [];
    foreach ($rows as $row) {
        if (!is_array($row)) {
            continue;
        }
        $title = trim(html_entity_decode(strip_tags((string) ($row['title']['rendered'] ?? '')), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
        $link = trim((string) ($row['link'] ?? ''));
        $modified = trim((string) ($row['modified'] ?? ''));
        if ($title === '' || $link === '' || !filter_var($link, FILTER_VALIDATE_URL)) {
            continue;
        }
        $items[] = [
            'title' => $title,
            'url' => $link,
            'image' => aiken_blog_featured_image_from_embed($row),
            'modified' => $modified,
        ];
    }
    return $items;
}

/**
 * REST 失敗時。RSS は投稿日順のため最終手段。
 *
 * @return list<array{title: string, url: string, image: ?string, modified: string}>
 */
function aiken_blog_items_from_rss(int $limit): array
{
    $xmlStr = aiken_http_get(BLOG_FEED_URL);
    if ($xmlStr === null || $xmlStr === '') {
        return [];
    }

    $prev = libxml_use_internal_errors(true);
    $xml = simplexml_load_string($xmlStr, 'SimpleXMLElement', LIBXML_NOCDATA);
    libxml_clear_errors();
    libxml_use_internal_errors($prev);
    if ($xml === false || !isset($xml->channel->item)) {
        return [];
    }

    $items = [];
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
            'modified' => trim((string) $item->pubDate),
        ];
    }
    return $items;
}

/**
 * @return array{datetime: string, label: string}|null
 */
function aiken_blog_modified_display(string $modified): ?array
{
    $modified = trim($modified);
    if ($modified === '') {
        return null;
    }
    if (preg_match('/^(\d{4})-(\d{2})-(\d{2})/', $modified, $m)) {
        return [
            'datetime' => $m[1] . '-' . $m[2] . '-' . $m[3],
            'label' => ((int) $m[1]) . '年' . ((int) $m[2]) . '月' . ((int) $m[3]) . '日 更新',
        ];
    }
    $ts = @strtotime($modified);
    if ($ts === false) {
        return null;
    }
    return [
        'datetime' => date('Y-m-d', $ts),
        'label' => date('Y年n月j日', $ts) . ' 更新',
    ];
}

/**
 * @return list<array{title: string, url: string, image: ?string, modified: string}>
 */
function get_blog_feed_items(int $limit = 20): array
{
    $limit = max(1, min(50, $limit));
    $cacheDir = __DIR__ . '/../cache';
    $cacheFile = $cacheDir . '/blog-feed-modified.json';
    $ttl = 3600;

    if (is_readable($cacheFile)) {
        $cached = json_decode((string) file_get_contents($cacheFile), true);
        if (is_array($cached) && isset($cached['expires'], $cached['items']) && (int) $cached['expires'] > time()) {
            return array_slice($cached['items'], 0, $limit);
        }
    }

    $items = aiken_blog_items_from_rest($limit);
    if ($items === []) {
        $items = aiken_blog_items_from_rss($limit);
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
