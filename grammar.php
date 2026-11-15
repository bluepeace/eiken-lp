<?php
/**
 * 級別文法 LP
 * URL: /5kyu/grammar/ から /2kyu/grammar/（1級・準1級はない）
 */
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/grade-data.php';
require_once __DIR__ . '/includes/grammar-data.php';

$level = isset($_GET['level']) ? trim((string) $_GET['level']) : '';
$grade_data = get_grade($level);
$grammar = get_grammar_content($level);

if ($grade_data === null || $grammar === null) {
    header('HTTP/1.1 404 Not Found');
    header('Location: ' . rtrim(SITE_URL, '/') . '/');
    exit;
}

$grade = $level;
$page = 'grammar';
$canonical = grammar_url($grade);
$meta_override = grammar_meta($grade_data, $grammar);
$faq_schema_items = grammar_faq_items($grammar);
$grammar_signup_href = grammar_signup_url();

$plan_heading = '料金・プラン';
$plan_heading_id = 'grammar-plan';
$plan_lead = '無料登録はメールアドレスだけで始められます。クレジットカードは不要です。文法は5級から2級まで、登録後も<strong>回数の制限なく</strong>使えます。1日1セットには入りません。リーディング・リスニング・ライティング・スピーキングは、登録から' . FREE_TRIAL_DAYS . '日間は回数の制限がなく、6日目以降の無料プランは<strong>1日1セット</strong>です。単語も登録後も回数の制限なく使えます。';

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/sections/grammar_hero.php';
include __DIR__ . '/includes/sections/grammar_points.php';
include __DIR__ . '/includes/sections/grammar_flow.php';
include __DIR__ . '/includes/sections/grammar_themes.php';
include __DIR__ . '/includes/sections/plan.php';
include __DIR__ . '/includes/sections/grammar_faq.php';
include __DIR__ . '/includes/sections/skill_column.php';
include __DIR__ . '/includes/sections/lp_updates.php';
include __DIR__ . '/includes/sections/grammar_related.php';
include __DIR__ . '/includes/sections/grammar_cta.php';
include __DIR__ . '/includes/grade-lightbox.php';
include __DIR__ . '/includes/footer.php';
