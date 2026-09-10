<?php
/**
 * 級別ページのパンくず（最終CTAの下）
 * @var array $grade_data
 * @var string $grade
 */
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../../config.php';
}

$name = (string) ($grade_data['name'] ?? '');
if ($name === '' || ($grade ?? '') === '') {
    return;
}

?>
<nav class="lp-breadcrumb" aria-label="パンくずリスト">
  <div class="lp-container">
    <ol class="lp-breadcrumb__list">
      <li><a href="/">TOP</a></li>
      <li><a href="/eiken/">英検対策</a></li>
      <li><span aria-current="page"><?php echo htmlspecialchars($name); ?></span></li>
    </ol>
  </div>
</nav>
