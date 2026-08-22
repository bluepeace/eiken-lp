<?php
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../config.php';
}
$current_page = $page ?? 'top';
$current_grade = $grade ?? '';
$show_main_nav = in_array($current_page, ['top', 'about', 'plan', 'faq', 'tokushoho', 'terms', 'privacy', 'contact', 'external', 'company', 'cancel', 'parents', 'guide', 'grade'], true);
$lp_index = in_array($current_page, ['top', 'about', 'plan', 'faq', 'tokushoho', 'terms', 'privacy', 'contact', 'external', 'company', 'cancel', 'parents', 'guide', 'grade'], true);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<?php include __DIR__ . '/head.php'; ?>
</head>
<body class="min-h-screen bg-slate-950 text-slate-50 antialiased">
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TW48595R"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<div class="min-h-screen bg-white<?php echo $lp_index ? ' lp-index' : ''; ?>">
<?php
// LP 内リンクはルート相対にし、localhost でも現在のホストで開く（SITE_URL 固定だと本番未反映ページが開けない）
$nav_links = [
    ['label' => 'Aikenとは', 'href' => '/about'],
    ['label' => '料金', 'href' => '/plan'],
    ['label' => 'よくあるご質問', 'href' => '/faq'],
    ['label' => '英検コラム', 'href' => '/blog'],
];
$grade_nav_items = grade_nav_items();
?>
<?php
$about = $nav_links[0];
$rest = array_slice($nav_links, 1);
$is_about = ($current_page === 'about');
?>
<header class="site-header sticky top-0 z-50 border-b border-slate-200/80 bg-white/90 backdrop-blur-md">
  <div class="lp-container site-header__inner px-4">
    <a class="flex shrink-0 items-center" href="/">
      <img alt="<?php echo htmlspecialchars(SITE_NAME); ?>" width="160" height="48" class="site-header__logo" src="<?php echo asset('assets/images/logo-aiken.png'); ?>">
    </a>
    <?php if ($show_main_nav): ?>
    <nav class="site-header__nav min-w-0 flex-1" aria-label="サイト内リンク">
      <div class="site-header__nav-inner flex flex-wrap justify-start gap-1 sm:justify-center md:gap-2">
        <a class="site-header__nav-link<?php echo $is_about ? ' is-current' : ''; ?>" href="<?php echo htmlspecialchars($about['href']); ?>"<?php echo $is_about ? ' aria-current="page"' : ''; ?>><?php echo htmlspecialchars($about['label']); ?></a>

        <div class="site-header__dropdown<?php echo $current_page === 'grade' ? ' is-current' : ''; ?>">
          <button
            type="button"
            class="site-header__nav-link site-header__dropdown-toggle<?php echo $current_page === 'grade' ? ' is-current' : ''; ?>"
            aria-expanded="false"
            aria-haspopup="true"
            aria-controls="grade-nav-menu"
            id="grade-nav-toggle"
          >級別対策<span class="site-header__dropdown-caret" aria-hidden="true">▾</span></button>
          <ul id="grade-nav-menu" class="site-header__dropdown-menu" role="menu" aria-labelledby="grade-nav-toggle" hidden>
            <?php foreach ($grade_nav_items as $gi):
                $is_grade_current = ($current_page === 'grade' && $current_grade === $gi['slug']);
                ?>
            <li role="none">
              <a
                role="menuitem"
                class="site-header__dropdown-link<?php echo $is_grade_current ? ' is-current' : ''; ?>"
                href="<?php echo htmlspecialchars($gi['href']); ?>"
                <?php echo $is_grade_current ? ' aria-current="page"' : ''; ?>
              ><?php echo htmlspecialchars($gi['name']); ?></a>
            </li>
            <?php endforeach; ?>
          </ul>
        </div>

        <?php foreach ($rest as $nl):
            $is_current = ($current_page === 'plan' && $nl['href'] === '/plan')
                || ($current_page === 'faq' && $nl['href'] === '/faq');
            $link_class = 'site-header__nav-link' . ($is_current ? ' is-current' : '');
            ?>
        <a class="<?php echo $link_class; ?>" href="<?php echo htmlspecialchars($nl['href']); ?>"<?php echo $is_current ? ' aria-current="page"' : ''; ?>><?php echo htmlspecialchars($nl['label']); ?></a>
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
      <a class="site-header__mobile-link<?php echo $is_about ? ' is-current' : ''; ?>" href="<?php echo htmlspecialchars($about['href']); ?>"<?php echo $is_about ? ' aria-current="page"' : ''; ?>><?php echo htmlspecialchars($about['label']); ?></a>

      <div class="site-header__mobile-accordion<?php echo $current_page === 'grade' ? ' is-open' : ''; ?>">
        <button
          type="button"
          class="site-header__mobile-link site-header__mobile-accordion-toggle<?php echo $current_page === 'grade' ? ' is-current' : ''; ?>"
          id="grade-mobile-toggle"
          aria-expanded="<?php echo $current_page === 'grade' ? 'true' : 'false'; ?>"
          aria-controls="grade-mobile-menu"
        >級別対策<span class="site-header__dropdown-caret" aria-hidden="true">▾</span></button>
        <ul id="grade-mobile-menu" class="site-header__mobile-sub"<?php echo $current_page === 'grade' ? '' : ' hidden'; ?>>
          <?php foreach ($grade_nav_items as $gi):
              $is_grade_current = ($current_page === 'grade' && $current_grade === $gi['slug']);
              ?>
          <li>
            <a
              class="site-header__mobile-sublink<?php echo $is_grade_current ? ' is-current' : ''; ?>"
              href="<?php echo htmlspecialchars($gi['href']); ?>"
              <?php echo $is_grade_current ? ' aria-current="page"' : ''; ?>
            ><?php echo htmlspecialchars($gi['name']); ?></a>
          </li>
          <?php endforeach; ?>
        </ul>
      </div>

      <?php foreach ($rest as $nl):
          $is_current = ($current_page === 'plan' && $nl['href'] === '/plan')
              || ($current_page === 'faq' && $nl['href'] === '/faq');
          ?>
      <a class="site-header__mobile-link<?php echo $is_current ? ' is-current' : ''; ?>" href="<?php echo htmlspecialchars($nl['href']); ?>"<?php echo $is_current ? ' aria-current="page"' : ''; ?>><?php echo htmlspecialchars($nl['label']); ?></a>
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
  var gradeToggle = document.getElementById('grade-mobile-toggle');
  var gradeList = document.getElementById('grade-mobile-menu');
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
  if (gradeToggle && gradeList) {
    gradeToggle.addEventListener('click', function () {
      var open = gradeToggle.getAttribute('aria-expanded') !== 'true';
      gradeToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
      gradeList.hidden = !open;
      gradeToggle.parentElement.classList.toggle('is-open', open);
    });
  }

  function onDesktopChange(e) {
    if (e.matches) setMenuOpen(false);
  }
  if (desktopMq.addEventListener) {
    desktopMq.addEventListener('change', onDesktopChange);
  } else if (desktopMq.addListener) {
    desktopMq.addListener(onDesktopChange);
  }

  var root = document.querySelector('.site-header__dropdown');
  var btn = document.getElementById('grade-nav-toggle');
  var menu = document.getElementById('grade-nav-menu');
  if (!root || !btn || !menu) return;

  var closeTimer = null;
  var canHover = false;
  try {
    canHover = window.matchMedia('(hover: hover) and (pointer: fine)').matches;
  } catch (e) {}

  function setOpen(open) {
    btn.setAttribute('aria-expanded', open ? 'true' : 'false');
    menu.hidden = !open;
    root.classList.toggle('is-open', open);
  }

  function openNow() {
    if (closeTimer) {
      clearTimeout(closeTimer);
      closeTimer = null;
    }
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
    setOpen(btn.getAttribute('aria-expanded') !== 'true');
  });

  document.addEventListener('click', function (e) {
    if (!root.contains(e.target)) setOpen(false);
  });

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
      setOpen(false);
      setMenuOpen(false);
    }
  });
})();
</script>
<?php endif; ?>
<main>
