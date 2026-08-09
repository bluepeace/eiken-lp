<?php if (!defined('SITE_NAME')) { require_once __DIR__ . '/../../config.php'; } ?>
<?php
$strength_items = [
    [
        'title' => '本試験形式で5技能すべて',
        'text' => '単語・リーディング・リスニング・ライティング・スピーキングを、<span class="lp-marker">英検の本番に近い形式で出題</span>します。級ごとに求められる形式に合わせて練習できるので、「本当に英検対策になっているのかな」という不安も減らせます。教材やアプリをバラバラに揃える必要がなく、ひとつのアプリで5技能の対策が完結。お子さんが今日何をすればよいかも、迷いにくい設計です。',
        'image' => '/assets/images/strength-01.png',
        'alt' => '電車の中でスマホを使う女子学生',
    ],
    [
        'title' => '10,000問超・類似問題が解き放題',
        'text' => '<span class="lp-marker">10,000問超</span>の問題数で、過去問だけでは足りない、もっといろんな問題を解きたい——そんな声に応えます。同じ形式の問題を何度でも解けるので、反復練習で定着させやすく、本番に近いパターンにも慣れていけます。量が足りないと感じていたお子さんにも、級に合わせてじっくり取り組める環境です。',
        'image' => 'https://images.unsplash.com/photo-1456513080740-66c8c171a88e?w=800&q=80',
        'alt' => '英検対策の問題集とノート',
    ],
    [
        'title' => 'AIがライティングをその場で添削',
        'text' => '英作文を書いた直後に、<span class="lp-marker">AIが文法・構成・語彙の観点からフィードバック</span>します。保護者の方が毎回添削するのは時間も負担もかかりますが、アプリならその日のうちに書いて直せます。意見論述やEメール形式など、級に合った英検ライティングの練習を、ご家庭だけでは難しい部分までカバーできます。',
        'image' => 'https://images.unsplash.com/photo-1455390582262-044cdead277a?w=800&q=80',
        'alt' => 'ライティングの練習イメージ',
    ],
    [
        'title' => 'AIスピーキング・面接形式の特訓',
        'text' => '音読・イラスト描写・意見を述べる流れなど、英検スピーキング・面接の形式で練習できます。オンライン英会話だけでは続けにくい、または別途費用がかかる——そんな悩みにも応えます。話した内容は<span class="lp-marker">AIが採点・フィードバック</span>するので、二次試験や面接対策も、アプリ内で繰り返し特訓できます。',
        'image' => 'https://images.unsplash.com/photo-1478737270239-2f02ca77fc66?w=800&q=80',
        'alt' => 'スピーキング練習のイメージ',
    ],
    [
        'title' => '間違えた問題をあとから復習',
        'text' => '解いた問題は学習履歴として残るので、<span class="lp-marker">間違えた問題だけをあとから集中的にやり直せます</span>。一度解いて終わりにせず、弱点を潰し込めるのが英検対策では大切です。お子さんがどこでつまずいているかも把握しやすく、復習のサイクルを回しやすいので、効率よく力を伸ばせます。',
        'image' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&q=80',
        'alt' => '学習履歴と復習のイメージ',
    ],
    [
        'title' => 'スキマ時間にスマホから',
        'text' => '部活や塾で忙しいお子さんでも、通学の電車の中や待ち時間など、<span class="lp-marker">5〜10分の空き時間でサクッと英検の練習</span>ができます。スマホ・タブレット・PCから利用できるので、場所を選ばず続けやすいのもポイントです。毎日まとまった時間が取れなくても、スキマ時間の積み重ねで対策を進められます。',
        'image' => 'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?w=800&q=80',
        'alt' => 'スマホで英検対策する様子',
    ],
    [
        'title' => monthly_price_label() . 'で5級〜1級まで',
        'text' => '英検5級から1級（準1級・準2級含む）まで、同じアプリで対策できます。級が上がっても<span class="lp-marker">乗り換え不要</span>で、兄弟で級が違ってもひとつのアプリでカバーできる可能性があります。' . FREE_TRIAL_DAYS . '日間無料体験があるので、まずはお子さんと一緒に触ってみて、「続けられそうか」を確かめてから始められます。',
        'image' => 'https://images.unsplash.com/photo-1600880292203-757bb62b4baf?w=800&q=80',
        'alt' => '保護者とお子さんのイメージ',
    ],
];
?>
<section class="strengths-section border-t border-slate-100 bg-white px-4 py-16 sm:py-20" aria-labelledby="features-heading">
  <div class="lp-container">
    <div class="strengths-section__header mx-auto max-w-3xl text-center">
      <h2 id="features-heading" class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">英検対策アプリ<?php echo htmlspecialchars(SITE_NAME); ?>の<span class="heading-accent">7つの強み</span></h2>
      <p class="strengths-section__lead mt-3"><?php echo br_after_period('さきほどのお悩みを、ひとつのアプリでまとめて解決。'); ?></p>
    </div>
    <div class="strengths-list mt-12 sm:mt-16">
      <?php foreach ($strength_items as $index => $item):
          $point = $index + 1;
          $reverse = $point % 2 === 0;
          ?>
      <article class="strengths-row<?php echo $reverse ? ' strengths-row--reverse' : ''; ?>">
        <div class="strengths-row__content">
          <p class="strengths-point">Point.<?php echo $point; ?></p>
          <h3 class="strengths-title"><?php echo htmlspecialchars($item['title']); ?></h3>
          <p class="strengths-desc"><?php echo br_after_period($item['text']); ?></p>
        </div>
        <figure class="strengths-row__media">
          <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['alt']); ?>" width="700" height="467" class="strengths-row__image" loading="lazy">
        </figure>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
