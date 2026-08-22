<?php
/**
 * 級別・大問付き技能セクション（reading / listening / writing / speaking）
 * 事前に $skill_key をセットして include する
 * @var string $grade
 * @var array $grade_data
 * @var array $grade_content
 * @var string $skill_key
 */
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../../config.php';
}
require_once __DIR__ . '/../grade-data.php';

$meta = [
    'reading' => ['badge' => 'READING', 'heading_suffix' => 'のリーディング対策', 'id' => 'grade-skill-reading'],
    'listening' => ['badge' => 'LISTENING', 'heading_suffix' => 'のリスニング対策', 'id' => 'grade-skill-listening'],
    'writing' => ['badge' => 'WRITING', 'heading_suffix' => 'のライティング対策', 'id' => 'grade-skill-writing'],
    'speaking' => ['badge' => 'SPEAKING', 'heading_suffix' => 'のスピーキング対策', 'id' => 'grade-skill-speaking'],
];

$skill_key = $skill_key ?? '';
if ($skill_key === '' || empty($meta[$skill_key]) || empty($grade_content[$skill_key])) {
    return;
}

$m = $meta[$skill_key];
$skill = $grade_content[$skill_key];
$name_short = $grade_data['name_short'] ?? '';
$parts = $skill['parts'] ?? [];
$colClass = 'grade-capture-grid--' . min(4, max(2, count($parts) ?: 2));
$bgClass = in_array($skill_key, ['listening', 'speaking'], true) ? 'bg-slate-50/50' : 'bg-white';
?>
<section id="<?php echo htmlspecialchars($m['id']); ?>" class="grade-skill-section border-t border-slate-100 <?php echo $bgClass; ?> px-4 py-16 sm:py-20" aria-labelledby="<?php echo htmlspecialchars($m['id']); ?>-heading">
  <div class="lp-container">
    <div class="mx-auto max-w-3xl text-center">
      <p class="section-badge section-badge--center" aria-hidden="true"><?php echo htmlspecialchars($m['badge']); ?></p>
      <h2 id="<?php echo htmlspecialchars($m['id']); ?>-heading" class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl"><?php echo htmlspecialchars($name_short . $m['heading_suffix']); ?></h2>
      <p class="mt-3 text-slate-600"><?php echo br_after_period($skill['lead'] ?? ''); ?></p>
      <?php if (!empty($skill['tips'])): ?>
      <p class="mt-2 text-sm text-slate-500"><?php echo htmlspecialchars($skill['tips']); ?></p>
      <?php endif; ?>
    </div>

    <?php if ($parts !== []): ?>
    <div class="grade-capture-grid <?php echo htmlspecialchars($colClass); ?> mt-10 sm:mt-12">
      <?php foreach ($parts as $part):
          $title = (string) ($part['title'] ?? '');
          $desc = (string) ($part['desc'] ?? '');
          $imageKey = (string) ($part['image'] ?? '');
          $src = grade_screen_url($grade, $imageKey);
          $zoomLabel = $title !== '' ? $title . 'を拡大表示' : '画面キャプチャを拡大表示';
          ?>
      <article class="grade-capture-card">
        <button
          type="button"
          class="grade-capture-card__zoom"
          data-grade-lightbox="<?php echo htmlspecialchars($src); ?>"
          data-grade-lightbox-caption="<?php echo htmlspecialchars($title); ?>"
          data-grade-lightbox-alt="<?php echo htmlspecialchars($title !== '' ? $title : '技能対策の画面'); ?>"
          aria-label="<?php echo htmlspecialchars($zoomLabel); ?>"
        >
          <span class="grade-capture-card__frame">
            <img src="<?php echo htmlspecialchars($src); ?>" alt="" class="grade-capture-card__img" loading="lazy" decoding="async" width="640" height="480">
          </span>
          <span class="grade-capture-card__zoom-hint" aria-hidden="true">拡大</span>
        </button>
        <?php if ($title !== ''): ?>
        <h3 class="grade-capture-card__title"><?php echo htmlspecialchars($title); ?></h3>
        <?php endif; ?>
        <?php if ($desc !== ''): ?>
        <p class="grade-capture-card__desc"><?php echo htmlspecialchars($desc); ?></p>
        <?php endif; ?>
      </article>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
  </div>
</section>
