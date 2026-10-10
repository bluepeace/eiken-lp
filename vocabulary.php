<?php
/**
 * 級別単語 LP
 * URL: /5kyu/vocabulary/ から /1kyu/vocabulary/
 */
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/grade-data.php';
require_once __DIR__ . '/includes/vocabulary-data.php';

$level = isset($_GET['level']) ? trim((string) $_GET['level']) : '';
$grade_data = get_grade($level);
$vocabulary = get_vocabulary_content($level);

if ($grade_data === null || $vocabulary === null) {
    header('HTTP/1.1 404 Not Found');
    header('Location: ' . rtrim(SITE_URL, '/') . '/');
    exit;
}

$grade = $level;
$page = 'vocabulary';
$canonical = vocabulary_url($grade);
$meta_override = vocabulary_meta($grade_data, $vocabulary);
$faq_schema_items = vocabulary_faq_items($vocabulary);
$vocabulary_try_href = vocabulary_try_url($grade);
$vocabulary_signup_href = vocabulary_signup_url();

$plan_heading = '料金・無料体験';
$plan_heading_id = 'vocabulary-plan';
$plan_lead = '登録なしで、単語クイズを<strong>3セット</strong>まで解けます。1セット10問です。履歴は残りません。無料登録のあと、単語クイズは<strong>回数の制限なく</strong>続けられます。5日を過ぎても、1日1セットにはなりません。間違えた語の優先出題と履歴は、登録後に有効です。リーディング、リスニング、ライティング、スピーキングは、登録から' . FREE_TRIAL_DAYS . '日間は回数の制限がありません。6日目以降は1日1セットです。'
    . (open_campaign_active()
        ? 'プレミアムは今なら<strong>' . monthly_price_label() . '</strong>です（OPEN記念価格・定価' . monthly_price_regular_label() . '・' . open_campaign_end_label() . 'まで）。'
        : 'プレミアムは<strong>' . monthly_price_regular_label() . '</strong>です。')
    . '単語のためだけにプレミアムは要りません。';

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/sections/vocabulary_hero.php';
include __DIR__ . '/includes/sections/vocabulary_worries.php';
include __DIR__ . '/includes/sections/vocabulary_practice.php';
include __DIR__ . '/includes/sections/vocabulary_example.php';
include __DIR__ . '/includes/sections/vocabulary_points.php';
include __DIR__ . '/includes/sections/vocabulary_reasons.php';
include __DIR__ . '/includes/sections/plan.php';
include __DIR__ . '/includes/sections/vocabulary_faq.php';
include __DIR__ . '/includes/sections/vocabulary_related.php';
include __DIR__ . '/includes/sections/vocabulary_cta.php';
include __DIR__ . '/includes/grade-lightbox.php';
include __DIR__ . '/includes/footer.php';
