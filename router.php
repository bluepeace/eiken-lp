<?php
/**
 * PHP 組み込みサーバー用ルーター
 * 使い方: php -S localhost:8000 router.php
 *
 * .htaccess の Rewrite に相当（級別 URL など）
 */
declare(strict_types=1);

$uri = rawurldecode(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/');
$path = __DIR__ . $uri;

if ($uri !== '/' && $uri !== '' && is_file($path)) {
    return false;
}

if (preg_match('#^/sitemap\.xml$#', $uri)) {
    require __DIR__ . '/sitemap.php';
    return true;
}

if (preg_match('#^/(1kyu|jun1kyu|2kyu|jun2kyu|3kyu|4kyu|5kyu)/?$#', $uri, $m)) {
    $_GET['level'] = $m[1];
    require __DIR__ . '/grade.php';
    return true;
}

if (preg_match('#^/about/?$#', $uri)) {
    require __DIR__ . '/about.php';
    return true;
}

if (preg_match('#^/faq/?$#', $uri)) {
    require __DIR__ . '/faq.php';
    return true;
}

if (preg_match('#^/tokushoho/?$#', $uri)) {
    require __DIR__ . '/tokushoho.php';
    return true;
}

if (preg_match('#^/terms/?$#', $uri)) {
    require __DIR__ . '/terms.php';
    return true;
}

if (preg_match('#^/privacy/?$#', $uri)) {
    require __DIR__ . '/privacy.php';
    return true;
}

if ($uri === '/' || $uri === '') {
    require __DIR__ . '/index.php';
    return true;
}

http_response_code(404);
header('Content-Type: text/plain; charset=utf-8');
echo '404 Not Found';
