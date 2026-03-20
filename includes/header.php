<?php
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../config.php';
}
$current_page = $page ?? 'top';
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
<div class="min-h-screen bg-white<?php echo in_array($current_page, ['top', 'about', 'faq', 'tokushoho', 'terms', 'privacy'], true) ? ' lp-index' : ''; ?>">
<?php
// LP 内リンクはルート相対にし、localhost でも現在のホストで開く（SITE_URL 固定だと本番未反映ページが開けない）
$nav_links = [
    ['label' => 'Aikenとは', 'href' => '/about'],
    ['label' => '料金', 'href' => '/plan'],
    ['label' => 'よくあるご質問', 'href' => '/faq'],
    ['label' => '英検コラム', 'href' => '/blog'],
];
$nav_class = 'whitespace-nowrap rounded-lg px-2 py-1.5 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-900 lg:px-3';
?>
<header class="sticky top-0 z-50 border-b border-slate-200/80 bg-white/90 backdrop-blur-md">
  <div class="mx-auto flex max-w-6xl items-center gap-3 px-4 py-3">
    <a class="flex shrink-0 items-center" href="/">
      <img alt="<?php echo htmlspecialchars(SITE_NAME); ?>" width="120" height="36" class="h-9 w-auto logo" src="<?php echo asset('assets/images/logo-aiken.png'); ?>">
    </a>
    <?php if (in_array($current_page, ['top', 'about', 'faq', 'tokushoho', 'terms', 'privacy', 'grade'], true)): ?>
    <nav class="min-w-0 flex-1 overflow-x-auto [-ms-overflow-style:none] [scrollbar-width:none] [&::-webkit-scrollbar]:hidden" aria-label="サイト内リンク">
      <div class="flex justify-start gap-1 sm:justify-center md:gap-2">
        <?php foreach ($nav_links as $nl):
            $is_current = ($current_page === 'about' && $nl['href'] === '/about')
                || ($current_page === 'faq' && $nl['href'] === '/faq');
            $link_class = $nav_class . ($is_current ? ' bg-slate-100 text-slate-900' : '');
            ?>
        <a class="<?php echo $link_class; ?>" href="<?php echo htmlspecialchars($nl['href']); ?>"<?php echo $is_current ? ' aria-current="page"' : ''; ?>><?php echo htmlspecialchars($nl['label']); ?></a>
        <?php endforeach; ?>
      </div>
    </nav>
    <?php else: ?>
    <div class="min-w-0 flex-1" aria-hidden="true"></div>
    <?php endif; ?>
    <nav class="flex shrink-0 items-center gap-2" aria-label="アカウント">
      <a class="rounded-full border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50" href="<?php echo APP_URL; ?>/login">ログイン</a>
      <a class="rounded-full bg-[#50c2cb] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#46adb5]" href="<?php echo APP_URL; ?>/signup">会員登録</a>
    </nav>
  </div>
</header>
<main>
