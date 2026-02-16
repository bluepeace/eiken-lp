<?php
if (!defined('SITE_NAME')) { require_once __DIR__ . '/../../config.php'; }
global $GRADES;
?>
<section class="border-t border-slate-100 bg-white px-4 py-16 sm:py-20" aria-labelledby="grade-links-heading">
  <div class="mx-auto max-w-4xl">
    <h2 id="grade-links-heading" class="text-center text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">級別の対策ページ</h2>
    <p class="mt-3 text-center text-slate-600">目標の級を選んで、対策をはじめよう。</p>
    <ul class="mt-10 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
      <?php foreach ($GRADES as $slug => $g): ?>
      <li>
        <a class="flex items-center justify-between rounded-xl border border-slate-200 bg-slate-50/50 px-5 py-4 text-slate-800 transition hover:border-[#50c2cb]/50 hover:bg-[#50c2cb]/5 hover:text-slate-900" href="<?php echo grade_url($slug); ?>">
          <span class="font-semibold"><?php echo htmlspecialchars($g['name']); ?>＋AI対策</span>
          <span class="text-slate-400" aria-hidden="true">→</span>
        </a>
      </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
