<?php
/**
 * 級の位置づけ（準2 / 準2+ / 2級などの比較）
 * @var array $grade_content
 */
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../../config.php';
}

$pos = $grade_content['positioning'] ?? null;
if (!is_array($pos)) {
    return;
}

$heading = (string) ($pos['heading'] ?? '');
$lead = (string) ($pos['lead'] ?? '');
$intro = is_array($pos['intro'] ?? null) ? $pos['intro'] : [];
$steps = is_array($pos['steps'] ?? null) ? $pos['steps'] : [];
$table = is_array($pos['table'] ?? null) ? $pos['table'] : null;
$takeaways = is_array($pos['takeaways'] ?? null) ? $pos['takeaways'] : [];
$takeaways_lead = (string) ($pos['takeaways_lead'] ?? '');
$image1 = (string) ($pos['image'] ?? '');
$image1_alt = (string) ($pos['image_alt'] ?? '');
$image2 = (string) ($pos['image_2'] ?? '');
$image2_alt = (string) ($pos['image_2_alt'] ?? '');
$highlight = (string) ($pos['highlight'] ?? '');
?>
<section class="grade-position border-t border-slate-100 bg-white px-4 py-16 sm:py-20" aria-labelledby="grade-position-heading">
  <div class="lp-container">
    <div class="mx-auto max-w-3xl text-center">
      <p class="section-badge section-badge--center" aria-hidden="true">LEVEL</p>
      <h2 id="grade-position-heading" class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl"><?php echo htmlspecialchars($heading); ?></h2>
      <?php if ($lead !== ''): ?>
      <p class="mt-3 text-slate-600"><?php echo br_after_period($lead); ?></p>
      <?php endif; ?>
    </div>

    <?php if ($image1 !== '' || $intro !== []): ?>
    <div class="grade-position__intro mt-10 sm:mt-12">
      <?php if ($image1 !== ''): ?>
      <figure class="grade-position__media">
        <img src="<?php echo htmlspecialchars($image1); ?>" alt="<?php echo htmlspecialchars($image1_alt); ?>" width="960" height="640" class="grade-position__image" loading="lazy" decoding="async">
      </figure>
      <?php endif; ?>
      <?php if ($intro !== []): ?>
      <div class="grade-position__copy intro-body space-y-5 leading-relaxed">
        <?php foreach ($intro as $para): ?>
        <p><?php echo br_after_period($para); ?></p>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>
    </div>
    <?php endif; ?>

    <?php if ($steps !== []): ?>
    <ol class="grade-position__steps mt-12">
      <?php foreach ($steps as $step):
          $is_current = !empty($step['current']);
          ?>
      <li class="grade-position__step<?php echo $is_current ? ' is-current' : ''; ?>">
        <p class="grade-position__step-kicker"><?php echo htmlspecialchars((string) ($step['kicker'] ?? '')); ?></p>
        <p class="grade-position__step-title"><?php echo htmlspecialchars((string) ($step['title'] ?? '')); ?></p>
        <p class="grade-position__step-text"><?php echo htmlspecialchars((string) ($step['text'] ?? '')); ?></p>
      </li>
      <?php endforeach; ?>
    </ol>
    <?php endif; ?>

    <?php if (is_array($table) && !empty($table['headers']) && !empty($table['rows'])): ?>
    <div class="grade-position__table-wrap mt-10">
      <h3 class="grade-position__subhead"><?php echo htmlspecialchars((string) ($table['heading'] ?? '級ごとのちがい')); ?></h3>
      <div class="grade-position__scroll" tabindex="0">
        <table class="grade-position__table">
          <thead>
            <tr>
              <?php foreach ($table['headers'] as $i => $header):
                  $th_current = ($highlight !== '' && ($table['header_keys'][$i] ?? '') === $highlight);
                  ?>
              <th scope="col"<?php echo $th_current ? ' class="is-current"' : ''; ?>><?php echo htmlspecialchars((string) $header); ?></th>
              <?php endforeach; ?>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($table['rows'] as $row): ?>
            <tr>
              <?php foreach ($row as $i => $cell):
                  $is_head = $i === 0;
                  $td_current = ($highlight !== '' && ($table['header_keys'][$i] ?? '') === $highlight);
                  $tag = $is_head ? 'th' : 'td';
                  $scope = $is_head ? ' scope="row"' : '';
                  $class = $td_current ? ' class="is-current"' : '';
                  ?>
              <<?php echo $tag; ?><?php echo $scope; ?><?php echo $class; ?>><?php echo htmlspecialchars((string) $cell); ?></<?php echo $tag; ?>>
              <?php endforeach; ?>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <?php if (!empty($table['note'])): ?>
      <p class="grade-position__note"><?php echo br_after_period($table['note']); ?></p>
      <?php endif; ?>
    </div>
    <?php endif; ?>

    <?php if ($takeaways !== [] || $image2 !== ''): ?>
    <div class="grade-position__outro mt-12 sm:mt-16">
      <?php if ($image2 !== ''): ?>
      <figure class="grade-position__media">
        <img src="<?php echo htmlspecialchars($image2); ?>" alt="<?php echo htmlspecialchars($image2_alt); ?>" width="960" height="640" class="grade-position__image" loading="lazy" decoding="async">
      </figure>
      <?php endif; ?>
      <div class="grade-position__copy">
        <?php if ($takeaways_lead !== ''): ?>
        <h3 class="grade-position__subhead grade-position__subhead--left"><?php echo htmlspecialchars($takeaways_lead); ?></h3>
        <?php endif; ?>
        <?php if ($takeaways !== []): ?>
        <ul class="grade-position__points">
          <?php foreach ($takeaways as $point): ?>
          <li>
            <span class="grade-position__check" aria-hidden="true"><?php echo lp_icon('check', 'w-5 h-5'); ?></span>
            <span><?php echo $point; ?></span>
          </li>
          <?php endforeach; ?>
        </ul>
        <?php endif; ?>
      </div>
    </div>
    <?php endif; ?>
  </div>
</section>
