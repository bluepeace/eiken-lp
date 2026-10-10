<?php
/**
 * 実際のリスニング問題
 * @var string $grade
 * @var array $grade_data
 * @var array $listening
 * @var string $listening_signup_href
 */
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../../config.php';
}
require_once __DIR__ . '/../listening-data.php';

$name_short = (string) ($grade_data['name_short'] ?? '');
$shots = is_array($listening['shots'] ?? null) ? $listening['shots'] : [];
$has_image = false;
foreach ($shots as $shot) {
    if (!is_array($shot)) {
        continue;
    }
    if (listening_shot_url((string) $grade, (string) ($shot['image'] ?? '')) !== '') {
        $has_image = true;
        break;
    }
}
$intro = $has_image
    ? $name_short . 'のアプリ内の問題です。過去問の転載ではありません。'
    : '画面のキャプチャは準備中です。下は、このページ用の見本です。';
?>
<section id="listening-example" class="border-t border-slate-100 bg-white px-4 py-16 sm:py-20" aria-labelledby="listening-example-heading">
  <div class="lp-container">
    <div class="mx-auto max-w-3xl text-center">
      <p class="section-badge section-badge--center" aria-hidden="true">EXAMPLE</p>
      <h2 id="listening-example-heading" class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">実際のリスニング問題を見てみよう</h2>
      <p class="mt-3 text-slate-600"><?php echo br_after_period(htmlspecialchars($intro, ENT_QUOTES, 'UTF-8')); ?></p>
    </div>

    <?php foreach ($shots as $i => $shot):
        if (!is_array($shot)) {
            continue;
        }
        $image = (string) ($shot['image'] ?? '');
        $src = listening_shot_url((string) $grade, $image);
        $kicker = (string) ($shot['kicker'] ?? '');
        $alt = (string) ($shot['alt'] ?? $kicker);
        $caption = (string) ($shot['caption'] ?? '');
        $question = (string) ($shot['question'] ?? '');
        $note = (string) ($shot['note'] ?? '');
        $margin = $i === 0 ? 'mt-10 sm:mt-12' : 'mt-12 sm:mt-16';
        ?>
    <div class="speaking-example <?php echo $margin; ?>">
      <?php if ($src !== ''): ?>
      <figure class="speaking-example__shot">
        <button
          type="button"
          class="grade-capture-card__zoom"
          data-grade-lightbox="<?php echo htmlspecialchars($src, ENT_QUOTES, 'UTF-8'); ?>"
          data-grade-lightbox-caption="<?php echo htmlspecialchars($kicker, ENT_QUOTES, 'UTF-8'); ?>"
          data-grade-lightbox-alt="<?php echo htmlspecialchars($alt, ENT_QUOTES, 'UTF-8'); ?>"
          aria-label="<?php echo htmlspecialchars($kicker . 'の画面を拡大表示', ENT_QUOTES, 'UTF-8'); ?>"
        >
          <span class="grade-capture-card__frame">
            <img src="<?php echo htmlspecialchars($src, ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($alt, ENT_QUOTES, 'UTF-8'); ?>" class="speaking-example__img" width="1024" height="638" loading="lazy" decoding="async">
          </span>
          <span class="grade-capture-card__zoom-hint" aria-hidden="true">拡大</span>
        </button>
        <?php if ($caption !== ''): ?>
        <figcaption class="speaking-example__caption"><?php echo br_after_period(htmlspecialchars($caption, ENT_QUOTES, 'UTF-8')); ?></figcaption>
        <?php endif; ?>
      </figure>
      <?php endif; ?>
      <div class="speaking-example__body writing-stack">
        <?php if ($kicker !== ''): ?>
        <p class="speaking-example__kicker"><?php echo htmlspecialchars($kicker); ?></p>
        <?php endif; ?>
        <?php if ($src === '' && $caption !== ''): ?>
        <p class="speaking-example__caption"><?php echo br_after_period(htmlspecialchars($caption, ENT_QUOTES, 'UTF-8')); ?></p>
        <?php endif; ?>
        <?php if ($question !== ''): ?>
        <p class="writing-question"><span>QUESTION</span><?php echo htmlspecialchars($question); ?></p>
        <?php endif; ?>
        <?php if ($note !== ''): ?>
        <article class="speaking-fb speaking-fb--high">
          <p class="speaking-fb__score">この画面</p>
          <p class="speaking-fb__text"><?php echo br_after_period(htmlspecialchars($note, ENT_QUOTES, 'UTF-8')); ?></p>
        </article>
        <?php endif; ?>
      </div>
    </div>
    <?php endforeach; ?>

    <div class="speaking-after">
      <p><?php echo br_after_period('リスニングは、登録してから演習が始まります。登録なしで1問だけ聞く体験はありません。'); ?></p>
      <a class="speaking-after__button" href="<?php echo htmlspecialchars($listening_signup_href, ENT_QUOTES, 'UTF-8'); ?>">無料でリスニング対策を始める</a>
    </div>
  </div>
</section>
