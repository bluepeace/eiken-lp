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
    'name' => SITE_NAME,
    'alternateName' => SITE_READING,
    'description' => SITE_DESCRIPTION,
    'url' => APP_URL,
    'applicationCategory' => 'EducationalApplication',
    'operatingSystem' => 'Any',
    'offers' => [
        '@type' => 'Offer',
        'price' => '0',
        'priceCurrency' => 'JPY',
    ],
];
?>
<script type="application/ld+json"><?php echo json_encode($jsonLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?></script>
