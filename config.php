<?php
/**
 * LP共通設定（SEO・ドメイン・メタ情報）
 * aiken.life = LP / app.aiken.life = アプリ
 */
define('SITE_NAME', 'AiKen');
define('SITE_READING', 'アイケン');
define('SITE_DESCRIPTION', '英検対策アプリならAiKen（アイケン）。5級〜1級を本試験形式でまとめて対策。単語・読解・リスニング・ライティング・スピーキングにAI採点。10,000問超・月額980円・5日間無料で始められます。');
define('SITE_URL', 'https://aiken.life');
define('APP_URL', 'https://app.aiken.life');
/** LP フッター著作権表示のリンク先 */
define('BLUEPIECE_LAB_URL', 'https://bluepiece.me/link');
define('BRAND_COLOR', '#50c2cb');
/** お問い合わせフォームの受信先・自動返信の From */
define('CONTACT_EMAIL', 'aiken.mame@gmail.com');
define('CONTACT_FROM_NAME', 'AiKen');
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
/** 英検コラム（WordPress）REST API（更新日順） */
define('BLOG_API_URL', 'https://aiken.life/blog/wp-json/wp/v2/posts');
/** 英検コラム RSS（REST 失敗時のフォールバック） */
define('BLOG_FEED_URL', 'https://aiken.life/blog/feed/');
/** TOPコラムカルーセルの表示件数（先頭はピックアップ、残りは最新記事） */
define('BLOG_CAROUSEL_LIMIT', 20);
/**
 * TOPの英検対策コラムで先頭に出す記事URL（指定した順）。
 * 指定以外は更新日の新しい順で埋める。古い記事もこのURLから拾います。
 */
$BLOG_CAROUSEL_PICKUP_URLS = [
    // 'https://aiken.life/blog/example-slug/',
];

// ページ別メタ（キー = ページ識別子）
$PAGE_META = [
    'top' => [
        'title' => '英検対策アプリ｜AiKen（アイケン）5級〜1級・本試験形式',
        'description' => SITE_DESCRIPTION,
        'og_type' => 'website',
    ],
    'about' => [
        'title' => '英検対策アプリ AiKen（アイケン）とは｜5級〜1級・本試験形式',
        'description' => '英検対策アプリAiKenとは？5級〜1級を本試験形式で学べる理由、AI採点、10,000問超の問題量までわかりやすく紹介。月額980円・5日間無料体験つき。',
        'og_type' => 'website',
    ],
    'faq' => [
        'title' => 'よくあるご質問｜おすすめの英検対策アプリAiKen',
        'description' => 'おすすめの英検対策アプリは？料金・級対応・AI採点・無料体験まで、保護者の疑問に答えます。5級〜1級対応のAiKenについて、よくあるご質問をまとめました。',
        'og_type' => 'website',
    ],
    'plan' => [
        'title' => '英検対策アプリの料金｜AiKen（アイケン）OPEN記念価格 月額980円',
        'description' => '英検対策アプリAiKenの料金プラン。5日間は全機能無料、その後はOPEN記念価格で月額980円（税込）。単語からAI添削まで、級を選ばず使い放題。',
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
    'contact' => [
        'title' => 'お問い合わせ｜AiKen（アイケン）',
        'description' => '英検対策アプリAiKen（アイケン）へのお問い合わせフォームです。サービス内容・料金・不具合などについてご連絡ください。',
        'og_type' => 'website',
        'omit_jsonld' => true,
    ],
    'external' => [
        'title' => '外部送信に関する公表｜AiKen（アイケン）',
        'description' => 'AiKen（アイケン）公式サイトにおける、Google Tag Manager等への利用者情報の外部送信についての公表です。',
        'og_type' => 'website',
        'omit_jsonld' => true,
    ],
    'company' => [
        'title' => '会社・運営者情報｜AiKen（アイケン）',
        'description' => '英検対策アプリAiKen（アイケン）の運営者情報。Bluepiece Lab.／事業者名・お問い合わせ先のご案内です。',
        'og_type' => 'website',
        'omit_jsonld' => true,
    ],
    'cancel' => [
        'title' => '退会・解約の手順｜AiKen（アイケン）',
        'description' => 'AiKen（アイケン）のプレミアムプラン解約・退会の手順。アプリ内の「サブスクリプションを管理」からの流れを案内します。',
        'og_type' => 'website',
        'omit_jsonld' => true,
    ],
    'parents' => [
        'title' => '保護者の方へ｜英検対策アプリAiKen（アイケン）',
        'description' => 'お子さまの英検対策、何を選ぶ？保護者向けに料金・安心ポイント・続け方をまとめました。英検対策アプリAiKenは5日間無料・カード登録不要で始められます。',
        'og_type' => 'website',
    ],
    'guide' => [
        'title' => 'はじめての使い方｜英検対策アプリAiKen（アイケン）',
        'description' => '英検対策アプリAiKenの始め方。会員登録から最初の10分の進め方、単語・読解・リスニング・ライティングの使い方まで。5日間無料・カード登録不要で今日から始められます。',
        'og_type' => 'website',
    ],
];

/**
 * 級別ページ用データ（URLスラッグ => 表示名・説明）
 * 入り口: /1kyu/, /jun1kyu/, /2kyu/, /jun2kyu-plus/, /jun2kyu/, /3kyu/, /4kyu/, /5kyu/
 * ナビ表示順はこの配列順。
 */
$GRADES = [
    '1kyu' => [
        'name' => '英検1級',
        'name_short' => '1級',
        'description' => '英検1級の対策アプリならAiKen。難関級の語彙・長文・リスニング・要約／英作文を本試験形式で特訓。AIがその場で添削し、弱点を逃さない。10,000問超・月額980円・5日間無料。',
    ],
    'jun1kyu' => [
        'name' => '英検準1級',
        'name_short' => '準1級',
        'description' => '英検準1級対策アプリならAiKen。大学中級レベルの単語・読解・リスニング・要約／英作文を本試験形式で。AIリアルタイム添削でライティングも安心。10,000問超・月額980円・5日間無料。',
    ],
    '2kyu' => [
        'name' => '英検2級',
        'name_short' => '2級',
        'description' => '英検2級対策アプリを探すならAiKen。高校卒業程度の単語・読解・リスニング・要約／英作文を本試験形式で。通学のスキマでも進む。AI添削・10,000問超・月額980円・5日間無料。',
    ],
    'jun2kyu-plus' => [
        'name' => '英検準2級プラス',
        'name_short' => '準2級プラス',
        'description' => '英検準2級プラスの対策アプリはAiKen。準2級と2級のあいだを埋める級を、本試験形式でしっかり特訓。要約・英作文はAI添削。10,000問超・月額980円・5日間無料。',
    ],
    'jun2kyu' => [
        'name' => '英検準2級',
        'name_short' => '準2級',
        'description' => '英検準2級対策アプリならAiKen。単語・読解・リスニングに加え、Eメール／英作文・スピーキングも本試験形式。面接練習もAI採点。10,000問超・月額980円・5日間無料。',
    ],
    '3kyu' => [
        'name' => '英検3級',
        'name_short' => '3級',
        'description' => '英検3級の対策アプリをお探しならAiKen。中学卒業レベルの単語・読解・リスニング・Eメール／英作文を本試験形式で。初めての作文もAI添削で安心。10,000問超・月額980円・5日間無料。',
    ],
    '4kyu' => [
        'name' => '英検4級',
        'name_short' => '4級',
        'description' => '英検4級対策は、楽しく続くアプリで。AiKenなら単語・リーディング・リスニングを本試験形式で特訓。間違えた問題だけ復習できるから続く。10,000問超・月額980円・5日間無料。',
    ],
    '5kyu' => [
        'name' => '英検5級',
        'name_short' => '5級',
        'description' => 'はじめての英検5級も、この対策アプリから。AiKenで単語・リーディング・リスニングを本試験形式に。短いクイズで毎日続く。10,000問超・月額980円・5日間無料体験。',
    ],
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

/** ナビ・級一覧用。$GRADES の定義順を返す */
function grade_nav_items(): array {
    global $GRADES;
    $items = [];
    foreach ($GRADES as $slug => $g) {
        $items[] = [
            'slug' => $slug,
            'name' => $g['name'],
            'name_short' => $g['name_short'],
            'href' => '/' . $slug . '/',
        ];
    }
    return $items;
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
