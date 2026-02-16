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
<meta charset="utf-8">
<link rel="canonical" href="<?php echo htmlspecialchars($canonical); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo htmlspecialchars($meta['title']); ?></title>
<meta name="description" content="<?php echo htmlspecialchars($meta['description']); ?>">

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
<?php include __DIR__ . '/structured-data.php'; ?>
