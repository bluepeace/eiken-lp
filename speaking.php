<?php
/**
 * 級別スピーキング LP
 * URL: /3kyu/speaking/ /jun2kyu/speaking/ /jun2kyu-plus/speaking/ /2kyu/speaking/ /jun1kyu/speaking/ /1kyu/speaking/
 */
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/grade-data.php';
require_once __DIR__ . '/includes/speaking-data.php';

$level = isset($_GET['level']) ? trim((string) $_GET['level']) : '';
$grade_data = get_grade($level);
$speaking = get_speaking_content($level);

if ($grade_data === null || $speaking === null) {
    header('HTTP/1.1 404 Not Found');
    header('Location: ' . rtrim(SITE_URL, '/') . '/');
    exit;
}

$grade = $level;
$page = 'speaking';
$canonical = speaking_url($grade);
$meta_override = speaking_meta($grade_data, $speaking);
$faq_schema_items = speaking_faq_items($grade, $speaking);
$speaking_primary_href = !empty($speaking['has_try'])
    ? speaking_try_url($grade)
    : speaking_signup_url();

$plan_heading = '料金・無料体験';
$plan_heading_id = 'speaking-plan';
$plan_lead = '登録から' . FREE_TRIAL_DAYS . '日間は、スピーキングを<strong>回数の制限なく</strong>練習できます。6日目以降の無料プランは<strong>1日1セット</strong>です。プレミアムはその後も使い放題です。'
    . (open_campaign_active()
        ? 'プレミアムは今なら<strong>' . monthly_price_label() . '</strong>です（OPEN記念価格・定価' . monthly_price_regular_label() . '・' . open_campaign_end_label() . 'まで）。'
        : 'プレミアムは<strong>' . monthly_price_regular_label() . '</strong>です。');

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/sections/speaking_hero.php';
include __DIR__ . '/includes/sections/speaking_practice.php';
include __DIR__ . '/includes/sections/speaking_example.php';
include __DIR__ . '/includes/sections/speaking_points.php';
include __DIR__ . '/includes/sections/plan.php';
include __DIR__ . '/includes/sections/speaking_faq.php';
include __DIR__ . '/includes/sections/speaking_related.php';
include __DIR__ . '/includes/sections/speaking_cta.php';
include __DIR__ . '/includes/grade-lightbox.php';
include __DIR__ . '/includes/footer.php';
