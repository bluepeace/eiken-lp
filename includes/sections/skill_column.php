<?php
/**
 * 級別・技能別コラムへの内部リンク。
 * @var string $grade
 * @var string $page
 * @var array $grade_data
 */
require_once __DIR__ . '/../skill-column-data.php';

$column_grade_name = (string) ($grade_data['name'] ?? '英検');
$column = skill_column_data((string) $grade, (string) $page, $column_grade_name);
if ($column === null) {
    return;
}
?>
<section class="border-t border-slate-100 bg-slate-50/60 py-16 sm:py-20" aria-labelledby="skill-column-heading">
  <div class="lp-container px-4">
    <div class="mx-auto max-w-4xl overflow-hidden rounded-3xl border border-[#50c2cb]/25 bg-white shadow-sm">
      <div class="p-6 sm:p-10">
        <p class="section-badge" aria-hidden="true">COLUMN</p>
        <h2 id="skill-column-heading" class="mt-3 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl"><?php echo htmlspecialchars($column_grade_name . 'の' . $column['skill_label'] . 'を、もっと深く学びたい方へ', ENT_QUOTES, 'UTF-8'); ?></h2>
        <p class="mt-4 leading-8 text-slate-600"><?php echo htmlspecialchars($column['lead'], ENT_QUOTES, 'UTF-8'); ?></p>

        <div class="mt-6 rounded-2xl bg-[#50c2cb]/[0.07] p-5 sm:p-6">
          <p class="text-sm font-bold tracking-wide text-[#008b96]">コラムでわかること</p>
          <ul class="mt-3 grid gap-3 text-sm leading-7 text-slate-700 sm:grid-cols-2">
            <?php foreach ($column['points'] as $point): ?>
            <li class="flex gap-2">
              <span class="mt-2 h-2 w-2 shrink-0 rounded-full bg-[#50c2cb]" aria-hidden="true"></span>
              <span><?php echo htmlspecialchars($point, ENT_QUOTES, 'UTF-8'); ?></span>
            </li>
            <?php endforeach; ?>
          </ul>
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
