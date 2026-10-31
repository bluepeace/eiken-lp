<?php
/**
 * TOP・YouTube聞き流し（動画がある級をタブでまとめる）
 */
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../../config.php';
}
require_once __DIR__ . '/../grade-data.php';

if (!function_exists('top_youtube_id')) {
    function top_youtube_id(string $embed): string
    {
        if (preg_match('~(?:youtu\.be/|youtube\.com/(?:watch\?v=|embed/|shorts/))([A-Za-z0-9_-]{6,})~', $embed, $m)) {
            return $m[1];
        }
        if (preg_match('~^[A-Za-z0-9_-]{6,}$~', $embed)) {
            return $embed;
        }
        return '';
    }
}

global $GRADES;
$contents = grade_content_all();
$grade_order = ['jun1kyu', '2kyu', 'jun2kyu-plus', 'jun2kyu', '3kyu'];
$youtube_grades = [];
foreach ($grade_order as $slug) {
    $block = $contents[$slug]['youtube'] ?? null;
    $videos = is_array($block['videos'] ?? null) ? $block['videos'] : [];
    if (!is_array($block) || $videos === []) {
        continue;
    }
    $embed = (string) ($block['embed'] ?? '');
    if ($embed === '') {
        $embed = (string) ($videos[0]['url'] ?? '');
    }
    $youtube_grades[] = [
        'slug' => $slug,
        'label' => (string) ($GRADES[$slug]['name_short'] ?? $slug),
        'button' => (string) ($block['button'] ?? 'YouTubeで聞き流し動画を見る'),
        'playlist' => (string) ($block['playlist'] ?? ''),
        'embed_id' => top_youtube_id($embed),
        'embed_title' => (string) ($block['embed_title'] ?? ($videos[0]['title'] ?? '聞き流し動画')),
        'videos' => $videos,
    ];
}
if ($youtube_grades === []) {
    return;
}
$channel = 'https://www.youtube.com/@aiken.english';
?>
<section class="top-youtube border-t border-slate-100 bg-white px-4 py-16 sm:py-20" aria-labelledby="top-youtube-heading" data-top-youtube>
  <div class="lp-container">
    <div class="mx-auto max-w-3xl text-center">
      <p class="section-badge section-badge--center" aria-hidden="true">YOUTUBE</p>
      <h2 id="top-youtube-heading" class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">英単語を、<span class="heading-accent">YouTubeで聞き流し</span></h2>
      <p class="mt-3 text-slate-600"><?php echo br_after_period('通学や家事のあいだに流せる、英単語100語の聞き流し動画を公開しています。準1級から3級まで、英語→日本語→例文の順なので、耳から語彙を増やしたいときにどうぞ。よかったらチャンネル登録もお願いします。'); ?></p>
    </div>

    <div class="top-youtube__tabs" role="tablist" aria-label="聞き流しの級">
      <?php foreach ($youtube_grades as $i => $youtube_grade): ?>
      <button
        type="button"
        class="top-youtube__tab"
        role="tab"
        id="top-youtube-tab-<?php echo htmlspecialchars($youtube_grade['slug']); ?>"
        aria-controls="top-youtube-panel-<?php echo htmlspecialchars($youtube_grade['slug']); ?>"
        aria-selected="<?php echo $i === 0 ? 'true' : 'false'; ?>"
        tabindex="<?php echo $i === 0 ? '0' : '-1'; ?>"
        data-youtube-tab="<?php echo htmlspecialchars($youtube_grade['slug']); ?>"
      ><?php echo htmlspecialchars($youtube_grade['label']); ?></button>
      <?php endforeach; ?>
    </div>

    <?php foreach ($youtube_grades as $i => $youtube_grade): ?>
    <div
      class="top-youtube__panel"
      role="tabpanel"
      id="top-youtube-panel-<?php echo htmlspecialchars($youtube_grade['slug']); ?>"
      aria-labelledby="top-youtube-tab-<?php echo htmlspecialchars($youtube_grade['slug']); ?>"
      data-youtube-panel="<?php echo htmlspecialchars($youtube_grade['slug']); ?>"
      <?php echo $i === 0 ? '' : 'hidden'; ?>
    >
      <?php if ($youtube_grade['embed_id'] !== ''): ?>
      <div class="grade-youtube__embed-wrap mt-8 sm:mt-10">
        <iframe
          class="grade-youtube__embed"
          <?php echo $i === 0 ? 'src' : 'data-src'; ?>="https://www.youtube-nocookie.com/embed/<?php echo htmlspecialchars($youtube_grade['embed_id'], ENT_QUOTES, 'UTF-8'); ?>"
          title="<?php echo htmlspecialchars($youtube_grade['embed_title']); ?>"
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
          referrerpolicy="strict-origin-when-cross-origin"
          allowfullscreen
          loading="lazy"
        ></iframe>
      </div>
      <?php endif; ?>

      <?php if ($youtube_grade['playlist'] !== ''): ?>
      <p class="mt-8 text-center">
        <a
          class="grade-youtube__button"
          href="<?php echo htmlspecialchars($youtube_grade['playlist']); ?>"
          target="_blank"
          rel="noopener noreferrer"
        ><?php echo htmlspecialchars($youtube_grade['button']); ?></a>
      </p>
      <?php endif; ?>

      <ul class="grade-youtube__list">
        <?php foreach ($youtube_grade['videos'] as $video):
            $title = (string) ($video['title'] ?? '');
            $url = (string) ($video['url'] ?? '');
            if ($title === '' || $url === '') {
                continue;
            }
            ?>
        <li>
          <a href="<?php echo htmlspecialchars($url); ?>" target="_blank" rel="noopener noreferrer"><?php echo htmlspecialchars($title); ?></a>
        </li>
        <?php endforeach; ?>
      </ul>
    </div>
    <?php endforeach; ?>

    <p class="mt-6 text-center text-sm text-slate-500">
      <a class="font-semibold text-[#50c2cb] underline-offset-2 hover:text-[#46adb5] hover:underline" href="<?php echo htmlspecialchars($channel); ?>" target="_blank" rel="noopener noreferrer">AiKen公式チャンネルを登録する</a>
    </p>
  </div>
  <script>
    (function () {
      var root = document.querySelector('[data-top-youtube]');
      if (!root) return;
      var tabs = Array.prototype.slice.call(root.querySelectorAll('[data-youtube-tab]'));
      var panels = Array.prototype.slice.call(root.querySelectorAll('[data-youtube-panel]'));
      function select(id) {
        tabs.forEach(function (tab) {
          var on = tab.getAttribute('data-youtube-tab') === id;
          tab.setAttribute('aria-selected', on ? 'true' : 'false');
          tab.tabIndex = on ? 0 : -1;
        });
        panels.forEach(function (panel) {
          var on = panel.getAttribute('data-youtube-panel') === id;
          panel.hidden = !on;
          if (!on) return;
          var frame = panel.querySelector('iframe');
          if (frame && !frame.getAttribute('src')) {
            frame.setAttribute('src', frame.getAttribute('data-src') || '');
          }
        });
      }
      tabs.forEach(function (tab, index) {
        tab.addEventListener('click', function () {
          select(tab.getAttribute('data-youtube-tab'));
        });
        tab.addEventListener('keydown', function (event) {
          var next = index;
          if (event.key === 'ArrowRight' || event.key === 'ArrowDown') next = (index + 1) % tabs.length;
          else if (event.key === 'ArrowLeft' || event.key === 'ArrowUp') next = (index - 1 + tabs.length) % tabs.length;
          else return;
          event.preventDefault();
          tabs[next].focus();
          select(tabs[next].getAttribute('data-youtube-tab'));
        });
      });
    })();
  </script>
</section>
