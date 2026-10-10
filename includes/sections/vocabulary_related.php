<?php
/**
 * 他級の単語ページと、級の単語記事
 * @var string $grade
 * @var array $grade_data
 * @var array $vocabulary
 */
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../../config.php';
}
require_once __DIR__ . '/../vocabulary-data.php';
require_once __DIR__ . '/../eiken-hub-data.php';

$name = (string) ($grade_data['name'] ?? '');
$items = vocabulary_nav_items();
$parent = '/' . rawurlencode((string) $grade) . '/';
$blog_slug = (string) ($vocabulary['blog_slug'] ?? '');
$blog_href = $blog_slug !== '' ? eiken_blog_url($blog_slug) : '';
?>
<section class="border-t border-slate-100 bg-white px-4 py-16 sm:py-20" aria-labelledby="vocabulary-related-heading">
  <div class="lp-container">
    <div class="mx-auto max-w-3xl text-center">
      <p class="section-badge section-badge--center" aria-hidden="true">GRADES</p>
      <h2 id="vocabulary-related-heading" class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">ほかの級の単語対策</h2>
      <p class="mt-3 text-slate-600"><?php echo br_after_period('単語クイズは、5級から1級まで同じアプリで練習できます。出題は全級とも10問、4択、間違えた語は最大4問です。'); ?></p>
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
      <?php if ($blog_href !== ''): ?>
      <a class="text-sm font-semibold text-[#50c2cb] underline-offset-2 hover:underline" href="<?php echo htmlspecialchars($blog_href); ?>"><?php echo htmlspecialchars($name); ?>の単語・語彙対策の記事を見る</a>
      <span class="mx-2 text-slate-300" aria-hidden="true">/</span>
      <?php endif; ?>
      <a class="text-sm font-semibold text-[#50c2cb] underline-offset-2 hover:underline" href="<?php echo htmlspecialchars($parent); ?>"><?php echo htmlspecialchars($name); ?>の対策ページへ</a>
    </p>
  </div>
</section>
