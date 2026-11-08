<?php
/**
 * 級別・中間CTA（強みの直後＝証拠を全部読む前）
 * @var array $grade_content
 */
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../../config.php';
}

$mid = $grade_content['mid_cta'] ?? null;
if (!is_array($mid)) {
    return;
}

$heading = (string) ($mid['heading'] ?? '');
if ($heading === '') {
    return;
}

$lead = (string) ($mid['lead'] ?? '');
$note = (string) ($mid['note'] ?? 'カード登録不要・1分で完了');
$secondary_label = (string) ($mid['secondary_label'] ?? '');
$secondary_href = (string) ($mid['secondary_href'] ?? '');
?>
<section class="grade-mid-cta px-4 py-12 sm:py-14" aria-labelledby="grade-mid-cta-heading">
  <div class="grade-mid-cta__inner">
    <p class="section-badge section-badge--center" aria-hidden="true">NOW</p>
    <h2 id="grade-mid-cta-heading" class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl"><?php echo $heading; ?></h2>
    <?php if ($lead !== ''): ?>
    <p class="grade-mid-cta__lead"><?php echo br_after_period($lead); ?></p>
    <?php endif; ?>
    <?php
    require_once __DIR__ . '/../exam-schedule.php';
    $mid_exam = lp_next_exam(lp_current_grade());
    $mid_campaign = open_campaign_active();
    ?>
    <?php if ($mid_exam !== null || $mid_campaign): ?>
    <ul class="mx-auto mt-6 flex max-w-xl flex-col gap-2 text-left text-sm leading-relaxed text-slate-800">
      <?php if ($mid_exam !== null): ?>
      <li class="rounded-xl border border-amber-300/70 bg-amber-50 px-4 py-3">
        <?php if ($mid_exam['days'] === 0): ?>
        <strong>今日は<?php echo htmlspecialchars($GRADES[$grade]['name'] . 'の' . $mid_exam['event']['short']); ?>です。</strong>
        <?php else: ?>
        <strong><?php echo htmlspecialchars($GRADES[$grade]['name'] . 'の' . $mid_exam['event']['short']); ?>まで、あと<span class="mx-0.5 text-lg text-amber-600"><?php echo (int) $mid_exam['days']; ?></span>日。</strong>
        <?php endif; ?>
        <?php echo htmlspecialchars(lp_exam_dates_text($mid_exam['event'])); ?>
        <?php if ($mid_exam['apply_until'] !== ''): ?>
        ／申込締切 <?php echo htmlspecialchars(lp_exam_date_label($mid_exam['apply_until'])); ?>
        <?php endif; ?>
      </li>
      <?php endif; ?>
      <?php if ($mid_campaign): ?>
      <li class="rounded-xl border border-[#50c2cb]/40 bg-white px-4 py-3">
        <strong>プレミアムのOPEN記念価格は、<?php echo htmlspecialchars(open_campaign_end_label()); ?>まで。</strong>
        <?php echo htmlspecialchars('期間中に申し込むと、解約しない限りずっと' . monthly_price_label() . 'のまま（定価 ' . monthly_price_regular_label(false) . '）。無料登録のあと、アプリ内で申し込めます。'); ?>
      </li>
      <?php endif; ?>
    </ul>
    <?php endif; ?>
    <div class="grade-mid-cta__actions">
      <a class="grade-mid-cta__button" href="<?php echo htmlspecialchars(lp_signup_url('mid'), ENT_QUOTES, 'UTF-8'); ?>"><?php echo lp_start_cta_inner('h-5 w-5'); ?></a>
      <?php if ($secondary_label !== '' && $secondary_href !== ''): ?>
      <a class="grade-mid-cta__secondary" href="<?php echo htmlspecialchars($secondary_href); ?>"><?php echo htmlspecialchars($secondary_label); ?></a>
      <?php endif; ?>
    </div>
    <?php if ($note !== ''): ?>
    <p class="grade-mid-cta__note"><?php echo htmlspecialchars($note); ?></p>
    <?php endif; ?>
  </div>
</section>
