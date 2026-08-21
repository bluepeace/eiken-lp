<?php
/**
 * 級別・単語セクション
 * @var string $grade
 * @var array $grade_data
 * @var array $skill  grade_content['word']
 */
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../../config.php';
}
require_once __DIR__ . '/../grade-data.php';
$name_short = $grade_data['name_short'] ?? '';
$skill = $grade_content['word'] ?? null;
if (!$skill) {
    return;
}
$images = $skill['images'] ?? [];
?>
<section id="grade-skill-word" class="grade-skill-section border-t border-slate-100 bg-white px-4 py-16 sm:py-20" aria-labelledby="grade-word-heading">
  <div class="lp-container">
    <div class="mx-auto max-w-3xl text-center">
      <p class="section-badge section-badge--center" aria-hidden="true">WORD</p>
      <h2 id="grade-word-heading" class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl"><?php echo htmlspecialchars($name_short); ?>の単語対策</h2>
      <p class="mt-3 text-slate-600"><?php echo br_after_period($skill['lead'] ?? ''); ?></p>
      <?php if (!empty($skill['vocab_note'])): ?>
      <p class="mt-2 text-sm text-slate-500"><?php echo htmlspecialchars($skill['vocab_note']); ?></p>
      <?php endif; ?>
    </div>

    <?php if (!empty($skill['points'])): ?>
    <ul class="grade-skill-points mx-auto mt-8 max-w-2xl">
      <?php foreach ($skill['points'] as $point): ?>
      <li class="grade-skill-points__item">
        <span class="grade-skill-points__check" aria-hidden="true"><?php echo lp_icon('check', 'w-5 h-5'); ?></span>
        <span><?php echo htmlspecialchars($point); ?></span>
      </li>
      <?php endforeach; ?>
    </ul>
    <?php endif; ?>

    <div class="grade-capture-grid grade-capture-grid--3 mt-10 sm:mt-12">
      <?php foreach ($images as $img):
          $key = (string) ($img['key'] ?? '');
          $caption = (string) ($img['caption'] ?? '');
          $src = grade_screen_url($grade, $key);
          ?>
      <figure class="grade-capture-card">
        <div class="grade-capture-card__frame">
          <img src="<?php echo htmlspecialchars($src); ?>" alt="" class="grade-capture-card__img" loading="lazy" decoding="async" width="360" height="640">
        </div>
        <?php if ($caption !== ''): ?>
        <figcaption class="grade-capture-card__caption"><?php echo htmlspecialchars($caption); ?></figcaption>
        <?php endif; ?>
      </figure>
      <?php endforeach; ?>
    </div>
  </div>
</section>
