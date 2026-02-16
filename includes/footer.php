<?php
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../config.php';
}
?>
</main>
<footer class="border-t border-slate-200 bg-slate-50 px-4 py-8">
  <div class="mx-auto flex max-w-6xl flex-col items-center justify-between gap-4 sm:flex-row">
    <a class="flex items-center" href="<?php echo SITE_URL; ?>/">
      <img alt="<?php echo htmlspecialchars(SITE_NAME); ?>" width="120" height="36" class="h-9 w-auto logo" src="<?php echo asset('assets/images/logo-aiken.png'); ?>">
    </a>
    <div class="flex gap-6 text-sm text-slate-600">
      <a class="hover:text-slate-900" href="<?php echo APP_URL; ?>/contact">お問い合わせ</a>
      <a class="hover:text-slate-900" href="<?php echo APP_URL; ?>/login">ログイン</a>
      <a class="hover:text-slate-900" href="<?php echo APP_URL; ?>/signup">会員登録</a>
    </div>
  </div>
  <p class="mt-6 text-center text-xs text-slate-500">© <?php echo date('Y'); ?> <?php echo htmlspecialchars(SITE_NAME); ?></p>
</footer>
</div>
</body>
</html>
