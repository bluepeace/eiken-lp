<?php
/**
 * ヒーロー下の「英検〇級の一次試験まで あと◯日」（級LP・技能LP）
 * 日程は includes/exam-schedule.php。試験日が過ぎると次の試験に自動で切り替わる。
 */
require_once __DIR__ . '/exam-schedule.php';

$lp_exam_level = lp_current_grade();
$lp_exam = lp_next_exam($lp_exam_level);
if ($lp_exam === null) {
    return;
}
$lp_exam_grade_name = $lp_exam_level !== '' ? (string) $GRADES[$lp_exam_level]['name'] : '英検';
$lp_exam_event = $lp_exam['event'];
?>
<div class="mt-4 max-w-lg rounded-xl border border-amber-300/70 bg-amber-50/90 px-4 py-3 text-left text-sm leading-relaxed text-slate-800">
  <p class="font-semibold text-slate-900">
    <?php if ($lp_exam['days'] === 0): ?>
    今日は<?php echo htmlspecialchars($lp_exam_grade_name . 'の' . $lp_exam_event['short']); ?>です
    <?php else: ?>
    <?php echo htmlspecialchars($lp_exam_grade_name . 'の' . $lp_exam_event['short']); ?>まで
    あと<span class="mx-0.5 text-2xl font-bold text-amber-600"><?php echo (int) $lp_exam['days']; ?></span>日
    <?php endif; ?>
  </p>
  <p class="mt-0.5 text-xs text-slate-600">
    <?php echo htmlspecialchars($lp_exam_event['name'] . '　' . lp_exam_dates_text($lp_exam_event)); ?>
    <?php if ($lp_exam['apply_until'] !== ''): ?>
    <br>申込締切 <?php echo htmlspecialchars(lp_exam_date_label($lp_exam['apply_until'])); ?>（個人申込）
    <?php endif; ?>
  </p>
</div>
