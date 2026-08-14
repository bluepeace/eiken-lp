<?php
/**
 * LP共通設定（SEO・ドメイン・メタ情報）
 * aiken.life = LP / app.aiken.life = アプリ
 */
define('SITE_NAME', 'AiKen');
define('SITE_READING', 'アイケン');
define('SITE_DESCRIPTION', '英検対策アプリAiKen（アイケン）。5級〜1級を本試験形式で対策。単語・リスニング・ライティング・スピーキング・AI採点。10,000問超。月額980円・5日間無料体験。');
define('SITE_URL', 'https://aiken.life');
define('APP_URL', 'https://app.aiken.life');
/** LP フッター著作権表示のリンク先 */
define('BLUEPIECE_LAB_URL', 'https://bluepiece.me/link');
define('BRAND_COLOR', '#50c2cb');
/** キーカラーより濃いテキスト用（キャッチコピーなど） */
define('BRAND_TEXT_COLOR', '#00a2af');
/** LP 本文・ナビの統一テキスト色 */
define('LP_TEXT_COLOR', '#232323');
/** 月額プラン料金（税込・円）。OPEN記念価格。LP・FAQ・特商法など表示の一元管理用 */
define('MONTHLY_PRICE', 980);
/** 月額プランの定価（税込・円） */
define('MONTHLY_PRICE_REGULAR', 1480);
/** OPEN記念価格の適用終了日（Y-m-d・当日まで有効） */
define('OPEN_CAMPAIGN_END', '2026-12-31');
/** 無料体験日数（正式オープン以降） */
define('FREE_TRIAL_DAYS', 5);

require_once __DIR__ . '/includes/icons.php';
/** 英検コラム（WordPress）RSS */
define('BLOG_FEED_URL', 'https://aiken.life/blog/feed/');

// ページ別メタ（キー = ページ識別子）
$PAGE_META = [
    'top' => [
        'title' => '英検対策アプリ｜AiKen（アイケン）5級〜1級・本試験形式',
        'description' => SITE_DESCRIPTION,
        'og_type' => 'website',
    ],
    'about' => [
        'title' => '英検対策アプリ AiKen（アイケン）とは｜5級〜1級・本試験形式',
        'description' => '英検対策アプリAiKen（アイケン）のご紹介。5級〜1級を本試験形式で対策。単語・リスニング・ライティング・スピーキング・AI採点。10,000問超。月額980円・5日間無料体験。',
        'og_type' => 'website',
    ],
    'faq' => [
        'title' => 'よくあるご質問（FAQ）｜AiKen（アイケン）英検対策',
        'description' => 'AiKenの使い方、料金、英検の級や4技能対策、保護者の方へ、利用環境など、よくあるご質問をカテゴリ別にまとめました。',
        'og_type' => 'website',
    ],
    'plan' => [
        'title' => '英検対策アプリの料金｜AiKen（アイケン）OPEN記念価格 月額980円',
        'description' => '英検対策アプリAiKen（アイケン）の料金。OPEN記念価格で月額980円（税込・定価1,480円・2026年12月31日まで）。5日間無料体験ののち、サブスクリプション課金。',
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
    '1kyu'    => [ 'name' => '英検1級',   'name_short' => '1級',   'description' => '英検1級対策アプリAiKen。単語・リーディング・リスニング・ライティング・スピーキングを本試験形式で対策。AI採点・10,000問超。' ],
    'jun1kyu' => [ 'name' => '英検準1級', 'name_short' => '準1級', 'description' => '英検準1級対策アプリAiKen。単語・リーディング・リスニング・ライティング・スピーキングを本試験形式で対策。AI採点・10,000問超。' ],
    '2kyu'    => [ 'name' => '英検2級',   'name_short' => '2級',   'description' => '英検2級対策アプリAiKen。単語・リーディング・リスニング・ライティング・スピーキングを本試験形式で対策。AI採点・10,000問超。' ],
    'jun2kyu' => [ 'name' => '英検準2級', 'name_short' => '準2級', 'description' => '英検準2級対策アプリAiKen。単語・リーディング・リスニング・ライティング・スピーキングを本試験形式で対策。AI採点・10,000問超。' ],
    '3kyu'    => [ 'name' => '英検3級',   'name_short' => '3級',   'description' => '英検3級対策アプリAiKen。単語・リーディング・リスニング・ライティング・スピーキングを本試験形式で対策。AI採点・10,000問超。' ],
    '4kyu'    => [ 'name' => '英検4級',   'name_short' => '4級',   'description' => '英検4級対策アプリAiKen。単語・リーディングを本試験形式で効率よく対策。10,000問超。' ],
    '5kyu'    => [ 'name' => '英検5級',   'name_short' => '5級',   'description' => '英検5級対策アプリAiKen。単語・リーディングを本試験形式で効率よく対策。10,000問超。' ],
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
    $title = $g['name'] . '対策アプリ｜' . SITE_NAME . '（' . SITE_READING . '）';
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

function format_yen(int $amount): string {
    return number_format($amount) . '円';
}

/** @param bool $with_tax 末尾に（税込）を付ける */
function monthly_price_label(bool $with_tax = true): string {
    $label = '月額' . format_yen(MONTHLY_PRICE);
    return $with_tax ? $label . '（税込）' : $label;
}

/** @param bool $with_tax 末尾に（税込）を付ける */
function monthly_price_regular_label(bool $with_tax = true): string {
    $label = '月額' . format_yen(MONTHLY_PRICE_REGULAR);
    return $with_tax ? $label . '（税込）' : $label;
}

function open_campaign_active(): bool {
    return time() <= strtotime(OPEN_CAMPAIGN_END . ' 23:59:59');
}

/** 例: 2026年12月31日 */
function open_campaign_end_label(): string {
    $ts = strtotime(OPEN_CAMPAIGN_END);
    return $ts ? date('Y年n月j日', $ts) : OPEN_CAMPAIGN_END;
}
