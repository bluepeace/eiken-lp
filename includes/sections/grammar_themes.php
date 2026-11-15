<?php
/**
 * 級の文法テーマ一覧
 * @var array $grade_data
 * @var array $grammar
 */
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../../config.php';
}

$name = (string) ($grade_data['name'] ?? '');
$name_short = (string) ($grade_data['name_short'] ?? '');
$themes = is_array($grammar['themes'] ?? null) ? $grammar['themes'] : [];
$theme_count = (int) ($grammar['theme_count'] ?? count($themes));
$question_count = (int) ($grammar['question_count'] ?? 0);
$curriculum_lead = (string) ($grammar['curriculum_lead'] ?? '');
$scope = (string) ($grammar['scope'] ?? '');
$later = (string) ($grammar['later'] ?? '');
$note = (string) ($grammar['note'] ?? '');
?>
<section id="grammar-themes" class="scroll-mt-24 border-t border-slate-100 bg-slate-50/50 px-4 py-16 sm:py-20" aria-labelledby="grammar-themes-heading">
  <div class="lp-container">
    <div class="mx-auto max-w-3xl text-center">
      <p class="section-badge section-badge--center" aria-hidden="true">THEMES</p>
      <h2 id="grammar-themes-heading" class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl"><?php echo htmlspecialchars($name_short); ?>のテーマ <?php echo $theme_count; ?>本</h2>
      <p class="mt-3 text-slate-600"><?php echo br_after_period(htmlspecialchars($curriculum_lead, ENT_QUOTES, 'UTF-8') . '確認問題は' . $question_count . '問です。'); ?></p>
      <?php if ($note !== ''): ?>
      <p class="mt-2 text-sm text-slate-500"><?php echo htmlspecialchars($note); ?></p>
      <?php endif; ?>
    </div>

    <?php if ($scope !== '' || $later !== ''): ?>
    <div class="mx-auto mt-8 grid max-w-3xl gap-4 sm:grid-cols-2">
      <?php if ($scope !== ''): ?>
      <article class="rounded-2xl border border-slate-200 bg-white p-5">
        <h3 class="text-sm font-bold text-[#008b96]">この級で扱うこと</h3>
        <p class="mt-2 text-sm leading-relaxed text-slate-700"><?php echo br_after_period(htmlspecialchars($scope, ENT_QUOTES, 'UTF-8')); ?></p>
      </article>
      <?php endif; ?>
      <?php if ($later !== ''): ?>
      <article class="rounded-2xl border border-slate-200 bg-white p-5">
        <h3 class="text-sm font-bold text-[#008b96]">上の級に残すこと</h3>
        <p class="mt-2 text-sm leading-relaxed text-slate-700"><?php echo br_after_period(htmlspecialchars($later, ENT_QUOTES, 'UTF-8')); ?></p>
      </article>
      <?php endif; ?>
    </div>
    <?php endif; ?>

    <ol class="mx-auto mt-8 max-w-3xl space-y-3">
      <?php foreach ($themes as $i => $theme):
          if (!is_array($theme)) {
              continue;
          }
          $title = (string) ($theme['title'] ?? '');
          if ($title === '') {
              continue;
          }
          ?>
      <li class="rounded-2xl border border-slate-200 bg-white px-5 py-4">
        <p class="text-xs font-semibold tracking-wide text-[#00a2af]"><?php echo htmlspecialchars((string) ($theme['category'] ?? '')); ?></p>
        <h3 class="mt-1 text-base font-bold text-slate-900"><?php echo ($i + 1) . '. ' . htmlspecialchars($title); ?></h3>
        <p class="mt-1 text-sm leading-relaxed text-slate-600"><?php echo htmlspecialchars((string) ($theme['summary'] ?? '')); ?></p>
      </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>
