<?php
if (!isset($faq_items) || !is_array($faq_items)) {
    return;
}
$faq_id_prefix = $faq_id_prefix ?? 'faq';
?>
<div class="faq-list">
  <?php foreach ($faq_items as $i => $faq):
      $item_id = $faq_id_prefix . '-' . ($i + 1);
      ?>
  <details class="faq-item" id="<?php echo htmlspecialchars($item_id); ?>">
    <summary class="faq-item__summary">
      <span class="faq-mark faq-mark--q" aria-hidden="true">Q</span>
      <span class="faq-item__question"><?php echo htmlspecialchars($faq['q']); ?></span>
      <span class="faq-item__toggle" aria-hidden="true"></span>
    </summary>
    <div class="faq-item__answer">
      <span class="faq-mark faq-mark--a" aria-hidden="true">A</span>
      <div class="faq-item__body"><?php echo br_after_period(nl2br(htmlspecialchars($faq['a']))); ?></div>
    </div>
  </details>
  <?php endforeach; ?>
</div>
