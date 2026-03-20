<?php
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../config.php';
}
?>
</main>
<footer class="border-t border-slate-200 bg-slate-50 px-4 py-8">
  <div class="mx-auto flex max-w-6xl flex-col items-center justify-between gap-4 sm:flex-row">
    <a class="flex items-center" href="/">
      <img alt="<?php echo htmlspecialchars(SITE_NAME); ?>" width="120" height="36" class="h-9 w-auto logo" src="<?php echo asset('assets/images/logo-aiken.png'); ?>">
    </a>
    <div class="flex gap-6 text-sm text-slate-600">
      <a class="hover:text-slate-900" href="<?php echo APP_URL; ?>/contact">お問い合わせ</a>
      <a class="hover:text-slate-900" href="<?php echo APP_URL; ?>/login">ログイン</a>
      <a class="hover:text-slate-900" href="<?php echo APP_URL; ?>/signup">会員登録</a>
    </div>
  </div>
  <nav class="mt-6 flex flex-wrap justify-center gap-x-5 gap-y-2 text-xs text-slate-600" aria-label="サイト内リンク">
    <a class="hover:text-slate-900 hover:underline" href="/">トップ</a>
    <a class="hover:text-slate-900 hover:underline" href="/about">AiKenとは</a>
    <a class="hover:text-slate-900 hover:underline" href="/plan">料金</a>
    <a class="hover:text-slate-900 hover:underline" href="/faq">よくあるご質問</a>
    <a class="hover:text-slate-900 hover:underline" href="/blog">英検コラム</a>
    <a class="hover:text-slate-900 hover:underline" href="/tokushoho">特定商取引法に基づく表記</a>
    <a class="hover:text-slate-900 hover:underline" href="/terms">利用規約</a>
    <a class="hover:text-slate-900 hover:underline" href="/privacy">プライバシーポリシー</a>
  </nav>
  <p class="mt-4 text-center text-xs text-slate-500">© <?php echo date('Y'); ?> <a class="text-slate-600 underline-offset-2 hover:text-slate-900 hover:underline" href="<?php echo htmlspecialchars(BLUEPIECE_LAB_URL); ?>" rel="noopener noreferrer" target="_blank">Bluepiece Lab.</a></p>
</footer>
</div>
</body>
</html>
