<?php
/**
 * 実際のAI添削
 * @var string $grade
 * @var array $grade_data
 * @var array $writing
 * @var string $writing_signup_href
 */
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../../config.php';
}
require_once __DIR__ . '/../grade-data.php';

$name_short = (string) ($grade_data['name_short'] ?? '');
$essay = is_array($writing['essay'] ?? null) ? $writing['essay'] : [];
$second = is_array($writing['second'] ?? null) ? $writing['second'] : [];
$result = grade_screen_url($grade, 'writing-3');
$result_alt = (string) ($writing['result_alt'] ?? '');
$result_caption = (string) ($writing['result_caption'] ?? '');
$second_shot = grade_screen_url($grade, 'writing-1');
$after_label = (string) ($writing['after_label'] ?? '登録して続きを練習する');
?>
<section id="writing-example" class="border-t border-slate-100 bg-white px-4 py-16 sm:py-20" aria-labelledby="writing-example-heading">
  <div class="lp-container">
    <div class="mx-auto max-w-3xl text-center">
      <p class="section-badge section-badge--center" aria-hidden="true">EXAMPLE</p>
      <h2 id="writing-example-heading" class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">実際のAI添削を見てみよう</h2>
      <p class="mt-3 text-slate-600"><?php echo br_after_period(htmlspecialchars($name_short, ENT_QUOTES, 'UTF-8') . 'のオリジナル問題です。過去問の転載ではありません。採点は各観点0〜5点で、総合はその平均です。'); ?></p>
    </div>

    <div class="speaking-example mt-10 sm:mt-12">
      <figure class="speaking-example__shot">
        <button
          type="button"
          class="grade-capture-card__zoom"
          data-grade-lightbox="<?php echo htmlspecialchars($result, ENT_QUOTES, 'UTF-8'); ?>"
          data-grade-lightbox-caption="添削結果"
          data-grade-lightbox-alt="<?php echo htmlspecialchars($result_alt, ENT_QUOTES, 'UTF-8'); ?>"
          aria-label="添削結果の画面を拡大表示"
        >
          <span class="grade-capture-card__frame">
            <img src="<?php echo htmlspecialchars($result, ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($result_alt, ENT_QUOTES, 'UTF-8'); ?>" class="speaking-example__img" width="1024" height="638" loading="lazy" decoding="async">
          </span>
          <span class="grade-capture-card__zoom-hint" aria-hidden="true">拡大</span>
        </button>
        <?php if ($result_caption !== ''): ?>
        <figcaption class="speaking-example__caption"><?php echo br_after_period(htmlspecialchars($result_caption, ENT_QUOTES, 'UTF-8')); ?></figcaption>
        <?php endif; ?>
      </figure>
      <div class="speaking-example__body writing-stack">
        <p class="speaking-example__kicker">英作文</p>
        <?php if (($essay['question'] ?? '') !== ''): ?>
        <p class="writing-question"><span>QUESTION</span><?php echo htmlspecialchars((string) $essay['question']); ?></p>
        <?php endif; ?>
        <?php if (($essay['weak'] ?? '') !== ''): ?>
        <article class="speaking-qa">
          <p class="speaking-qa__label">書きかけの答案</p>
          <p class="speaking-qa__a"><?php echo htmlspecialchars((string) $essay['weak']); ?></p>
        </article>
        <?php endif; ?>
        <?php if (($essay['comment'] ?? '') !== ''): ?>
        <article class="speaking-fb speaking-fb--low">
          <p class="speaking-fb__score">内容・構成・指示遵守が下がる例</p>
          <p class="speaking-fb__text"><?php echo br_after_period(htmlspecialchars((string) $essay['comment'], ENT_QUOTES, 'UTF-8')); ?></p>
        </article>
        <?php endif; ?>
        <?php if (($essay['model'] ?? '') !== ''): ?>
        <article class="speaking-fb speaking-fb--high">
          <p class="speaking-fb__score">模範の型</p>
          <p class="speaking-fb__text"><?php echo htmlspecialchars((string) $essay['model']); ?></p>
        </article>
        <?php endif; ?>
        <?php if (($essay['aside'] ?? '') !== ''): ?>
        <p class="writing-aside"><?php echo br_after_period(htmlspecialchars((string) $essay['aside'], ENT_QUOTES, 'UTF-8')); ?></p>
        <?php endif; ?>
      </div>
    </div>

    <?php if ($second !== []): ?>
    <div class="speaking-example mt-12 sm:mt-16">
      <figure class="speaking-example__shot">
        <button
          type="button"
          class="grade-capture-card__zoom"
          data-grade-lightbox="<?php echo htmlspecialchars($second_shot, ENT_QUOTES, 'UTF-8'); ?>"
          data-grade-lightbox-caption="<?php echo htmlspecialchars((string) ($second['kicker'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>"
          data-grade-lightbox-alt="<?php echo htmlspecialchars((string) ($second['shot_alt'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>"
          aria-label="<?php echo htmlspecialchars((string) ($second['kicker'] ?? '問題') . 'の画面を拡大表示', ENT_QUOTES, 'UTF-8'); ?>"
        >
          <span class="grade-capture-card__frame">
            <img src="<?php echo htmlspecialchars($second_shot, ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars((string) ($second['shot_alt'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>" class="speaking-example__img" width="1024" height="638" loading="lazy" decoding="async">
          </span>
          <span class="grade-capture-card__zoom-hint" aria-hidden="true">拡大</span>
        </button>
        <?php if (($second['shot_caption'] ?? '') !== ''): ?>
        <figcaption class="speaking-example__caption"><?php echo br_after_period(htmlspecialchars((string) $second['shot_caption'], ENT_QUOTES, 'UTF-8')); ?></figcaption>
        <?php endif; ?>
      </figure>
      <div class="speaking-example__body writing-stack">
        <?php if (($second['kicker'] ?? '') !== ''): ?>
        <p class="speaking-example__kicker"><?php echo htmlspecialchars((string) $second['kicker']); ?></p>
        <?php endif; ?>
        <?php if (($second['lead'] ?? '') !== ''): ?>
        <p class="writing-aside"><?php echo br_after_period(htmlspecialchars((string) $second['lead'], ENT_QUOTES, 'UTF-8')); ?></p>
        <?php endif; ?>
        <?php if (($second['model'] ?? '') !== ''): ?>
        <article class="speaking-fb speaking-fb--high">
          <p class="speaking-fb__score">見本</p>
          <p class="speaking-fb__text"><?php echo htmlspecialchars((string) $second['model']); ?></p>
        </article>
        <?php endif; ?>
        <?php if (($second['pitfall'] ?? '') !== ''): ?>
        <article class="speaking-fb speaking-fb--low">
          <p class="speaking-fb__score">点が落ちる典型</p>
          <p class="speaking-fb__text"><?php echo br_after_period(htmlspecialchars((string) $second['pitfall'], ENT_QUOTES, 'UTF-8')); ?></p>
        </article>
        <?php endif; ?>
      </div>
    </div>
    <?php endif; ?>

    <div class="speaking-after">
      <p><?php echo br_after_period('登録なしで試せるのは英作文1問です。もう一つの形式は、登録後に同じ添削で練習できます。'); ?></p>
      <a class="speaking-after__button" href="<?php echo htmlspecialchars($writing_signup_href, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($after_label); ?></a>
    </div>
  </div>
</section>
