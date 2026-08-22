<?php
/**
 * 級別SEO LP（英検〇級 対策アプリ）
 * URL: /1kyu/, /jun1kyu/, /2kyu/, /jun2kyu-plus/, /jun2kyu/, /3kyu/, /4kyu/, /5kyu/
 */
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/grade-data.php';

$level = isset($_GET['level']) ? trim($_GET['level']) : '';
$grade_data = get_grade($level);

if (!$grade_data) {
    header('HTTP/1.1 404 Not Found');
    header('Location: ' . rtrim(SITE_URL, '/') . '/');
    exit;
}

$grade = $level;
$page = 'grade';
$canonical = grade_url($grade);
$grade_content = get_grade_content($grade);
if ($grade_content === null) {
    header('HTTP/1.1 404 Not Found');
    header('Location: ' . rtrim(SITE_URL, '/') . '/');
    exit;
}

$faq_schema_items = grade_faq_items($grade_content, $grade_data);
$sections = $grade_content['sections'] ?? ['word', 'reading', 'listening'];

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/sections/grade_seo_hero.php';

if (in_array('word', $sections, true)) {
    include __DIR__ . '/includes/sections/grade_skill_word.php';
}

foreach (['reading', 'listening', 'writing', 'speaking'] as $skill_key) {
    if (!in_array($skill_key, $sections, true)) {
        continue;
    }
    include __DIR__ . '/includes/sections/grade_skill_exam.php';
}

include __DIR__ . '/includes/sections/plan.php';
include __DIR__ . '/includes/sections/howto.php';
include __DIR__ . '/includes/sections/grade_faq.php';
include __DIR__ . '/includes/sections/grade_blog.php';
include __DIR__ . '/includes/sections/cta.php';
include __DIR__ . '/includes/grade-lightbox.php';
include __DIR__ . '/includes/footer.php';
