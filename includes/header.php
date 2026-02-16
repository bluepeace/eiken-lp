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
<div class="min-h-screen bg-white">
<header class="sticky top-0 z-50 border-b border-slate-200/80 bg-white/90 backdrop-blur-md">
  <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-3">
    <a class="flex items-center" href="<?php echo rtrim(SITE_URL, '/') . '/'; ?>">
      <img alt="<?php echo htmlspecialchars(SITE_NAME); ?>" width="120" height="36" class="h-9 w-auto logo" src="<?php echo asset('assets/images/logo-aiken.png'); ?>">
    </a>
    <nav class="flex items-center gap-2" aria-label="メインナビゲーション">
      <a class="rounded-full border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50" href="<?php echo APP_URL; ?>/login">ログイン</a>
      <a class="rounded-full bg-[#50c2cb] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#46adb5]" href="<?php echo APP_URL; ?>/signup">会員登録</a>
    </nav>
  </div>
</header>
<main>
