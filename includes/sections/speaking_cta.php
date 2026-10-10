<?php
/**
 * スピーキング LP 最終 CTA
 * @var array $grade_data
 * @var array $speaking
 * @var string $speaking_primary_href
 */
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../../config.php';
}

$name_short = (string) ($grade_data['name_short'] ?? '英検');
$primary_label = (string) ($speaking['primary_label'] ?? '無料で練習する');
$parent = '/' . rawurlencode((string) ($grade ?? '')) . '/';
?>
<section class="border-t border-slate-100 bg-white px-4 py-16 sm:py-20" aria-labelledby="speaking-cta-heading">
  <div class="mx-auto max-w-2xl text-center">
    <p class="section-badge section-badge--center" aria-hidden="true">GO</p>
    <h2 id="speaking-cta-heading" class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl"><?php echo htmlspecialchars($name_short); ?>の面接練習を、<span class="heading-accent">今日から</span>。</h2>
    <p class="mt-3 text-slate-600"><?php echo br_after_period('各パート0〜3点の日本語フィードバックで、形式の抜けをその場で直せます。カード登録は不要です。'); ?></p>
    <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:justify-center">
      <a class="inline-flex items-center justify-center rounded-full bg-[#50c2cb] px-10 py-4 text-lg font-semibold text-white shadow-lg shadow-[#50c2cb]/25 transition hover:bg-[#46adb5] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#50c2cb]/60 focus-visible:ring-offset-2" href="<?php echo htmlspecialchars($speaking_primary_href, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($primary_label); ?></a>
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
