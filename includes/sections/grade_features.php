<?php
if (!defined('SITE_NAME')) { require_once __DIR__ . '/../../config.php'; }
$g = get_grade($grade);
if (!$g) return;
$name_short = $g['name_short'];
// 4級・5級はライティング・スピーキング非対応のため文言を分岐
$has_writing_speaking = !in_array($grade, ['4kyu', '5kyu'], true);
?>
<section class="border-t border-slate-100 bg-slate-50/50 px-4 py-16 sm:py-20" aria-labelledby="grade-features-heading">
  <div class="mx-auto max-w-4xl">
    <h2 id="grade-features-heading" class="text-center text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl"><?php echo htmlspecialchars($name_short); ?>でできること</h2>
    <p class="mt-3 text-center text-slate-600">単語から<?php echo $has_writing_speaking ? '面接まで' : 'リーディングまで'; ?>、<?php echo htmlspecialchars($name_short); ?>対策に必要なものをひとつに。</p>
    <div class="mt-12 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
      <div class="rounded-xl border-l-4 border-[#F99F66] border border-slate-200 bg-white p-5">
        <span class="text-xl" aria-hidden="true">📚</span>
        <h3 class="mt-2 font-semibold text-slate-900">単語 × SRS</h3>
        <p class="mt-1 text-sm text-slate-600">忘れそうなタイミングで復習。<?php echo htmlspecialchars($name_short); ?>の語彙を効率よく覚えられます。</p>
      </div>
      <div class="rounded-xl border-l-4 border-[#50c2cb] border border-slate-200 bg-white p-5">
        <span class="text-xl" aria-hidden="true">📖</span>
        <h3 class="mt-2 font-semibold text-slate-900">リーディング</h3>
        <p class="mt-1 text-sm text-slate-600">長文読解・要約で<?php echo htmlspecialchars($name_short); ?>の読解力を鍛えます。</p>
      </div>
      <?php if ($has_writing_speaking): ?>
      <div class="rounded-xl border-l-4 border-[#A6D472] border border-slate-200 bg-white p-5">
        <span class="text-xl" aria-hidden="true">✏️</span>
        <h3 class="mt-2 font-semibold text-slate-900">ライティング × AI添削</h3>
        <p class="mt-1 text-sm text-slate-600">24時間いつでも添削。文法・構成・語彙のフィードバックで仕上げます。</p>
      </div>
      <div class="rounded-xl border-l-4 border-[#A77CBF] border border-slate-200 bg-white p-5">
        <span class="text-xl" aria-hidden="true">🎧</span>
        <h3 class="mt-2 font-semibold text-slate-900">リスニング</h3>
        <p class="mt-1 text-sm text-slate-600">音声教材で<?php echo htmlspecialchars($name_short); ?>のリスニング対策。</p>
      </div>
      <div class="rounded-xl border-l-4 border-[#F57A9C] border border-slate-200 bg-white p-5">
        <span class="text-xl" aria-hidden="true">🎤</span>
        <h3 class="mt-2 font-semibold text-slate-900">スピーキング</h3>
        <p class="mt-1 text-sm text-slate-600">面接ロールプレイで本番に近い練習ができます。</p>
      </div>
      <div class="rounded-xl border-l-4 border-[#50c2cb] border border-slate-200 bg-white p-5">
        <span class="text-xl" aria-hidden="true">🎯</span>
        <h3 class="mt-2 font-semibold text-slate-900">学習提案</h3>
        <p class="mt-1 text-sm text-slate-600">次にやるべきことを自動提案。迷わず続けられます。</p>
      </div>
      <?php else: ?>
      <div class="rounded-xl border-l-4 border-[#50c2cb] border border-slate-200 bg-white p-5">
        <span class="text-xl" aria-hidden="true">🎯</span>
        <h3 class="mt-2 font-semibold text-slate-900">学習提案</h3>
        <p class="mt-1 text-sm text-slate-600">次にやるべきことを自動提案。迷わず続けられます。</p>
      </div>
      <?php endif; ?>
    </div>
  </div>
</section>
