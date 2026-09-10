<?php
/**
 * 級別・出題形式表 + 週間の使い方
 * @var array $grade_content
 */
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../../config.php';
}

$block = $grade_content['format_plan'] ?? null;
if (!is_array($block)) {
    return;
}

$heading = (string) ($block['heading'] ?? '');
if ($heading === '') {
    return;
}

$lead = (string) ($block['lead'] ?? '');
$table = is_array($block['table'] ?? null) ? $block['table'] : null;
$week = is_array($block['week'] ?? null) ? $block['week'] : null;
$rows = is_array($table['rows'] ?? null) ? $table['rows'] : [];
$headers = is_array($table['headers'] ?? null) ? $table['headers'] : ['技能', '大問', '本番の目安'];
$spans = [];
$count = count($rows);
for ($i = 0; $i < $count; $i++) {
    if ($i > 0 && (string) ($rows[$i]['skill'] ?? '') === (string) ($rows[$i - 1]['skill'] ?? '')) {
        $spans[$i] = 0;
        continue;
    }
    $span = 1;
    while ($i + $span < $count && (string) ($rows[$i + $span]['skill'] ?? '') === (string) ($rows[$i]['skill'] ?? '')) {
        $span++;
    }
    $spans[$i] = $span;
}
?>
<section class="grade-format border-t border-slate-100 bg-white px-4 py-16 sm:py-20" aria-labelledby="grade-format-heading">
  <div class="lp-container">
    <div class="mx-auto max-w-3xl text-center">
      <p class="section-badge section-badge--center" aria-hidden="true">PLAN</p>
      <h2 id="grade-format-heading" class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl"><?php echo $heading; ?></h2>
      <?php if ($lead !== ''): ?>
      <p class="mt-3 text-slate-600"><?php echo br_after_period($lead); ?></p>
      <?php endif; ?>
    </div>

    <?php if ($table !== null && $rows !== []): ?>
    <div class="grade-format__table-wrap mt-10 sm:mt-12">
      <?php if (!empty($table['heading'])): ?>
      <h3 class="grade-position__subhead"><?php echo htmlspecialchars((string) $table['heading']); ?></h3>
      <?php endif; ?>
      <div class="grade-position__scroll" tabindex="0">
        <table class="grade-position__table grade-format__table">
          <thead>
            <tr>
              <?php foreach ($headers as $header): ?>
              <th scope="col"><?php echo htmlspecialchars((string) $header); ?></th>
              <?php endforeach; ?>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($rows as $i => $row):
                $mark = !empty($row['mark']);
                ?>
            <tr<?php echo $mark ? ' class="is-mark"' : ''; ?>>
              <?php if (($spans[$i] ?? 0) > 0): ?>
              <th scope="row" rowspan="<?php echo (int) $spans[$i]; ?>"><?php echo htmlspecialchars((string) ($row['skill'] ?? '')); ?></th>
              <?php endif; ?>
              <td><?php echo htmlspecialchars((string) ($row['part'] ?? '')); ?></td>
              <td><?php echo htmlspecialchars((string) ($row['note'] ?? '')); ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <?php if (!empty($table['note'])): ?>
      <p class="grade-position__note"><?php echo br_after_period((string) $table['note']); ?></p>
      <?php endif; ?>
    </div>
    <?php endif; ?>

    <?php if (is_array($week)): ?>
    <div class="grade-format__week mt-12 sm:mt-16">
      <div class="grade-format__week-intro">
        <?php if (!empty($week['image'])): ?>
        <figure class="grade-format__media">
          <img src="<?php echo htmlspecialchars((string) $week['image']); ?>" alt="<?php echo htmlspecialchars((string) ($week['image_alt'] ?? '')); ?>" width="960" height="640" class="grade-format__image" loading="lazy" decoding="async">
        </figure>
        <?php endif; ?>
        <div class="grade-format__week-copy">
          <?php if (!empty($week['heading'])): ?>
          <h3 class="grade-position__subhead grade-position__subhead--left"><?php echo htmlspecialchars((string) $week['heading']); ?></h3>
          <?php endif; ?>
          <?php if (!empty($week['lead'])): ?>
          <p><?php echo br_after_period((string) $week['lead']); ?></p>
          <?php endif; ?>
        </div>
      </div>

      <?php if (!empty($week['roles']) && is_array($week['roles'])): ?>
      <ul class="grade-format__roles">
        <?php foreach ($week['roles'] as $role): ?>
        <li class="grade-format__role">
          <p class="grade-format__role-when">
            <span class="grade-format__role-icon" aria-hidden="true"><?php echo lp_icon((string) ($role['icon'] ?? 'check'), 'w-5 h-5'); ?></span>
            <?php echo htmlspecialchars((string) ($role['when'] ?? '')); ?>
            <?php if (!empty($role['time'])): ?>
            <span class="grade-format__role-time"><?php echo htmlspecialchars((string) $role['time']); ?></span>
            <?php endif; ?>
          </p>
          <p class="grade-format__role-title"><?php echo htmlspecialchars((string) ($role['title'] ?? '')); ?></p>
          <p class="grade-format__role-text"><?php echo htmlspecialchars((string) ($role['text'] ?? '')); ?></p>
        </li>
        <?php endforeach; ?>
      </ul>
      <?php endif; ?>

      <?php if (!empty($week['days']) && is_array($week['days'])): ?>
      <ol class="grade-format__days" aria-label="1週間の目安">
        <?php foreach ($week['days'] as $day): ?>
        <li>
          <span class="grade-format__day-name"><?php echo htmlspecialchars((string) ($day['day'] ?? '')); ?></span>
          <span class="grade-format__day-text"><?php echo htmlspecialchars((string) ($day['text'] ?? '')); ?></span>
        </li>
        <?php endforeach; ?>
      </ol>
      <?php endif; ?>

      <?php if (!empty($week['footnote'])): ?>
      <p class="grade-format__footnote"><?php echo htmlspecialchars((string) $week['footnote']); ?></p>
      <?php endif; ?>
    </div>
    <?php endif; ?>
  </div>
</section>
