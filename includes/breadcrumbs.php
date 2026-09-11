<?php
/**
 * 全ページ共通パンくず（フッター直上）
 *
 * @var string|null $page
 * @var string|null $grade
 * @var array<string, mixed>|null $grade_data
 */
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../config.php';
}

/**
 * @param array<string, mixed>|null $grade_data
 * @return list<array{name: string, url: string}>
 */
function lp_breadcrumb_items(string $page = 'top', string $grade = '', ?array $grade_data = null): array
{
    $top = ['name' => 'TOP', 'url' => '/'];
    if ($page === 'top' || $page === '') {
        return [];
    }
    if ($page === 'grade') {
        $name = (string) ($grade_data['name'] ?? '');
        if ($name === '' || $grade === '') {
            return [];
        }
        return [
            $top,
            ['name' => '英検対策', 'url' => '/eiken/'],
            ['name' => $name, 'url' => '/' . rawurlencode($grade) . '/'],
        ];
    }
    $pages = [
        'about' => ['name' => 'AiKenとは', 'url' => '/about'],
        'eiken' => ['name' => '英検対策', 'url' => '/eiken/'],
        'plan' => ['name' => '料金', 'url' => '/plan'],
        'faq' => ['name' => 'よくあるご質問', 'url' => '/faq'],
        'parents' => ['name' => '保護者の方へ', 'url' => '/parents'],
        'guide' => ['name' => '使い方ガイド', 'url' => '/guide'],
        'cancel' => ['name' => '退会・解約', 'url' => '/cancel'],
        'contact' => ['name' => 'お問い合わせ', 'url' => '/contact'],
        'company' => ['name' => '運営者情報', 'url' => '/company'],
        'tokushoho' => ['name' => '特定商取引法に基づく表記', 'url' => '/tokushoho'],
        'terms' => ['name' => '利用規約', 'url' => '/terms'],
        'privacy' => ['name' => 'プライバシーポリシー', 'url' => '/privacy'],
        'external' => ['name' => '外部送信に関する公表', 'url' => '/external-transmission'],
    ];
    if (!isset($pages[$page])) {
        return [];
    }
    return [$top, $pages[$page]];
}

function lp_breadcrumb_absolute_url(string $url): string
{
    if (preg_match('#^https?://#i', $url) === 1) {
        return $url;
    }
    $base = rtrim(SITE_URL, '/');
    return $url === '/' ? $base . '/' : $base . $url;
}

$crumb_items = lp_breadcrumb_items(
    (string) ($page ?? 'top'),
    (string) ($grade ?? ''),
    is_array($grade_data ?? null) ? $grade_data : null
);
if (count($crumb_items) < 2) {
    return;
}
$crumb_last = count($crumb_items) - 1;
?>
<nav class="lp-breadcrumb" aria-label="パンくずリスト">
  <div class="lp-container">
    <ol class="lp-breadcrumb__list">
      <?php foreach ($crumb_items as $i => $crumb): ?>
      <li>
        <?php if ($i === $crumb_last): ?>
        <span aria-current="page"><?php echo htmlspecialchars($crumb['name']); ?></span>
        <?php else: ?>
        <a href="<?php echo htmlspecialchars($crumb['url']); ?>"><?php echo htmlspecialchars($crumb['name']); ?></a>
        <?php endif; ?>
      </li>
      <?php endforeach; ?>
    </ol>
  </div>
</nav>
<?php
$crumb_list = [];
foreach ($crumb_items as $i => $crumb) {
    $crumb_list[] = [
        '@type' => 'ListItem',
        'position' => $i + 1,
        'name' => $crumb['name'],
        'item' => lp_breadcrumb_absolute_url($crumb['url']),
    ];
}
$crumb_ld = [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => $crumb_list,
];
echo '<script type="application/ld+json">' . json_encode($crumb_ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
