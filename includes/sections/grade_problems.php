<?php
/**
 * 級特化の悩み（TOPの problems と同じ型。バディはチョコ）
 * @var array $grade_content
 * @var array $grade_data
 */
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../../config.php';
}

$problems = $grade_content['problems'] ?? null;
if (!is_array($problems) || empty($problems['items'])) {
    return;
}

$name_short = $grade_data['name_short'] ?? '英検';
$heading = (string) ($problems['heading'] ?? ($name_short . '対策、<span class="heading-accent">こんなお悩み</span>ありませんか？'));
$lead = (string) ($problems['lead'] ?? '');
$items = $problems['items'];
$solution = (string) ($problems['solution'] ?? '');
$buddy_src = (string) ($problems['buddy_image'] ?? '/assets/images/buddy-worries.png');
$buddy_alt = (string) ($problems['buddy_alt'] ?? 'AiKenのバディ「チョコ」');
?>
<section class="problems-section border-t border-[#50c2cb]/15 px-4 py-16 sm:py-20" aria-labelledby="grade-problems-heading">
  <div class="lp-container">
    <div class="problems-section__header mx-auto max-w-3xl text-center">
      <p class="section-badge section-badge--center" aria-hidden="true">WORRY</p>
      <h2 id="grade-problems-heading" class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl"><?php echo $heading; ?></h2>
      <?php if ($lead !== ''): ?>
      <p class="problems-lead mt-3"><?php echo br_after_period($lead); ?></p>
      <?php endif; ?>
    </div>
    <div class="problems-card mt-8 rounded-2xl border border-white/80 bg-white px-5 py-6 text-left shadow-sm sm:px-8 sm:py-8">
      <div class="problems-card__inner">
        <ul class="problems-list space-y-4 sm:space-y-5">
          <?php foreach ($items as $text): ?>
          <li class="problems-list__item">
            <span class="problems-list__check text-[#50c2cb]" aria-hidden="true"><?php echo lp_icon('check', 'w-4 h-4'); ?></span>
            <span class="problems-lead"><?php echo $text; ?></span>
          </li>
          <?php endforeach; ?>
        </ul>
        <figure class="problems-buddy">
          <img src="<?php echo htmlspecialchars($buddy_src); ?>" alt="<?php echo htmlspecialchars($buddy_alt); ?>" width="320" height="320" class="problems-buddy__image" loading="lazy">
        </figure>
      </div>
    </div>
    <?php if ($solution !== ''): ?>
    <div class="problems-solution">
      <div class="problems-arrow" aria-hidden="true">
        <?php echo lp_icon('chevron-down', 'problems-arrow__icon'); ?>
        <?php echo lp_icon('chevron-down', 'problems-arrow__icon'); ?>
      </div>
      <p class="problems-lead problems-solution__text mx-auto max-w-3xl text-center text-lg font-bold"><?php echo br_after_period($solution); ?></p>
    </div>
    <?php endif; ?>
  </div>
</section>
