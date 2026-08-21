<?php
/**
 * 級別コラム（WordPressタグで絞り込み）
 * @var array $grade_data
 * @var array $grade_content
 */
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../../config.php';
}
require_once __DIR__ . '/../blog-feed.php';

$name = $grade_data['name'] ?? '英検';
$name_short = $grade_data['name_short'] ?? '';
$tagSlug = (string) ($grade_content['blog_tag_slug'] ?? $name_short);
$blog_items = $tagSlug !== '' ? get_blog_items_by_tag($tagSlug, 12) : [];
$blog_index_url = rtrim(SITE_URL, '/') . '/blog/';
$carousel_id = 'grade-blog-carousel';
?>
<section class="border-t border-slate-100 bg-slate-50/50 py-16 sm:py-20" aria-labelledby="grade-blog-heading">
  <div class="lp-container px-4">
    <p class="section-badge section-badge--center" aria-hidden="true">COLUMN</p>
    <h2 id="grade-blog-heading" class="text-center text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl"><?php echo htmlspecialchars($name); ?>の英検対策コラム</h2>
    <p class="mt-2 text-center text-slate-600"><?php echo br_after_period(htmlspecialchars($name_short) . 'の試験形式・勉強法・ポイントをコラムで解説しています。受験前の確認にお役立てください。'); ?></p>

    <?php if ($blog_items === []): ?>
    <p class="mt-10 text-center text-slate-600">この級のコラムは準備中か、まだ公開がありません。</p>
    <p class="mt-4 text-center">
      <a class="inline-flex items-center justify-center rounded-full bg-[#50c2cb] px-6 py-3 text-sm font-semibold text-white transition hover:bg-[#46adb5]" href="<?php echo htmlspecialchars($blog_index_url); ?>">英検コラム一覧を見る</a>
    </p>
    <?php endif; ?>
  </div>

  <?php if ($blog_items !== []): ?>
  <div class="blog-carousel-bleed mt-10">
    <div class="relative">
      <button type="button" id="<?php echo $carousel_id; ?>-prev" class="absolute left-2 top-1/2 z-10 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full border border-slate-200 bg-white/95 text-xl text-slate-700 shadow-md backdrop-blur-sm transition hover:bg-white sm:left-4" aria-controls="<?php echo $carousel_id; ?>-track" aria-label="前の記事へ">‹</button>
      <button type="button" id="<?php echo $carousel_id; ?>-next" class="absolute right-2 top-1/2 z-10 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full border border-slate-200 bg-white/95 text-xl text-slate-700 shadow-md backdrop-blur-sm transition hover:bg-white sm:right-4" aria-controls="<?php echo $carousel_id; ?>-track" aria-label="次の記事へ">›</button>
      <div
        id="<?php echo $carousel_id; ?>-track"
        class="flex w-full snap-x snap-mandatory gap-4 overflow-x-auto scroll-smooth px-4 pb-2 [-ms-overflow-style:none] [scrollbar-width:none] sm:px-6 md:px-10 [&::-webkit-scrollbar]:hidden"
        tabindex="0"
        role="region"
        aria-roledescription="カルーセル"
        aria-label="<?php echo htmlspecialchars($name); ?>の英検対策コラム"
        data-autoplay-ms="5000"
      >
        <?php foreach ($blog_items as $post): ?>
        <a href="<?php echo htmlspecialchars($post['url']); ?>" class="group flex w-[min(calc(100vw-3rem),320px)] shrink-0 snap-start flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:border-[#50c2cb]/40 hover:shadow-md sm:w-80">
          <div class="relative aspect-video w-full overflow-hidden bg-slate-100">
            <?php if (!empty($post['image'])): ?>
            <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="" class="h-full w-full object-cover transition duration-300 group-hover:scale-[1.03]" loading="lazy" decoding="async" width="576" height="324">
            <?php else: ?>
            <div class="flex h-full w-full items-center justify-center text-slate-300"><?php echo lp_icon('book-text', 'w-12 h-12'); ?></div>
            <?php endif; ?>
          </div>
          <div class="flex flex-1 flex-col p-4">
            <h3 class="line-clamp-2 text-sm font-semibold leading-snug text-slate-900 group-hover:text-[#46adb5]"><?php echo htmlspecialchars($post['title']); ?></h3>
            <?php
            $modified_display = aiken_blog_modified_display((string) ($post['modDate'] ?? $post['pubDate'] ?? ''));
            if ($modified_display): ?>
            <time class="mt-auto pt-3 text-xs text-slate-500" datetime="<?php echo htmlspecialchars($modified_display['datetime']); ?>"><?php echo htmlspecialchars($modified_display['label']); ?></time>
            <?php endif; ?>
          </div>
        </a>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
  <div class="lp-container px-4">
    <p class="mt-8 text-center">
      <a class="text-sm font-semibold text-[#50c2cb] underline-offset-2 hover:text-[#46adb5] hover:underline" href="<?php echo htmlspecialchars($blog_index_url); ?>">コラム一覧へ</a>
    </p>
  </div>
  <script>
  (function () {
    var track = document.getElementById('<?php echo $carousel_id; ?>-track');
    var prev = document.getElementById('<?php echo $carousel_id; ?>-prev');
    var next = document.getElementById('<?php echo $carousel_id; ?>-next');
    if (!track || !prev || !next) return;
    function cardStep() {
      var card = track.querySelector('a');
      if (!card) return Math.max(280, Math.round(track.clientWidth * 0.85));
      var gap = parseFloat(getComputedStyle(track).columnGap || getComputedStyle(track).gap) || 16;
      return Math.round(card.getBoundingClientRect().width + gap);
    }
    prev.addEventListener('click', function () { track.scrollBy({ left: -cardStep(), behavior: 'smooth' }); });
    next.addEventListener('click', function () {
      var step = cardStep();
      var maxScroll = track.scrollWidth - track.clientWidth;
      if (maxScroll <= 0) return;
      if (track.scrollLeft >= maxScroll - 2) track.scrollTo({ left: 0, behavior: 'smooth' });
      else track.scrollBy({ left: step, behavior: 'smooth' });
    });
  })();
  </script>
  <?php endif; ?>
</section>
