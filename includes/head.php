<?php
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../config.php';
}
if (!empty($grade)) {
    $meta = get_grade_meta($grade);
} else {
    $meta = get_page_meta($page ?? 'top');
}
$canonical = $canonical ?? (isset($grade) ? grade_url($grade) : rtrim(SITE_URL, '/') . '/');
?>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-TW48595R');</script>
<!-- End Google Tag Manager -->
<meta charset="utf-8">
<?php $base = rtrim((string)(parse_url(SITE_URL, PHP_URL_PATH) ?? ''), '/'); ?>
<link rel="icon" type="image/png" href="<?php echo $base; ?>/assets/images/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="32x32" href="<?php echo $base; ?>/assets/images/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo $base; ?>/assets/images/favicon-16x16.png">
<link rel="apple-touch-icon" sizes="48x48" href="<?php echo $base; ?>/assets/images/favicon-48x48.png">
<link rel="canonical" href="<?php echo htmlspecialchars($canonical); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo htmlspecialchars($meta['title']); ?></title>
<meta name="description" content="<?php echo htmlspecialchars($meta['description']); ?>">
<?php if (!empty($meta['robots'])): ?>
<meta name="robots" content="<?php echo htmlspecialchars($meta['robots']); ?>">
<?php endif; ?>

<!-- OGP -->
<meta property="og:type" content="<?php echo htmlspecialchars($meta['og_type']); ?>">
<meta property="og:title" content="<?php echo htmlspecialchars($meta['title']); ?>">
<meta property="og:description" content="<?php echo htmlspecialchars($meta['description']); ?>">
<meta property="og:url" content="<?php echo htmlspecialchars($canonical); ?>">
<meta property="og:locale" content="ja_JP">
<meta property="og:site_name" content="<?php echo htmlspecialchars(SITE_NAME); ?>">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;600;700&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="<?php echo asset('assets/css/style.css'); ?>">
<?php if (empty($meta['omit_jsonld'])): ?>
<?php include __DIR__ . '/structured-data.php'; ?>
<?php endif; ?>
