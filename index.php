<?php
/**
 * AiKen LP - TOP
 * aiken.life 用ランディングページ（SEO特化）
 */
$page = 'top';
require_once __DIR__ . '/config.php';
$canonical = rtrim(SITE_URL, '/') . '/';

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/sections/hero.php';
include __DIR__ . '/includes/sections/trust_badges.php';
include __DIR__ . '/includes/sections/intro.php';
include __DIR__ . '/includes/sections/problems.php';
include __DIR__ . '/includes/sections/features.php';
include __DIR__ . '/includes/sections/target.php';
include __DIR__ . '/includes/sections/grade_links.php';
include __DIR__ . '/includes/sections/benefits.php';
include __DIR__ . '/includes/sections/howto.php';
include __DIR__ . '/includes/sections/faq.php';
include __DIR__ . '/includes/sections/cta.php';
include __DIR__ . '/includes/footer.php';
