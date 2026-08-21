<?php
/**
 * 英検コラム記事の取得（WordPress REST / RSS、キャッシュ付き）
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
 * @return list<array{title: string, url: string, image: ?string, pubDate: string, modDate: string}>
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
                $pubDate = trim((string) $item->pubDate);
                $modDate = $pubDate;
                $atom = $item->children('http://www.w3.org/2005/Atom');
                if ($atom && isset($atom->updated) && trim((string) $atom->updated) !== '') {
                    $modDate = trim((string) $atom->updated);
                }
                $items[] = [
                    'title' => $title,
                    'url' => $link,
                    'image' => $image,
                    'pubDate' => $pubDate,
                    'modDate' => $modDate,
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

function aiken_normalize_blog_url(string $url): string
{
    $parts = parse_url($url);
    if ($parts === false || empty($parts['host'])) {
        return rtrim(strtolower($url), '/');
    }
    $host = strtolower($parts['host']);
    if (str_starts_with($host, 'www.')) {
        $host = substr($host, 4);
    }
    $path = isset($parts['path']) ? rtrim($parts['path'], '/') : '';
    return $host . ($path === '' ? '' : $path);
}

function aiken_html_meta(string $html, string $key): ?string
{
    $k = preg_quote($key, '/');
    $patterns = [
        '/<meta[^>]+(?:property|name)=["\']' . $k . '["\'][^>]*content=["\']([^"\']+)["\']/i',
        '/<meta[^>]+content=["\']([^"\']+)["\'][^>]*(?:property|name)=["\']' . $k . '["\']/i',
    ];
    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $html, $m)) {
            $value = html_entity_decode(trim($m[1]), ENT_QUOTES | ENT_HTML5, 'UTF-8');
            if ($value !== '') {
                return $value;
            }
        }
    }
    return null;
}

function aiken_blog_rest_posts_url(): string
{
    if (defined('BLOG_API_URL') && is_string(BLOG_API_URL) && BLOG_API_URL !== '') {
        return rtrim(BLOG_API_URL, '/');
    }
    return rtrim(SITE_URL, '/') . '/blog/wp-json/wp/v2/posts';
}

function aiken_blog_item_timestamp(array $item): int
{
    foreach (['modDate', 'pubDate'] as $key) {
        if (empty($item[$key])) {
            continue;
        }
        $ts = @strtotime((string) $item[$key]);
        if ($ts) {
            return (int) $ts;
        }
    }
    return 0;
}

/**
 * @param array<string, mixed> $post
 * @return array{title: string, url: string, image: ?string, pubDate: string, modDate: string}|null
 */
function aiken_wp_rest_item_from_post(array $post, string $fallbackUrl = ''): ?array
{
    $title = trim(html_entity_decode(strip_tags((string) ($post['title']['rendered'] ?? '')), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
    $link = trim((string) ($post['link'] ?? $fallbackUrl));
    if ($title === '' || $link === '') {
        return null;
    }
    $image = aiken_blog_featured_image_from_embed($post);
    $pubDate = trim((string) ($post['date'] ?? ''));
    $modDate = trim((string) ($post['modified'] ?? ''));
    if ($modDate === '') {
        $modDate = $pubDate;
    }

    return [
        'title' => $title,
        'url' => $link,
        'image' => $image,
        'pubDate' => $pubDate,
        'modDate' => $modDate,
    ];
}

function aiken_blog_item_from_wp_rest(string $url): ?array
{
    $path = parse_url($url, PHP_URL_PATH);
    if (!is_string($path) || $path === '') {
        return null;
    }
    $segments = array_values(array_filter(explode('/', $path), 'strlen'));
    $slug = $segments ? (string) end($segments) : '';
    if ($slug === '' || $slug === 'blog') {
        return null;
    }

    $api = aiken_blog_rest_posts_url() . '?slug=' . rawurlencode($slug) . '&_embed=1';
    $json = aiken_http_get($api);
    if ($json === null) {
        return null;
    }
    $posts = json_decode($json, true);
    if (!is_array($posts) || $posts === [] || empty($posts[0]) || !is_array($posts[0])) {
        return null;
    }

    return aiken_wp_rest_item_from_post($posts[0], $url);
}

function aiken_blog_item_from_og(string $url): ?array
{
    $html = aiken_http_get($url);
    if ($html === null) {
        return null;
    }
    $title = aiken_html_meta($html, 'og:title');
    if ($title === null && preg_match('/<title[^>]*>(.*?)<\/title>/is', $html, $m)) {
        $title = trim(html_entity_decode(strip_tags($m[1]), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
    }
    if ($title === null || $title === '') {
        return null;
    }
    $image = aiken_html_meta($html, 'og:image');
    if ($image !== null && !filter_var($image, FILTER_VALIDATE_URL)) {
        $image = null;
    }
    $pubDate = aiken_html_meta($html, 'article:published_time') ?? '';
    $modDate = aiken_html_meta($html, 'article:modified_time')
        ?? aiken_html_meta($html, 'og:updated_time')
        ?? $pubDate;

    return [
        'title' => $title,
        'url' => $url,
        'image' => $image,
        'pubDate' => $pubDate,
        'modDate' => $modDate,
    ];
}

function aiken_blog_item_from_url(string $url): ?array
{
    if (!filter_var($url, FILTER_VALIDATE_URL)) {
        return null;
    }
    return aiken_blog_item_from_wp_rest($url) ?? aiken_blog_item_from_og($url);
}

/**
 * 更新日が新しい順の記事一覧（WordPress REST。失敗時は RSS）。
 *
 * @return list<array{title: string, url: string, image: ?string, pubDate: string, modDate: string}>
 */
function get_blog_items_by_modified(int $limit = 20): array
{
    $limit = max(1, min(100, $limit));
    $api = aiken_blog_rest_posts_url() . '?per_page=' . $limit . '&orderby=modified&order=desc&_embed=1';
    $json = aiken_http_get($api);
    $items = [];

    if ($json !== null) {
        $posts = json_decode($json, true);
        if (is_array($posts)) {
            foreach ($posts as $post) {
                if (!is_array($post)) {
                    continue;
                }
                $item = aiken_wp_rest_item_from_post($post);
                if ($item !== null) {
                    $items[] = $item;
                }
            }
        }
    }

    if ($items !== []) {
        return $items;
    }

    $fallback = get_blog_feed_items($limit);
    usort($fallback, static function (array $a, array $b): int {
        return aiken_blog_item_timestamp($b) <=> aiken_blog_item_timestamp($a);
    });

    return $fallback;
}

/**
 * TOPカルーセル用。ピックアップURLを先頭にし、残りを更新日の新しい順で埋める。
 *
 * @param list<string> $pickupUrls
 * @return list<array{title: string, url: string, image: ?string, pubDate: string, modDate: string}>
 */
function get_blog_carousel_items(array $pickupUrls = [], int $limit = 20): array
{
    $limit = max(1, min(50, $limit));
    $pickups = [];
    foreach ($pickupUrls as $url) {
        $url = trim((string) $url);
        if ($url !== '') {
            $pickups[] = $url;
        }
    }

    $cacheDir = __DIR__ . '/../cache';
    $cacheFile = $cacheDir . '/blog-carousel.json';
    $ttl = 3600;
    $pickupKey = md5(json_encode($pickups, JSON_UNESCAPED_SLASHES) . '|modified|' . $limit);

    if (is_readable($cacheFile)) {
        $cached = json_decode((string) file_get_contents($cacheFile), true);
        if (
            is_array($cached)
            && ($cached['key'] ?? '') === $pickupKey
            && (int) ($cached['expires'] ?? 0) > time()
            && isset($cached['items'])
            && is_array($cached['items'])
        ) {
            return $cached['items'];
        }
    }

    $feedLimit = min(100, max(50, $limit + count($pickups)));
    $feed = get_blog_items_by_modified($feedLimit);
    $feedByUrl = [];
    foreach ($feed as $item) {
        $feedByUrl[aiken_normalize_blog_url($item['url'])] = $item;
    }

    $used = [];
    $items = [];

    foreach ($pickups as $url) {
        if (count($items) >= $limit) {
            break;
        }
        $norm = aiken_normalize_blog_url($url);
        if (isset($used[$norm])) {
            continue;
        }
        $item = $feedByUrl[$norm] ?? aiken_blog_item_from_url($url);
        if ($item === null) {
            continue;
        }
        $used[$norm] = true;
        $used[aiken_normalize_blog_url($item['url'])] = true;
        $items[] = $item;
    }

    $rest = [];
    foreach ($feed as $item) {
        $norm = aiken_normalize_blog_url($item['url']);
        if (isset($used[$norm])) {
            continue;
        }
        $rest[] = $item;
    }
    usort($rest, static function (array $a, array $b): int {
        return aiken_blog_item_timestamp($b) <=> aiken_blog_item_timestamp($a);
    });

    foreach ($rest as $item) {
        if (count($items) >= $limit) {
            break;
        }
        $used[aiken_normalize_blog_url($item['url'])] = true;
        $items[] = $item;
    }

    if ($items !== []) {
        if (!is_dir($cacheDir)) {
            @mkdir($cacheDir, 0755, true);
        }
        @file_put_contents(
            $cacheFile,
            json_encode(
                ['key' => $pickupKey, 'expires' => time() + $ttl, 'items' => $items],
                JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
            ),
            LOCK_EX
        );
    }

    return $items;
}
