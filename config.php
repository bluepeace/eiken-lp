<?php
/**
 * LP共通設定（SEO・ドメイン・メタ情報）
 * aiken.life = LP / app.aiken.life = アプリ
 */
define('SITE_NAME', 'AiKen');
define('SITE_READING', 'アイケン');
define('SITE_DESCRIPTION', '英検対策×AIのAiKen（アイケン）。5級〜1級の勉強法・単語・面接・ライティングをひとつで。AI添削と4技能対策で合格まで寄り添う英検対策アプリ。無料ではじめられます。');
define('SITE_URL', 'https://aiken.life');
define('APP_URL', 'https://app.aiken.life');
/** LP フッター著作権表示のリンク先 */
define('BLUEPIECE_LAB_URL', 'https://bluepiece.me/link');
define('BRAND_COLOR', '#50c2cb');
/** 英検コラム（WordPress）RSS */
define('BLOG_FEED_URL', 'https://aiken.life/blog/feed/');

// ページ別メタ（キー = ページ識別子）
$PAGE_META = [
    'top' => [
        'title' => 'AiKen（アイケン）｜英検対策×AI',
        'description' => SITE_DESCRIPTION,
        'og_type' => 'website',
    ],
    'about' => [
        'title' => 'AiKen（アイケン）とは｜英検全級×AI×4技能をひとつのアプリで',
        'description' => '初めての方へ。AiKenは英検1級〜5級まで、リーディング・リスニング・ライティング・スピーキングをAIとバディの伴走でまとめて対策できるアプリです。無料で会員登録し、今日から英検勉強をはじめられます。',
        'og_type' => 'website',
    ],
    'faq' => [
        'title' => 'よくあるご質問（FAQ）｜AiKen（アイケン）英検対策',
        'description' => 'AiKenの使い方、料金、英検の級や4技能対策、保護者の方へ、利用環境など、よくあるご質問をカテゴリ別にまとめました。',
        'og_type' => 'website',
    ],
    'tokushoho' => [
        'title' => '特定商取引法に基づく表記｜AiKen（アイケン）',
        'description' => 'AiKen（アイケン）のオンラインサービス（サブスクリプション）に関する特定商取引法に基づく表記です。',
        'og_type' => 'website',
        'robots' => 'noindex, follow',
        'omit_jsonld' => true,
    ],
    'terms' => [
        'title' => '利用規約｜AiKen（アイケン）',
        'description' => 'AiKen（アイケン）のご利用にあたっての利用規約です。',
        'og_type' => 'website',
        'omit_jsonld' => true,
    ],
    'privacy' => [
        'title' => 'プライバシーポリシー｜AiKen（アイケン）',
        'description' => 'AiKen（アイケン）における個人情報の取り扱いについて定めたプライバシーポリシーです。',
        'og_type' => 'website',
        'omit_jsonld' => true,
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
        'robots' => isset($meta['robots']) ? (string) $meta['robots'] : '',
        'omit_jsonld' => !empty($meta['omit_jsonld']),
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
        'robots' => '',
        'omit_jsonld' => false,
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

/** 句点（。）の直後に改行を挿入（index用） */
function br_after_period(string $html): string {
    return str_replace('。', '。<br>', $html);
}
