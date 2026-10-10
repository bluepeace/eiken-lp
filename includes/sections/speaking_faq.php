<?php
/**
 * スピーキング LP の FAQ
 * @var string $grade
 * @var array $grade_data
 * @var array $speaking
 * @var list<array{q: string, a: string}> $faq_schema_items
 */
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../../config.php';
}
require_once __DIR__ . '/../speaking-data.php';

$name = (string) ($grade_data['name'] ?? '英検');
$faq_items = $faq_schema_items ?? speaking_faq_items((string) ($grade ?? ''), $speaking ?? []);
$faq_id_prefix = 'speaking-faq';
?>
<section class="faq-section border-t border-slate-100 px-4 py-16 sm:py-20" aria-labelledby="speaking-faq-heading">
  <div class="faq-section__inner">
    <p class="faq-section__badge" aria-hidden="true">FAQ</p>
    <h2 id="speaking-faq-heading" class="text-center text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">よくある質問</h2>
    <p class="faq-section__lead mt-3 text-center"><?php echo br_after_period(htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . 'のスピーキング練習を始める前の質問をまとめました。'); ?></p>
    <?php include __DIR__ . '/../faq-accordion.php'; ?>
    <p class="mt-8 text-center">
      <a class="text-sm font-semibold text-[#50c2cb] underline-offset-2 hover:underline" href="/faq">カテゴリ別のよくあるご質問をすべて見る</a>
    </p>
  </div>
</section>
