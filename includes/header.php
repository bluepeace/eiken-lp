<?php
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../config.php';
}
require_once __DIR__ . '/speaking-data.php';
require_once __DIR__ . '/writing-data.php';
require_once __DIR__ . '/reading-data.php';
require_once __DIR__ . '/listening-data.php';
require_once __DIR__ . '/vocabulary-data.php';
$current_page = $page ?? 'top';
$current_grade = $grade ?? '';
$show_main_nav = in_array($current_page, ['top', 'about', 'plan', 'faq', 'tokushoho', 'terms', 'privacy', 'contact', 'external', 'company', 'cancel', 'parents', 'guide', 'study', 'grade', 'speaking', 'writing', 'reading', 'listening', 'vocabulary', 'eiken'], true);
$lp_index = in_array($current_page, ['top', 'about', 'plan', 'faq', 'tokushoho', 'terms', 'privacy', 'contact', 'external', 'company', 'cancel', 'parents', 'guide', 'study', 'grade', 'speaking', 'writing', 'reading', 'listening', 'vocabulary', 'eiken'], true);
$is_grade_section = in_array($current_page, ['grade', 'speaking', 'writing', 'reading', 'listening', 'vocabulary'], true);
$about_nav = [
    ['label' => 'AiKenとは', 'href' => '/about', 'current' => $current_page === 'about'],
    ['label' => '使い方ガイド', 'href' => '/guide', 'current' => $current_page === 'guide'],
    ['label' => '英検合格の道', 'href' => '/study', 'current' => $current_page === 'study'],
    ['label' => '保護者の方へ', 'href' => '/parents', 'current' => $current_page === 'parents'],
    ['label' => '英検対策コンテンツ', 'href' => '/eiken/', 'current' => $current_page === 'eiken'],
];
$is_about_section = false;
foreach ($about_nav as $about_item) {
    if ($about_item['current']) {
        $is_about_section = true;
        break;
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<?php include __DIR__ . '/head.php'; ?>
</head>
<body class="min-h-screen bg-white text-slate-900 antialiased">
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TW48595R"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<div class="min-h-screen bg-white<?php echo $lp_index ? ' lp-index' : ''; ?>">
<?php
// LP 内リンクはルート相対にし、localhost でも現在のホストで開く（SITE_URL 固定だと本番未反映ページが開けない）
$nav_links = [
    ['label' => '料金', 'href' => '/plan', 'current' => $current_page === 'plan'],
    ['label' => 'よくあるご質問', 'href' => '/faq', 'current' => $current_page === 'faq'],
    ['label' => '英検コラム', 'href' => '/blog', 'current' => false],
];
$grade_nav_items = grade_nav_items();
$nav_caret = '<span class="site-header__dropdown-caret" aria-hidden="true"><svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" focusable="false"><path d="M4 6l4 4 4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></span>';
?>
<header class="site-header sticky top-0 z-50 border-b border-slate-200/80 bg-white/90 backdrop-blur-md">
  <div class="lp-container site-header__inner px-4">
    <a class="flex shrink-0 items-center" href="/">
      <?php echo lp_picture([
          'src' => lp_versioned_asset('/assets/images/logo-aiken.png'),
          'alt' => SITE_NAME,
          'width' => 1630,
          'height' => 524,
          'class' => 'site-header__logo',
          'loading' => 'eager',
      ]); ?>
    </a>
    <?php if ($show_main_nav): ?>
    <nav class="site-header__nav min-w-0 flex-1" aria-label="サイト内リンク">
      <div class="site-header__nav-inner flex flex-wrap justify-start gap-1 sm:justify-center md:gap-2">
        <div class="site-header__dropdown<?php echo $is_about_section ? ' is-current' : ''; ?>">
          <button
            type="button"
            class="site-header__nav-link site-header__dropdown-toggle<?php echo $is_about_section ? ' is-current' : ''; ?>"
            aria-expanded="false"
            aria-haspopup="true"
            aria-controls="about-nav-menu"
            id="about-nav-toggle"
          >AiKenとは<?php echo $nav_caret; ?></button>
          <ul id="about-nav-menu" class="site-header__dropdown-menu site-header__dropdown-menu--plain" role="menu" aria-labelledby="about-nav-toggle" hidden>
            <?php foreach ($about_nav as $item): ?>
            <li class="site-header__dropdown-item" role="none">
              <a
                role="menuitem"
                class="site-header__dropdown-link<?php echo $item['current'] ? ' is-current' : ''; ?>"
                href="<?php echo htmlspecialchars($item['href']); ?>"
                <?php echo $item['current'] ? ' aria-current="page"' : ''; ?>
              ><?php echo htmlspecialchars($item['label']); ?></a>
            </li>
            <?php endforeach; ?>
          </ul>
        </div>

        <div class="site-header__dropdown<?php echo $is_grade_section ? ' is-current' : ''; ?>">
          <button
            type="button"
            class="site-header__nav-link site-header__dropdown-toggle<?php echo $is_grade_section ? ' is-current' : ''; ?>"
            aria-expanded="false"
            aria-haspopup="true"
            aria-controls="grade-nav-menu"
            id="grade-nav-toggle"
          >級別対策<?php echo $nav_caret; ?></button>
          <ul id="grade-nav-menu" class="site-header__dropdown-menu" role="menu" aria-labelledby="grade-nav-toggle" hidden>
            <?php foreach ($grade_nav_items as $gi):
                $is_this_grade = ($current_grade === $gi['slug']);
                $grade_current = ($current_page === 'grade' && $is_this_grade);
                $word_href = vocabulary_page_path($gi['slug']);
                $word_current = ($current_page === 'vocabulary' && $is_this_grade && $word_href !== null);
                $reading_href = reading_page_path($gi['slug']);
                $reading_current = ($current_page === 'reading' && $is_this_grade && $reading_href !== null);
                $listening_href = listening_page_path($gi['slug']);
                $listening_current = ($current_page === 'listening' && $is_this_grade && $listening_href !== null);
                $writing_href = writing_page_path($gi['slug']);
                $writing_current = ($current_page === 'writing' && $is_this_grade && $writing_href !== null);
                $speaking_href = speaking_page_path($gi['slug']);
                $speaking_current = ($current_page === 'speaking' && $is_this_grade && $speaking_href !== null);
                ?>
            <li class="site-header__dropdown-item" role="none">
              <a
                role="menuitem"
                class="site-header__dropdown-link<?php echo $grade_current ? ' is-current' : ''; ?>"
                href="<?php echo htmlspecialchars($gi['href']); ?>"
                <?php echo $grade_current ? ' aria-current="page"' : ''; ?>
              ><?php echo htmlspecialchars($gi['name']); ?></a>
              <?php if ($word_href !== null || $reading_href !== null || $listening_href !== null || $writing_href !== null || $speaking_href !== null): ?>
              <span class="site-header__dropdown-subs">
                <?php if ($word_href !== null): ?>
                <a
                  role="menuitem"
                  class="site-header__dropdown-sublink<?php echo $word_current ? ' is-current' : ''; ?>"
                  href="<?php echo htmlspecialchars($word_href); ?>"
                  aria-label="<?php echo htmlspecialchars($gi['name'] . 'の単語'); ?>"
                  <?php echo $word_current ? ' aria-current="page"' : ''; ?>
                >単語</a>
                <?php endif; ?>
                <?php if ($reading_href !== null): ?>
                <a
                  role="menuitem"
                  class="site-header__dropdown-sublink<?php echo $reading_current ? ' is-current' : ''; ?>"
                  href="<?php echo htmlspecialchars($reading_href); ?>"
                  aria-label="<?php echo htmlspecialchars($gi['name'] . 'のリーディング'); ?>"
                  <?php echo $reading_current ? ' aria-current="page"' : ''; ?>
                >リーディング</a>
                <?php endif; ?>
                <?php if ($listening_href !== null): ?>
                <a
                  role="menuitem"
                  class="site-header__dropdown-sublink<?php echo $listening_current ? ' is-current' : ''; ?>"
                  href="<?php echo htmlspecialchars($listening_href); ?>"
                  aria-label="<?php echo htmlspecialchars($gi['name'] . 'のリスニング'); ?>"
                  <?php echo $listening_current ? ' aria-current="page"' : ''; ?>
                >リスニング</a>
                <?php endif; ?>
                <?php if ($writing_href !== null): ?>
                <a
                  role="menuitem"
                  class="site-header__dropdown-sublink<?php echo $writing_current ? ' is-current' : ''; ?>"
                  href="<?php echo htmlspecialchars($writing_href); ?>"
                  aria-label="<?php echo htmlspecialchars($gi['name'] . 'のライティング'); ?>"
                  <?php echo $writing_current ? ' aria-current="page"' : ''; ?>
                >ライティング</a>
                <?php endif; ?>
                <?php if ($speaking_href !== null): ?>
                <a
                  role="menuitem"
                  class="site-header__dropdown-sublink<?php echo $speaking_current ? ' is-current' : ''; ?>"
                  href="<?php echo htmlspecialchars($speaking_href); ?>"
                  aria-label="<?php echo htmlspecialchars($gi['name'] . 'のスピーキング'); ?>"
                  <?php echo $speaking_current ? ' aria-current="page"' : ''; ?>
                >スピーキング</a>
                <?php endif; ?>
              </span>
              <?php endif; ?>
            </li>
            <?php endforeach; ?>
          </ul>
        </div>

        <?php foreach ($nav_links as $nl): ?>
        <a class="site-header__nav-link<?php echo $nl['current'] ? ' is-current' : ''; ?>" href="<?php echo htmlspecialchars($nl['href']); ?>"<?php echo $nl['current'] ? ' aria-current="page"' : ''; ?>><?php echo htmlspecialchars($nl['label']); ?></a>
        <?php endforeach; ?>
      </div>
    </nav>
    <?php else: ?>
    <div class="min-w-0 flex-1" aria-hidden="true"></div>
    <?php endif; ?>
    <nav class="site-header__account flex shrink-0 items-center gap-2" aria-label="アカウント">
      <a class="site-header__btn site-header__btn--login" href="<?php echo APP_URL; ?>/login">ログイン</a>
      <a class="site-header__btn site-header__btn--signup" href="<?php echo APP_URL; ?>/signup">会員登録</a>
    </nav>
    <?php if ($show_main_nav): ?>
    <button
      type="button"
      class="site-header__menu-btn"
      id="site-menu-toggle"
      aria-expanded="false"
      aria-controls="site-mobile-nav"
      aria-label="メニューを開く"
    >
      <span class="site-header__menu-icon" aria-hidden="true">
        <span></span>
        <span></span>
        <span></span>
      </span>
    </button>
    <?php endif; ?>
  </div>
  <?php if ($show_main_nav): ?>
  <div class="site-header__backdrop" id="site-mobile-backdrop" hidden></div>
  <nav class="site-header__mobile" id="site-mobile-nav" aria-label="サイト内リンク" hidden>
    <div class="site-header__mobile-inner">
      <div class="site-header__mobile-accordion<?php echo $is_about_section ? ' is-open' : ''; ?>">
        <button
          type="button"
          class="site-header__mobile-link site-header__mobile-accordion-toggle<?php echo $is_about_section ? ' is-current' : ''; ?>"
          id="about-mobile-toggle"
          aria-expanded="<?php echo $is_about_section ? 'true' : 'false'; ?>"
          aria-controls="about-mobile-menu"
        >AiKenとは<?php echo $nav_caret; ?></button>
        <ul id="about-mobile-menu" class="site-header__mobile-sub"<?php echo $is_about_section ? '' : ' hidden'; ?>>
          <?php foreach ($about_nav as $item): ?>
          <li>
            <a
              class="site-header__mobile-sublink<?php echo $item['current'] ? ' is-current' : ''; ?>"
              href="<?php echo htmlspecialchars($item['href']); ?>"
              <?php echo $item['current'] ? ' aria-current="page"' : ''; ?>
            ><?php echo htmlspecialchars($item['label']); ?></a>
          </li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div class="site-header__mobile-accordion<?php echo $is_grade_section ? ' is-open' : ''; ?>">
        <button
          type="button"
          class="site-header__mobile-link site-header__mobile-accordion-toggle<?php echo $is_grade_section ? ' is-current' : ''; ?>"
          id="grade-mobile-toggle"
          aria-expanded="<?php echo $is_grade_section ? 'true' : 'false'; ?>"
          aria-controls="grade-mobile-menu"
        >級別対策<?php echo $nav_caret; ?></button>
        <ul id="grade-mobile-menu" class="site-header__mobile-sub"<?php echo $is_grade_section ? '' : ' hidden'; ?>>
          <?php foreach ($grade_nav_items as $gi):
              $is_this_grade = ($current_grade === $gi['slug']);
              $grade_current = ($current_page === 'grade' && $is_this_grade);
              $word_href = vocabulary_page_path($gi['slug']);
              $word_current = ($current_page === 'vocabulary' && $is_this_grade && $word_href !== null);
              $reading_href = reading_page_path($gi['slug']);
              $reading_current = ($current_page === 'reading' && $is_this_grade && $reading_href !== null);
              $listening_href = listening_page_path($gi['slug']);
              $listening_current = ($current_page === 'listening' && $is_this_grade && $listening_href !== null);
              $writing_href = writing_page_path($gi['slug']);
              $writing_current = ($current_page === 'writing' && $is_this_grade && $writing_href !== null);
              $speaking_href = speaking_page_path($gi['slug']);
              $speaking_current = ($current_page === 'speaking' && $is_this_grade && $speaking_href !== null);
              ?>
          <li class="site-header__mobile-grade">
            <a
              class="site-header__mobile-sublink<?php echo $grade_current ? ' is-current' : ''; ?>"
              href="<?php echo htmlspecialchars($gi['href']); ?>"
              <?php echo $grade_current ? ' aria-current="page"' : ''; ?>
            ><?php echo htmlspecialchars($gi['name']); ?></a>
            <?php if ($word_href !== null || $reading_href !== null || $listening_href !== null || $writing_href !== null || $speaking_href !== null): ?>
            <span class="site-header__mobile-subs">
              <?php if ($word_href !== null): ?>
              <a
                class="site-header__mobile-speaking<?php echo $word_current ? ' is-current' : ''; ?>"
                href="<?php echo htmlspecialchars($word_href); ?>"
                aria-label="<?php echo htmlspecialchars($gi['name'] . 'の単語'); ?>"
                <?php echo $word_current ? ' aria-current="page"' : ''; ?>
              >単語</a>
              <?php endif; ?>
              <?php if ($reading_href !== null): ?>
              <a
                class="site-header__mobile-speaking<?php echo $reading_current ? ' is-current' : ''; ?>"
                href="<?php echo htmlspecialchars($reading_href); ?>"
                aria-label="<?php echo htmlspecialchars($gi['name'] . 'のリーディング'); ?>"
                <?php echo $reading_current ? ' aria-current="page"' : ''; ?>
              >リーディング</a>
              <?php endif; ?>
              <?php if ($listening_href !== null): ?>
              <a
                class="site-header__mobile-speaking<?php echo $listening_current ? ' is-current' : ''; ?>"
                href="<?php echo htmlspecialchars($listening_href); ?>"
                aria-label="<?php echo htmlspecialchars($gi['name'] . 'のリスニング'); ?>"
                <?php echo $listening_current ? ' aria-current="page"' : ''; ?>
              >リスニング</a>
              <?php endif; ?>
              <?php if ($writing_href !== null): ?>
              <a
                class="site-header__mobile-speaking<?php echo $writing_current ? ' is-current' : ''; ?>"
                href="<?php echo htmlspecialchars($writing_href); ?>"
                aria-label="<?php echo htmlspecialchars($gi['name'] . 'のライティング'); ?>"
                <?php echo $writing_current ? ' aria-current="page"' : ''; ?>
              >ライティング</a>
              <?php endif; ?>
              <?php if ($speaking_href !== null): ?>
              <a
                class="site-header__mobile-speaking<?php echo $speaking_current ? ' is-current' : ''; ?>"
                href="<?php echo htmlspecialchars($speaking_href); ?>"
                aria-label="<?php echo htmlspecialchars($gi['name'] . 'のスピーキング'); ?>"
                <?php echo $speaking_current ? ' aria-current="page"' : ''; ?>
              >スピーキング</a>
              <?php endif; ?>
            </span>
            <?php endif; ?>
          </li>
          <?php endforeach; ?>
        </ul>
      </div>

      <?php foreach ($nav_links as $nl): ?>
      <a class="site-header__mobile-link<?php echo $nl['current'] ? ' is-current' : ''; ?>" href="<?php echo htmlspecialchars($nl['href']); ?>"<?php echo $nl['current'] ? ' aria-current="page"' : ''; ?>><?php echo htmlspecialchars($nl['label']); ?></a>
      <?php endforeach; ?>

      <div class="site-header__mobile-actions">
        <a class="site-header__btn site-header__btn--login" href="<?php echo APP_URL; ?>/login">ログイン</a>
        <a class="site-header__btn site-header__btn--signup" href="<?php echo APP_URL; ?>/signup">会員登録</a>
      </div>
    </div>
  </nav>
  <?php endif; ?>
</header>
<?php if ($show_main_nav): ?>
<script>
(function () {
  var header = document.querySelector('.site-header');
  var menuBtn = document.getElementById('site-menu-toggle');
  var mobileNav = document.getElementById('site-mobile-nav');
  var backdrop = document.getElementById('site-mobile-backdrop');
  var desktopMq = window.matchMedia('(min-width: 1024px)');

  function setMenuOpen(open) {
    if (!header || !menuBtn || !mobileNav || !backdrop) return;
    header.classList.toggle('is-menu-open', open);
    menuBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
    menuBtn.setAttribute('aria-label', open ? 'メニューを閉じる' : 'メニューを開く');
    mobileNav.hidden = !open;
    backdrop.hidden = !open;
    document.body.classList.toggle('is-nav-locked', open);
  }

  if (menuBtn) {
    menuBtn.addEventListener('click', function () {
      setMenuOpen(menuBtn.getAttribute('aria-expanded') !== 'true');
    });
  }
  if (backdrop) {
    backdrop.addEventListener('click', function () {
      setMenuOpen(false);
    });
  }
  document.querySelectorAll('.site-header__mobile-accordion').forEach(function (acc) {
    var toggle = acc.querySelector('.site-header__mobile-accordion-toggle');
    var list = acc.querySelector('.site-header__mobile-sub');
    if (!toggle || !list) return;
    toggle.addEventListener('click', function () {
      var open = toggle.getAttribute('aria-expanded') !== 'true';
      toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
      list.hidden = !open;
      acc.classList.toggle('is-open', open);
    });
  });

  function onDesktopChange(e) {
    if (e.matches) setMenuOpen(false);
  }
  if (desktopMq.addEventListener) {
    desktopMq.addEventListener('change', onDesktopChange);
  } else if (desktopMq.addListener) {
    desktopMq.addListener(onDesktopChange);
  }

  var canHover = false;
  try {
    canHover = window.matchMedia('(hover: hover) and (pointer: fine)').matches;
  } catch (e) {}

  var dropdowns = [];
  document.querySelectorAll('.site-header__dropdown').forEach(function (root) {
    var btn = root.querySelector('.site-header__dropdown-toggle');
    var menu = root.querySelector('.site-header__dropdown-menu');
    if (!btn || !menu) return;
    var closeTimer = null;

    function setOpen(open) {
      btn.setAttribute('aria-expanded', open ? 'true' : 'false');
      menu.hidden = !open;
      root.classList.toggle('is-open', open);
    }

    function closeOthers() {
      dropdowns.forEach(function (other) {
        if (other.root !== root) other.setOpen(false);
      });
    }

    function openNow() {
      if (closeTimer) {
        clearTimeout(closeTimer);
        closeTimer = null;
      }
      closeOthers();
      setOpen(true);
    }

    function closeSoon() {
      if (closeTimer) clearTimeout(closeTimer);
      closeTimer = window.setTimeout(function () {
        setOpen(false);
        closeTimer = null;
      }, 160);
    }

    if (canHover) {
      root.addEventListener('mouseenter', openNow);
      root.addEventListener('mouseleave', closeSoon);
      btn.addEventListener('focus', openNow);
      menu.addEventListener('focusin', openNow);
      root.addEventListener('focusout', function (e) {
        if (!root.contains(e.relatedTarget)) closeSoon();
      });
    }

    btn.addEventListener('click', function (e) {
      e.preventDefault();
      e.stopPropagation();
      var open = btn.getAttribute('aria-expanded') !== 'true';
      if (open) closeOthers();
      setOpen(open);
    });

    dropdowns.push({ root: root, setOpen: setOpen });
  });

  document.addEventListener('click', function (e) {
    dropdowns.forEach(function (item) {
      if (!item.root.contains(e.target)) item.setOpen(false);
    });
  });

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
      dropdowns.forEach(function (item) {
        item.setOpen(false);
      });
      setMenuOpen(false);
    }
  });
})();
</script>
<?php endif; ?>
<main>
