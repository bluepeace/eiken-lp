<?php if (!defined('SITE_NAME')) { require_once __DIR__ . '/../../config.php'; } ?>
<section class="trust-badges border-t border-[#50c2cb]/15 px-4 py-8 sm:py-10" aria-label="信頼のポイント">
  <div class="lp-container">
    <div class="flex flex-wrap items-center justify-center gap-6 sm:gap-10">
      <div class="trust-badges__item">
        <span class="trust-badges__icon text-[#50c2cb]"><?php echo lp_icon('book-open', 'w-5 h-5'); ?></span>
        <span class="trust-badges__label">英検5級〜1級対応</span>
      </div>
      <div class="trust-badges__item">
        <span class="trust-badges__icon text-[#50c2cb]"><?php echo lp_icon('check', 'w-5 h-5'); ?></span>
        <span class="trust-badges__label">4技能 全対応</span>
      </div>
      <div class="trust-badges__item">
        <span class="trust-badges__icon text-[#50c2cb]"><?php echo lp_icon('sparkles', 'w-5 h-5'); ?></span>
        <span class="trust-badges__label">AI添削</span>
      </div>
      <div class="trust-badges__item">
        <span class="trust-badges__icon text-[#50c2cb]"><?php echo lp_icon('dog', 'w-5 h-5'); ?></span>
        <span class="trust-badges__label">バディが寄り添う</span>
      </div>
      <div class="trust-badges__item">
        <span class="trust-badges__icon text-[#50c2cb]"><?php echo lp_icon('badge-check', 'w-5 h-5'); ?></span>
        <span class="trust-badges__label"><?php echo htmlspecialchars(monthly_price_label(false)); ?></span>
      </div>
    </div>
  </div>
</section>
