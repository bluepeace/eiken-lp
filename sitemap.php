<?php
/**
 * XML サイトマップ（https://aiken.life/sitemap.xml で配信）
 * SITE_URL・$GRADES から URL を生成
 */
declare(strict_types=1);

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/speaking-data.php';
require_once __DIR__ . '/includes/writing-data.php';
require_once __DIR__ . '/includes/reading-data.php';
require_once __DIR__ . '/includes/listening-data.php';
require_once __DIR__ . '/includes/vocabulary-data.php';

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
$entries[] = ['loc' => $base . '/parents', 'changefreq' => 'monthly', 'priority' => '0.8'];
$entries[] = ['loc' => $base . '/guide', 'changefreq' => 'monthly', 'priority' => '0.7'];
$entries[] = ['loc' => $base . '/eiken/', 'changefreq' => 'weekly', 'priority' => '0.9'];
$entries[] = ['loc' => $base . '/faq', 'changefreq' => 'monthly', 'priority' => '0.8'];
$entries[] = ['loc' => $base . '/plan', 'changefreq' => 'monthly', 'priority' => '0.8'];
$entries[] = ['loc' => $base . '/cancel', 'changefreq' => 'yearly', 'priority' => '0.5'];
$entries[] = ['loc' => $base . '/company', 'changefreq' => 'yearly', 'priority' => '0.5'];
$entries[] = ['loc' => $base . '/terms', 'changefreq' => 'monthly', 'priority' => '0.5'];
$entries[] = ['loc' => $base . '/privacy', 'changefreq' => 'monthly', 'priority' => '0.5'];
$entries[] = ['loc' => $base . '/external-transmission', 'changefreq' => 'yearly', 'priority' => '0.4'];
$entries[] = ['loc' => $base . '/contact', 'changefreq' => 'yearly', 'priority' => '0.4'];
$entries[] = ['loc' => $base . '/blog/', 'changefreq' => 'weekly', 'priority' => '0.7'];
// /tokushoho は noindex のためサイトマップに含めない

foreach (array_keys($GRADES) as $level) {
    $entries[] = [
        'loc' => grade_url($level),
        'changefreq' => 'weekly',
        'priority' => '0.9',
    ];
}

foreach (speaking_grade_slugs() as $level) {
    $speaking_path = speaking_page_path($level);
    if ($speaking_path === null) {
        continue;
    }
    $entries[] = [
        'loc' => $base . $speaking_path,
        'changefreq' => 'weekly',
        'priority' => '0.8',
    ];
}

foreach (vocabulary_grade_slugs() as $level) {
    $vocabulary_path = vocabulary_page_path($level);
    if ($vocabulary_path === null) {
        continue;
    }
    $entries[] = [
        'loc' => $base . $vocabulary_path,
        'changefreq' => 'weekly',
        'priority' => '0.8',
    ];
}

foreach (listening_grade_slugs() as $level) {
    $listening_path = listening_page_path($level);
    if ($listening_path === null) {
        continue;
    }
    $entries[] = [
        'loc' => $base . $listening_path,
        'changefreq' => 'weekly',
        'priority' => '0.8',
    ];
}

foreach (reading_grade_slugs() as $level) {
    $reading_path = reading_page_path($level);
    if ($reading_path === null) {
        continue;
    }
    $entries[] = [
        'loc' => $base . $reading_path,
        'changefreq' => 'weekly',
        'priority' => '0.8',
    ];
}

foreach (writing_grade_slugs() as $level) {
    $writing_path = writing_page_path($level);
    if ($writing_path === null) {
        continue;
    }
    $entries[] = [
        'loc' => $base . $writing_path,
        'changefreq' => 'weekly',
        'priority' => '0.8',
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
