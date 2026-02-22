<?php
if (!defined('SITE_NAME')) { require_once __DIR__ . '/../../config.php'; }
$faqs = [
  [
    'q' => '無料でどこまで使えますか？',
    'a' => '会員登録後、単語クイズ・ライティング（AI添削）・リーディング・リスニング・スピーキングなど、主要な機能をご利用いただけます。まずは無料で英検対策を体験してみてください。',
  ],
  [
    'q' => '英検の何級に対応していますか？',
    'a' => '英検5級・4級・3級・準2級・2級・準1級・1級の全級に対応しています。級別の出題形式に合わせた単語・リーディング・リスニング・ライティング・スピーキング対策が可能です。',
  ],
  [
    'q' => '英検 日程に合わせて勉強できますか？',
    'a' => 'はい。目標の試験日を設定し、日々の学習提案を受けながら計画的に英検対策ができます。英検 申し込みや英検 試験日を意識した勉強法で進められます。',
  ],
  [
    'q' => '英検 小学生・中学生でも使えますか？',
    'a' => 'はい。英検 何歳から・英検 いつからという疑問を持つ方にも、5級〜3級など級別の対策が可能です。スマートフォン・タブレット・PCのブラウザから利用できるので、お子様の英検 勉強法のひとつとしてご検討ください。',
  ],
  [
    'q' => 'スマホでも使えますか？',
    'a' => 'はい。スマートフォン・タブレット・PCのブラウザから利用できます。英検 単語の復習やライティング・スピーキングの練習を、すきま時間に進められます。',
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
    <p class="mt-2 text-center text-slate-600">英検 メリットや使い方について、よくいただく質問です。</p>
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
