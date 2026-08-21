<?php
/**
 * 使い方ガイド／ヘルプ（手順寄り・キャプチャ枠あり）
 */
declare(strict_types=1);

$page = 'guide';
require_once __DIR__ . '/config.php';
$canonical = rtrim(SITE_URL, '/') . '/guide';

/**
 * ガイド用キャプチャ（専用画像がなければ共通アプリ画面へフォールバック）
 */
function guide_screen_url(string $key): string
{
    $dir = __DIR__ . '/assets/images/guide/';
    foreach (['.png', '.jpg', '.jpeg', '.webp'] as $ext) {
        if (is_file($dir . $key . $ext)) {
            return '/assets/images/guide/' . $key . $ext;
        }
    }
    $fallback = [
        'signup' => 'word',
        'profile' => 'word',
        'word' => 'word',
        'reading' => 'reading',
        'listening' => 'listening',
        'writing' => 'writing',
        'premium' => 'writing',
    ];
    $skill = $fallback[$key] ?? 'word';
    $common = __DIR__ . '/assets/images/';
    foreach (['.png', '.jpg', '.jpeg', '.webp'] as $ext) {
        $file = 'app-screen-' . $skill . $ext;
        if (is_file($common . $file)) {
            return '/assets/images/' . $file;
        }
    }
    return '/assets/images/app-screen-placeholder.svg';
}

$steps = [
    [
        'id' => 'start',
        'title' => '会員登録からはじめる',
        'lead' => 'カード登録は不要。メールでアカウントを作成し、すぐに学習を開始できます。',
        'bullets' => [
            APP_URL . '/signup から会員登録',
            'プロフィールで目標の級とバディ（愛犬）を設定',
            FREE_TRIAL_DAYS . '日間は全機能を無料で利用可能',
        ],
        'image' => 'signup',
        'caption' => '会員登録・プロフィール設定のイメージ',
    ],
    [
        'id' => 'word',
        'title' => '単語を4択で練習する',
        'lead' => '級別の語彙をクイズ形式で出題。選んだ直後に正誤と解説が表示されます。',
        'bullets' => [
            'スキマ時間に1問ずつ進められる',
            '間違えた問題は履歴から復習',
            '音声・例文がある問題では耳からも定着',
        ],
        'image' => 'word',
        'caption' => '単語クイズ画面のイメージ',
    ],
    [
        'id' => 'skills',
        'title' => 'リーディング・リスニング・ライティング',
        'lead' => '本試験に近い形式で反復。ライティングはAIがその場で添削します。',
        'bullets' => [
            '読解は正誤ハイライトと解説で振り返りやすい',
            'リスニングは本番を意識した放送回数の設計',
            '英作文・要約・Eメール（級による）をAI添削',
        ],
        'image' => 'writing',
        'caption' => '学習画面・AI添削のイメージ',
    ],
    [
        'id' => 'premium',
        'title' => 'プランの確認・解約',
        'lead' => '料金や解約はアプリ内のプレミアム画面から確認できます。',
        'bullets' => [
            'プレミアムページでプラン状況を確認',
            '「サブスクリプションを管理」から解約',
            '詳細手順は退会・解約ページでも案内',
        ],
        'image' => 'premium',
        'caption' => 'プラン管理のイメージ（差し替え予定）',
        'link' => ['href' => '/cancel', 'label' => '退会・解約の手順へ'],
    ],
];

include __DIR__ . '/includes/header.php';
?>
<article class="border-b border-slate-100 bg-white" aria-labelledby="guide-heading">
  <section class="border-b border-slate-100 bg-gradient-to-b from-[#e8f8f9] to-white px-4 py-14 sm:py-20">
    <div class="mx-auto max-w-3xl text-center">
      <p class="section-badge section-badge--center" aria-hidden="true">GUIDE</p>
      <h1 id="guide-heading" class="mt-3 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">使い方ガイド</h1>
      <p class="mt-4 text-base leading-relaxed text-slate-700"><?php echo br_after_period('AiKen（アイケン）の始め方から、単語・技能練習、プラン確認までの手順です。画面イメージは後日差し替え予定の枠を含みます。'); ?></p>
    </div>
  </section>

  <nav class="border-b border-slate-100 px-4 py-6" aria-label="ガイド目次">
    <div class="mx-auto flex max-w-3xl flex-wrap gap-x-5 gap-y-2 text-sm font-medium text-slate-600">
      <?php foreach ($steps as $s): ?>
      <a class="hover:text-[#50c2cb] hover:underline" href="#guide-<?php echo htmlspecialchars($s['id']); ?>"><?php echo htmlspecialchars($s['title']); ?></a>
      <?php endforeach; ?>
    </div>
  </nav>

  <div class="mx-auto max-w-3xl px-4 py-12 sm:py-16">
    <?php foreach ($steps as $i => $s):
        $src = guide_screen_url($s['image']);
        $reverse = $i % 2 === 1;
        ?>
    <section id="guide-<?php echo htmlspecialchars($s['id']); ?>" class="guide-step border-b border-slate-100 py-12 last:border-b-0 sm:py-14" aria-labelledby="guide-<?php echo htmlspecialchars($s['id']); ?>-heading">
      <div class="guide-step__grid<?php echo $reverse ? ' guide-step__grid--reverse' : ''; ?>">
        <div>
          <p class="text-xs font-semibold tracking-wide text-[#50c2cb]">STEP <?php echo $i + 1; ?></p>
          <h2 id="guide-<?php echo htmlspecialchars($s['id']); ?>-heading" class="mt-2 text-xl font-bold text-slate-900 sm:text-2xl"><?php echo htmlspecialchars($s['title']); ?></h2>
          <p class="mt-3 text-sm leading-relaxed text-slate-600"><?php echo br_after_period($s['lead']); ?></p>
          <ul class="mt-4 space-y-2 text-sm text-slate-700">
            <?php foreach ($s['bullets'] as $b): ?>
            <li class="flex gap-2"><span class="shrink-0 text-[#50c2cb]"><?php echo lp_icon('check', 'w-5 h-5'); ?></span><span><?php echo htmlspecialchars($b); ?></span></li>
            <?php endforeach; ?>
          </ul>
          <?php if (!empty($s['link'])): ?>
          <p class="mt-4"><a class="text-sm font-semibold text-[#50c2cb] underline-offset-2 hover:underline" href="<?php echo htmlspecialchars($s['link']['href']); ?>"><?php echo htmlspecialchars($s['link']['label']); ?></a></p>
          <?php endif; ?>
        </div>
        <figure class="guide-step__figure">
          <div class="guide-step__frame">
            <img src="<?php echo htmlspecialchars($src); ?>" alt="" class="guide-step__img" loading="lazy" decoding="async" width="360" height="640">
          </div>
          <figcaption class="mt-3 text-center text-xs text-slate-500"><?php echo htmlspecialchars($s['caption']); ?></figcaption>
        </figure>
      </div>
    </section>
    <?php endforeach; ?>

    <section class="mt-4 rounded-xl border border-slate-200 bg-slate-50/50 px-5 py-6" aria-labelledby="guide-more">
      <h2 id="guide-more" class="text-lg font-bold text-slate-900">うまくいかないときは</h2>
      <ul class="mt-3 list-disc space-y-2 pl-5 text-sm text-slate-700">
        <li><a class="font-medium text-[#50c2cb] underline-offset-2 hover:underline" href="/faq">よくあるご質問</a></li>
        <li><a class="font-medium text-[#50c2cb] underline-offset-2 hover:underline" href="/contact?subject=bug">お問い合わせ（不具合・技術）</a></li>
        <li><a class="font-medium text-[#50c2cb] underline-offset-2 hover:underline" href="/parents">保護者の方へ</a></li>
      </ul>
    </section>

    <div class="mt-10 text-center">
      <a class="inline-flex items-center justify-center rounded-full bg-[#50c2cb] px-8 py-3.5 text-sm font-semibold text-white transition hover:bg-[#46adb5]" href="<?php echo htmlspecialchars(APP_URL); ?>/signup"><?php echo FREE_TRIAL_DAYS; ?>日間無料で試す</a>
    </div>
  </div>
</article>
<?php
include __DIR__ . '/includes/footer.php';
