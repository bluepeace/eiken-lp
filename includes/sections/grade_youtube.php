<?php
/**
 * 級別・YouTube聞き流し（データがある級だけ表示）
 * @var array $grade_content
 */
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../../config.php';
}

$block = $grade_content['youtube'] ?? null;
if (!is_array($block)) {
    return;
}

$heading = (string) ($block['heading'] ?? '');
if ($heading === '') {
    return;
}

$lead = (string) ($block['lead'] ?? '');
$button = (string) ($block['button'] ?? 'YouTubeで聞き流し動画を見る');
$playlist = (string) ($block['playlist'] ?? '');
$channel = (string) ($block['channel'] ?? 'https://www.youtube.com/@aiken.english');
$videos = is_array($block['videos'] ?? null) ? $block['videos'] : [];
$embed = (string) ($block['embed'] ?? '');
if ($embed === '' && $videos !== []) {
    $embed = (string) ($videos[0]['url'] ?? '');
}

$embed_id = '';
if (preg_match('~(?:youtu\.be/|youtube\.com/(?:watch\?v=|embed/|shorts/))([A-Za-z0-9_-]{6,})~', $embed, $m)) {
    $embed_id = $m[1];
} elseif (preg_match('~^[A-Za-z0-9_-]{6,}$~', $embed)) {
    $embed_id = $embed;
}

$embed_title = (string) ($block['embed_title'] ?? ($videos[0]['title'] ?? '聞き流し動画'));
?>
<section class="grade-youtube border-t border-slate-100 bg-white px-4 py-16 sm:py-20" aria-labelledby="grade-youtube-heading">
  <div class="lp-container">
    <div class="mx-auto max-w-3xl text-center">
      <p class="section-badge section-badge--center" aria-hidden="true">YOUTUBE</p>
      <h2 id="grade-youtube-heading" class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl"><?php echo $heading; ?></h2>
      <?php if ($lead !== ''): ?>
      <p class="mt-3 text-slate-600"><?php echo br_after_period($lead); ?></p>
      <?php endif; ?>
    </div>

    <?php if ($embed_id !== ''): ?>
    <div class="grade-youtube__embed-wrap mt-10 sm:mt-12">
      <iframe
        class="grade-youtube__embed"
        src="https://www.youtube-nocookie.com/embed/<?php echo htmlspecialchars($embed_id, ENT_QUOTES, 'UTF-8'); ?>"
        title="<?php echo htmlspecialchars($embed_title); ?>"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
        referrerpolicy="strict-origin-when-cross-origin"
        allowfullscreen
        loading="lazy"
      ></iframe>
    </div>
    <?php endif; ?>

    <?php if ($playlist !== ''): ?>
    <p class="mt-8 text-center">
      <a
        class="grade-youtube__button"
        href="<?php echo htmlspecialchars($playlist); ?>"
        target="_blank"
        rel="noopener noreferrer"
      ><?php echo htmlspecialchars($button); ?></a>
    </p>
    <?php endif; ?>

    <?php if ($channel !== ''): ?>
    <p class="mt-3 text-center text-sm text-slate-500">
      <a class="font-semibold text-[#50c2cb] underline-offset-2 hover:text-[#46adb5] hover:underline" href="<?php echo htmlspecialchars($channel); ?>" target="_blank" rel="noopener noreferrer">AiKen公式チャンネルを登録する</a>
    </p>
    <?php endif; ?>

    <?php if ($videos !== []): ?>
    <ul class="grade-youtube__list">
      <?php foreach ($videos as $video):
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
    <?php endif; ?>
  </div>
</section>
