<?php
/**
 * https://aiken.life/llms.txt
 * LLM向けのページ一覧。URLは sitemap.php と同じデータから出す。
 */
declare(strict_types=1);

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/speaking-data.php';
require_once __DIR__ . '/includes/writing-data.php';
require_once __DIR__ . '/includes/reading-data.php';
require_once __DIR__ . '/includes/listening-data.php';
require_once __DIR__ . '/includes/vocabulary-data.php';
require_once __DIR__ . '/includes/grammar-data.php';

header('Content-Type: text/plain; charset=UTF-8');

$base = rtrim(SITE_URL, '/');

$line = static function (string $title, string $path, string $note) use ($base): string {
    $url = str_starts_with($path, 'http') ? $path : $base . $path;
    return '- [' . $title . '](' . $url . '): ' . $note;
};

$sections = [];

$sections['サービス'] = [
    $line('トップ', '/', '英検5級から1級までの対策アプリ AiKen の案内。'),
    $line('AiKenとは', '/about', 'アプリの特徴と、単語・文法・4技能の位置づけ。'),
    $line('使い方ガイド', '/guide', '登録から、単語・文法・4技能の始め方。'),
    $line('英検合格の道', '/study', '級ごとの勉強の進め方。'),
    $line('保護者の方へ', '/parents', '保護者向けの料金と学習の説明。'),
    $line('学校向け', '/school', '私立中学・高校向けの導入相談。学習内容は現在のAiKenに同じ。'),
    $line('学習塾向け', '/juku', '学習塾向けの英検対策の相談。学習内容は現在のAiKenに同じ。料金の金額は掲載していない。'),
    $line('英検対策コンテンツ', '/eiken/', '級別ページ、技能ページ、コラムへの入口。'),
    $line('料金', '/plan', '無料プランとプレミアムプラン。単語と、5級から2級の文法は回数の上限がない。'),
    $line('よくあるご質問', '/faq', '料金、回数、文法の有無を含む質問。'),
    $line('英検コラム', '/blog/', '級別・技能別の解説記事。'),
];

$gradeLines = [];
foreach ($GRADES as $slug => $grade) {
    $name = (string) ($grade['name'] ?? $slug);
    $gradeLines[] = $line($name, grade_url($slug), (string) ($grade['description'] ?? $name . 'の対策ページ。'));
}
$sections['級別ページ'] = $gradeLines;

$grammarLines = [];
foreach (grammar_grade_slugs() as $slug) {
    $content = get_grammar_content($slug);
    $grade = get_grade($slug);
    if ($content === null || $grade === null) {
        continue;
    }
    $name = (string) $grade['name'];
    $note = (int) $content['theme_count'] . 'テーマ・' . (int) $content['question_count'] . '問。' . (string) $content['h1_sub'] . ' AiKen独自のカリキュラムで、公式の文法項目一覧ではない。';
    $grammarLines[] = $line($name . 'の文法', (string) grammar_page_path($slug), $note);
}
$sections['文法（5級から2級）'] = $grammarLines;

$skillSections = [
    '単語' => ['fn' => 'vocabulary_page_path', 'suffix' => 'の単語'],
    'リーディング' => ['fn' => 'reading_page_path', 'suffix' => 'のリーディング'],
    'リスニング' => ['fn' => 'listening_page_path', 'suffix' => 'のリスニング'],
    'ライティング' => ['fn' => 'writing_page_path', 'suffix' => 'のライティング'],
    'スピーキング' => ['fn' => 'speaking_page_path', 'suffix' => 'のスピーキング'],
];
foreach ($skillSections as $heading => $skill) {
    $items = [];
    foreach ($GRADES as $slug => $grade) {
        $path = ($skill['fn'])($slug);
        if ($path === null) {
            continue;
        }
        $name = (string) ($grade['name'] ?? $slug);
        $items[] = $line($name . $skill['suffix'], $path, $name . $skill['suffix'] . 'の練習ページ。');
    }
    $sections[$heading] = $items;
}

$sections['運営'] = [
    $line('運営者情報', '/company', '運営者の情報。'),
    $line('メディアの方へ', '/media', '紹介用の事実と素材。'),
    $line('利用規約', '/terms', 'サービスの利用条件。'),
    $line('プライバシーポリシー', '/privacy', '個人情報の取り扱い。'),
    $line('サイトマップ', '/sitemap.xml', '公開ページのURL一覧。'),
];

echo "# AiKen（アイケン）\n\n";
echo "> 英検5級から1級までを、単語・リーディング・リスニング・ライティング・スピーキングの本試験に近い形式で練習できる英検対策アプリの公式サイトです。文法は5級から2級まで、1テーマ5問で、回数の上限はありません。\n\n";
echo "文法はAiKen独自のカリキュラムです。英検協会が公式に定めた文法項目の一覧ではありません。1級と準1級の文法テーマはありません。全範囲の網羅や、合格点は約束していません。\n\n";

foreach ($sections as $heading => $items) {
    if ($items === []) {
        continue;
    }
    echo '## ' . $heading . "\n\n";
    echo implode("\n", $items) . "\n\n";
}
