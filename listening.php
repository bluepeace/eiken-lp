<?php
/**
 * 級別リスニング LP
 * URL: /5kyu/listening/ から /1kyu/listening/
 */
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/grade-data.php';
require_once __DIR__ . '/includes/listening-data.php';

$level = isset($_GET['level']) ? trim((string) $_GET['level']) : '';
$grade_data = get_grade($level);
$listening = get_listening_content($level);

if ($grade_data === null || $listening === null) {
    header('HTTP/1.1 404 Not Found');
    header('Location: ' . rtrim(SITE_URL, '/') . '/');
    exit;
}

$grade = $level;
$page = 'listening';
$canonical = listening_url($grade);
$meta_override = listening_meta($grade_data, $listening);
$faq_schema_items = listening_faq_items($listening);
$listening_signup_href = listening_signup_url();

$plan_heading = '料金・無料体験';
$plan_heading_id = 'listening-plan';
$plan_lead = '無料登録はメールアドレスだけで始められます。クレジットカードは不要です。登録から' . FREE_TRIAL_DAYS . '日間は、リスニングを<strong>回数の制限なく</strong>練習できます。6日目以降の無料プランは、<strong>1日1セット</strong>までです。' . (string) ($listening['day6'] ?? '') . '単語は登録後も回数の制限なく使えます。'
    . (open_campaign_active()
        ? 'プレミアムは今なら<strong>' . monthly_price_label() . '</strong>です（OPEN記念価格・定価' . monthly_price_regular_label() . '・' . open_campaign_end_label() . 'まで）。'
        : 'プレミアムは<strong>' . monthly_price_regular_label() . '</strong>です。');

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/sections/listening_hero.php';
include __DIR__ . '/includes/sections/listening_worries.php';
include __DIR__ . '/includes/sections/listening_practice.php';
include __DIR__ . '/includes/sections/listening_example.php';
include __DIR__ . '/includes/sections/listening_points.php';
include __DIR__ . '/includes/sections/listening_reasons.php';
include __DIR__ . '/includes/sections/plan.php';
include __DIR__ . '/includes/sections/listening_faq.php';
include __DIR__ . '/includes/sections/listening_related.php';
include __DIR__ . '/includes/sections/listening_cta.php';
include __DIR__ . '/includes/grade-lightbox.php';
include __DIR__ . '/includes/footer.php';
