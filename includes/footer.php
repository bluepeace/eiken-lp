<?php
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../config.php';
}
$footer_grade_items = grade_nav_items();
?>
</main>
<footer class="site-footer">
  <div class="lp-container site-footer__inner">
    <div class="site-footer__top">
      <div class="site-footer__brand">
        <a class="site-footer__logo-link" href="/">
          <img alt="<?php echo htmlspecialchars(SITE_NAME); ?>" width="120" height="36" class="site-footer__logo logo" src="<?php echo asset('assets/images/logo-aiken.png'); ?>">
        </a>
        <p class="site-footer__tagline">英検対策アプリ AiKen（アイケン）</p>
      </div>
      <div class="site-footer__actions">
        <a class="site-footer__action site-footer__action--ghost" href="/contact">お問い合わせ</a>
        <a class="site-footer__action site-footer__action--ghost" href="<?php echo APP_URL; ?>/login">ログイン</a>
        <a class="site-footer__action site-footer__action--solid" href="<?php echo APP_URL; ?>/signup">会員登録</a>
      </div>
    </div>

    <div class="site-footer__columns">
      <nav class="site-footer__col" aria-label="サービス">
        <p class="site-footer__col-title">サービス</p>
        <ul class="site-footer__list">
          <li><a href="/">トップ</a></li>
          <li><a href="/about">AiKenとは</a></li>
          <li><a href="/plan">料金</a></li>
          <li><a href="/blog">英検コラム</a></li>
        </ul>
        <p class="site-footer__col-subtitle">級別対策</p>
        <ul class="site-footer__list">
          <?php foreach ($footer_grade_items as $gi): ?>
          <li><a href="<?php echo htmlspecialchars($gi['href']); ?>"><?php echo htmlspecialchars($gi['name']); ?></a></li>
          <?php endforeach; ?>
        </ul>
      </nav>
      <nav class="site-footer__col" aria-label="サポート">
        <p class="site-footer__col-title">サポート</p>
        <ul class="site-footer__list">
          <li><a href="/parents">保護者の方へ</a></li>
          <li><a href="/guide">使い方ガイド</a></li>
          <li><a href="/faq">よくあるご質問</a></li>
          <li><a href="/cancel">退会・解約</a></li>
          <li><a href="/contact">お問い合わせ</a></li>
        </ul>
      </nav>
      <nav class="site-footer__col" aria-label="法務・運営">
        <p class="site-footer__col-title">法務・運営</p>
        <ul class="site-footer__list">
          <li><a href="/company">運営者情報</a></li>
          <li><a href="https://note.com/wu_moriyama" rel="noopener noreferrer" target="_blank">開発者note</a></li>
          <li><a href="/tokushoho">特定商取引法に基づく表記</a></li>
          <li><a href="/terms">利用規約</a></li>
          <li><a href="/privacy">プライバシーポリシー</a></li>
          <li><a href="/external-transmission">外部送信に関する公表</a></li>
        </ul>
      </nav>
    </div>

    <div class="site-footer__bottom">
      <p class="site-footer__copy">© <?php echo date('Y'); ?> <a href="<?php echo htmlspecialchars(BLUEPIECE_LAB_URL); ?>" rel="noopener noreferrer" target="_blank">Bluepiece Lab.</a></p>
    </div>
  </div>
</footer>
</div>
</body>
</html>
