<?php
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../config.php';
}
require_once __DIR__ . '/speaking-data.php';
require_once __DIR__ . '/writing-data.php';
require_once __DIR__ . '/reading-data.php';
require_once __DIR__ . '/listening-data.php';
require_once __DIR__ . '/vocabulary-data.php';
$footer_grade_items = grade_nav_items();
include __DIR__ . '/breadcrumbs.php';
?>
</main>
<footer class="site-footer">
  <div class="lp-container site-footer__inner">
    <div class="site-footer__top">
      <div class="site-footer__brand">
        <a class="site-footer__logo-link" href="/">
          <?php echo lp_picture([
              'src' => lp_versioned_asset('/assets/images/logo-aiken.png'),
              'alt' => SITE_NAME,
              'width' => 1630,
              'height' => 524,
              'class' => 'site-footer__logo logo',
              'loading' => 'lazy',
          ]); ?>
        </a>
        <p class="site-footer__tagline">英検対策アプリ AiKen（アイケン）</p>
      </div>
      <div class="site-footer__actions">
        <a class="site-footer__action site-footer__action--ghost" href="/contact">お問い合わせ</a>
        <a class="site-footer__action site-footer__action--ghost" href="<?php echo APP_URL; ?>/login">ログイン</a>
        <a class="site-footer__action site-footer__action--solid" href="<?php echo htmlspecialchars(lp_signup_url('footer'), ENT_QUOTES, 'UTF-8'); ?>">会員登録</a>
      </div>
    </div>

    <div class="site-footer__columns">
      <nav class="site-footer__col" aria-label="サービス">
        <p class="site-footer__col-title">サービス</p>
        <ul class="site-footer__list">
          <li><a href="/">トップ</a></li>
          <li><a href="/about">AiKenとは</a></li>
          <li><a href="/plan">料金プラン</a></li>
          <li><a href="/guide">使い方ガイド</a></li>
          <li><a href="/study">合格までの道</a></li>
          <li><a href="/parents">保護者の方へ</a></li>
          <li><a href="/eiken/">英検対策コンテンツ</a></li>
          <li><a href="/blog">英検コラム</a></li>
        </ul>
      </nav>
      <nav class="site-footer__col site-footer__col--grades" aria-label="級別対策">
        <p class="site-footer__col-title">級別対策</p>
        <ul class="site-footer__list site-footer__list--grades">
          <?php foreach ($footer_grade_items as $gi):
              $word_href = vocabulary_page_path($gi['slug']);
              $word_current = (($page ?? '') === 'vocabulary' && ($grade ?? '') === $gi['slug'] && $word_href !== null);
              $reading_href = reading_page_path($gi['slug']);
              $reading_current = (($page ?? '') === 'reading' && ($grade ?? '') === $gi['slug'] && $reading_href !== null);
              $listening_href = listening_page_path($gi['slug']);
              $listening_current = (($page ?? '') === 'listening' && ($grade ?? '') === $gi['slug'] && $listening_href !== null);
              $writing_href = writing_page_path($gi['slug']);
              $writing_current = (($page ?? '') === 'writing' && ($grade ?? '') === $gi['slug'] && $writing_href !== null);
              $speaking_href = speaking_page_path($gi['slug']);
              $speaking_current = (($page ?? '') === 'speaking' && ($grade ?? '') === $gi['slug'] && $speaking_href !== null);
              ?>
          <li class="site-footer__grade">
            <a href="<?php echo htmlspecialchars($gi['href']); ?>"><?php echo htmlspecialchars($gi['name']); ?></a>
            <?php if ($word_href !== null || $reading_href !== null || $listening_href !== null || $writing_href !== null || $speaking_href !== null): ?>
            <ul class="site-footer__sublist">
              <?php if ($word_href !== null): ?>
              <li><a href="<?php echo htmlspecialchars($word_href); ?>"<?php echo $word_current ? ' aria-current="page"' : ''; ?>>単語</a></li>
              <?php endif; ?>
              <?php if ($reading_href !== null): ?>
              <li><a href="<?php echo htmlspecialchars($reading_href); ?>"<?php echo $reading_current ? ' aria-current="page"' : ''; ?>>リーディング</a></li>
              <?php endif; ?>
              <?php if ($listening_href !== null): ?>
              <li><a href="<?php echo htmlspecialchars($listening_href); ?>"<?php echo $listening_current ? ' aria-current="page"' : ''; ?>>リスニング</a></li>
              <?php endif; ?>
              <?php if ($writing_href !== null): ?>
              <li><a href="<?php echo htmlspecialchars($writing_href); ?>"<?php echo $writing_current ? ' aria-current="page"' : ''; ?>>ライティング</a></li>
              <?php endif; ?>
              <?php if ($speaking_href !== null): ?>
              <li><a href="<?php echo htmlspecialchars($speaking_href); ?>"<?php echo $speaking_current ? ' aria-current="page"' : ''; ?>>スピーキング</a></li>
              <?php endif; ?>
            </ul>
            <?php endif; ?>
          </li>
          <?php endforeach; ?>
        </ul>
      </nav>
      <nav class="site-footer__col" aria-label="サポート">
        <p class="site-footer__col-title">サポート</p>
        <ul class="site-footer__list">
          <li><a href="/faq">よくあるご質問</a></li>
          <li><a href="/cancel">退会・解約</a></li>
          <li><a href="/contact">お問い合わせ</a></li>
        </ul>
        <p class="site-footer__col-subtitle">アプリ</p>
        <ul class="site-footer__list">
          <li><a href="<?php echo htmlspecialchars(lp_signup_url('footer_link'), ENT_QUOTES, 'UTF-8'); ?>">AiKen無料登録</a></li>
          <li><a href="<?php echo htmlspecialchars(APP_URL); ?>/login">AiKenログイン</a></li>
          <?php if (defined('APP_STORE_URL') && APP_STORE_URL !== ''): ?>
          <li><a href="<?php echo htmlspecialchars(APP_STORE_URL); ?>" rel="noopener noreferrer" target="_blank">App Store</a></li>
          <?php endif; ?>
          <?php if (defined('PLAY_STORE_URL') && PLAY_STORE_URL !== ''): ?>
          <li><a href="<?php echo htmlspecialchars(PLAY_STORE_URL); ?>" rel="noopener noreferrer" target="_blank">Google Play</a></li>
          <?php endif; ?>
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
      <nav class="site-footer__col" aria-label="関連">
        <p class="site-footer__col-title">関連</p>
        <ul class="site-footer__list">
          <li><a href="https://www.youtube.com/@aiken.english" rel="noopener noreferrer" target="_blank">AiKen公式YouTube</a></li>
          <li><a href="https://note.com/wu_moriyama/m/mc163c29fa30b" rel="noopener noreferrer" target="_blank">noteマガジン</a></li>
          <li><a href="https://bluepiece.me/" rel="noopener noreferrer" target="_blank">bluepiece lab.</a></li>
          <li><a href="https://uchiuta.online/" rel="noopener noreferrer" target="_blank">うちうた</a></li>
        </ul>
        <p class="site-footer__col-subtitle">Thanks</p>
        <ul class="site-footer__list">
          <li><a href="https://www.worldtalk.jp/mypages/eiken" rel="noopener noreferrer" target="_blank">ワールドトーク</a></li>
          <li><a href="https://academy.kirihara.co.jp/wte/eiken1" rel="noopener noreferrer" target="_blank">KIRIHARA Online Academy</a></li>
          <li><a href="https://pr.wte.jp/column" rel="noopener noreferrer" target="_blank">WTE</a></li>
        </ul>
      </nav>
    </div>

    <nav class="site-footer__social" aria-label="ソーシャル">
      <a class="site-footer__social-link" href="https://note.com/wu_moriyama/m/mc163c29fa30b" rel="noopener noreferrer" target="_blank">
        <span class="site-footer__social-icon">
          <img alt="" width="48" height="48" src="<?php echo asset('assets/images/social-note.svg'); ?>">
        </span>
        <span class="sr-only">noteマガジン</span>
      </a>
      <a class="site-footer__social-link" href="https://www.youtube.com/@aiken.english" rel="noopener noreferrer" target="_blank">
        <span class="site-footer__social-icon">
          <img alt="" width="48" height="48" src="<?php echo asset('assets/images/social-youtube.svg'); ?>">
        </span>
        <span class="sr-only">AiKen公式YouTube</span>
      </a>
    </nav>

    <div class="site-footer__bottom">
      <p class="site-footer__copy">© <?php echo date('Y'); ?> <a href="<?php echo htmlspecialchars(BLUEPIECE_LAB_URL); ?>" rel="noopener noreferrer" target="_blank">Bluepiece Lab.</a></p>
    </div>
  </div>
</footer>
</div>
<script>
/*
 * 外部からの流入元（?pid=instagram など）をアプリへのリンクに引き継ぐ。
 * LP の各ボタンは pid=lp_{ページ}_{級}_{位置} で出力しているので、
 * 流入元があれば先頭の lp を置き換えて instagram_{ページ}_{級}_{位置} にする。
 * 流入元は aiken.life のクッキーに30日保存（app 側の保持期間に合わせる）。
 * 形式は app 側（lib/signup-attribution.ts）と同じく英数字・_・- のみ、全体64文字以内。
 */
(function () {
  var COOKIE = 'aiken_lp_src';
  var MAX_AGE = 60 * 60 * 24 * 30;
  var APP_ORIGIN = <?php echo json_encode(parse_url(APP_URL, PHP_URL_SCHEME) . '://' . parse_url(APP_URL, PHP_URL_HOST)); ?>;

  function clean(v) {
    v = (v || '').trim().slice(0, 30);
    return /^[A-Za-z0-9_-]+$/.test(v) && v.toLowerCase().indexOf('lp_') !== 0 && v.toLowerCase() !== 'lp' ? v : '';
  }

  var src = '';
  try {
    var q = new URLSearchParams(location.search);
    src = clean(q.get('pid') || q.get('p'));
    if (src) {
      document.cookie = COOKIE + '=' + encodeURIComponent(src) + '; path=/; max-age=' + MAX_AGE + '; SameSite=Lax' + (location.protocol === 'https:' ? '; Secure' : '');
    } else {
      var m = document.cookie.match(new RegExp('(?:^|; )' + COOKIE + '=([^;]*)'));
      if (m) src = clean(decodeURIComponent(m[1]));
    }
  } catch (e) {
    src = '';
  }
  if (!src) return;

  var links = document.querySelectorAll('a[href^="' + APP_ORIGIN + '"]');
  for (var i = 0; i < links.length; i++) {
    try {
      var url = new URL(links[i].href);
      var pid = url.searchParams.get('pid') || '';
      if (pid.indexOf('lp_') !== 0) continue;
      // 64文字を超えるときは、ボタン位置ではなく流入元の側を短くする
      var rest = pid.slice(2);
      url.searchParams.set('pid', src.slice(0, Math.max(1, 64 - rest.length)) + rest);
      links[i].href = url.toString();
    } catch (e) {}
  }
})();
</script>
</body>
</html>
