<?php
/**
 * ヒーロー下の「最新の更新」1行（級LP・技能LP）。クリックでページ内の更新一覧へ。
 */
require_once __DIR__ . '/lp-announcements.php';

$lp_latest_items = lp_announcements_for(lp_announcement_place());
if ($lp_latest_items === []) {
    return;
}
$lp_latest = $lp_latest_items[0];
?>
<a class="mt-4 inline-flex max-w-lg items-start gap-2 rounded-xl border border-[#50c2cb]/30 bg-white/80 px-3 py-2 text-left text-sm leading-relaxed text-slate-700 transition hover:border-[#50c2cb] hover:bg-white" href="#lp-updates">
  <span class="shrink-0 rounded-full bg-[#50c2cb] px-2 py-0.5 text-xs font-bold text-white"><?php echo lp_announcement_is_new($lp_latest['date']) ? 'NEW' : '更新'; ?></span>
  <span>
    <time class="mr-1 font-semibold text-slate-900" datetime="<?php echo htmlspecialchars($lp_latest['date'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars(lp_announcement_date($lp_latest['date'])); ?></time>
    <?php echo htmlspecialchars($lp_latest['text']); ?>
  </span>
</a>
