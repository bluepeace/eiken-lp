<?php
/**
 * プライバシーポリシー（app.aiken.life/privacy を基に LP 掲載）
 */
declare(strict_types=1);

$page = 'privacy';
require_once __DIR__ . '/config.php';
$canonical = rtrim(SITE_URL, '/') . '/privacy';

include __DIR__ . '/includes/header.php';
?>
<article class="border-b border-slate-100 bg-white px-4 py-12 sm:py-16" aria-labelledby="privacy-heading">
  <div class="mx-auto max-w-3xl text-slate-800">
    <h1 id="privacy-heading" class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">プライバシーポリシー</h1>
    <p class="mt-4 text-sm leading-relaxed text-slate-600">AiKen（アイケン）（以下「当サービス」）は、ユーザーの個人情報の取り扱いについて以下のとおり定めます。</p>
    <p class="mt-4 text-sm text-slate-600">制定日：2026年2月16日<br>最終更新：2026年2月16日</p>

    <div class="mt-10 space-y-10 text-sm leading-relaxed">
      <section aria-labelledby="privacy-s1">
        <h2 id="privacy-s1" class="text-lg font-bold text-slate-900">1. はじめに</h2>
        <p class="mt-3">AiKen（アイケン、以下「当サービス」）は、ユーザーの個人情報の保護を重視しています。本プライバシーポリシー（以下「本ポリシー」）は、当サービスが収集する情報、その利用方法、およびユーザーの権利について説明します。当サービスをご利用になることで、本ポリシーに同意いただいたものとみなします。</p>
      </section>
      <section aria-labelledby="privacy-s2">
        <h2 id="privacy-s2" class="text-lg font-bold text-slate-900">2. 収集する情報</h2>
        <p class="mt-3">当サービスでは、以下の情報を収集・保存します。</p>
        <p class="mt-3 font-semibold text-slate-900">【アカウント情報】</p>
        <ul class="mt-2 list-disc space-y-2 pl-5">
          <li>メールアドレス（認証用）</li>
          <li>パスワード（暗号化して保存）</li>
          <li>表示名・ニックネーム</li>
          <li>プロフィール設定（目標級、目標受験日など）</li>
          <li>Google アカウントでログインする場合：Google から提供されるメールアドレス・表示名</li>
        </ul>
        <p class="mt-4 font-semibold text-slate-900">【学習データ】</p>
        <ul class="mt-2 list-disc space-y-2 pl-5">
          <li>単語の学習履歴・習熟度</li>
          <li>ライティングの提出内容・添削結果</li>
          <li>学習時間・連続学習日数などの統計</li>
        </ul>
        <p class="mt-4 font-semibold text-slate-900">【お問い合わせ】</p>
        <ul class="mt-2 list-disc space-y-2 pl-5">
          <li>お問い合わせフォームから送信された内容・メールアドレス</li>
        </ul>
        <p class="mt-4 font-semibold text-slate-900">【決済情報】</p>
        <p class="mt-2">クレジットカード番号等の決済情報は当サービスでは保持せず、決済代行会社（Stripe）にて処理されます。</p>
      </section>
      <section aria-labelledby="privacy-s3">
        <h2 id="privacy-s3" class="text-lg font-bold text-slate-900">3. 情報の利用目的</h2>
        <p class="mt-3">収集した情報は、以下の目的で利用します。</p>
        <ul class="mt-3 list-disc space-y-2 pl-5">
          <li>サービスの提供・運営</li>
          <li>ユーザー認証・アカウント管理</li>
          <li>学習進捗の記録・表示・パーソナライズ</li>
          <li>AI によるライティング添削</li>
          <li>お問い合わせへの対応</li>
          <li>有料プランの課金処理</li>
          <li>サービス改善・新機能の開発</li>
          <li>重要なお知らせの送信</li>
          <li>利用規約違反への対応</li>
          <li>法令に基づく対応</li>
        </ul>
      </section>
      <section aria-labelledby="privacy-s4">
        <h2 id="privacy-s4" class="text-lg font-bold text-slate-900">4. 第三者への提供</h2>
        <p class="mt-3">当サービスは、以下の第三者サービスを利用しています。これらの事業者は、それぞれのプライバシーポリシーに従って情報を処理します。</p>
        <p class="mt-4 font-semibold text-slate-900">【Supabase】</p>
        <ul class="mt-2 list-disc space-y-2 pl-5">
          <li>認証・データベース管理（アカウント情報・学習データの保存）</li>
          <li>利用規約：<a class="text-[#50c2cb] underline-offset-2 hover:underline" href="https://supabase.com/legal/privacy" rel="noopener noreferrer" target="_blank">https://supabase.com/legal/privacy</a></li>
        </ul>
        <p class="mt-4 font-semibold text-slate-900">【Stripe】</p>
        <ul class="mt-2 list-disc space-y-2 pl-5">
          <li>決済処理（カード情報等は Stripe が直接処理）</li>
          <li>利用規約：<a class="text-[#50c2cb] underline-offset-2 hover:underline" href="https://stripe.com/jp/legal" rel="noopener noreferrer" target="_blank">https://stripe.com/jp/legal</a></li>
        </ul>
        <p class="mt-4 font-semibold text-slate-900">【OpenAI】</p>
        <ul class="mt-2 list-disc space-y-2 pl-5">
          <li>ライティングの AI 添削（提出内容を送信）</li>
          <li>利用規約：<a class="text-[#50c2cb] underline-offset-2 hover:underline" href="https://openai.com/policies/privacy-policy" rel="noopener noreferrer" target="_blank">https://openai.com/policies/privacy-policy</a></li>
        </ul>
        <p class="mt-4 font-semibold text-slate-900">【Resend】</p>
        <ul class="mt-2 list-disc space-y-2 pl-5">
          <li>お問い合わせメールの送信</li>
          <li>利用規約：<a class="text-[#50c2cb] underline-offset-2 hover:underline" href="https://resend.com/legal/privacy-policy" rel="noopener noreferrer" target="_blank">https://resend.com/legal/privacy-policy</a></li>
        </ul>
        <p class="mt-4">上記以外に、法令に基づく場合を除き、ユーザーの同意なく個人情報を第三者に提供することはありません。</p>
      </section>
      <section aria-labelledby="privacy-s5">
        <h2 id="privacy-s5" class="text-lg font-bold text-slate-900">5. Cookie・ローカルストレージ</h2>
        <p class="mt-3">当サービスでは、以下の目的で Cookie およびローカルストレージを使用しています。</p>
        <ul class="mt-3 list-disc space-y-2 pl-5">
          <li>ログイン状態の維持（認証セッション）</li>
          <li>設定の保存（ダークモード等があれば）</li>
        </ul>
        <p class="mt-3">これらはサービスの提供に必要な範囲で使用します。ブラウザの設定で Cookie を無効にした場合、一部機能が正常に動作しない場合があります。</p>
      </section>
      <section aria-labelledby="privacy-s6">
        <h2 id="privacy-s6" class="text-lg font-bold text-slate-900">6. データの保管期間</h2>
        <ul class="mt-3 list-disc space-y-2 pl-5">
          <li>アカウント情報・学習データ：アカウント削除まで保管します。削除後は速やかに消去します。</li>
          <li>お問い合わせ内容：対応完了後、一定期間保管の上、削除します。</li>
          <li>決済記録：法令に基づき、必要な期間保管することがあります。</li>
        </ul>
      </section>
      <section aria-labelledby="privacy-s7">
        <h2 id="privacy-s7" class="text-lg font-bold text-slate-900">7. ユーザーの権利</h2>
        <p class="mt-3">ユーザーは、ご自身の個人情報について、以下の権利を有します。</p>
        <ul class="mt-3 list-disc space-y-2 pl-5">
          <li>アクセス権：収集した情報の開示を請求できます。</li>
          <li>訂正権：誤りのある情報の訂正を請求できます。</li>
          <li>削除権：アカウント削除により、関連データの削除を請求できます。</li>
        </ul>
        <p class="mt-3">これらの請求は、お問い合わせ窓口までご連絡ください。</p>
      </section>
      <section aria-labelledby="privacy-s8">
        <h2 id="privacy-s8" class="text-lg font-bold text-slate-900">8. セキュリティ</h2>
        <p class="mt-3">個人情報の漏えい・滅失・毀損を防ぐため、適切な技術的・組織的な対策を講じます。ただし、インターネット上のデータ送信は完全に安全であることを保証するものではありません。</p>
      </section>
      <section aria-labelledby="privacy-s9">
        <h2 id="privacy-s9" class="text-lg font-bold text-slate-900">9. 子どもの利用</h2>
        <p class="mt-3">当サービスは、16歳未満の方が保護者の同意なくご利用になることを想定していません。保護者が同意の上でご利用いただくことを推奨します。</p>
      </section>
      <section aria-labelledby="privacy-s10">
        <h2 id="privacy-s10" class="text-lg font-bold text-slate-900">10. ポリシーの変更</h2>
        <p class="mt-3">当サービスは、必要に応じて本ポリシーを改定することがあります。重要な変更がある場合は、サービス内またはメール等でお知らせします。改定後の利用をもって同意いただいたものとみなします。</p>
      </section>
      <section aria-labelledby="privacy-s11">
        <h2 id="privacy-s11" class="text-lg font-bold text-slate-900">11. お問い合わせ</h2>
        <p class="mt-3">本ポリシーに関するお問い合わせは、<a class="font-medium text-[#50c2cb] underline-offset-2 hover:underline" href="<?php echo htmlspecialchars(APP_URL); ?>/contact">お問い合わせフォーム</a>または、特定商取引法に基づく表記に記載の連絡先までご連絡ください。</p>
      </section>
    </div>

    <p class="mt-12 flex flex-wrap justify-center gap-4 text-center text-sm">
      <a class="font-medium text-[#50c2cb] underline-offset-2 hover:underline" href="/">トップに戻る</a>
      <a class="font-medium text-[#50c2cb] underline-offset-2 hover:underline" href="/terms">利用規約</a>
      <a class="font-medium text-[#50c2cb] underline-offset-2 hover:underline" href="/tokushoho">特定商取引法に基づく表記</a>
    </p>
  </div>
</article>
<?php
include __DIR__ . '/includes/footer.php';
