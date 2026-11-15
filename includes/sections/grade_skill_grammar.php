<?php
/**
 * 級別・文法セクション（5級〜2級）
 * @var string $grade
 * @var array $grade_data
 */
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../../config.php';
}
require_once __DIR__ . '/../grade-data.php';
require_once __DIR__ . '/../grammar-data.php';

$grammar = grade_grammar_content((string) $grade);
if ($grammar === null) {
    return;
}
$name_short = $grade_data['name_short'] ?? '';
$images = $grammar['images'];
?>
<section id="grade-skill-grammar" class="grade-skill-section grade-skill-section--grammar border-t border-slate-100 bg-white px-4 py-16 sm:py-20" aria-labelledby="grade-grammar-heading">
  <div class="lp-container">
    <div class="mx-auto max-w-3xl text-center">
      <p class="section-badge section-badge--center" aria-hidden="true">GRAMMAR</p>
      <h2 id="grade-grammar-heading" class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl"><?php echo htmlspecialchars($name_short); ?>の文法</h2>
      <p class="mt-3 text-slate-600"><?php echo br_after_period($grammar['lead']); ?></p>
      <p class="mt-2 text-sm text-slate-500"><?php echo htmlspecialchars($grammar['note']); ?></p>
    </div>

    <ul class="grade-skill-points mx-auto mt-8 max-w-2xl">
      <?php foreach ($grammar['points'] as $point): ?>
      <li class="grade-skill-points__item">
        <span class="grade-skill-points__check" aria-hidden="true"><?php echo lp_icon('check', 'w-5 h-5'); ?></span>
        <span><?php echo htmlspecialchars($point); ?></span>
      </li>
      <?php endforeach; ?>
    </ul>

    <div class="grade-capture-grid grade-capture-grid--3 mt-10 sm:mt-12">
      <?php foreach ($images as $img):
          $key = (string) $img['key'];
          $caption = (string) $img['caption'];
          $src = grade_screen_url($grade, $key);
          $zoomLabel = $caption . 'を拡大表示';
          ?>
      <figure class="grade-capture-card">
        <button
          type="button"
          class="grade-capture-card__zoom"
          data-grade-lightbox="<?php echo htmlspecialchars($src); ?>"
          data-grade-lightbox-caption="<?php echo htmlspecialchars($caption); ?>"
          data-grade-lightbox-alt="<?php echo htmlspecialchars($name_short . 'の文法。' . $caption); ?>"
          aria-label="<?php echo htmlspecialchars($zoomLabel); ?>"
        >
          <span class="grade-capture-card__frame">
            <img src="<?php echo htmlspecialchars($src); ?>" alt="" class="grade-capture-card__img" loading="lazy" decoding="async" width="1024" height="633">
          </span>
          <span class="grade-capture-card__zoom-hint" aria-hidden="true">拡大</span>
        </button>
        <figcaption class="grade-capture-card__caption"><?php echo htmlspecialchars($caption); ?></figcaption>
      </figure>
      <?php endforeach; ?>
    </div>

    <?php $grammar_href = grammar_page_path((string) $grade); ?>
    <?php if ($grammar_href !== null): ?>
    <p class="mt-10 text-center">
      <a class="inline-flex items-center justify-center rounded-full bg-[#50c2cb] px-8 py-3.5 text-base font-semibold text-white shadow-lg shadow-[#50c2cb]/25 transition hover:bg-[#46adb5] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#50c2cb]/60 focus-visible:ring-offset-2" href="<?php echo htmlspecialchars($grammar_href); ?>"><?php echo htmlspecialchars($name_short); ?>の文法を詳しく見る</a>
    </p>
    <?php endif; ?>
  </div>
</section>
