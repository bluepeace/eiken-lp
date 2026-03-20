<?php
/**
 * 利用規約（app.aiken.life/terms を基に LP 掲載）
 */
declare(strict_types=1);

$page = 'terms';
require_once __DIR__ . '/config.php';
$canonical = rtrim(SITE_URL, '/') . '/terms';

include __DIR__ . '/includes/header.php';
?>
<article class="border-b border-slate-100 bg-white px-4 py-12 sm:py-16" aria-labelledby="terms-heading">
  <div class="mx-auto max-w-3xl text-slate-800">
    <h1 id="terms-heading" class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">利用規約</h1>
    <p class="mt-3 text-sm leading-relaxed text-slate-600">AiKen（アイケン、以下「本サービス」）の利用に関する規約です。</p>
    <p class="mt-4 text-sm text-slate-600">制定日：2026年2月16日<br>最終更新：2026年2月16日</p>

    <div class="mt-10 space-y-10 text-sm leading-relaxed">
      <section aria-labelledby="terms-s1">
        <h2 id="terms-s1" class="text-lg font-bold text-slate-900">第1条（適用）</h2>
        <p class="mt-3">本利用規約（以下「本規約」）は、AiKen（アイケン、以下「本サービス」）の利用に関する条件を定めるものです。ユーザーは、本サービスを利用することにより、本規約に同意したものとみなされます。</p>
      </section>
      <section aria-labelledby="terms-s2">
        <h2 id="terms-s2" class="text-lg font-bold text-slate-900">第2条（定義）</h2>
        <ul class="mt-3 list-disc space-y-2 pl-5">
          <li>「本サービス」：AiKen が提供する英検対策のためのオンライン学習サービス（単語学習、ライティング添削、その他関連機能を含む）をいいます。</li>
          <li>「ユーザー」：本サービスを利用する全ての方をいいます。</li>
          <li>「コンテンツ」：本サービス上で提供される文章、画像、データその他一切の情報をいいます。</li>
        </ul>
      </section>
      <section aria-labelledby="terms-s3">
        <h2 id="terms-s3" class="text-lg font-bold text-slate-900">第3条（アカウント登録）</h2>
        <ol class="mt-3 list-decimal space-y-2 pl-5">
          <li>本サービスの一部機能をご利用になるには、アカウント登録が必要です。</li>
          <li>登録時に提供された情報は正確かつ最新のものである必要があります。</li>
          <li>アカウントの管理責任はユーザーにあります。パスワードの第三者利用による損害について、当サービスは責任を負いません。</li>
        </ol>
      </section>
      <section aria-labelledby="terms-s4">
        <h2 id="terms-s4" class="text-lg font-bold text-slate-900">第4条（利用料金）</h2>
        <ol class="mt-3 list-decimal space-y-2 pl-5">
          <li>本サービスには無料でご利用いただける範囲と、有料プラン（プレミアム）があります。</li>
          <li>有料プランの料金・支払方法は、サービス内の料金表および特定商取引法に基づく表記に従います。</li>
          <li>有料プランは、解約手続きを行うまで毎月自動更新されます。解約後も、お支払い済みの期間まではご利用いただけます。</li>
          <li>一度お支払いいただいた料金の返金は、法令で認められる場合を除き行いません。</li>
        </ol>
      </section>
      <section aria-labelledby="terms-s5">
        <h2 id="terms-s5" class="text-lg font-bold text-slate-900">第5条（禁止事項）</h2>
        <p class="mt-3">ユーザーは、以下の行為を行ってはなりません。</p>
        <ul class="mt-3 list-disc space-y-2 pl-5">
          <li>法令または公序良俗に反する行為</li>
          <li>当サービスまたは第三者の権利を侵害する行為</li>
          <li>当サービスの運営を妨害する行為（不正アクセス、過度な負荷のかける行為など）</li>
          <li>他のユーザーまたは第三者になりすます行為</li>
          <li>本サービスのコンテンツを無断で複製・転載・再配布する行為</li>
          <li>AI 添削結果等を営利目的で二次利用する行為</li>
          <li>その他、当サービスが不適切と判断する行為</li>
        </ul>
      </section>
      <section aria-labelledby="terms-s6">
        <h2 id="terms-s6" class="text-lg font-bold text-slate-900">第6条（知的財産権）</h2>
        <p class="mt-3">本サービスに含まれるコンテンツ（プログラム、デザイン、ロゴ、文章等）の知的財産権は、当サービスまたは正当な権利者に帰属します。ユーザーは、本サービスで提供される学習機能を利用する権利のみを有し、コンテンツの複製・改変・販売等を行うことはできません。</p>
      </section>
      <section aria-labelledby="terms-s7">
        <h2 id="terms-s7" class="text-lg font-bold text-slate-900">第7条（サービスの変更・中断・終了）</h2>
        <p class="mt-3">当サービスは、以下の場合に事前の通知なくサービス内容の変更、一時的な中断、または終了を行う場合があります。</p>
        <ul class="mt-3 list-disc space-y-2 pl-5">
          <li>保守・点検・更新のため</li>
          <li>天災、事故、その他不可抗力により</li>
          <li>その他運営上必要と判断した場合</li>
        </ul>
        <p class="mt-3">有料プランをご利用中にサービスを終了する場合は、可能な限り事前にお知らせし、残りの利用期間に応じた返金等の対応を行うことがあります。</p>
      </section>
      <section aria-labelledby="terms-s8">
        <h2 id="terms-s8" class="text-lg font-bold text-slate-900">第8条（免責事項）</h2>
        <ol class="mt-3 list-decimal space-y-2 pl-5">
          <li>当サービスは、英検合格等の学習成果を保証するものではありません。</li>
          <li>AI 添削結果は参考情報であり、採点の正確性を保証するものではありません。</li>
          <li>通信環境・端末等の理由によりサービスが利用できない場合、当サービスは責任を負いません。</li>
          <li>法令上の責任を免責するものではありません。</li>
        </ol>
      </section>
      <section aria-labelledby="terms-s9">
        <h2 id="terms-s9" class="text-lg font-bold text-slate-900">第9条（損害賠償の制限）</h2>
        <p class="mt-3">当サービスは、ユーザーが本サービスを利用して被った損害について、当サービスに故意または重過失がある場合を除き、責任を負いません。また、有料プランの場合であっても、賠償責任の範囲は、当該ユーザーが当サービスに支払った直近3か月分の料金を上限とすることがあります。</p>
      </section>
      <section aria-labelledby="terms-s10">
        <h2 id="terms-s10" class="text-lg font-bold text-slate-900">第10条（規約の変更）</h2>
        <p class="mt-3">当サービスは、必要に応じて本規約を変更することができます。重要な変更がある場合は、サービス内での通知、メール送信等によりお知らせします。変更後に本サービスを利用された場合、変更後の規約に同意したものとみなします。</p>
      </section>
      <section aria-labelledby="terms-s11">
        <h2 id="terms-s11" class="text-lg font-bold text-slate-900">第11条（準拠法・管轄）</h2>
        <p class="mt-3">本規約は日本法に準拠します。本サービスに関する紛争については、当サービスの本店所在地を管轄する裁判所を第一審の専属的合意管轄裁判所とします。</p>
      </section>
      <section aria-labelledby="terms-s12">
        <h2 id="terms-s12" class="text-lg font-bold text-slate-900">第12条（お問い合わせ）</h2>
        <p class="mt-3">本規約に関するお問い合わせは、<a class="font-medium text-[#50c2cb] underline-offset-2 hover:underline" href="<?php echo htmlspecialchars(APP_URL); ?>/contact">お問い合わせフォーム</a>または、特定商取引法に基づく表記に記載の連絡先までご連絡ください。</p>
      </section>
    </div>

    <p class="mt-12 flex flex-wrap justify-center gap-4 text-center text-sm">
      <a class="font-medium text-[#50c2cb] underline-offset-2 hover:underline" href="/">トップに戻る</a>
      <a class="font-medium text-[#50c2cb] underline-offset-2 hover:underline" href="/privacy">プライバシーポリシー</a>
      <a class="font-medium text-[#50c2cb] underline-offset-2 hover:underline" href="/tokushoho">特定商取引法に基づく表記</a>
    </p>
  </div>
</article>
<?php
include __DIR__ . '/includes/footer.php';
