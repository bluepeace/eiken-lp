<?php
/**
 * 外部送信に関する公表（電気通信事業法）
 * GTM・フォント・CDN 等の利用者情報の外部送信について記載
 */
declare(strict_types=1);

$page = 'external';
require_once __DIR__ . '/config.php';
$canonical = rtrim(SITE_URL, '/') . '/external-transmission';

include __DIR__ . '/includes/header.php';
?>
<article class="border-b border-slate-100 bg-white px-4 py-12 sm:py-16" aria-labelledby="external-heading">
  <div class="mx-auto max-w-3xl text-slate-800">
    <h1 id="external-heading" class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">外部送信に関する公表</h1>
    <p class="mt-4 text-sm leading-relaxed text-slate-600"><?php echo br_after_period('電気通信事業法に基づき、AiKen（アイケン）公式サイト（' . htmlspecialchars(SITE_URL, ENT_QUOTES, 'UTF-8') . '）において、利用者に関する情報を外部事業者へ送信する場合があることについて公表します。'); ?></p>
    <p class="mt-4 text-sm text-slate-600">制定日：2026年8月21日<br>最終更新：2026年8月21日</p>

    <div class="mt-10 space-y-10 text-sm leading-relaxed">
      <section aria-labelledby="external-s1">
        <h2 id="external-s1" class="text-lg font-bold text-slate-900">1. はじめに</h2>
        <p class="mt-3">当サイトでは、サイトの表示・計測・改善のため、第三者が提供するプログラム（タグ・スクリプト・フォント配信等）を読み込むことがあります。その際、ご利用の端末から当該第三者へ、IPアドレス等の情報が送信される場合があります。</p>
        <p class="mt-3">本ページは、その概要を分かりやすくまとめたものです。個人情報の取扱い全般については、<a class="font-medium text-[#50c2cb] underline-offset-2 hover:underline" href="/privacy">プライバシーポリシー</a>もあわせてご確認ください。</p>
      </section>

      <section aria-labelledby="external-s2">
        <h2 id="external-s2" class="text-lg font-bold text-slate-900">2. 外部送信の一覧</h2>

        <h3 class="mt-6 font-semibold text-slate-900">（1）Google Tag Manager</h3>
        <div class="mt-3 overflow-x-auto rounded-xl border border-slate-200">
          <table class="w-full min-w-[280px] border-collapse text-left text-sm">
            <tbody>
              <tr class="border-b border-slate-200">
                <th scope="row" class="w-[min(36%,10rem)] bg-slate-50 px-4 py-3 font-semibold text-slate-900">送信先事業者</th>
                <td class="px-4 py-3">Google LLC（Google Tag Manager）</td>
              </tr>
              <tr class="border-b border-slate-200">
                <th scope="row" class="bg-slate-50 px-4 py-3 font-semibold text-slate-900">送信される情報の例</th>
                <td class="px-4 py-3">IPアドレス、ユーザーエージェント、閲覧ページのURL、リファラー、Cookie 等により付与・参照される識別子、タグの発火に伴うイベント情報 など</td>
              </tr>
              <tr class="border-b border-slate-200">
                <th scope="row" class="bg-slate-50 px-4 py-3 font-semibold text-slate-900">利用目的</th>
                <td class="px-4 py-3">タグの一括管理、サイト利用状況の把握、サービス改善・マーケティング施策の効果測定</td>
              </tr>
              <tr class="border-b border-slate-200">
                <th scope="row" class="bg-slate-50 px-4 py-3 font-semibold text-slate-900">コンテナ ID</th>
                <td class="px-4 py-3">GTM-TW48595R</td>
              </tr>
              <tr>
                <th scope="row" class="bg-slate-50 px-4 py-3 font-semibold text-slate-900">関連情報</th>
                <td class="px-4 py-3">
                  <a class="text-[#50c2cb] underline-offset-2 hover:underline" href="https://policies.google.com/privacy" rel="noopener noreferrer" target="_blank">Google プライバシーポリシー</a><br>
                  <a class="text-[#50c2cb] underline-offset-2 hover:underline" href="https://support.google.com/tagmanager/answer/9323295" rel="noopener noreferrer" target="_blank">Google Tag Manager の利用について</a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <p class="mt-3 text-slate-600">Google Tag Manager 経由で、Google Analytics その他の計測・広告タグが読み込まれる場合があります。追加・変更した場合は、本ページを更新します。</p>

        <h3 class="mt-8 font-semibold text-slate-900">（2）Google Fonts</h3>
        <div class="mt-3 overflow-x-auto rounded-xl border border-slate-200">
          <table class="w-full min-w-[280px] border-collapse text-left text-sm">
            <tbody>
              <tr class="border-b border-slate-200">
                <th scope="row" class="w-[min(36%,10rem)] bg-slate-50 px-4 py-3 font-semibold text-slate-900">送信先事業者</th>
                <td class="px-4 py-3">Google LLC（Google Fonts）</td>
              </tr>
              <tr class="border-b border-slate-200">
                <th scope="row" class="bg-slate-50 px-4 py-3 font-semibold text-slate-900">送信される情報の例</th>
                <td class="px-4 py-3">IPアドレス、ユーザーエージェント、リクエストしたフォント情報 など</td>
              </tr>
              <tr class="border-b border-slate-200">
                <th scope="row" class="bg-slate-50 px-4 py-3 font-semibold text-slate-900">利用目的</th>
                <td class="px-4 py-3">ウェブサイト上でのフォント表示</td>
              </tr>
              <tr>
                <th scope="row" class="bg-slate-50 px-4 py-3 font-semibold text-slate-900">関連情報</th>
                <td class="px-4 py-3"><a class="text-[#50c2cb] underline-offset-2 hover:underline" href="https://policies.google.com/privacy" rel="noopener noreferrer" target="_blank">Google プライバシーポリシー</a></td>
              </tr>
            </tbody>
          </table>
        </div>

        <h3 class="mt-8 font-semibold text-slate-900">（3）Tailwind CSS（CDN）</h3>
        <div class="mt-3 overflow-x-auto rounded-xl border border-slate-200">
          <table class="w-full min-w-[280px] border-collapse text-left text-sm">
            <tbody>
              <tr class="border-b border-slate-200">
                <th scope="row" class="w-[min(36%,10rem)] bg-slate-50 px-4 py-3 font-semibold text-slate-900">送信先事業者</th>
                <td class="px-4 py-3">Tailwind Labs 等が提供する CDN（cdn.tailwindcss.com）</td>
              </tr>
              <tr class="border-b border-slate-200">
                <th scope="row" class="bg-slate-50 px-4 py-3 font-semibold text-slate-900">送信される情報の例</th>
                <td class="px-4 py-3">IPアドレス、ユーザーエージェント、リクエストしたスクリプト情報 など</td>
              </tr>
              <tr class="border-b border-slate-200">
                <th scope="row" class="bg-slate-50 px-4 py-3 font-semibold text-slate-900">利用目的</th>
                <td class="px-4 py-3">ウェブサイトのスタイル（CSS）の配信・表示</td>
              </tr>
              <tr>
                <th scope="row" class="bg-slate-50 px-4 py-3 font-semibold text-slate-900">関連情報</th>
                <td class="px-4 py-3"><a class="text-[#50c2cb] underline-offset-2 hover:underline" href="https://tailwindcss.com/privacy-policy" rel="noopener noreferrer" target="_blank">Tailwind CSS Privacy Policy</a></td>
              </tr>
            </tbody>
          </table>
        </div>
      </section>

      <section aria-labelledby="external-s3">
        <h2 id="external-s3" class="text-lg font-bold text-slate-900">3. オプトアウト等について</h2>
        <p class="mt-3">ブラウザの設定により Cookie を無効化・削除することや、各事業者が提供するオプトアウト手段を利用することで、一部の情報送信を制限できる場合があります。ただし、サイトの表示や一部機能に影響が出ることがあります。</p>
      </section>

      <section aria-labelledby="external-s4">
        <h2 id="external-s4" class="text-lg font-bold text-slate-900">4. 本公表の変更</h2>
        <p class="mt-3">利用する外部サービスや送信内容に変更があった場合は、本ページを更新します。</p>
      </section>

      <section aria-labelledby="external-s5">
        <h2 id="external-s5" class="text-lg font-bold text-slate-900">5. お問い合わせ</h2>
        <p class="mt-3">本公表に関するお問い合わせは、<a class="font-medium text-[#50c2cb] underline-offset-2 hover:underline" href="/contact">お問い合わせフォーム</a>までご連絡ください。</p>
      </section>
    </div>

    <p class="mt-12 flex flex-wrap justify-center gap-4 text-center text-sm">
      <a class="font-medium text-[#50c2cb] underline-offset-2 hover:underline" href="/">トップに戻る</a>
      <a class="font-medium text-[#50c2cb] underline-offset-2 hover:underline" href="/privacy">プライバシーポリシー</a>
    </p>
  </div>
</article>
<?php
include __DIR__ . '/includes/footer.php';
