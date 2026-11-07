<?php
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../../config.php';
}
require_once __DIR__ . '/../buddy-data.php';

$buddy_items = buddy_cast();
?>
<section class="buddies-section border-t border-slate-100 bg-white px-4 py-16 sm:py-20" aria-labelledby="buddies-heading">
  <div class="lp-container">
    <div class="mx-auto max-w-3xl text-center">
      <p class="section-badge section-badge--center" aria-hidden="true">BUDDIES</p>
      <h2 id="buddies-heading" class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">愛犬（バディ）紹介</h2>
      <p class="mt-3 text-slate-600"><?php echo br_after_period('学習のそばにいてくれる10匹のバディ。あなたに合う子を選んで、一緒に英検対策を続けましょう。'); ?></p>
      <div class="mt-8 flex justify-center">
        <?php buddy_say('mame', 'マメ', '10匹いるよ。気に入った子と、英検を続けよう。', 'lg'); ?>
      </div>
    </div>

    <ul class="buddies-grid mt-10 sm:mt-12">
      <?php foreach ($buddy_items as $buddy): ?>
      <li class="buddy-card">
        <div class="buddy-card__media">
          <img
            src="/assets/images/buddies/<?php echo htmlspecialchars($buddy['slug']); ?>.png"
            alt="<?php echo htmlspecialchars('バディ「' . $buddy['name'] . '」'); ?>"
            width="320"
            height="320"
            class="buddy-card__img"
            loading="lazy"
            decoding="async"
          >
        </div>
        <h3 class="buddy-card__name"><?php echo htmlspecialchars($buddy['name']); ?></h3>
        <p class="buddy-card__text"><?php echo br_after_period($buddy['text']); ?></p>
      </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
