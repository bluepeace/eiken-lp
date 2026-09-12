<?php
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../../config.php';
}

$headers = ['見るポイント', '単語アプリ', '塾・教室', '過去問・教材', SITE_NAME];
$rows = [
    ['級の範囲', '級が限られることが多い', '講座による', '級ごとに揃える', '5級〜1級'],
    ['出題形式', '単語が中心', '授業が中心', '本番に近い', '本試験形式'],
    ['技能', '単語が中心', '講座次第', '技能は分かれがち', '単語＋4技能'],
    ['添削・面接', 'なし', '先生が添削', '自己採点が中心', 'AIがその場で'],
    ['いまの形式', '弱いことが多い', '講座次第', '要約・Eメールは不足しがち', '要約・Eメール対応'],
    ['続け方', 'スキマ向き', '通う必要がある', '机が必要になりやすい', 'スキマ＋自宅'],
    ['費用感', '安い〜中', '高い', '都度購入', monthly_price_label(false)],
];
$aiken_col = count($headers) - 1;
?>
<section class="choose-app border-t border-slate-100 bg-slate-50/50 px-4 py-16 sm:py-20" aria-labelledby="choose-app-heading">
  <div class="lp-container">
    <div class="mx-auto max-w-3xl text-center">
      <p class="section-badge section-badge--center" aria-hidden="true">COMPARE</p>
      <h2 id="choose-app-heading" class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl"><span class="heading-accent">英検対策アプリ</span>の選び方</h2>
      <p class="mt-3 text-slate-600"><?php echo br_after_period('単語だけ・塾・過去問、どれが合うかは目的次第です。2024年度以降の要約・Eメールまで本試験形式で進めたいなら、技能の範囲と添削の有無を先に見ると迷いません。'); ?></p>
    </div>

    <div class="choose-app__table-wrap mt-10 sm:mt-12">
      <div class="grade-position__scroll" tabindex="0">
        <table class="grade-position__table choose-app__table">
          <thead>
            <tr>
              <?php foreach ($headers as $i => $header): ?>
              <th scope="col"<?php echo $i === $aiken_col ? ' class="is-current"' : ''; ?>><?php echo htmlspecialchars($header); ?></th>
              <?php endforeach; ?>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($rows as $row): ?>
            <tr>
              <?php foreach ($row as $i => $cell):
                  $is_head = $i === 0;
                  $tag = $is_head ? 'th' : 'td';
                  $scope = $is_head ? ' scope="row"' : '';
                  $class = $i === $aiken_col ? ' class="is-current"' : '';
                  ?>
              <<?php echo $tag; ?><?php echo $scope; ?><?php echo $class; ?>><?php echo htmlspecialchars($cell); ?></<?php echo $tag; ?>>
              <?php endforeach; ?>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <p class="grade-position__note"><?php echo br_after_period('一般的な傾向です。講座や教材によって内容は異なります。AiKenは' . FREE_TRIAL_DAYS . '日間、カード登録なしで全機能を試せます。'); ?></p>
    </div>

    <div class="mt-10 flex justify-center">
      <a class="inline-flex items-center justify-center rounded-full bg-[#50c2cb] px-10 py-4 text-lg font-semibold text-white shadow-lg shadow-[#50c2cb]/25 transition hover:bg-[#46adb5] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#50c2cb]/60 focus-visible:ring-offset-2" href="<?php echo APP_URL; ?>/signup"><?php echo FREE_TRIAL_DAYS; ?>日間無料で試す</a>
    </div>
  </div>
</section>
