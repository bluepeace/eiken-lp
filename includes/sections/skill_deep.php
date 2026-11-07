<?php
/**
 * 技能LP：その級・その技能ならではの解説（データは includes/skill-deep-data.php）
 * 出題と話題 → 失点しやすい型とAiKenでの直し方 → 一次試験までの練習計画（今の段階を強調）
 * @var string $grade
 * @var string $page 技能キー（listening など）
 */
require_once __DIR__ . '/../skill-deep-data.php';
require_once __DIR__ . '/../exam-schedule.php';

$deep = skill_deep_data((string) ($page ?? ''), (string) $grade);
if ($deep === null) {
    return;
}

// 一次試験までの日数で、今の段階を決める（日程が未登録なら強調しない）
$deep_exam = lp_next_exam((string) $grade, null, 'first');
$deep_now = -1;
if ($deep_exam !== null) {
    foreach ($deep['plan'] as $i => $step) {
        if ($deep_exam['days'] >= (int) $step['min_days']) {
            $deep_now = $i;
            break;
        }
    }
}
?>
<section id="skill-deep" class="border-t border-slate-100 bg-slate-50/50 px-4 py-16 sm:py-20" aria-labelledby="skill-deep-heading">
  <div class="lp-container">
    <div class="mx-auto max-w-3xl text-center">
      <p class="section-badge section-badge--center" aria-hidden="true">GUIDE</p>
      <h2 id="skill-deep-heading" class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl"><?php echo htmlspecialchars($deep['heading']); ?></h2>
      <p class="mt-4 text-left leading-relaxed text-slate-700 sm:text-center"><?php echo br_after_period(htmlspecialchars($deep['intro'])); ?></p>
    </div>

    <div class="mx-auto mt-12 max-w-3xl">
      <h3 class="text-xl font-bold text-slate-900"><?php echo htmlspecialchars($deep['topics_heading']); ?></h3>
      <p class="mt-3 leading-relaxed text-slate-700"><?php echo htmlspecialchars($deep['topics_lead']); ?></p>
      <ul class="mt-4 flex flex-wrap gap-2">
        <?php foreach ($deep['topics'] as $topic): ?>
        <li class="rounded-full border border-[#50c2cb]/40 bg-white px-3 py-1 text-sm font-semibold text-slate-700"><?php echo htmlspecialchars($topic); ?></li>
        <?php endforeach; ?>
      </ul>
      <p class="mt-4 text-sm leading-relaxed text-slate-600"><?php echo htmlspecialchars($deep['topics_note']); ?></p>
    </div>

    <div class="mx-auto mt-12 max-w-3xl">
      <h3 class="text-xl font-bold text-slate-900"><?php echo htmlspecialchars($deep['traps_heading']); ?></h3>
      <ol class="mt-5 space-y-4">
        <?php foreach ($deep['traps'] as $i => $trap): ?>
        <li class="rounded-2xl border border-slate-200 bg-white p-5 sm:p-6">
          <h4 class="flex items-start gap-3 text-base font-bold text-slate-900 sm:text-lg">
            <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-[#50c2cb] text-sm text-white"><?php echo $i + 1; ?></span>
            <span><?php echo htmlspecialchars($trap['title']); ?></span>
          </h4>
          <p class="mt-3 leading-relaxed text-slate-700"><?php echo htmlspecialchars($trap['why']); ?></p>
          <p class="mt-3 rounded-xl bg-[#e8f8f9] px-4 py-3 leading-relaxed text-slate-800"><span class="mb-1 block text-sm font-bold text-[#2a9aa3]">AiKenでの直し方</span><?php echo htmlspecialchars($trap['fix']); ?></p>
        </li>
        <?php endforeach; ?>
      </ol>
    </div>

    <div class="mx-auto mt-12 max-w-3xl">
      <h3 class="text-xl font-bold text-slate-900"><?php echo htmlspecialchars($deep['plan_heading']); ?></h3>
      <p class="mt-3 leading-relaxed text-slate-700"><?php echo htmlspecialchars($deep['plan_lead']); ?></p>
      <?php if ($deep_exam !== null): ?>
      <p class="mt-2 text-sm text-slate-600"><?php echo htmlspecialchars($deep_exam['event']['name'] . '（' . lp_exam_dates_text($deep_exam['event']) . '）まで、あと' . $deep_exam['days'] . '日です。'); ?></p>
      <?php endif; ?>
      <ol class="mt-5 space-y-3">
        <?php foreach ($deep['plan'] as $i => $step): $is_now = ($i === $deep_now); ?>
        <li class="rounded-2xl border p-5 <?php echo $is_now ? 'border-amber-300 bg-amber-50' : 'border-slate-200 bg-white'; ?>">
          <p class="flex items-center gap-2 font-bold text-slate-900">
            <?php echo htmlspecialchars($step['span']); ?>
            <?php if ($is_now): ?><span class="rounded-full bg-amber-500 px-2 py-0.5 text-xs text-white">今ここ</span><?php endif; ?>
          </p>
          <p class="mt-2 leading-relaxed text-slate-700"><?php echo htmlspecialchars($step['text']); ?></p>
        </li>
        <?php endforeach; ?>
      </ol>
    </div>
  </div>
</section>
