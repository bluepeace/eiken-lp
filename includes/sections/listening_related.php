<?php
/**
 * 他級のリスニングページと、親の級ページ
 * @var string $grade
 * @var array $grade_data
 */
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../../config.php';
}
require_once __DIR__ . '/../listening-data.php';
require_once __DIR__ . '/../reading-data.php';
require_once __DIR__ . '/../writing-data.php';
require_once __DIR__ . '/../speaking-data.php';

$name = (string) ($grade_data['name'] ?? '');
$items = listening_nav_items();
$parent = '/' . rawurlencode((string) $grade) . '/';
$more = ['単語'];
if (reading_page_path((string) $grade) !== null) {
    $more[] = 'リーディング';
}
if (writing_page_path((string) $grade) !== null) {
    $more[] = 'ライティング';
}
if (speaking_page_path((string) $grade) !== null) {
    $more[] = 'スピーキング';
}
?>
<section class="border-t border-slate-100 bg-white px-4 py-16 sm:py-20" aria-labelledby="listening-related-heading">
  <div class="lp-container">
    <div class="mx-auto max-w-3xl text-center">
      <p class="section-badge section-badge--center" aria-hidden="true">GRADES</p>
      <h2 id="listening-related-heading" class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">ほかの級のリスニング対策</h2>
      <p class="mt-3 text-slate-600"><?php echo br_after_period('リスニングは、5級から1級まで同じアプリで練習できます。'); ?></p>
    </div>
    <ul class="speaking-related mt-8">
      <?php foreach ($items as $item):
          $current = $item['slug'] === $grade;
          ?>
      <li>
        <?php if ($current): ?>
        <span class="speaking-related__link is-current" aria-current="page"><?php echo htmlspecialchars($item['name']); ?></span>
        <?php else: ?>
        <a class="speaking-related__link" href="<?php echo htmlspecialchars($item['href']); ?>"><?php echo htmlspecialchars($item['name']); ?></a>
        <?php endif; ?>
      </li>
      <?php endforeach; ?>
    </ul>
    <p class="mt-8 text-center">
      <a class="text-sm font-semibold text-[#50c2cb] underline-offset-2 hover:underline" href="<?php echo htmlspecialchars($parent); ?>"><?php echo htmlspecialchars($name . 'の' . implode('・', $more) . 'も見る'); ?></a>
    </p>
  </div>
</section>
