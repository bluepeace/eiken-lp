<?php
/**
 * 特定商取引法に基づく表記（noindex・サイトマップ除外）
 * 掲載内容は app.aiken.life/tokushoho と同一の趣旨（Stripe 審査・表示用）
 */
declare(strict_types=1);

header('X-Robots-Tag: noindex, follow', true);

$page = 'tokushoho';
require_once __DIR__ . '/config.php';
$canonical = rtrim(SITE_URL, '/') . '/tokushoho';

$tokushoho_rows = [
    ['事業者名', 'AiKen'],
    ['事業者氏名', '森山卓'],
    ['所在地', '〒182-0006 東京都調布市西つつじヶ丘4-23-59-703'],
    ['電話番号', '090-1743-3178'],
    ['メールアドレス', 'aiken.mame@gmail.com'],
    ['営業時間', '平日 10:00〜18:00'],
    ['販売価格', '各プランの料金はサービス内の料金表に表示する価格（税込）とします。'],
    ['支払方法', 'クレジットカード決済（Stripe）。代金は各課金サイクル（月額の場合は毎月の契約日）に自動課金されます。'],
    ['支払時期', 'サブスクリプション登録時に初回分を請求。以降、毎月の契約日に自動で請求します。'],
    ['役務の提供時期', 'お支払い完了後、即時にお申し込みのプランをご利用いただけます。'],
    [
        '返品・キャンセル・解約',
        "【サブスクリプションの解約】\n"
        . "・いつでも解約可能です。解約手続きは「プレミアム」ページ内の「サブスクリプションを管理」より行ってください。\n"
        . "・解約後も、お支払い済みの期間まではサービスをご利用いただけます。\n"
        . "・解約後の返金はいたしかねます。\n"
        . "\n"
        . "【初回申込み後のキャンセル】\n"
        . "・クーリング・オフ：電子メディアを利用した役務については、契約成立後は原則クーリング・オフの対象外です。\n"
        . "・誤って申し込んだ場合など、お早めにご連絡いただければご相談に応じます。",
    ],
    ['事業者の責任に関する事項', '当サービスはインターネット環境に依存するため、通信障害等により一時的にご利用いただけない場合があります。'],
    ['支払可能な手段の価格表示に関する事項', '表示価格は全て税込です。'],
    ['事業者団体の名称・所在地・連絡先', '当サービスは事業者団体には所属しておりません。'],
    ['相談窓口', 'お住まいの地域の消費生活センター等の相談窓口をご利用ください。'],
];

include __DIR__ . '/includes/header.php';
?>
<article class="border-b border-slate-100 bg-white px-4 py-12 sm:py-16" aria-labelledby="tokushoho-heading">
  <div class="mx-auto max-w-3xl">
    <h1 id="tokushoho-heading" class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">特定商取引法に基づく表記</h1>
    <p class="mt-3 text-sm text-slate-600"><?php echo br_after_period('AiKen（アイケン）のオンラインサービス（サブスクリプション）に関する表記です。'); ?></p>
    <div class="mt-8 overflow-x-auto rounded-xl border border-slate-200 shadow-sm">
      <table class="w-full min-w-[280px] border-collapse text-left text-sm text-slate-800">
        <tbody>
          <?php foreach ($tokushoho_rows as $row): ?>
          <tr class="border-b border-slate-200 last:border-b-0">
            <th scope="row" class="w-[min(32%,11rem)] align-top bg-slate-50 px-4 py-3 font-semibold text-slate-900 sm:px-5 sm:py-4"><?php echo htmlspecialchars($row[0]); ?></th>
            <td class="px-4 py-3 leading-relaxed text-slate-700 sm:px-5 sm:py-4"><?php echo nl2br(htmlspecialchars($row[1])); ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <p class="mt-8 text-xs text-slate-500">最終更新：2026年2月16日</p>
    <p class="mt-6 text-center text-sm">
      <a class="font-medium text-[#50c2cb] underline-offset-2 hover:underline" href="/">トップに戻る</a>
    </p>
  </div>
</article>
<?php
include __DIR__ . '/includes/footer.php';
