<?php
/**
 * 級特化の強み（TOPの strengths と同じ7点の型）
 * @var array $grade_content
 * @var array $grade_data
 */
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../../config.php';
}

$strengths = $grade_content['strengths'] ?? null;
if (!is_array($strengths) || empty($strengths['items'])) {
    return;
}

$items = $strengths['items'];
$count = count($items);
$name_short = $grade_data['name_short'] ?? '英検';
$heading = (string) ($strengths['heading'] ?? ('英検対策アプリ' . htmlspecialchars(SITE_NAME) . 'の<span class="heading-accent">' . $count . 'つの強み</span>'));
$lead = (string) ($strengths['lead'] ?? 'さきほどのお悩みを、ひとつのアプリでまとめて解決。');
?>
<section class="strengths-section border-t border-slate-100 bg-white px-4 py-16 sm:py-20" aria-labelledby="grade-strengths-heading">
  <div class="lp-container">
    <div class="strengths-section__header mx-auto max-w-3xl text-center">
      <p class="section-badge section-badge--center" aria-hidden="true">STRENGTHS</p>
      <h2 id="grade-strengths-heading" class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl"><?php echo $heading; ?></h2>
      <p class="strengths-section__lead mt-3"><?php echo br_after_period($lead); ?></p>
    </div>
    <div class="strengths-list mt-12 sm:mt-16">
      <?php foreach ($items as $index => $item):
          $point = $index + 1;
          $reverse = $point % 2 === 0;
          $title = (string) ($item['title'] ?? '');
          $text = (string) ($item['text'] ?? '');
          $image = (string) ($item['image'] ?? '/assets/images/strength-0' . min(7, $point) . '.png');
          $alt = (string) ($item['alt'] ?? $title);
          ?>
      <article class="strengths-row<?php echo $reverse ? ' strengths-row--reverse' : ''; ?>">
        <div class="strengths-row__content">
          <p class="strengths-point">Point.<?php echo $point; ?></p>
          <h3 class="strengths-title"><?php echo htmlspecialchars($title); ?></h3>
          <p class="strengths-desc"><?php echo br_after_period($text); ?></p>
        </div>
        <figure class="strengths-row__media">
          <img src="<?php echo htmlspecialchars($image); ?>" alt="<?php echo htmlspecialchars($alt); ?>" width="700" height="467" class="strengths-row__image" loading="lazy">
        </figure>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
