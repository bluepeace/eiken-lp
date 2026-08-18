<?php
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../../config.php';
}

$news_items = [
    [
        'date' => '2026/06/12',
        'title' => '6月アップデートのお知らせ',
        'lead' => [
            'いつも' . SITE_NAME . 'をご利用いただきありがとうございます。',
            'この1か月ほどで追加・改善した主な内容をお知らせします。',
        ],
        'sections' => [
            [
                'heading' => '新機能・便利になったこと',
                'items' => [
                    'Google アカウントでログインできるようになりました',
                    'ヘルプ（画面右上メニュー → ヘルプ）で FAQ を選ぶか、AI に質問できます',
                    '学習履歴から「同じ問題で再演習」できるようになりました（1日の無料セット数には含まれません）',
                    'リーディング・リスニング・ライティングの履歴で、正解した問題も解説をあとから確認できます',
                    'リスニングの学習履歴で、出題内容の詳細を見られるようになりました',
                    'プレミアム購入ページから、購入履歴と領収書 PDF のダウンロードができます',
                    'プロフィールにプレミアム契約の状態を表示するようになりました',
                    'プロフィールからアカウント退会（再登録可）ができます',
                ],
            ],
            [
                'heading' => '問題・コンテンツの追加',
                'items' => [
                    '準1級・1級：Real-Life 形式、1級インタビュー（第4部）の練習問題を追加',
                    '準2級：第1部（応答文）・第2部（会話の内容一致）の問題を大幅追加',
                    '2級：リーディング長文（語句空所・内容一致）の問題を追加',
                    '3級・準2級：長文内容一致の問題を追加',
                    '5級：イラストリスニング（絵で選ぶ）の問題追加と表示の改善',
                    '各級の単語・ライティング問題も随時追加しています',
                ],
            ],
            [
                'heading' => '使いやすさの改善',
                'items' => [
                    '無料プラン：登録後5日間は各技能を制限なく利用可能。6日目以降は各技能1日1セット',
                    '単語テストで「次へ」ボタンを解説の上に配置（スクロールなしで次の問題へ）',
                    '学習ストリークを端末の日付（日本では0時）基準で計算するよう改善',
                    'ライティングで級を変更する際、確認ダイアログを表示',
                ],
            ],
        ],
        'closing' => [
            '今後も問題数の追加と機能改善を続けます。',
            'ご意見・不具合報告は各問題画面の「問題を報告する」、その他はヘルプまたはお問い合わせフォームからお知らせください。',
        ],
    ],
    [
        'date' => '2026/04/05',
        'title' => '2級、準2級の単語問題を追加しました',
        'lead' => [
            '準2級を500単語、2級を300単語追加しました。',
        ],
        'sections' => [],
        'closing' => [],
    ],
    [
        'date' => '2026/03/19',
        'title' => 'リスニング（5級）大問1、大問2を追加しました',
        'lead' => [],
        'sections' => [],
        'closing' => [],
    ],
];
?>
<section class="news-section border-t border-slate-100 px-4 py-16 sm:py-20" aria-labelledby="news-heading">
  <div class="lp-container">
    <p class="section-badge section-badge--center" aria-hidden="true">NEWS</p>
    <h2 id="news-heading" class="text-center text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">お知らせ</h2>
    <p class="news-section__lead mt-3 text-center"><?php echo br_after_period('アプリのアップデートや問題追加など、最近のお知らせです。'); ?></p>

    <div class="news-frame">
      <div class="news-frame__chrome" aria-hidden="true">
        <span></span><span></span><span></span>
        <p class="news-frame__address">お知らせ</p>
      </div>
      <div class="news-frame__body" tabindex="0" role="region" aria-label="お知らせ一覧（スクロールできます）">
        <?php foreach ($news_items as $news): ?>
        <article class="news-item">
          <header class="news-item__header">
            <h3 class="news-item__title"><?php echo htmlspecialchars($news['title']); ?></h3>
            <time class="news-item__date" datetime="<?php echo htmlspecialchars(str_replace('/', '-', $news['date'])); ?>"><?php echo htmlspecialchars($news['date']); ?></time>
          </header>
          <?php foreach ($news['lead'] as $p): ?>
          <p><?php echo htmlspecialchars($p); ?></p>
          <?php endforeach; ?>
          <?php foreach ($news['sections'] as $sec): ?>
          <h4><?php echo htmlspecialchars($sec['heading']); ?></h4>
          <ul>
            <?php foreach ($sec['items'] as $item): ?>
            <li><?php echo htmlspecialchars($item); ?></li>
            <?php endforeach; ?>
          </ul>
          <?php endforeach; ?>
          <?php foreach ($news['closing'] as $p): ?>
          <p><?php echo htmlspecialchars($p); ?></p>
          <?php endforeach; ?>
        </article>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
