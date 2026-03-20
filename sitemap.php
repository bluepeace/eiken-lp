<?php
/**
 * XML サイトマップ（https://aiken.life/sitemap.xml で配信）
 * SITE_URL・$GRADES から URL を生成
 */
declare(strict_types=1);

require_once __DIR__ . '/config.php';

header('Content-Type: application/xml; charset=UTF-8');

$base = rtrim(SITE_URL, '/');
$lastmod = gmdate('Y-m-d');

$esc = static function (string $s): string {
    return htmlspecialchars($s, ENT_XML1 | ENT_COMPAT, 'UTF-8');
};

/** @var list<array{loc: string, changefreq: string, priority: string}> $entries */
$entries = [];

$entries[] = ['loc' => $base . '/', 'changefreq' => 'weekly', 'priority' => '1.0'];
$entries[] = ['loc' => $base . '/about', 'changefreq' => 'monthly', 'priority' => '0.8'];
$entries[] = ['loc' => $base . '/faq', 'changefreq' => 'monthly', 'priority' => '0.8'];
$entries[] = ['loc' => $base . '/terms', 'changefreq' => 'monthly', 'priority' => '0.5'];
$entries[] = ['loc' => $base . '/privacy', 'changefreq' => 'monthly', 'priority' => '0.5'];
$entries[] = ['loc' => $base . '/blog/', 'changefreq' => 'weekly', 'priority' => '0.7'];
// /tokushoho は noindex のためサイトマップに含めない

foreach (array_keys($GRADES) as $level) {
    $entries[] = [
        'loc' => grade_url($level),
        'changefreq' => 'weekly',
        'priority' => '0.9',
    ];
}

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

foreach ($entries as $e) {
    echo "  <url>\n";
    echo '    <loc>' . $esc($e['loc']) . "</loc>\n";
    echo '    <lastmod>' . $esc($lastmod) . "</lastmod>\n";
    echo '    <changefreq>' . $esc($e['changefreq']) . "</changefreq>\n";
    echo '    <priority>' . $esc($e['priority']) . "</priority>\n";
    echo "  </url>\n";
}

echo '</urlset>';
