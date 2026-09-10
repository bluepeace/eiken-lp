<?php
/**
 * 級別・信頼ストリップ
 * @var array $grade_content from get_grade_content()
 */
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../../config.php';
}

$trust_items = $grade_content['trust_badges'] ?? [];
if ($trust_items === []) {
    return;
}
?>
<section class="trust-badges border-t border-[#50c2cb]/15 px-4 py-8 sm:py-10" aria-label="この級でできること">
  <div class="lp-container">
    <ul class="trust-badges__grid">
      <?php foreach ($trust_items as $item):
          $icon = (string) ($item['icon'] ?? 'check');
          $label = (string) ($item['label'] ?? '');
          if ($label === '') {
              continue;
          }
          ?>
      <li class="trust-badges__item">
        <span class="trust-badges__icon" aria-hidden="true"><?php echo lp_icon($icon, 'w-5 h-5'); ?></span>
        <span class="trust-badges__label"><?php echo htmlspecialchars($label); ?></span>
      </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
