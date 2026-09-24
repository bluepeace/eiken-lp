<?php
/**
 * Web CTA の下に添えるストア導線。主ボタンは差し替えない。
 * @var string $store_align start|center
 * @var bool $store_on_hero ヒーロー上では半透明パネルにする
 */
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../config.php';
}

$store_url = defined('APP_STORE_URL') ? (string) APP_STORE_URL : '';
if ($store_url === '') {
    return;
}

$store_align = (($store_align ?? 'center') === 'start') ? 'start' : 'center';
$store_on_hero = !empty($store_on_hero);
$play_url = defined('PLAY_STORE_URL') ? (string) PLAY_STORE_URL : '';

$classes = 'store-cta store-cta--' . $store_align;
if ($store_on_hero) {
    $classes .= ' store-cta--on-hero';
}
?>
<div class="<?php echo $classes; ?>">
  <p class="store-cta__divider"><span>スマホアプリでも</span></p>
  <div class="store-cta__row">
    <a
      class="store-cta__badge"
      href="<?php echo htmlspecialchars($store_url, ENT_QUOTES, 'UTF-8'); ?>"
      target="_blank"
      rel="noopener noreferrer"
    >
      <img
        src="/assets/images/badge-app-store.svg"
        alt="App Store からダウンロード"
        width="109"
        height="40"
      >
    </a>
    <?php if ($play_url !== ''): ?>
    <a
      class="store-cta__badge"
      href="<?php echo htmlspecialchars($play_url, ENT_QUOTES, 'UTF-8'); ?>"
      target="_blank"
      rel="noopener noreferrer"
    >Google Play で手に入れる</a>
    <?php else: ?>
    <p class="store-cta__soon">
      <span class="store-cta__soon-kicker">Google Play</span>
      近日公開
    </p>
    <?php endif; ?>
  </div>
  <p class="store-cta__note">同じアカウントで、ブラウザでもアプリでも使えます</p>
</div>
<?php
unset($store_align, $store_on_hero, $store_url, $play_url, $classes);
