<?php
/**
 * 級別ライティング LP
 * URL: /3kyu/writing/ /jun2kyu/writing/ /jun2kyu-plus/writing/ /2kyu/writing/ /jun1kyu/writing/ /1kyu/writing/
 */
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/grade-data.php';
require_once __DIR__ . '/includes/writing-data.php';

$level = isset($_GET['level']) ? trim((string) $_GET['level']) : '';
$grade_data = get_grade($level);
$writing = get_writing_content($level);

if ($grade_data === null || $writing === null) {
    header('HTTP/1.1 404 Not Found');
    header('Location: ' . rtrim(SITE_URL, '/') . '/');
    exit;
}

$grade = $level;
$page = 'writing';
$canonical = writing_url($grade);
$meta_override = writing_meta($grade_data, $writing);
$faq_schema_items = writing_faq_items($grade, $writing);
$writing_primary_href = writing_try_url($grade);
$writing_signup_href = writing_signup_url();

$plan_heading = '料金・無料体験';
$plan_heading_id = 'writing-plan';
$plan_lead = '登録なしでは、英作文を<strong>1問</strong>添削できます。登録から' . FREE_TRIAL_DAYS . '日間は、ライティングを<strong>回数の制限なく</strong>練習できます。6日目以降の無料プランは、<strong>1日のAI添削1回</strong>までです。単語は登録後も回数の制限なく使えます。'
    . (open_campaign_active()
        ? 'プレミアムは今なら<strong>' . monthly_price_label() . '</strong>です（OPEN記念価格・定価' . monthly_price_regular_label() . '・' . open_campaign_end_label() . 'まで）。'
        : 'プレミアムは<strong>' . monthly_price_regular_label() . '</strong>です。');

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/sections/writing_hero.php';
include __DIR__ . '/includes/sections/writing_worries.php';
include __DIR__ . '/includes/sections/writing_practice.php';
include __DIR__ . '/includes/sections/writing_example.php';
include __DIR__ . '/includes/sections/writing_points.php';
include __DIR__ . '/includes/sections/writing_reasons.php';
include __DIR__ . '/includes/sections/plan.php';
include __DIR__ . '/includes/sections/writing_faq.php';
include __DIR__ . '/includes/sections/writing_related.php';
include __DIR__ . '/includes/sections/writing_cta.php';
include __DIR__ . '/includes/grade-lightbox.php';
include __DIR__ . '/includes/footer.php';
