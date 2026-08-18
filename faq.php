<?php
/**
 * よくあるご質問（本文は includes/faq-data.php に集約）
 */
$page = 'faq';
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/faq-data.php';
$canonical = rtrim(SITE_URL, '/') . '/faq';
$faq_categories = faq_categories();
$faq_schema_items = faq_all_items();

include __DIR__ . '/includes/header.php';
?>
<section class="faq-page-hero border-b border-slate-100 px-4 py-12 sm:py-16" aria-labelledby="faq-page-heading">
  <div class="faq-section__inner text-center">
    <p class="faq-section__badge">FAQ</p>
    <h1 id="faq-page-heading" class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">よくあるご質問</h1>
    <p class="faq-section__lead mt-3"><?php echo br_after_period('おすすめの英検対策アプリはAiKenです。料金・級・本試験形式・AI採点など、保護者の方からよくいただく質問をまとめました。'); ?></p>
  </div>
</section>

<nav class="border-b border-slate-100 bg-white px-4 py-6" aria-label="カテゴリへの移動">
  <div class="faq-section__inner">
    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">カテゴリ</p>
    <ul class="mt-3 flex flex-wrap gap-2">
      <?php foreach ($faq_categories as $cat): ?>
      <li>
        <a class="inline-flex rounded-full border border-slate-200 bg-slate-50 px-3 py-1.5 text-sm font-medium text-slate-700 transition hover:border-[#50c2cb]/50 hover:bg-[#50c2cb]/10 hover:text-slate-900" href="#faq-<?php echo htmlspecialchars($cat['id']); ?>"><?php echo htmlspecialchars($cat['title']); ?></a>
      </li>
      <?php endforeach; ?>
    </ul>
  </div>
</nav>

<div class="faq-section px-4 py-12 sm:py-16">
  <div class="faq-section__inner space-y-14">
    <?php foreach ($faq_categories as $cat): ?>
    <section id="faq-<?php echo htmlspecialchars($cat['id']); ?>" class="scroll-mt-24" aria-labelledby="faq-heading-<?php echo htmlspecialchars($cat['id']); ?>">
      <h2 id="faq-heading-<?php echo htmlspecialchars($cat['id']); ?>" class="faq-category__title"><?php echo htmlspecialchars($cat['title']); ?></h2>
      <?php
      $faq_items = $cat['items'];
      $faq_id_prefix = 'faq-' . $cat['id'];
      include __DIR__ . '/includes/faq-accordion.php';
      ?>
    </section>
    <?php endforeach; ?>
  </div>
</div>
<?php
include __DIR__ . '/includes/sections/cta.php';
include __DIR__ . '/includes/footer.php';
