<?php if (!defined('SITE_NAME')) { require_once __DIR__ . '/../../config.php'; } ?>
<section class="border-t border-slate-100 bg-white px-4 py-8 sm:py-10" aria-label="信頼のポイント">
  <div class="lp-container">
    <div class="flex flex-wrap items-center justify-center gap-6 sm:gap-10 text-slate-600">
      <div class="flex items-center gap-2">
        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#50c2cb]/10 text-[#50c2cb]"><?php echo lp_icon('book-open', 'w-5 h-5'); ?></span>
        <span class="text-sm font-medium">英検5級〜1級対応</span>
      </div>
      <div class="flex items-center gap-2">
        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#50c2cb]/10 text-[#50c2cb]"><?php echo lp_icon('check', 'w-5 h-5'); ?></span>
        <span class="text-sm font-medium">4技能 全対応</span>
      </div>
      <div class="flex items-center gap-2">
        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#50c2cb]/10 text-[#50c2cb]"><?php echo lp_icon('sparkles', 'w-5 h-5'); ?></span>
        <span class="text-sm font-medium">AI添削</span>
      </div>
      <div class="flex items-center gap-2">
        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#50c2cb]/10 text-[#50c2cb]"><?php echo lp_icon('dog', 'w-5 h-5'); ?></span>
        <span class="text-sm font-medium">バディが寄り添う</span>
      </div>
      <div class="flex items-center gap-2">
        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#50c2cb]/10 text-[#50c2cb]"><?php echo lp_icon('badge-check', 'w-5 h-5'); ?></span>
        <span class="text-sm font-medium"><?php echo htmlspecialchars(monthly_price_label(false)); ?></span>
      </div>
    </div>
  </div>
</section>
