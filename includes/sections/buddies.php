<?php
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../../config.php';
}

$buddy_items = [
    [
        'name' => 'マメ',
        'slug' => 'mame',
        'text' => '明るくポジティブ。失敗しても「大丈夫！」と前を向ける。困ったときは自然とみんなをまとめる。',
    ],
    [
        'name' => 'チョコ',
        'slug' => 'choco',
        'text' => '優しくて共感力が高い。「大丈夫かな？」とすぐ相手を気にする。少し心配性だけど、その優しさでみんなを支える。',
    ],
    [
        'name' => 'コロ',
        'slug' => 'koro',
        'text' => '人懐っこく天真爛漫。誰とでもすぐ仲良くなれる。気づくと周りに犬が集まっている。',
    ],
    [
        'name' => 'モコ',
        'slug' => 'moko',
        'text' => '小柄で物静か。感情を大きく出さないけれど、実は誰よりもよく見ている。困ったときに的確な一言をくれる。',
    ],
    [
        'name' => 'マロン',
        'slug' => 'marron',
        'text' => 'とにかく懐っこい。初対面でも距離を縮めるのが上手。「ねえねえ！」と自然に懐に入ってくる。',
    ],
];
?>
<section class="buddies-section border-t border-slate-100 bg-white px-4 py-16 sm:py-20" aria-labelledby="buddies-heading">
  <div class="lp-container">
    <div class="mx-auto max-w-3xl text-center">
      <p class="section-badge section-badge--center" aria-hidden="true">BUDDIES</p>
      <h2 id="buddies-heading" class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">愛犬（バディ）紹介</h2>
      <p class="mt-3 text-slate-600"><?php echo br_after_period('学習のそばにいてくれる5匹のバディ。あなたに合う子を選んで、一緒に英検対策を続けましょう。'); ?></p>
    </div>

    <ul class="buddies-grid mt-10 sm:mt-12">
      <?php foreach ($buddy_items as $buddy): ?>
      <li class="buddy-card">
        <div class="buddy-card__media">
          <img
            src="/assets/images/buddies/<?php echo htmlspecialchars($buddy['slug']); ?>.png"
            alt="<?php echo htmlspecialchars('バディ「' . $buddy['name'] . '」'); ?>"
            width="320"
            height="320"
            class="buddy-card__img"
            loading="lazy"
            decoding="async"
          >
        </div>
        <h3 class="buddy-card__name"><?php echo htmlspecialchars($buddy['name']); ?></h3>
        <p class="buddy-card__text"><?php echo br_after_period($buddy['text']); ?></p>
      </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
