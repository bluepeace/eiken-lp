<?php
/**
 * 級別・技能別コラムへの内部リンク。
 * @var string $grade
 * @var string $page
 * @var array $grade_data
 */
require_once __DIR__ . '/../skill-column-data.php';
require_once __DIR__ . '/../blog-feed.php';

$column_grade_name = (string) ($grade_data['name'] ?? '英検');
$column = skill_column_data((string) $grade, (string) $page, $column_grade_name);
if ($column === null) {
    return;
}
$column_article = aiken_blog_item_from_url_cached($column['url']);
$column_article_title = trim((string) ($column_article['title'] ?? ''));
if ($column_article_title === '') {
    $column_article_title = $column_grade_name . 'の' . $column['skill_label'] . '対策を詳しく解説';
}
$column_article_image = is_string($column_article['image'] ?? null) ? $column_article['image'] : '';
?>
<section class="border-t border-slate-100 bg-slate-50/60 py-16 sm:py-20" aria-labelledby="skill-column-heading">
  <div class="lp-container px-4">
    <div class="mx-auto max-w-4xl overflow-hidden rounded-3xl border border-[#50c2cb]/25 bg-white shadow-sm">
      <div class="p-6 sm:p-10">
        <p class="section-badge" aria-hidden="true">COLUMN</p>
        <h2 id="skill-column-heading" class="mt-3 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl"><?php echo htmlspecialchars($column_grade_name . 'の' . $column['skill_label'] . 'を、もっと深く学びたい方へ', ENT_QUOTES, 'UTF-8'); ?></h2>
        <p class="mt-4 leading-8 text-slate-600"><?php echo htmlspecialchars($column['lead'], ENT_QUOTES, 'UTF-8'); ?></p>

        <div class="mt-7 overflow-hidden rounded-2xl border border-slate-200 bg-white sm:grid sm:grid-cols-[minmax(0,0.9fr)_minmax(0,1.25fr)]">
          <?php if ($column_article_image !== ''): ?>
          <a class="block aspect-video overflow-hidden bg-slate-100 sm:aspect-auto" href="<?php echo htmlspecialchars($column['url'], ENT_QUOTES, 'UTF-8'); ?>" aria-label="<?php echo htmlspecialchars($column_article_title, ENT_QUOTES, 'UTF-8'); ?>を読む">
            <img src="<?php echo htmlspecialchars($column_article_image, ENT_QUOTES, 'UTF-8'); ?>" alt="" class="h-full w-full object-cover transition duration-300 hover:scale-[1.03]" width="576" height="324" loading="lazy" decoding="async">
          </a>
          <?php endif; ?>
          <div class="p-5 sm:p-6<?php echo $column_article_image === '' ? ' sm:col-span-2' : ''; ?>">
            <p class="text-xs font-bold tracking-wider text-[#008b96]">おすすめ記事</p>
            <h3 class="mt-2 text-lg font-bold leading-relaxed text-slate-900 sm:text-xl">
              <a class="transition hover:text-[#008b96]" href="<?php echo htmlspecialchars($column['url'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($column_article_title, ENT_QUOTES, 'UTF-8'); ?></a>
            </h3>
            <div class="mt-4 rounded-xl bg-[#50c2cb]/[0.07] p-4">
              <p class="text-sm font-bold tracking-wide text-[#008b96]">コラムでわかること</p>
              <ul class="mt-2 space-y-2 text-sm leading-7 text-slate-700">
                <?php foreach ($column['points'] as $point): ?>
                <li class="flex gap-2">
                  <span class="mt-2 h-2 w-2 shrink-0 rounded-full bg-[#50c2cb]" aria-hidden="true"></span>
                  <span><?php echo htmlspecialchars($point, ENT_QUOTES, 'UTF-8'); ?></span>
                </li>
                <?php endforeach; ?>
              </ul>
            </div>
          </div>
        </div>

        <p class="mt-6 text-slate-600">ページの内容とあわせて読むことで、練習の目的と進め方がより具体的になります。ぜひご確認ください。</p>
        <p class="mt-7">
          <a class="inline-flex items-center justify-center rounded-full bg-[#50c2cb] px-7 py-3.5 text-sm font-semibold text-white shadow-lg shadow-[#50c2cb]/20 transition hover:bg-[#46adb5] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#50c2cb]/60 focus-visible:ring-offset-2" href="<?php echo htmlspecialchars($column['url'], ENT_QUOTES, 'UTF-8'); ?>">
            <?php echo htmlspecialchars($column['button'], ENT_QUOTES, 'UTF-8'); ?><span class="ml-2" aria-hidden="true">→</span>
          </a>
        </p>
      </div>
    </div>
  </div>
</section>
