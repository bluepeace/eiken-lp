<?php if (!defined('SITE_NAME')) { require_once __DIR__ . '/../../config.php'; } ?>
<section class="trust-badges border-t border-[#50c2cb]/15 px-4 py-8 sm:py-10" aria-label="信頼のポイント">
  <div class="lp-container">
    <ul class="trust-badges__grid">
      <li class="trust-badges__item">
        <span class="trust-badges__icon" aria-hidden="true"><?php echo lp_icon('book-open', 'w-5 h-5'); ?></span>
        <span class="trust-badges__label">英検5級〜1級対応</span>
      </li>
      <li class="trust-badges__item">
        <span class="trust-badges__icon" aria-hidden="true"><?php echo lp_icon('check', 'w-5 h-5'); ?></span>
        <span class="trust-badges__label">4技能 全対応</span>
      </li>
      <li class="trust-badges__item">
        <span class="trust-badges__icon" aria-hidden="true"><?php echo lp_icon('sparkles', 'w-5 h-5'); ?></span>
        <span class="trust-badges__label">AI添削</span>
      </li>
      <li class="trust-badges__item">
        <span class="trust-badges__icon" aria-hidden="true"><?php echo lp_icon('clipboard-list', 'w-5 h-5'); ?></span>
        <span class="trust-badges__label">問題数10,000問以上</span>
      </li>
      <li class="trust-badges__item">
        <span class="trust-badges__icon" aria-hidden="true"><?php echo lp_icon('badge-check', 'w-5 h-5'); ?></span>
        <span class="trust-badges__label"><?php echo htmlspecialchars(monthly_price_label(false)); ?></span>
      </li>
    </ul>
  </div>
</section>
