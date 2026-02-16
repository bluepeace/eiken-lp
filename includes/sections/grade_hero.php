<?php
if (!defined('SITE_NAME')) { require_once __DIR__ . '/../../config.php'; }
$g = get_grade($grade);
if (!$g) return;
$name = $g['name'];
$name_short = $g['name_short'];
?>
<section class="relative overflow-hidden bg-gradient-to-b from-slate-50 to-white px-4 py-16 sm:py-20 md:py-24" aria-labelledby="grade-hero-heading">
  <div class="mx-auto max-w-3xl text-center">
    <p class="mb-3 text-sm font-medium text-slate-600"><?php echo htmlspecialchars($name); ?>対策</p>
    <h1 id="grade-hero-heading" class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl md:text-5xl">
      <?php echo htmlspecialchars($name_short); ?>を、<span class="text-[#50c2cb]">AIで。</span>
    </h1>
    <p class="mt-6 max-w-xl mx-auto text-base leading-relaxed text-slate-600 sm:text-lg">
      <?php echo htmlspecialchars($g['description']); ?>
    </p>
    <div class="mt-10 flex flex-col gap-3 sm:flex-row sm:justify-center">
      <a class="inline-flex items-center justify-center rounded-full bg-[#50c2cb] px-8 py-3.5 text-base font-semibold text-white shadow-lg shadow-[#50c2cb]/25 transition hover:bg-[#46adb5] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#50c2cb]/60 focus-visible:ring-offset-2" href="<?php echo APP_URL; ?>/signup">無料ではじめる</a>
      <a class="inline-flex items-center justify-center rounded-full border-2 border-slate-300 bg-white px-8 py-3.5 text-base font-semibold text-slate-800 transition hover:border-slate-400 hover:bg-slate-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-slate-300 focus-visible:ring-offset-2" href="<?php echo SITE_URL; ?>/">他の級を見る</a>
    </div>
  </div>
</section>
