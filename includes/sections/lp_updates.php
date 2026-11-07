<?php
/**
 * 級LP・技能LPの更新履歴（その級／その級×技能に関係するものだけ）
 * 最新5件を表示し、残りは「過去の更新」で開く。
 */
require_once __DIR__ . '/../lp-announcements.php';

$lp_updates = lp_announcements_for(lp_announcement_place());
if ($lp_updates === []) {
    return;
}
$lp_updates_visible = 5;
$lp_updates_head = array_slice($lp_updates, 0, $lp_updates_visible);
$lp_updates_rest = array_slice($lp_updates, $lp_updates_visible);

$lp_updates_title = (string) ($GRADES[lp_current_grade()]['name'] ?? '');
$lp_updates_skill = lp_announcement_skills()[$page ?? ''] ?? '';
if ($lp_updates_skill !== '') {
    $lp_updates_title .= $lp_updates_skill;
}

if (!function_exists('lp_updates_row')) {
    function lp_updates_row(array $item): string
    {
        $new = lp_announcement_is_new((string) $item['date'])
            ? '<span class="ml-2 rounded-full bg-[#50c2cb] px-2 py-0.5 text-xs font-bold text-white">NEW</span>'
            : '';
        return '<li class="flex flex-col gap-1 py-4 sm:flex-row sm:gap-6">'
            . '<time class="shrink-0 text-sm font-semibold text-slate-500 sm:w-36" datetime="' . htmlspecialchars((string) $item['date'], ENT_QUOTES, 'UTF-8') . '">'
            . htmlspecialchars(lp_announcement_date((string) $item['date'])) . $new . '</time>'
            . '<span class="text-slate-800">' . htmlspecialchars((string) $item['text']) . '</span>'
            . '</li>';
    }
}
?>
<section id="lp-updates" class="scroll-mt-24 border-t border-slate-100 bg-white px-4 py-16 sm:py-20" aria-labelledby="lp-updates-heading">
  <div class="lp-container">
    <div class="mx-auto max-w-3xl text-center">
      <p class="section-badge section-badge--center" aria-hidden="true">UPDATE</p>
      <h2 id="lp-updates-heading" class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl"><?php echo htmlspecialchars($lp_updates_title); ?>の最近の更新</h2>
      <p class="mt-3 text-slate-600"><?php echo br_after_period('問題の追加や機能の改善を、日付つきでお知らせしています。'); ?></p>
    </div>
    <div class="mx-auto mt-10 max-w-3xl">
      <ul class="divide-y divide-slate-200 border-y border-slate-200">
        <?php foreach ($lp_updates_head as $item) { echo lp_updates_row($item); } ?>
      </ul>
      <?php if ($lp_updates_rest !== []): ?>
      <details class="group mt-4">
        <summary class="cursor-pointer list-none text-center text-sm font-semibold text-[#2a9aa3] hover:underline">
          <span class="group-open:hidden">過去の更新を見る（<?php echo count($lp_updates_rest); ?>件）</span>
          <span class="hidden group-open:inline">過去の更新を閉じる</span>
        </summary>
        <ul class="mt-2 divide-y divide-slate-200 border-y border-slate-200">
          <?php foreach ($lp_updates_rest as $item) { echo lp_updates_row($item); } ?>
        </ul>
      </details>
      <?php endif; ?>
    </div>
  </div>
</section>
