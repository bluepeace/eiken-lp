<?php if (!defined('SITE_NAME')) { require_once __DIR__ . '/../../config.php'; } ?>
<?php
$target_items = [
    [
        'title' => '英検を始めたい小中学生',
        'text' => '5級・4級・3級から。いつから・何級がおすすめか迷っている方にも。',
        'image' => '/assets/images/target/elementary.jpg',
        'alt' => '英検学習をする小中学生',
        'span' => '',
    ],
    [
        'title' => '英検対策の中高生・保護者',
        'text' => '準2級・2級・準1級。受験や単位認定を見据えた対策をしたい方。',
        'image' => '/assets/images/target/junior-senior.jpg',
        'alt' => '英検対策に取り組む中高生',
        'span' => '',
    ],
    [
        'title' => '上位級を目指す社会人',
        'text' => '準1級・1級。就活やキャリアで英検を活用したい方。',
        'image' => '/assets/images/target/adult.jpg',
        'alt' => '上位級を目指す社会人',
        'span' => 'sm:col-span-2 lg:col-span-1',
    ],
    [
        'title' => '単語〜面接までひとつで対策したい方',
        'text' => '参考書やアプリを増やさず、英検の勉強法・対策をまとめて効率よく。',
        'image' => '/assets/images/target/all-in-one.jpg',
        'alt' => 'ひとつのアプリで英検対策をする学習者',
        'span' => 'sm:col-span-2',
    ],
    [
        'title' => '毎日コツコツ続けたい方',
        'text' => 'バディの存在と学習提案で、目標の英検 日程まで走り抜けたい方。',
        'image' => '/assets/images/target/daily.jpg',
        'alt' => '毎日コツコツ英検学習を続ける人',
        'span' => '',
    ],
];
?>
<section class="border-t border-slate-100 bg-slate-50/50 px-4 py-16 sm:py-20" aria-labelledby="target-heading">
  <div class="lp-container">
    <p class="section-badge section-badge--center" aria-hidden="true">FOR YOU</p>
    <h2 id="target-heading" class="text-center text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">こんな方におすすめです</h2>
    <p class="mt-3 text-center text-slate-600"><?php echo br_after_period('英検 小学生・中学生・高校生・社会人まで。級や目的に合わせてご利用ください。'); ?></p>
    <div class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
      <?php foreach ($target_items as $item): ?>
      <div class="flex items-start gap-4 rounded-xl border border-slate-200 bg-white p-5 shadow-sm<?php echo $item['span'] !== '' ? ' ' . htmlspecialchars($item['span']) : ''; ?>">
        <img
          src="<?php echo htmlspecialchars($item['image']); ?>"
          alt="<?php echo htmlspecialchars($item['alt']); ?>"
          width="96"
          height="96"
          class="target-avatar h-12 w-12 shrink-0 rounded-full object-cover ring-2 ring-white shadow-sm"
          loading="lazy"
          decoding="async"
        >
        <div>
          <p class="font-semibold text-slate-800"><?php echo htmlspecialchars($item['title']); ?></p>
          <p class="mt-1 text-sm text-slate-600"><?php echo br_after_period($item['text']); ?></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
