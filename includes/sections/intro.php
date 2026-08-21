<?php if (!defined('SITE_NAME')) { require_once __DIR__ . '/../../config.php'; } ?>
<section class="border-t border-slate-100 bg-white px-4 py-12 sm:py-16" aria-labelledby="intro-heading">
  <div class="lp-container">
    <div class="flex flex-col gap-8 lg:flex-row lg:items-center lg:gap-12">
      <div class="flex-1 shrink-0 lg:order-2">
        <div class="overflow-hidden rounded-2xl shadow-lg ring-1 ring-slate-900/5">
          <img src="/assets/images/intro-app-screen.jpg" alt="スマホで英検対策アプリAiKenを使っている様子" width="1024" height="683" class="h-auto w-full" loading="lazy">
        </div>
      </div>
      <div class="flex-1">
        <p class="section-badge" aria-hidden="true">ABOUT</p>
        <h2 id="intro-heading" class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl"><span class="heading-accent">英検対策アプリ<?php echo htmlspecialchars(SITE_NAME); ?></span>でできること</h2>
        <div class="intro-body mt-6 space-y-6 leading-relaxed sm:space-y-7">
          <p><?php echo br_after_period('お子さんの英検は、<strong>入試や進学にも関わる</strong>大切な検定です。保護者の方にとっても、<strong>単語</strong>・<strong>リーディング</strong>・<strong>面接対策</strong>…と教材やアプリをバラバラに揃えるのは、時間も費用もかかります。「うちの子、本当に<strong>英検対策</strong>できているのかな」と不安になる方も多いはずです。'); ?></p>
          <p><?php echo br_after_period('<span class="lp-marker">' . htmlspecialchars(SITE_NAME) . '（' . htmlspecialchars(SITE_READING) . '）は、英検5級から1級まで対応した英検対策アプリです。</span><strong>単語</strong>・<strong>リーディング</strong>・<strong>リスニング</strong>・<strong>ライティング</strong>・<strong>スピーキング</strong>を、本試験に近い形式でひとつにまとめました。学習履歴が残るので<strong>間違えた問題の復習</strong>もでき、ライティングとスピーキングは<span class="lp-marker">AIがその場で採点・フィードバックします。</span><strong>ご家庭だけでは難しい部分</strong>も、アプリ内で対策できます。'); ?></p>
        </div>
      </div>
    </div>
    <div class="mt-10 flex justify-center">
      <a class="inline-flex items-center justify-center rounded-full bg-[#50c2cb] px-10 py-4 text-lg font-semibold text-white shadow-lg shadow-[#50c2cb]/25 transition hover:bg-[#46adb5] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#50c2cb]/60 focus-visible:ring-offset-2" href="<?php echo APP_URL; ?>/signup">無料で試す</a>
    </div>
  </div>
</section>
