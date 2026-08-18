<?php
if (!defined('SITE_NAME')) { require_once __DIR__ . '/../../config.php'; }
require_once __DIR__ . '/../faq-data.php';
$faq_items = faq_top_items();
$faq_id_prefix = 'top-faq';
?>
<section class="faq-section border-t border-slate-100 px-4 py-16 sm:py-20" aria-labelledby="faq-heading">
  <div class="faq-section__inner">
    <p class="faq-section__badge" aria-hidden="true">FAQ</p>
    <h2 id="faq-heading" class="text-center text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">よくある質問</h2>
    <p class="faq-section__lead mt-3 text-center"><?php echo br_after_period('おすすめの英検対策アプリや、料金・使い方についてまとめました。'); ?></p>
    <?php include __DIR__ . '/../faq-accordion.php'; ?>
    <p class="mt-8 text-center">
      <a class="text-sm font-semibold text-[#50c2cb] underline-offset-2 hover:underline" href="/faq">カテゴリ別のよくあるご質問をすべて見る</a>
    </p>
  </div>
</section>
