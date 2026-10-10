<?php
/**
 * 問題・回答・AIフィードバック例
 * @var string $grade
 * @var array $grade_data
 * @var array $speaking
 * @var string $speaking_primary_href
 */
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../../config.php';
}
require_once __DIR__ . '/../grade-data.php';
require_once __DIR__ . '/../speaking-data.php';

$name = (string) ($grade_data['name'] ?? '');
$screen = grade_screen_url($grade, 'speaking-1');
$screen_alt = (string) ($speaking['screen_alt'] ?? '');
$screen_caption = (string) ($speaking['screen_caption'] ?? '');
$kicker = (string) ($speaking['example_kicker'] ?? '');
$example_lead = (string) ($speaking['example_lead'] ?? '');
$exchanges = is_array($speaking['exchanges'] ?? null) ? $speaking['exchanges'] : [];
$feedback = is_array($speaking['feedback'] ?? null) ? $speaking['feedback'] : [];
$after = (string) ($speaking['after_example'] ?? '');
$has_try = !empty($speaking['has_try']);
$follow_href = $has_try ? speaking_signup_url() : $speaking_primary_href;
$follow_label = $has_try ? '登録して残りのパートも練習する' : (string) ($speaking['primary_label'] ?? '無料登録して練習する');
?>
<section id="speaking-example" class="border-t border-slate-100 bg-slate-50/50 px-4 py-16 sm:py-20" aria-labelledby="speaking-example-heading">
  <div class="lp-container">
    <div class="mx-auto max-w-3xl text-center">
      <p class="section-badge section-badge--center" aria-hidden="true">EXAMPLE</p>
      <h2 id="speaking-example-heading" class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">実際の問題・回答・AIフィードバック例</h2>
      <p class="mt-3 text-slate-600"><?php echo br_after_period(htmlspecialchars($example_lead, ENT_QUOTES, 'UTF-8')); ?></p>
    </div>

    <div class="speaking-example mt-10 sm:mt-12">
      <figure class="speaking-example__shot">
        <button
          type="button"
          class="grade-capture-card__zoom"
          data-grade-lightbox="<?php echo htmlspecialchars($screen, ENT_QUOTES, 'UTF-8'); ?>"
          data-grade-lightbox-caption="<?php echo htmlspecialchars($kicker !== '' ? $kicker : $name, ENT_QUOTES, 'UTF-8'); ?>"
          data-grade-lightbox-alt="<?php echo htmlspecialchars($screen_alt, ENT_QUOTES, 'UTF-8'); ?>"
          aria-label="練習画面を拡大表示"
        >
          <span class="grade-capture-card__frame">
            <img src="<?php echo htmlspecialchars($screen, ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($screen_alt, ENT_QUOTES, 'UTF-8'); ?>" class="speaking-example__img" width="1024" height="638" loading="lazy" decoding="async">
          </span>
          <span class="grade-capture-card__zoom-hint" aria-hidden="true">拡大</span>
        </button>
        <?php if ($screen_caption !== ''): ?>
        <figcaption class="speaking-example__caption"><?php echo br_after_period(htmlspecialchars($screen_caption, ENT_QUOTES, 'UTF-8')); ?></figcaption>
        <?php endif; ?>
      </figure>

      <div class="speaking-example__body">
        <?php if ($kicker !== ''): ?>
        <p class="speaking-example__kicker"><?php echo htmlspecialchars($kicker); ?></p>
        <?php endif; ?>
        <div class="speaking-qa-list">
          <?php foreach ($exchanges as $row): ?>
          <article class="speaking-qa">
            <?php if (($row['label'] ?? '') !== ''): ?>
            <p class="speaking-qa__label"><?php echo htmlspecialchars((string) $row['label']); ?></p>
            <?php endif; ?>
            <p class="speaking-qa__q"><span>質問</span><?php echo htmlspecialchars((string) ($row['q'] ?? '')); ?></p>
            <p class="speaking-qa__a"><span>答え</span><?php echo htmlspecialchars((string) ($row['a'] ?? '')); ?></p>
          </article>
          <?php endforeach; ?>
        </div>
        <div class="speaking-fb-list">
          <?php foreach ($feedback as $fb):
              $tone = ($fb['tone'] ?? '') === 'low' ? 'low' : 'high';
              ?>
          <article class="speaking-fb speaking-fb--<?php echo $tone; ?>">
            <p class="speaking-fb__score"><?php echo htmlspecialchars((string) ($fb['score'] ?? '')); ?></p>
            <p class="speaking-fb__text"><?php echo br_after_period(htmlspecialchars((string) ($fb['text'] ?? ''), ENT_QUOTES, 'UTF-8')); ?></p>
            <?php if (($fb['model'] ?? '') !== ''): ?>
            <p class="speaking-fb__model"><span>模範</span><?php echo htmlspecialchars((string) $fb['model']); ?></p>
            <?php endif; ?>
          </article>
          <?php endforeach; ?>
        </div>
      </div>
    </div>

    <?php if ($after !== ''): ?>
    <div class="speaking-after">
      <p><?php echo br_after_period(htmlspecialchars($after, ENT_QUOTES, 'UTF-8')); ?></p>
      <a class="speaking-after__button" href="<?php echo htmlspecialchars($follow_href, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($follow_label); ?></a>
    </div>
    <?php endif; ?>
  </div>
</section>
