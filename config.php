<?php
/**
 * LP共通設定（SEO・ドメイン・メタ情報）
 * aiken.life = LP / app.aiken.life = アプリ
 */
define('SITE_NAME', 'AiKen');
define('SITE_READING', 'アイケン');
define('SITE_DESCRIPTION', '英検5級〜1級の勉強法・単語・面接・ライティングをひとつで。AI添削と4技能対策で合格まで寄り添う英検対策アプリ。無料ではじめられます。');
define('SITE_URL', 'https://aiken.life');
define('APP_URL', 'https://app.aiken.life');
define('BRAND_COLOR', '#50c2cb');

// ページ別メタ（キー = ページ識別子）
$PAGE_META = [
    'top' => [
        'title' => SITE_NAME . '（アイケン）| 英検対策アプリ - 勉強法・単語・4技能・面接をAIで',
        'description' => SITE_DESCRIPTION,
        'og_type' => 'website',
    ],
];

/**
 * 級別ページ用データ（URLスラッグ => 表示名・説明）
 * 入り口ページ: /1kyu/, /jun1kyu/, /2kyu/, /jun2kyu/, /3kyu/, /4kyu/, /5kyu/
 */
$GRADES = [
    '1kyu'    => [ 'name' => '英検1級',   'name_short' => '1級',   'description' => '英検1級の単語・リーディング・リスニング・ライティング・スピーキングをAI添削で対策。合格までひとつのアプリで。' ],
    'jun1kyu' => [ 'name' => '英検準1級', 'name_short' => '準1級', 'description' => '英検準1級の単語・リーディング・リスニング・ライティング・スピーキングをAI添削で対策。合格までひとつのアプリで。' ],
    '2kyu'    => [ 'name' => '英検2級',   'name_short' => '2級',   'description' => '英検2級の単語・リーディング・リスニング・ライティング・スピーキングをAI添削で対策。合格までひとつのアプリで。' ],
    'jun2kyu' => [ 'name' => '英検準2級', 'name_short' => '準2級', 'description' => '英検準2級の単語・リーディング・リスニング・ライティング・スピーキングをAI添削で対策。合格までひとつのアプリで。' ],
    '3kyu'    => [ 'name' => '英検3級',   'name_short' => '3級',   'description' => '英検3級の単語・リーディング・リスニング・ライティング・スピーキングをAI添削で対策。合格までひとつのアプリで。' ],
    '4kyu'    => [ 'name' => '英検4級',   'name_short' => '4級',   'description' => '英検4級の単語・リーディングをAIで効率よく対策。合格までひとつのアプリで。' ],
    '5kyu'    => [ 'name' => '英検5級',   'name_short' => '5級',   'description' => '英検5級の単語・リーディングをAIで効率よく対策。合格までひとつのアプリで。' ],
];

function get_page_meta(string $page = 'top'): array {
    global $PAGE_META;
    $meta = $PAGE_META[$page] ?? $PAGE_META['top'];
    return [
        'title' => $meta['title'] ?? SITE_NAME . ' | 英検対策アプリ',
        'description' => $meta['description'] ?? SITE_DESCRIPTION,
        'og_type' => $meta['og_type'] ?? 'website',
    ];
}

function get_grade_meta(string $level): array {
    global $GRADES;
    $g = $GRADES[$level] ?? null;
    if (!$g) {
        return get_page_meta('top');
    }
    $title = $g['name'] . '＋AI対策 | ' . SITE_NAME;
    return [
        'title' => $title,
        'description' => $g['description'],
        'og_type' => 'website',
    ];
}

function get_grade(string $level): ?array {
    global $GRADES;
    return $GRADES[$level] ?? null;
}

function grade_url(string $level): string {
    return rtrim(SITE_URL, '/') . '/' . $level . '/';
}

function asset(string $path): string {
    return rtrim(SITE_URL, '/') . '/' . ltrim($path, '/');
}
