<?php
/**
 * ほかの級の文法ページ
 * @var string $grade
 * @var array $grade_data
 */
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../../config.php';
}
require_once __DIR__ . '/../grammar-data.php';
require_once __DIR__ . '/../vocabulary-data.php';

$name = (string) ($grade_data['name'] ?? '');
$items = grammar_nav_items();
$parent = '/' . rawurlencode((string) $grade) . '/';
$word_href = vocabulary_page_path((string) $grade);
?>
<section class="border-t border-slate-100 bg-white px-4 py-16 sm:py-20" aria-labelledby="grammar-related-heading">
  <div class="lp-container">
    <div class="mx-auto max-w-3xl text-center">
      <p class="section-badge section-badge--center" aria-hidden="true">GRADES</p>
      <h2 id="grammar-related-heading" class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">ほかの級の文法</h2>
      <p class="mt-3 text-slate-600"><?php echo br_after_period('文法は5級から2級までです。下の級は導入、上の級は使い分けです。1級と準1級のテーマはありません。'); ?></p>
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
    <p class="mt-8 text-center text-sm">
      <a class="font-semibold text-[#50c2cb] underline-offset-2 hover:underline" href="<?php echo htmlspecialchars($parent); ?>"><?php echo htmlspecialchars($name); ?>の対策ページへ</a>
      <?php if ($word_href !== null): ?>
      <span class="mx-2 text-slate-300" aria-hidden="true">/</span>
      <a class="font-semibold text-[#50c2cb] underline-offset-2 hover:underline" href="<?php echo htmlspecialchars($word_href); ?>"><?php echo htmlspecialchars($name); ?>の単語対策へ</a>
      <?php endif; ?>
    </p>
  </div>
</section>
