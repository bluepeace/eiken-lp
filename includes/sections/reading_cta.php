<?php
/**
 * リーディング LP 最終 CTA
 * @var array $grade_data
 * @var string $grade
 * @var string $reading_signup_href
 */
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../../config.php';
}
$name_short = (string) ($grade_data['name_short'] ?? '英検');
$parent = '/' . rawurlencode((string) ($grade ?? '')) . '/';
?>
<section class="border-t border-slate-100 bg-white px-4 py-16 sm:py-20" aria-labelledby="reading-cta-heading">
  <div class="mx-auto max-w-2xl text-center">
    <p class="section-badge section-badge--center" aria-hidden="true">GO</p>
    <h2 id="reading-cta-heading" class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl"><?php echo htmlspecialchars($name_short); ?>の読解を、<span class="heading-accent">今日から</span>。</h2>
    <p class="mt-3 text-slate-600"><?php echo br_after_period('登録すると、その日から級の形式で演習を始められます。カード登録は不要です。'); ?></p>
    <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:justify-center">
      <a class="inline-flex items-center justify-center rounded-full bg-[#50c2cb] px-10 py-4 text-lg font-semibold text-white shadow-lg shadow-[#50c2cb]/25 transition hover:bg-[#46adb5] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#50c2cb]/60 focus-visible:ring-offset-2" href="<?php echo htmlspecialchars($reading_signup_href, ENT_QUOTES, 'UTF-8'); ?>">無料でリーディング対策を始める</a>
      <a class="inline-flex items-center justify-center rounded-full border-2 border-slate-300 bg-white px-10 py-4 text-lg font-semibold text-slate-800 transition hover:border-slate-400 hover:bg-slate-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-slate-300 focus-visible:ring-offset-2" href="<?php echo htmlspecialchars($parent); ?>"><?php echo htmlspecialchars($name_short); ?>の対策ページへ</a>
    </div>
    <?php
    $store_align = 'center';
    $store_on_hero = false;
    include __DIR__ . '/../store-cta.php';
    ?>
    <p class="mt-4 text-sm text-slate-500">カード登録不要・1分で完了</p>
  </div>
</section>
