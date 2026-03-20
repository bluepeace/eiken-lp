<?php
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../../config.php';
}
require_once __DIR__ . '/../blog-feed.php';

$blog_items = get_blog_feed_items(20);
$blog_index_url = rtrim(SITE_URL, '/') . '/blog/';
?>
<section class="border-t border-slate-100 bg-slate-50/50 py-16 sm:py-20" aria-labelledby="blog-column-heading">
  <div class="mx-auto max-w-6xl px-4">
    <h2 id="blog-column-heading" class="text-center text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">英検コラム</h2>
    <p class="mt-2 text-center text-slate-600"><?php echo br_after_period('英検の試験形式・勉強法・級別のポイントを、コラムでわかりやすく解説しています。'); ?></p>

    <?php if ($blog_items === []): ?>
    <p class="mt-10 text-center text-slate-600">記事一覧の取得に失敗したか、まだ公開がありません。</p>
    <p class="mt-4 text-center">
      <a class="inline-flex items-center justify-center rounded-full bg-[#50c2cb] px-6 py-3 text-sm font-semibold text-white transition hover:bg-[#46adb5]" href="<?php echo htmlspecialchars($blog_index_url); ?>">英検コラムを見る</a>
    </p>
    <?php endif; ?>
  </div>

    <?php if ($blog_items !== []): ?>
  <div class="blog-carousel-bleed mt-10">
    <div class="relative">
      <button type="button" id="blog-carousel-prev" class="absolute left-2 top-1/2 z-10 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full border border-slate-200 bg-white/95 text-xl text-slate-700 shadow-md backdrop-blur-sm transition hover:bg-white sm:left-4" aria-controls="blog-carousel-track" aria-label="前の記事へ">‹</button>
      <button type="button" id="blog-carousel-next" class="absolute right-2 top-1/2 z-10 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full border border-slate-200 bg-white/95 text-xl text-slate-700 shadow-md backdrop-blur-sm transition hover:bg-white sm:right-4" aria-controls="blog-carousel-track" aria-label="次の記事へ">›</button>
      <div
        id="blog-carousel-track"
        class="flex w-full snap-x snap-mandatory gap-4 overflow-x-auto scroll-smooth px-4 pb-2 [-ms-overflow-style:none] [scrollbar-width:none] sm:px-6 md:px-10 [&::-webkit-scrollbar]:hidden"
        tabindex="0"
        role="region"
        aria-roledescription="カルーセル"
        aria-label="英検コラムの記事一覧"
        data-autoplay-ms="5000"
      >
        <?php foreach ($blog_items as $post): ?>
        <a href="<?php echo htmlspecialchars($post['url']); ?>" class="group flex w-[min(calc(100vw-3rem),320px)] shrink-0 snap-start flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:border-[#50c2cb]/40 hover:shadow-md sm:w-80">
          <div class="relative aspect-video w-full overflow-hidden bg-slate-100">
            <?php if (!empty($post['image'])): ?>
            <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="" class="h-full w-full object-cover transition duration-300 group-hover:scale-[1.03]" loading="lazy" decoding="async" width="576" height="324">
            <?php else: ?>
            <div class="flex h-full w-full items-center justify-center text-4xl text-slate-300" aria-hidden="true">📄</div>
            <?php endif; ?>
          </div>
          <div class="flex flex-1 flex-col p-4">
            <h3 class="line-clamp-2 text-sm font-semibold leading-snug text-slate-900 group-hover:text-[#46adb5]"><?php echo htmlspecialchars($post['title']); ?></h3>
            <?php
            $ts = !empty($post['pubDate']) ? @strtotime($post['pubDate']) : false;
            if ($ts): ?>
            <time class="mt-auto pt-3 text-xs text-slate-500" datetime="<?php echo date('c', $ts); ?>"><?php echo date('Y年n月j日', $ts); ?></time>
            <?php endif; ?>
          </div>
        </a>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
  <div class="mx-auto max-w-6xl px-4">
    <p class="mt-8 text-center">
      <a class="text-sm font-semibold text-[#50c2cb] underline-offset-2 hover:text-[#46adb5] hover:underline" href="<?php echo htmlspecialchars($blog_index_url); ?>">コラム一覧へ</a>
    </p>
  </div>
    <script>
    (function () {
      var track = document.getElementById('blog-carousel-track');
      var prev = document.getElementById('blog-carousel-prev');
      var next = document.getElementById('blog-carousel-next');
      if (!track || !prev || !next) return;

      function cardStep() {
        var card = track.querySelector('a');
        if (!card) return Math.max(280, Math.round(track.clientWidth * 0.85));
        var gap = parseFloat(getComputedStyle(track).columnGap || getComputedStyle(track).gap) || 16;
        return Math.round(card.getBoundingClientRect().width + gap);
      }

      var programmaticScroll = false;
      var programmaticTimer = null;
      function markProgrammaticScroll() {
        programmaticScroll = true;
        if (programmaticTimer) clearTimeout(programmaticTimer);
        programmaticTimer = window.setTimeout(function () {
          programmaticScroll = false;
          programmaticTimer = null;
        }, 800);
      }

      function scrollPrev() {
        markProgrammaticScroll();
        track.scrollBy({ left: -cardStep(), behavior: 'smooth' });
      }

      function scrollNext() {
        var step = cardStep();
        var maxScroll = track.scrollWidth - track.clientWidth;
        if (maxScroll <= 0) return;
        markProgrammaticScroll();
        if (track.scrollLeft >= maxScroll - 2) {
          track.scrollTo({ left: 0, behavior: 'smooth' });
        } else {
          track.scrollBy({ left: step, behavior: 'smooth' });
        }
      }

      prev.addEventListener('click', function () {
        scrollPrev();
        resetAutoplay();
      });
      next.addEventListener('click', function () {
        scrollNext();
        resetAutoplay();
      });

      var reduced = false;
      try {
        reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
      } catch (e) {}

      var autoplayMs = parseInt(track.getAttribute('data-autoplay-ms') || '5000', 10);
      if (isNaN(autoplayMs) || autoplayMs < 2000) autoplayMs = 5000;

      var timer = null;
      function startAutoplay() {
        if (reduced || document.hidden) return;
        stopAutoplay();
        timer = window.setInterval(scrollNext, autoplayMs);
      }
      function stopAutoplay() {
        if (timer !== null) {
          clearInterval(timer);
          timer = null;
        }
      }
      function resetAutoplay() {
        stopAutoplay();
        startAutoplay();
      }

      track.addEventListener('mouseenter', stopAutoplay);
      track.addEventListener('mouseleave', startAutoplay);

      var scrollResume = null;
      track.addEventListener(
        'scroll',
        function () {
          if (reduced || programmaticScroll) return;
          stopAutoplay();
          if (scrollResume) clearTimeout(scrollResume);
          scrollResume = window.setTimeout(function () {
            scrollResume = null;
            startAutoplay();
          }, autoplayMs);
        },
        { passive: true }
      );

      document.addEventListener('visibilitychange', function () {
        if (document.hidden) stopAutoplay();
        else startAutoplay();
      });

      try {
        window.matchMedia('(prefers-reduced-motion: reduce)').addEventListener('change', function (ev) {
          reduced = ev.matches;
          if (reduced) stopAutoplay();
          else startAutoplay();
        });
      } catch (e) {}

      startAutoplay();
    })();
    </script>
    <?php endif; ?>
</section>
