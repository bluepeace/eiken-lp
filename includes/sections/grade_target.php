<?php
/**
 * 級別・おすすめの人（TOP target と同じカード型）
 * @var array $grade_content
 */
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../../config.php';
}

$target = $grade_content['target'] ?? null;
if (!is_array($target) || empty($target['items'])) {
    return;
}

$heading = (string) ($target['heading'] ?? 'こんな方におすすめです');
$lead = (string) ($target['lead'] ?? '');
$items = $target['items'];
?>
<section class="border-t border-slate-100 bg-slate-50/50 px-4 py-16 sm:py-20" aria-labelledby="grade-target-heading">
  <div class="lp-container">
    <p class="section-badge section-badge--center" aria-hidden="true">FOR YOU</p>
    <h2 id="grade-target-heading" class="text-center text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl"><?php echo $heading; ?></h2>
    <?php if ($lead !== ''): ?>
    <p class="mt-3 text-center text-slate-600"><?php echo br_after_period($lead); ?></p>
    <?php endif; ?>
    <div class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
      <?php foreach ($items as $item):
          $title = (string) ($item['title'] ?? '');
          $text = (string) ($item['text'] ?? '');
          $image = (string) ($item['image'] ?? '');
          $alt = (string) ($item['alt'] ?? $title);
          $span = (string) ($item['span'] ?? '');
          ?>
      <div class="flex items-start gap-4 rounded-xl border border-slate-200 bg-white p-5 shadow-sm<?php echo $span !== '' ? ' ' . htmlspecialchars($span) : ''; ?>">
        <?php if ($image !== ''): ?>
        <img
          src="<?php echo htmlspecialchars($image); ?>"
          alt="<?php echo htmlspecialchars($alt); ?>"
          width="96"
          height="96"
          class="target-avatar h-12 w-12 shrink-0 rounded-full object-cover ring-2 ring-white shadow-sm"
          loading="lazy"
          decoding="async"
        >
        <?php endif; ?>
        <div>
          <p class="font-semibold text-slate-800"><?php echo htmlspecialchars($title); ?></p>
          <?php if ($text !== ''): ?>
          <p class="mt-1 text-sm text-slate-600"><?php echo br_after_period($text); ?></p>
          <?php endif; ?>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
