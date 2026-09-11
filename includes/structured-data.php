<?php
/**
 * JSON-LD（構造化データ） - SEO用
 * 必要に応じて index.php などで include
 */
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../config.php';
}
$jsonLd = [
    '@context' => 'https://schema.org',
    '@type' => 'WebApplication',
    'name' => SITE_NAME . '（英検対策アプリ）',
    'alternateName' => [SITE_READING, '英検対策アプリ', '英検対策アプリ AiKen'],
    'description' => SITE_DESCRIPTION,
    'url' => APP_URL,
    'applicationCategory' => 'EducationalApplication',
    'operatingSystem' => 'Any',
    'offers' => [
        '@type' => 'Offer',
        'price' => (string) MONTHLY_PRICE,
        'priceCurrency' => 'JPY',
    ],
];
?>
<script type="application/ld+json"><?php echo json_encode($jsonLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?></script>
<?php
if (!empty($faq_schema_items) && is_array($faq_schema_items)) {
    $faqMainEntity = [];
    foreach ($faq_schema_items as $faqItem) {
        if (empty($faqItem['q']) || empty($faqItem['a'])) {
            continue;
        }
        $faqMainEntity[] = [
            '@type' => 'Question',
            'name' => $faqItem['q'],
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => $faqItem['a'],
            ],
        ];
    }
    if ($faqMainEntity) {
        $faqPageName = 'よくあるご質問｜' . SITE_NAME . '（英検対策アプリ）';
        if (($page ?? '') === 'grade' && !empty($grade_data['name'])) {
            $faqPageName = $grade_data['name'] . 'のよくある質問｜' . SITE_NAME . '（英検対策アプリ）';
        }
        $faqLd = [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'inLanguage' => 'ja',
            'name' => $faqPageName,
            'url' => $canonical ?? rtrim(SITE_URL, '/') . '/',
            'mainEntity' => $faqMainEntity,
        ];
        echo '<script type="application/ld+json">' . json_encode($faqLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
    }
}
?>
