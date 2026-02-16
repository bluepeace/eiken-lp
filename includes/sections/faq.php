<?php
if (!defined('SITE_NAME')) { require_once __DIR__ . '/../../config.php'; }
$faqs = [
  [
    'q' => '無料でどこまで使えますか？',
    'a' => '会員登録後、単語クイズ・ライティング（AI添削）・リーディング・リスニング・スピーキングなど、主要な機能をご利用いただけます。',
  ],
  [
    'q' => '英検〇級には対応していますか？',
    'a' => '英検5級・4級・3級・準2級・2級・準1級・1級の全級に対応しています。',
  ],
  [
    'q' => 'スマホでも使えますか？',
    'a' => 'はい。スマートフォン・タブレット・PCのブラウザから利用できます。',
  ],
  [
    'q' => '退会・解約はできますか？',
    'a' => 'はい。アプリ内の設定からいつでも退会できます。',
  ],
];
?>
<section class="border-t border-slate-100 bg-slate-50/50 px-4 py-16 sm:py-20" aria-labelledby="faq-heading">
  <div class="mx-auto max-w-2xl">
    <h2 id="faq-heading" class="text-center text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">よくある質問</h2>
    <dl class="mt-10 space-y-3">
      <?php foreach ($faqs as $i => $faq): ?>
      <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <dt class="px-5 py-4 font-semibold text-slate-900"><?php echo htmlspecialchars($faq['q']); ?></dt>
        <dd class="border-t border-slate-100 px-5 py-4 text-sm leading-relaxed text-slate-600"><?php echo nl2br(htmlspecialchars($faq['a'])); ?></dd>
      </div>
      <?php endforeach; ?>
    </dl>
  </div>
</section>
