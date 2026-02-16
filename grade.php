<?php
/**
 * 級別入り口ページ（英検〇級＋AI対策）
 * URL: /1kyu/, /jun1kyu/, /2kyu/, /jun2kyu/, /3kyu/, /4kyu/, /5kyu/
 */
require_once __DIR__ . '/config.php';

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

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/sections/grade_hero.php';
include __DIR__ . '/includes/sections/grade_features.php';
include __DIR__ . '/includes/sections/grade_cta.php';
include __DIR__ . '/includes/footer.php';
