<?php
/**
 * 級別SEO LP の本文・技能データ
 * 級別画像は assets/images/grade/{slug}/{key}.webp|jpg|png（webp → jpg → png）。なければ共通画面／プレースホルダー。
 */
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../config.php';
}
require_once __DIR__ . '/faq-data.php';

/**
 * 級別キャプチャ画像URL（差し替え用キー）
 * 級別ファイルは .webp → .jpg → .png の順。共通フォールバックは既存 png 等も許可。
 */
function grade_screen_url(string $slug, string $key): string
{
    $dir = __DIR__ . '/../assets/images/grade/' . $slug . '/';
    foreach (['.webp', '.jpg', '.png'] as $ext) {
        if (is_file($dir . $key . $ext)) {
            return '/assets/images/grade/' . rawurlencode($slug) . '/' . $key . $ext;
        }
    }
    // 共通アプリ画面にフォールバック
    $fallbackMap = [
        'word-1' => 'word',
        'word-2' => 'word',
        'word-3' => 'word',
        'reading-1' => 'reading',
        'reading-2' => 'reading',
        'reading-3' => 'reading',
        'reading-4' => 'reading',
        'listening-1' => 'listening',
        'listening-2' => 'listening',
        'listening-3' => 'listening',
        'listening-4' => 'listening',
        'writing-1' => 'writing',
        'writing-2' => 'writing',
        'writing-3' => 'writing',
        'speaking-1' => 'speaking',
        'speaking-2' => 'speaking',
        'speaking-3' => 'speaking',
    ];
    $skill = $fallbackMap[$key] ?? null;
    if ($skill !== null) {
        $commonDir = __DIR__ . '/../assets/images/';
        foreach (['.webp', '.jpg', '.jpeg', '.png'] as $ext) {
            $file = 'app-screen-' . $skill . $ext;
            if (is_file($commonDir . $file)) {
                return '/assets/images/' . $file;
            }
        }
    }
    return '/assets/images/app-screen-placeholder.svg';
}

/**
 * 級別ヒーロー背景。`hero-bg.webp|jpg|png` があればそれを、なければ TOP 共通背景。
 */
function grade_hero_bg_url(string $slug): string
{
    $dir = __DIR__ . '/../assets/images/grade/' . $slug . '/';
    foreach (['.webp', '.jpg', '.png'] as $ext) {
        if (is_file($dir . 'hero-bg' . $ext)) {
            return '/assets/images/grade/' . rawurlencode($slug) . '/hero-bg' . $ext;
        }
    }
    return '/assets/images/hero-bg.png';
}

function grade_has_hero_scene(string $slug): bool
{
    return grade_hero_bg_url($slug) !== '/assets/images/hero-bg.png';
}

/**
 * @return array<string, mixed>|null
 */
function get_grade_content(string $slug): ?array
{
    $all = grade_content_all();
    return $all[$slug] ?? null;
}

/**
 * 「英検●級におすすめのアプリは？」→ AiKen を紹介するFAQ
 *
 * @param list<string> $sections
 * @return array{q: string, a: string}
 */
function grade_recommend_faq_item(string $gradeName, array $sections = []): array
{
    $skillLabels = [
        'word' => '単語',
        'reading' => 'リーディング',
        'listening' => 'リスニング',
        'writing' => 'ライティング',
        'speaking' => 'スピーキング',
    ];
    $skills = [];
    foreach ($sections as $section) {
        if (isset($skillLabels[$section])) {
            $skills[] = $skillLabels[$section];
        }
    }
    $skillText = $skills !== []
        ? implode('・', $skills)
        : '単語・リーディング・リスニング・ライティング・スピーキング';

    $hasWriting = in_array('writing', $sections, true);
    $hasSpeaking = in_array('speaking', $sections, true);
    if ($hasWriting && $hasSpeaking) {
        $aiNote = 'ライティングとスピーキングはAIがその場で採点・フィードバックします。';
    } elseif ($hasWriting) {
        $aiNote = 'ライティングはAIがその場で添削・フィードバックします。';
    } elseif ($hasSpeaking) {
        $aiNote = 'スピーキングはAIがその場で採点・フィードバックします。';
    } else {
        $aiNote = '間違えた問題は履歴から復習でき、スキマ時間の学習にも向いています。';
    }

    return [
        'q' => $gradeName . 'におすすめのアプリは？',
        'a' => $gradeName . 'におすすめのアプリは、AiKen（アイケン）です。'
            . $gradeName . 'の' . $skillText . 'を本試験に近い形式で対策できます。'
            . $aiNote
            . '収録問題は10,000問超。今なら' . monthly_price_label() . 'で、'
            . FREE_TRIAL_DAYS . '日間の無料体験から始められます。',
    ];
}

/**
 * 級別FAQ（おすすめアプリ質問を先頭に付与）
 *
 * @param array<string, mixed>|null $grade_content
 * @param array<string, mixed>|null $grade_data
 * @return list<array{q: string, a: string}>
 */
function grade_faq_items(?array $grade_content, ?array $grade_data): array
{
    $items = [];
    if (is_array($grade_content['faq'] ?? null)) {
        $items = $grade_content['faq'];
    }
    if ($items === []) {
        $items = faq_top_items();
    }

    $name = $grade_data['name'] ?? '英検';
    $sections = is_array($grade_content['sections'] ?? null) ? $grade_content['sections'] : [];
    $recommend = grade_recommend_faq_item($name, $sections);

    foreach ($items as $item) {
        if (($item['q'] ?? '') === $recommend['q']) {
            return $items;
        }
    }

    array_unshift($items, $recommend);
    return $items;
}

/**
 * @return array<string, array<string, mixed>>
 */
function grade_content_all(): array
{
    static $cache = null;
    if ($cache !== null) {
        return $cache;
    }

    $wordCommonPoints = [
        '級別の語彙を4択クイズでサクッと練習',
        '解答直後に正誤と解説が表示される',
        '履歴から間違えた問題だけ復習できる',
    ];

    $cache = [
        '1kyu' => [
            'level_label' => '大学上級程度',
            'hero_lead' => '英検1級は、社会生活で求められる高度な英語力を測る最終目標の級です。AiKenなら、難度の高い語彙から長文・要約・英作文・リスニングまで、本試験に近い形式でまとめて対策できます。',
            'blog_tag_slug' => '英検1級',
            'sections' => ['word', 'reading', 'listening', 'writing'],
            'word' => [
                'lead' => '1級の短文空所補充は、難度の高い語彙・語法が中心です。社会・科学・ビジネスなど幅広い分野の語を、4択クイズで反復しながら定着させましょう。',
                'vocab_note' => '想定語彙は約10,000〜15,000語レベル。時事・学術寄りの抽象語やコロケーションも出やすい級です。',
                'points' => $wordCommonPoints,
                'images' => [
                    ['key' => 'word-1', 'caption' => '4択で意味を選ぶ'],
                    ['key' => 'word-2', 'caption' => '正誤と解説がその場で表示'],
                    ['key' => 'word-3', 'caption' => '履歴で弱点だけ復習'],
                ],
            ],
            'reading' => [
                'lead' => '1級リーディングは短文空所・長文空所・内容一致の3構成。説明文・評論文など社会性の高い題材が多く、段落の論理展開を追う力が問われます。',
                'tips' => '空所前後の接続詞・指示語に注目し、長文は段落ごとの要旨を先につかんでから設問に入ると安定します。',
                'parts' => [
                    ['title' => '短文の語句空所補充', 'desc' => '文脈に合う語句を4肢から選ぶ。語彙・語法の精度が直結する大問です。', 'image' => 'reading-1'],
                    ['title' => '長文の語句空所補充', 'desc' => 'パッセージ全体の流れを読み取り、空所に適した語句を補います。', 'image' => 'reading-2'],
                    ['title' => '長文の内容一致選択', 'desc' => '説明文・評論文の内容を正確に把握し、設問に答えます。', 'image' => 'reading-3'],
                ],
            ],
            'listening' => [
                'lead' => '放送はすべて1回。会話・説明文に加え、Real-Life形式やインタビューもあり、先読みとメモ取りが得点の鍵です。',
                'tips' => '設問と選択肢を先に眺め、キーワードを意識しながら聞く練習を重ねましょう。',
                'parts' => [
                    ['title' => '会話の内容一致選択', 'desc' => '会話のポイントを聞き取り、質問に答えます（放送1回）。', 'image' => 'listening-1'],
                    ['title' => '文の内容一致選択', 'desc' => '説明文などのパッセージ内容に関する質問です。', 'image' => 'listening-2'],
                    ['title' => 'Real-Life形式', 'desc' => 'アナウンス等の実生活に近い音声から情報を拾います。', 'image' => 'listening-3'],
                    ['title' => 'インタビュー', 'desc' => 'インタビュー全体の流れと発言の意図を捉えます。', 'image' => 'listening-4'],
                ],
            ],
            'writing' => [
                'lead' => '2024年度から英文要約が加わり、英作文とあわせて2題。論理展開の把握と、立場・理由・結論の型が重要です。AiKenでは書いた内容をAIがリアルタイムで添削します。',
                'tips' => '要約は要点の抽出、英作文は主張→理由→結論の型を時間内に書く練習を。',
                'parts' => [
                    ['title' => '英文要約', 'desc' => '与えられた英文の要点を英語で短くまとめます。', 'image' => 'writing-1'],
                    ['title' => '英作文（意見論述）', 'desc' => '指定トピックについて意見を論述します。', 'image' => 'writing-2'],
                    ['title' => 'AIによるリアルタイム添削', 'desc' => '文法・語彙・構成のフィードバックがその場で届きます。', 'image' => 'writing-3'],
                ],
            ],
            'faq' => [
                ['q' => '英検1級対策アプリとしてAiKenは何ができますか？', 'a' => '単語・リーディング・リスニング・ライティングを本試験に近い形式で対策できます。ライティングはAIがその場で添削・フィードバックします。'],
                ['q' => '1級の語彙はどのくらい必要ですか？', 'a' => '目安として約10,000〜15,000語レベルの語彙力が求められます。AiKenでは級別の単語を4択で反復し、間違えた問題を履歴から復習できます。'],
                ['q' => '1級のライティング（要約・英作文）にも対応していますか？', 'a' => 'はい。英文要約と意見論述の練習ができ、提出後はAIがリアルタイムで添削します。'],
                ['q' => '無料で試せますか？', 'a' => 'はい。登録から' . FREE_TRIAL_DAYS . '日間は全機能を無料でお試しいただけます。カード登録は不要です。'],
            ],
        ],

        'jun1kyu' => [
            'level_label' => '大学中級程度',
            'hero_lead' => '英検準1級は、社会生活で通用する英語力の目安として広く使われる級です。AiKenなら、語彙・長文・要約・英作文・リスニングを本試験形式で効率よく対策できます。',
            'blog_tag_slug' => '英検準1級',
            'sections' => ['word', 'reading', 'listening', 'writing'],
            'word' => [
                'lead' => '準1級の短文空所は、準1級レベルの語彙・語法が中心。学術・社会寄りの語も増え、意味だけでなくコロケーションの理解も大切です。',
                'vocab_note' => '想定語彙は約7,500〜9,000語レベル。説明文・評論文で出会う語を優先して押さえましょう。',
                'points' => $wordCommonPoints,
                'images' => [
                    ['key' => 'word-1', 'caption' => '4択で意味を選ぶ'],
                    ['key' => 'word-2', 'caption' => '正誤と解説がその場で表示'],
                    ['key' => 'word-3', 'caption' => '履歴で弱点だけ復習'],
                ],
            ],
            'reading' => [
                'lead' => '短文空所・長文空所・内容一致の3構成。パラグラフの流れを意識した読解が得点に直結します。',
                'tips' => '長文は段落冒頭と末尾で要旨をつかみ、設問のキーワードと対応させましょう。',
                'parts' => [
                    ['title' => '短文の語句空所補充', 'desc' => '文脈に合う語句を4肢から選ぶ語彙・語法問題です。', 'image' => 'reading-1'],
                    ['title' => '長文の語句空所補充', 'desc' => '説明文・評論文の空所に適した語句を補います。', 'image' => 'reading-2'],
                    ['title' => '長文の内容一致選択', 'desc' => 'パッセージ内容に関する質問に答えます。', 'image' => 'reading-3'],
                ],
            ],
            'listening' => [
                'lead' => '会話・説明文・Real-Life形式。放送は1回なので、先読みと要点メモが有効です。',
                'tips' => '選択肢を先に見て「何を聞かれるか」を想定してから音声を聞きましょう。',
                'parts' => [
                    ['title' => '会話の内容一致選択', 'desc' => '会話の内容に関する質問に答えます（放送1回）。', 'image' => 'listening-1'],
                    ['title' => '文の内容一致選択', 'desc' => 'パッセージ内容の聞き取り問題です。', 'image' => 'listening-2'],
                    ['title' => 'Real-Life形式', 'desc' => 'アナウンスなど実生活に近い音声から情報を拾います。', 'image' => 'listening-3'],
                ],
            ],
            'writing' => [
                'lead' => '英文要約と英作文の2題。要点抽出と、主張・理由・反論・結論の構成力が問われます。AiKenのAI添削で、書いた直後に改善点を確認できます。',
                'tips' => '要約は論理マーカーに注目。英作文は型を決めて時間内に書き切る練習を。',
                'parts' => [
                    ['title' => '英文要約', 'desc' => '文章の要点を英語で簡潔にまとめます。', 'image' => 'writing-1'],
                    ['title' => '英作文（意見論述）', 'desc' => '指定トピックについて意見を論述します。', 'image' => 'writing-2'],
                    ['title' => 'AIによるリアルタイム添削', 'desc' => '文法・構成・語彙のフィードバックをその場で受け取れます。', 'image' => 'writing-3'],
                ],
            ],
            'faq' => [
                ['q' => '英検準1級対策アプリで何ができますか？', 'a' => '単語・リーディング・リスニング・ライティングを本試験に近い形式で対策できます。ライティングはAIがリアルタイム添削します。'],
                ['q' => '準1級の要約問題にも対応していますか？', 'a' => 'はい。2024年度から導入された英文要約の練習ができ、提出後はAIが添削します。'],
                ['q' => '社会人の受験にも向いていますか？', 'a' => 'はい。スキマ時間で4択単語やリスニングを進められ、ライティングも自宅でAI添削できるため、忙しい方にも続けやすい設計です。'],
                ['q' => '無料体験はありますか？', 'a' => '登録から' . FREE_TRIAL_DAYS . '日間は全機能無料です。カード登録は不要です。'],
            ],
        ],

        '2kyu' => [
            'level_label' => '高校卒業程度',
            'hero_kicker' => '英検対策アプリ',
            'hero_headline' => '2級対策を、本試験形式で。',
            'hero_chips' => ['要約対応', '社会的な話題', '高校卒業程度'],
            'hero_lead' => '入試・就職・留学でも評価される級です。社会的な話題の読解と、要約・英作文を、単語からスピーキングまで本試験形式で対策できます。',
            'blog_tag_slug' => '英検2級',
            'trust_badges' => [
                ['icon' => 'sparkles', 'label' => 'AI添削'],
                ['icon' => 'pencil-line', 'label' => '要約問題'],
                ['icon' => 'mic', 'label' => 'スピーキング採点'],
                ['icon' => 'clipboard-list', 'label' => '問題数10,000問以上'],
                ['icon' => 'badge-check', 'label' => FREE_TRIAL_DAYS . '日間無料'],
            ],
            'positioning' => [
                'heading' => '英検2級のレベル｜準2級プラス・準1級との違い',
                'lead' => '高校卒業程度として、入試・就職・留学でも評価される級です。準2級プラスの「身近な社会」から一歩進み、社会生活に必要な英語が問われます。',
                'image' => '/assets/images/grade/2kyu/position-classroom.jpg',
                'image_alt' => '教室で教科書を開き、2級対策を考える高校生',
                'image_2' => '/assets/images/grade/2kyu/position-takeaways.jpg',
                'image_2_alt' => '机でノートに書きながら2級の学習をする生徒',
                'highlight' => '2kyu',
                'intro' => [
                    '準2級プラスは<strong>身近な社会的な話題</strong>、2級は<strong>社会的な話題</strong>。教育・環境・テクノロジーなどが、より広い社会生活の文脈で出ます。その先の準1級は大学中級程度で、求められる社会性と試験の長さが一段上がります。',
                    '試験時間は準2級プラスと同じで、リーディング・ライティング85分、リスニング約25分、面接約7分。ライティングは2024年度から<strong>英文要約＋英作文</strong>です。形式は似ていても、語彙と論理の密度が上がるので、準2級プラスの延長だけでは足りない部分を本試験の形式で慣らす級です。',
                ],
                'steps' => [
                    ['kicker' => '準2級プラス', 'title' => '身近な社会', 'text' => '教育・環境・テクノロジーなど、身の回りの社会'],
                    ['kicker' => '2級', 'title' => '社会', 'text' => '社会生活に必要な、より広い分野の話題', 'current' => true],
                    ['kicker' => '準1級', 'title' => '社会生活', 'text' => '大学中級。より高い社会性と長い試験'],
                ],
                'table' => [
                    'heading' => '準2級プラス・2級・準1級の比較',
                    'headers' => ['', '準2級プラス', '2級', '準1級'],
                    'header_keys' => ['', 'jun2kyu-plus', '2kyu', 'jun1kyu'],
                    'rows' => [
                        ['レベル目安', '高校上級程度', '高校卒業程度', '大学中級程度'],
                        ['話題', '身近な社会的な話題', '社会的な話題', '社会生活の幅広い分野'],
                        ['一次（R+W / L）', '85分 / 約25分', '85分 / 約25分', '90分 / 約30分'],
                        ['ライティング', '要約＋英作文', '要約＋英作文', '要約＋英作文'],
                        ['二次面接', '約7分・3コマ', '約7分・3コマ', '約8分・4コマ'],
                    ],
                    'note' => '時間・形式の目安は日本英語検定協会の公表内容に基づきます。最新の出題は公式サイトでご確認ください。',
                ],
                'takeaways_lead' => '準2級プラスから上がるときに、変わること',
                'takeaways' => [
                    '題材が<strong>身近な社会から、社会的な話題</strong>へ広がります。語彙と読解の抽象度が上がるのが、いちばんの差です。',
                    '要約は同じ形式でも、2級では<strong>指定語数内で要点を落とさず</strong>まとめる精度が問われます。',
                    '一次の時間と面接（約7分・3コマ）は<strong>準2級プラスと同じ</strong>。準1級は90分・面接約8分の4コマと、一段上です。',
                    'AiKenなら、要約のAI添削から社会的話題の読解まで、この級の出題に合わせて対策できます。',
                ],
            ],
            'problems' => [
                'heading' => '2級対策、<span class="heading-accent">こんなお悩み</span>ありませんか？',
                'lead' => '準2級プラスから上がる人にも、入試・就職で2級が必要な人にも。英検2級、こんなことで止まっていませんか。',
                'buddy_image' => '/assets/images/buddy-worries.png',
                'buddy_alt' => 'AiKenのバディ「チョコ」',
                'items' => [
                    '2024年から<strong>要約</strong>が出て、指定語数内に要点をまとめる型がわからない',
                    '題材が<strong>社会的な話題</strong>になって、読解や語彙が急に難しく感じる',
                    '入試・就職・留学で2級が必要だが、<strong>何から手をつければいいか</strong>迷う',
                    '要約や英作文を、保護者がその場で<strong>添削できない</strong>',
                    '準2級プラスまではできたのに、<strong>社会的な話題</strong>で点が伸びない',
                    '<strong>本番に近い形式</strong>で、この級の大問をまとめて練習したい',
                ],
                'solution' => 'だからこそ、<span class="text-brand-accent">社会的な話題の要約</span>も<strong>AIがその場で添削</strong>。本試験形式の問題を、アプリひとつで。',
            ],
            'strengths' => [
                'heading' => '英検2級対策アプリ' . htmlspecialchars(SITE_NAME) . 'の<span class="heading-accent">7つの強み</span>',
                'lead' => 'さきほどのお悩みを、ひとつのアプリでまとめて解決。',
                'items' => [
                    [
                        'title' => '2級の本試験形式で、大問どおりに',
                        'text' => '単語・リーディング・リスニング・ライティングを、<span class="lp-marker">英検2級の本番に近い形式で出題</span>します。社会的な話題の題材に合わせてあるので、「本当にこの級の対策になっているのかな」という不安も減らせます。教材をバラバラに揃えず、ひとつのアプリで今日やるべきことが明確になります。',
                        'image' => '/assets/images/grade/2kyu/strength-1.jpg',
                        'alt' => '教室で英検の問題に取り組む高校生',
                    ],
                    [
                        'title' => '形式変更後の要約も、類似問題が解き放題',
                        'text' => '2024年度から要約が入り、古い過去問だけではライティングの量が足りないことがあります。<span class="lp-marker">10,000問超</span>の問題数で、同じ形式の類似問題を何度でも解けるので、社会的な話題の読解も要約の型も、反復で定着させられます。',
                        'image' => '/assets/images/grade/2kyu/strength-2.jpg',
                        'alt' => '窓際で参考書を開いて学習する高校生',
                    ],
                    [
                        'title' => '2級の要約を、AIがその場で添削',
                        'text' => '2級のライティングは<strong>英文要約と英作文</strong>の2題です。書いた直後に、<span class="lp-marker">AIが要点のまとめ方・文法・構成をフィードバック</span>するので、保護者の方が毎回添削しなくても、その日のうちに書いて直せます。指定語数内に落とさずまとめる練習を、いちばんの不安としてカバーします。',
                        'image' => '/assets/images/grade/2kyu/strength-3.jpg',
                        'alt' => 'ヘッドセットを着けてノートPCで学習する高校生',
                    ],
                    [
                        'title' => '身近な社会から、社会的な話題へ慣らす',
                        'text' => '準2級プラスまでの延長では足りない、<span class="lp-marker">社会的な話題</span>の読解・リスニングを用意しています。教育・環境・テクノロジーなどが、より広い社会生活の文脈で出るので、語彙と論理の密度を2級の本番に合わせて上げていけます。',
                        'image' => '/assets/images/grade/2kyu/strength-4.jpg',
                        'alt' => '机でノートに書きながら学習する高校生',
                    ],
                    [
                        'title' => '間違えた問題をあとから復習',
                        'text' => '解いた問題は学習履歴として残るので、<span class="lp-marker">間違えた問題だけをあとから集中的にやり直せます</span>。要約の型も社会的話題の語彙も、一度解いて終わりにせず弱点を潰せます。どこでつまずいているか把握しやすいので、保護者の方も安心です。',
                        'image' => '/assets/images/grade/2kyu/strength-5.jpg',
                        'alt' => 'ペンで解答を書き進める高校生',
                    ],
                    [
                        'title' => 'スキマ時間にスマホから',
                        'text' => '部活や塾、仕事で忙しい方でも、通学・通勤の電車や待ち時間など、<span class="lp-marker">5〜10分の空き時間で2級の練習</span>ができます。単語やリスニングはスキマで、要約は自宅で、と役割を分けやすいのもポイントです。',
                        'image' => '/assets/images/grade/2kyu/strength-6.jpg',
                        'alt' => 'カフェでスマホを見てスキマ学習をする女性',
                    ],
                    [
                        'title' => '次の準1級も、同じアプリで続けられる',
                        'text' => '2級で固めた要約と社会的な話題は、準1級でも活きます。級が上がっても<span class="lp-marker">乗り換え不要</span>。' . FREE_TRIAL_DAYS . '日間は全機能を無料で試せるので、まずはお子さんと一緒に触ってみて、「続けられそうか」を確かめてから始められます。',
                        'image' => '/assets/images/grade/2kyu/strength-7.jpg',
                        'alt' => 'タブレットを見ながらノートを取る高校生',
                    ],
                ],
            ],
            'mid_cta' => [
                'heading' => 'まずは要約と単語を、<span class="heading-accent">' . FREE_TRIAL_DAYS . '日間無料</span>で。',
                'lead' => '2級でいちばん差がつくのは、社会的な話題の語彙と、要約の精度です。学習画面を全部見なくても、登録したその場で本試験形式に触れられます。',
                'note' => 'カード登録不要・1分で完了',
                'secondary_label' => '2級の学習内容を見る',
                'secondary_href' => '#grade-skill-word',
            ],
            'sections' => ['word', 'reading', 'listening', 'writing', 'speaking'],
            'word' => [
                'lead' => '2級では社会的な話題に登場する語彙が増えます。短文空所で頻出の語法・熟語を、4択と解説で定着させましょう。',
                'vocab_note' => '想定語彙は約5,000〜6,000語レベル。学校・仕事・環境・テクノロジーなどのテーマ語が中心です。',
                'points' => $wordCommonPoints,
                'images' => [
                    ['key' => 'word-1', 'caption' => '4択で意味を選ぶ'],
                    ['key' => 'word-2', 'caption' => '正誤と解説がその場で表示'],
                    ['key' => 'word-3', 'caption' => '履歴で弱点だけ復習'],
                ],
            ],
            'reading' => [
                'lead' => '短文空所・長文空所・内容一致。2024年度の形式変更後も、段落要旨と設問キーワードの対応が基本です。',
                'tips' => '短文は語彙・文法の定番を押さえ、長文は「誰が・何を・なぜ」を段落単位で整理しましょう。',
                'parts' => [
                    ['title' => '短文の語句空所補充', 'desc' => '文脈に合う語句を選ぶ語彙・文法問題です。', 'image' => 'reading-1'],
                    ['title' => '長文の語句空所補充', 'desc' => '説明文の空所に適した語句を補います。', 'image' => 'reading-2'],
                    ['title' => '長文の内容一致選択', 'desc' => 'パッセージ内容に関する質問に答えます。', 'image' => 'reading-3'],
                ],
            ],
            'listening' => [
                'lead' => '会話と文の内容一致が中心。放送は1回のため、選択肢の先読みが得点差になります。',
                'tips' => '質問文を先に読み、聞き取るポイントを絞ってから音声を再生しましょう。',
                'parts' => [
                    ['title' => '会話の内容一致選択', 'desc' => '会話の内容に関する質問に答えます（放送1回）。', 'image' => 'listening-1'],
                    ['title' => '文の内容一致選択', 'desc' => 'パッセージ内容を聞き取り、設問に答えます。', 'image' => 'listening-2'],
                    ['title' => '学習履歴', 'desc' => '間違えた回数が多い順に並び、音声を聞き直して弱点を復習できます。', 'image' => 'listening-3'],
                ],
            ],
            'writing' => [
                'lead' => '英文要約と英作文の2題。Yes/No＋理由2つ＋結論の型を身につけ、語数指定を守る練習が有効です。AiKenではAIがその場で添削します。',
                'tips' => '要約は段落の要点を指定語数内に。英作文は理由を具体例で支えると説得力が増します。',
                'parts' => [
                    ['title' => '英文要約', 'desc' => '文章の内容を英語で要約します。', 'image' => 'writing-1'],
                    ['title' => '英作文（意見論述）', 'desc' => '指定トピックについて意見を論述します。', 'image' => 'writing-2'],
                    ['title' => 'AIによるリアルタイム添削', 'desc' => '書いた直後に文法・構成のフィードバックが届きます。', 'image' => 'writing-3'],
                ],
            ],
            'speaking' => [
                'lead' => '2級の二次は約7分。音読、パッセージの質問、3コマのイラスト展開、自分の意見（トピック関連・一般）の流れです。AiKenでは本試験に近いカード形式で繰り返し練習でき、話した内容はAIがその場で採点します。',
                'tips' => 'イラストは過去形で3コマをつなぐ。意見はYes/Noに理由を1〜2文。カードを裏返したあとも答えられるよう、話題を頭に残しておきましょう。',
                'parts' => [
                    ['title' => 'パッセージとイラスト', 'desc' => '問題カードのパッセージと、3コマの展開を英語で説明する練習です。時系列で「誰が何をしたか」を話す力が問われます。', 'image' => 'speaking-1'],
                    ['title' => 'トピックに関する質問', 'desc' => '問題カードの社会的な話題に関連した質問へ、自分の考えで答えます。カードを見ずに答える本番の後半に近い練習です。', 'image' => 'speaking-2'],
                    ['title' => '意見を問う質問', 'desc' => '社会生活の一般的な事柄について、理由をつけて短く意見を述べます。カードの話題から少し離れた質問にも、同じ型で答えられます。', 'image' => 'speaking-3'],
                ],
            ],
            'plan' => [
                'heading' => 'この級も同じプラン',
            ],
            'target' => [
                'heading' => 'こんな方におすすめです',
                'lead' => '2級は、準2級プラスから上がる人にも、入試・就職・留学で必要な人にも選ばれています。',
                'items' => [
                    [
                        'title' => '準2級プラスから、2級へ進みたい方',
                        'text' => '形式は似ていても、題材は社会的な話題へ広がります。語彙と要約の精度を、本試験形式で上げられます。',
                        'image' => '/assets/images/target/junior-senior.jpg',
                        'alt' => '次の級に進む高校生',
                    ],
                    [
                        'title' => '入試で2級を活用したい高校生',
                        'text' => '高校卒業程度として、入試で評価される級です。通学のスキマと、自宅での要約練習を組み合わせやすいです。',
                        'image' => '/assets/images/grade/2kyu/strength-1.jpg',
                        'alt' => '教室で英検の問題に取り組む高校生',
                    ],
                    [
                        'title' => '就職・留学で2級が必要な方',
                        'text' => '社会生活に必要な英語の目安として使われます。忙しい週でも、単語とリスニングはスキマで進められます。',
                        'image' => '/assets/images/target/adult.jpg',
                        'alt' => '就職や留学に向けて学習する社会人',
                    ],
                    [
                        'title' => '要約を、保護者がその場で見られない方',
                        'text' => '書いた直後にAIが要点と文法をフィードバック。添削待ちで止まらず、その日のうちに直せます。',
                        'image' => '/assets/images/grade/2kyu/strength-5.jpg',
                        'alt' => 'ペンで解答を書き進める高校生',
                    ],
                    [
                        'title' => '部活や仕事のスキマで、一次を進めたい方',
                        'text' => '単語とリスニングは通学・通勤で、夜に要約1本。教材を増やさず、ひとつのアプリで足ります。',
                        'image' => '/assets/images/grade/2kyu/strength-6.jpg',
                        'alt' => 'カフェでスマホを見てスキマ学習をする女性',
                    ],
                    [
                        'title' => '最終目標は準1級、という方',
                        'text' => '2級で固めた要約と社会的な話題は、準1級でも活きます。級が上がっても同じアプリで続けられます。',
                        'image' => '/assets/images/grade/2kyu/strength-7.jpg',
                        'alt' => 'タブレットを見ながら学習を続ける高校生',
                    ],
                ],
            ],
            'faq' => [
                ['q' => '準2級プラスと2級の違いは何ですか？', 'a' => '準2級プラスは身近な社会的な話題、2級は社会的な話題が中心です。レベル目安は高校上級程度と高校卒業程度。一次の時間と面接（約7分・3コマ）は同じで、ライティングもどちらも要約＋英作文です。いちばんの差は、語彙と読解の抽象度が上がることです。'],
                ['q' => '2級の要約・英作文はアプリで練習できますか？', 'a' => 'はい。英文要約と意見論述の両方に対応し、書いた直後にAIが要点のまとめ方・文法・構成をフィードバックします。指定語数内に落とさずまとめる練習を、その場で直しながら進められます。'],
                ['q' => '2024年度の形式変更後も、練習できますか？', 'a' => 'はい。2級は2024年度から要約が入り、古い過去問だけではライティングの量が足りないことがあります。AiKenでは本試験に近い形式の類似問題を繰り返し解けます。本番の過去問そのものは、日本英語検定協会の公式サイトでご確認ください。'],
                ['q' => '二次試験（面接）の練習はできますか？', 'a' => 'はい。二次は約7分で、パッセージ、3コマのイラスト展開、トピック関連と一般の意見質問が出ます。AiKenでは本試験に近いカード形式で練習でき、話した内容はAIがその場で採点します。本番の面接官ではありませんが、形式と型に慣れる反復に使えます。'],
                ['q' => '2級だけ、料金は別ですか？', 'a' => 'いいえ。級ごとの料金はありません。2級も、5級〜1級と同じプレミアムプランです。' . (open_campaign_active()
                    ? '今なら' . monthly_price_label() . 'です（OPEN記念価格・定価' . monthly_price_regular_label() . '・' . open_campaign_end_label() . 'まで）。'
                    : monthly_price_regular_label() . 'です。')
                    . '詳細は料金ページをご覧ください。'],
                ['q' => '無料で始められますか？', 'a' => '登録から' . FREE_TRIAL_DAYS . '日間は全機能無料です。カード登録は不要で、会員登録の時点では課金は発生しません。'],
                ['q' => '入試・就職・留学の対策にも使えますか？', 'a' => 'はい。2級は高校卒業程度として、入試・就職・留学でも評価される級です。通学・通勤のスキマで単語とリスニング、自宅で要約と面接、と役割を分けて続けられます。'],
                ['q' => '最終目標が準1級でも、この級から始めてよいですか？', 'a' => 'はい。2級で固めた要約と社会的な話題は、準1級でも活きます。準1級は一次90分・面接約8分の4コマと一段上ですが、まずは2級の形式で慣らしておくと次につながります。級が上がっても同じアプリで続けられます。'],
                ['q' => '保護者が要約を添削できなくても大丈夫ですか？', 'a' => 'はい。書いた内容はAIがその場で添削するので、保護者の方が毎回見なくても、その日のうちに直して次へ進めます。間違えた問題は履歴から復習できます。'],
            ],
            'cta' => [
                'heading' => '2級対策を、<span class="heading-accent">' . FREE_TRIAL_DAYS . '日間無料</span>で。',
                'lead' => '社会的な話題の読解も、要約も、3コマの面接も。カード登録なしで、今日から本試験形式に触れられます。最終目標が準1級でも、同じアプリで続けられます。',
                'button' => FREE_TRIAL_DAYS . '日間無料で試す',
                'secondary_label' => '料金を見る',
                'secondary_href' => '/plan',
                'note' => 'カード登録不要・1分で完了',
            ],
        ],

        'jun2kyu-plus' => [
            'level_label' => '高校上級程度',
            'hero_kicker' => '英検対策アプリ',
            'hero_headline' => '準2級プラス対策を、本試験形式で。',
            'hero_chips' => ['要約対応', '身近な社会的話題', '準2級と2級の間'],
            'hero_lead' => '準2級と2級の間をつなぐ級です。身近な社会的な話題と、初めて出る要約を、単語からスピーキングまで本試験形式で対策できます。',
            'blog_tag_slug' => '英検準2級プラス',
            'trust_badges' => [
                ['icon' => 'sparkles', 'label' => 'AI添削'],
                ['icon' => 'pencil-line', 'label' => '要約問題'],
                ['icon' => 'mic', 'label' => 'スピーキング採点'],
                ['icon' => 'clipboard-list', 'label' => '問題数10,000問以上'],
                ['icon' => 'badge-check', 'label' => FREE_TRIAL_DAYS . '日間無料'],
            ],
            'positioning' => [
                'heading' => '英検準2級プラスのレベル｜準2級・2級との違い',
                'lead' => '2025年度に新設された、準2級と2級のあいだの級です。高校上級程度として、日常から一歩進んだ「身近な社会」の英語が問われます。',
                'image' => '/assets/images/grade/jun2kyu-plus/position-classroom.jpg',
                'image_alt' => '教室で英検対策の授業を受ける高校生',
                'image_2' => '/assets/images/grade/jun2kyu-plus/position-takeaways.jpg',
                'image_2_alt' => 'ノートを開き、準2級から次の級を考える高校生',
                'highlight' => 'jun2kyu-plus',
                'intro' => [
                    '準2級は<strong>日常的な話題</strong>、2級は<strong>社会的な話題</strong>。その谷が大きかったため、あいだをつなぐ級として準2級プラスが生まれました。学校・仕事・環境・テクノロジーなど、<span class="lp-marker">身近な社会的な話題</span>が中心です。',
                    '試験時間は2級と同じで、リーディング・ライティング85分、リスニング約25分、面接約7分。ライティングには準2級にはない<strong>英文要約</strong>も入ります。準2級の延長や単語帳だけでは足りない部分を、本試験の形式で慣らす級です。',
                ],
                'steps' => [
                    ['kicker' => '準2級', 'title' => '日常', 'text' => '学校・趣味・買い物など、身近なやりとり'],
                    ['kicker' => '準2級プラス', 'title' => '身近な社会', 'text' => '教育・環境・テクノロジーなど、身の回りの社会', 'current' => true],
                    ['kicker' => '2級', 'title' => '社会', 'text' => '社会生活に必要な、より広い分野の話題'],
                ],
                'table' => [
                    'heading' => '準2級・準2級プラス・2級の比較',
                    'headers' => ['', '準2級', '準2級プラス', '2級'],
                    'header_keys' => ['', 'jun2kyu', 'jun2kyu-plus', '2kyu'],
                    'rows' => [
                        ['レベル目安', '高校中級程度', '高校上級程度', '高校卒業程度'],
                        ['話題', '日常的な話題', '身近な社会的な話題', '社会的な話題'],
                        ['一次（R+W / L）', '80分 / 約25分', '85分 / 約25分', '85分 / 約25分'],
                        ['ライティング', 'Eメール＋英作文', '要約＋英作文', '要約＋英作文'],
                        ['二次面接', '約6分', '約7分', '約7分'],
                    ],
                    'note' => '時間・形式の目安は日本英語検定協会の公表内容に基づきます。最新の出題は公式サイトでご確認ください。',
                ],
                'takeaways_lead' => '準2級から上がるときに、変わること',
                'takeaways' => [
                    'ライティングが<strong>Eメールから要約</strong>に変わる。要点を短い英文にまとめる練習が必要です。',
                    '題材が日常会話から、<strong>教育・環境・テクノロジー</strong>など身近な社会へ広がります。',
                    '一次の時間と面接の長さは<strong>2級と同じ</strong>。形式に慣れておくと、次の級にもつながります。',
                    'AiKenなら、要約のAI添削からスピーキング採点まで、この級の出題に合わせて対策できます。',
                ],
            ],
            'problems' => [
                'heading' => '準2級プラス対策、<span class="heading-accent">こんなお悩み</span>ありませんか？',
                'lead' => '準2級からステップアップするあなたへ。英検準2級プラス、こんなことで止まっていませんか。',
                'buddy_image' => '/assets/images/buddy-worries.png',
                'buddy_alt' => 'AiKenのバディ「チョコ」',
                'items' => [
                    '準2級プラスから<strong>要約</strong>が出て、書き方の型がわからない',
                    '準2級と2級の<strong>谷</strong>が大きくて、何から手をつければいいか迷う',
                    '新設の級で<strong>過去問が少なく</strong>、練習量が足りない',
                    '要約や英作文を、保護者がその場で<strong>添削できない</strong>',
                    '題材が<strong>身近な社会</strong>になって、読解やリスニングが急に難しく感じる',
                    '<strong>本番に近い形式</strong>で、この級の大問をまとめて練習したい',
                ],
                'solution' => 'だからこそ、<span class="text-brand-accent">初めての要約</span>も<strong>AIがその場で添削</strong>。本試験形式の問題を、アプリひとつで。',
            ],
            'strengths' => [
                'heading' => '英検準2級プラス対策アプリ' . htmlspecialchars(SITE_NAME) . 'の<span class="heading-accent">7つの強み</span>',
                'lead' => 'さきほどのお悩みを、ひとつのアプリでまとめて解決。',
                'items' => [
                    [
                        'title' => '準2級プラスの本試験形式で、大問どおりに',
                        'text' => '単語・リーディング・リスニング・ライティングを、<span class="lp-marker">英検準2級プラスの本番に近い形式で出題</span>します。身近な社会的話題の題材に合わせてあるので、「本当にこの級の対策になっているのかな」という不安も減らせます。教材をバラバラに揃えず、ひとつのアプリで今日やるべきことが明確になります。',
                        'image' => '/assets/images/grade/jun2kyu-plus/strength-1.jpg',
                        'alt' => '机で英検の勉強をする高校生',
                    ],
                    [
                        'title' => '過去問が少ない新級でも、類似問題が解き放題',
                        'text' => '準2級プラスは新しい級のため、市販の過去問だけでは量が足りないことがあります。<span class="lp-marker">10,000問超</span>の問題数で、同じ形式の類似問題を何度でも解けるので、反復で定着させやすく、本番のパターンにも慣れられます。',
                        'image' => '/assets/images/grade/jun2kyu-plus/strength-2.jpg',
                        'alt' => 'ヘッドホンでスマホとタブレットを使い学習する生徒',
                    ],
                    [
                        'title' => '初めての要約を、AIがその場で添削',
                        'text' => '準2級にはなかった<strong>英文要約</strong>が、準2級プラスから出題されます。書いた直後に、<span class="lp-marker">AIが要点のまとめ方・文法・構成をフィードバック</span>するので、保護者の方が毎回添削しなくても、その日のうちに書いて直せます。初めて要約に取り組む方の、いちばんの不安をカバーします。',
                        'image' => '/assets/images/grade/jun2kyu-plus/strength-3.jpg',
                        'alt' => 'タブレットを見ながら英作文を書く高校生',
                    ],
                    [
                        'title' => '準2級と2級の谷を、身近な社会の題材で埋める',
                        'text' => '日常会話から社会問題へ一気に飛び級しなくてよいよう、教育・環境・テクノロジーなど<span class="lp-marker">身近な社会的話題</span>の読解・リスニングを用意しています。準2級の延長だけでは足りない部分を、2級の手前で慣らしていけます。',
                        'image' => '/assets/images/grade/jun2kyu-plus/strength-4.jpg',
                        'alt' => '身近な社会の話題について発表する学生',
                    ],
                    [
                        'title' => '間違えた問題をあとから復習',
                        'text' => '解いた問題は学習履歴として残るので、<span class="lp-marker">間違えた問題だけをあとから集中的にやり直せます</span>。要約の型も語彙も、一度解いて終わりにせず弱点を潰せます。どこでつまずいているか把握しやすいので、保護者の方も安心です。',
                        'image' => '/assets/images/grade/jun2kyu-plus/strength-5.jpg',
                        'alt' => 'タブレットで復習する高校生',
                    ],
                    [
                        'title' => 'スキマ時間にスマホから',
                        'text' => '部活や塾で忙しいお子さんでも、通学の電車や待ち時間など、<span class="lp-marker">5〜10分の空き時間で準2級プラスの練習</span>ができます。単語やリスニングはスキマで、要約は自宅で、と役割を分けやすいのもポイントです。',
                        'image' => '/assets/images/grade/jun2kyu-plus/strength-6.jpg',
                        'alt' => 'スマホでスキマ学習をする高校生',
                    ],
                    [
                        'title' => '次の2級も、同じアプリで続けられる',
                        'text' => '準2級プラスで慣らした要約や社会的話題は、2級でも活きます。級が上がっても<span class="lp-marker">乗り換え不要</span>。' . FREE_TRIAL_DAYS . '日間は全機能を無料で試せるので、まずはお子さんと一緒に触ってみて、「続けられそうか」を確かめてから始められます。',
                        'image' => '/assets/images/grade/jun2kyu-plus/strength-7.jpg',
                        'alt' => 'ノートに書き込みながら学習を続ける高校生',
                    ],
                ],
            ],
            'mid_cta' => [
                'heading' => 'まずは要約と単語を、<span class="heading-accent">' . FREE_TRIAL_DAYS . '日間無料</span>で。',
                'lead' => '準2級プラスでいちばん変わるのは、初めて出る要約と、身近な社会の語彙です。学習画面を全部見なくても、登録したその場で本試験形式に触れられます。',
                'note' => 'カード登録不要・1分で完了',
                'secondary_label' => '準2級プラスの学習内容を見る',
                'secondary_href' => '#grade-skill-word',
            ],
            'sections' => ['word', 'reading', 'listening', 'writing', 'speaking'],
            'word' => [
                'lead' => '日常から一歩進んだ「身近な社会的話題」の語彙が増えます。4択と解説で、意味と使い方をセットで覚えましょう。',
                'vocab_note' => '準2級より抽象度が上がり、教育・環境・テクノロジーなどのテーマ語が出やすくなります。',
                'points' => $wordCommonPoints,
                'images' => [
                    ['key' => 'word-1', 'caption' => '4択で意味を選ぶ'],
                    ['key' => 'word-2', 'caption' => '正誤と解説がその場で表示'],
                    ['key' => 'word-3', 'caption' => '履歴で弱点だけ復習'],
                ],
            ],
            'reading' => [
                'lead' => '短文空所・長文空所・内容一致。Eメールや説明文など、身近な社会的話題が中心です。',
                'tips' => '準2級より論理的なつながりを意識し、段落の要点を素早くつかむ練習を。',
                'parts' => [
                    ['title' => '短文の語句空所補充', 'desc' => '短文・会話文の空所に適した語句を選びます。', 'image' => 'reading-1'],
                    ['title' => '長文の語句空所補充', 'desc' => '説明文の空所に語句を補います。', 'image' => 'reading-2'],
                    ['title' => '長文の内容一致選択', 'desc' => 'Eメール・説明文などの内容一致問題です。', 'image' => 'reading-3'],
                ],
            ],
            'listening' => [
                'lead' => '会話と文の内容一致。放送は1回。物語文・説明文など、身近な社会的話題を扱います。',
                'tips' => '選択肢を先読みし、固有名詞や数字などの手がかりに耳をすませましょう。',
                'parts' => [
                    ['title' => '会話の内容一致選択', 'desc' => '会話の内容に関する質問に答えます（放送1回）。', 'image' => 'listening-1'],
                    ['title' => '文の内容一致選択', 'desc' => '物語文・説明文の内容を聞き取ります。', 'image' => 'listening-2'],
                    ['title' => '学習履歴', 'desc' => '間違えた回数が多い順に並び、音声を聞き直して弱点を復習できます。', 'image' => 'listening-3'],
                ],
            ],
            'writing' => [
                'lead' => '英文要約と英作文。準2級よりやや論理的な意見述べが求められます。AiKenのAI添削で、書き方の型を早く身につけられます。',
                'tips' => '要約は初めて出る方も多い大問。要点を短い英文にまとめる練習を重点的に。',
                'parts' => [
                    ['title' => '英文要約', 'desc' => '文章の内容を英語で要約します。', 'image' => 'writing-1'],
                    ['title' => '英作文（意見論述）', 'desc' => '質問に対する意見を論述します。', 'image' => 'writing-2'],
                    ['title' => 'AIによるリアルタイム添削', 'desc' => '文法・理由の明確さなどをその場でフィードバック。', 'image' => 'writing-3'],
                ],
            ],
            'speaking' => [
                'lead' => '準2級プラスの二次は約7分。準2級より2級に近い流れで、3コマのイラスト展開と、身近な社会の話題についての意見質問が出ます。AiKenでは本試験に近いカード形式で繰り返し練習でき、話した内容はAIがその場で採点します。',
                'tips' => 'イラストは過去形で3コマをつなぐ。意見はYes/Noに理由を1〜2文。カードを裏返したあとも答えられるよう、話題を頭に残しておきましょう。',
                'parts' => [
                    ['title' => 'イラストを使った質問', 'desc' => '3コマの展開を英語で説明する練習です。準2級の1枚絵と違い、時系列で「誰が何をしたか」を話す力が問われます。', 'image' => 'speaking-1'],
                    ['title' => 'トピックに関する質問', 'desc' => '問題カードの話題（買い物・環境など身近な社会）に関連した質問へ、自分の考えで答えます。カードを見ずに答える本番の後半に近い練習です。', 'image' => 'speaking-2'],
                    ['title' => '意見を問う質問', 'desc' => '日常生活の一般的な事柄について、理由をつけて短く意見を述べます。カードの話題から少し離れた質問にも、同じ型で答えられます。', 'image' => 'speaking-3'],
                ],
            ],
            'format_plan' => [
                'heading' => '英検準2級プラスの出題形式と、<span class="heading-accent">1週間の使い方</span>',
                'lead' => '公式の大問に合わせて練習できます。忙しい週は、通学で単語とリスニング、夜に要約1本、で十分です。',
                'table' => [
                    'heading' => '本番の大問（目安）',
                    'headers' => ['技能', '大問', '本番の目安'],
                    'rows' => [
                        ['skill' => 'リーディング', 'part' => '短文の語句空所補充', 'note' => '17問'],
                        ['skill' => 'リーディング', 'part' => '長文の語句空所補充', 'note' => '6問'],
                        ['skill' => 'リーディング', 'part' => '長文の内容一致選択', 'note' => '8問'],
                        ['skill' => 'ライティング', 'part' => '英文要約', 'note' => '1題', 'mark' => true],
                        ['skill' => 'ライティング', 'part' => '英作文（意見論述）', 'note' => '1題'],
                        ['skill' => 'リスニング', 'part' => '会話の内容一致選択', 'note' => '15問・放送1回'],
                        ['skill' => 'リスニング', 'part' => '文の内容一致選択', 'note' => '15問・放送1回'],
                        ['skill' => 'スピーキング', 'part' => '二次面接', 'note' => '約7分・3コマ＋意見'],
                    ],
                    'note' => '問題数・時間は日本英語検定協会の公表内容に基づく目安です。最新の出題は公式サイトでご確認ください。',
                ],
                'week' => [
                    'heading' => '忙しい週でも、役割を分ければ続く',
                    'lead' => '毎日1時間じゃなくて大丈夫。スキマ・夜・週末で役割を分けると、部活のある週でも続きやすいです。',
                    'image' => '/assets/images/grade/jun2kyu-plus/format-week.jpg',
                    'image_alt' => 'ノートを開き、次の学習を考える高校生',
                    'roles' => [
                        ['when' => '通学・待ち時間', 'time' => '5〜10分', 'title' => '単語とリスニング', 'text' => '放送1回の本番に慣れる。間違えた語だけ履歴でやり直せます。', 'icon' => 'smartphone'],
                        ['when' => '夜の机', 'time' => '15〜20分', 'title' => '週に1回は要約', 'text' => '書いた直後にAIが添削するので、保護者の方が見なくてもその日のうちに直せます。', 'icon' => 'pencil-line'],
                        ['when' => '週末', 'time' => '20分', 'title' => '英作文か面接', 'text' => '意見を書くか、3コマの展開を声に出す。2級の二次にもつながる型です。', 'icon' => 'mic'],
                    ],
                    'days' => [
                        ['day' => '月', 'text' => '単語＋L'],
                        ['day' => '火', 'text' => '単語＋読解'],
                        ['day' => '水', 'text' => '夜に要約'],
                        ['day' => '木', 'text' => '単語＋L'],
                        ['day' => '金', 'text' => '単語＋読解'],
                        ['day' => '土', 'text' => '作文 or 面接'],
                        ['day' => '日', 'text' => '履歴で復習'],
                    ],
                    'footnote' => '目安です。部活で忙しい日は、スキマの単語だけで大丈夫。',
                ],
            ],
            'plan' => [
                'heading' => 'この級も同じプラン',
            ],
            'target' => [
                'heading' => 'こんな方におすすめです',
                'lead' => '準2級プラスは、準2級の次として受ける方が多く、最終的に2級を目指す方も少なくありません。',
                'items' => [
                    [
                        'title' => '準2級に合格して、次の級へ進みたい方',
                        'text' => '日常会話の延長だけでは足りない「身近な社会」と、初めての要約。準2級プラスで、準2級と2級の谷を埋められます。',
                        'image' => '/assets/images/target/junior-senior.jpg',
                        'alt' => '次の級に進む高校生',
                    ],
                    [
                        'title' => '最終目標は2級、という方',
                        'text' => '一次の時間も面接も2級と同じです。要約と社会的話題にここで慣らしておくと、級が上がっても同じアプリで続けられます。',
                        'image' => '/assets/images/grade/jun2kyu-plus/format-week.jpg',
                        'alt' => '2級を見据えて学習する高校生',
                    ],
                    [
                        'title' => '2級がまだ遠く感じる保護者の方',
                        'text' => 'いきなり広い社会問題へ飛ばず、教育・環境・テクノロジーなど身近な社会から。要約の添削はAIに任せられます。',
                        'image' => '/assets/images/target/daily.jpg',
                        'alt' => 'お子さんの英検対策を見守る保護者',
                    ],
                    [
                        'title' => '要約を、保護者がその場で見られない方',
                        'text' => '書いた直後にAIが要点と文法をフィードバック。添削待ちで止まらず、その日のうちに直せます。',
                        'image' => '/assets/images/grade/jun2kyu-plus/strength-3.jpg',
                        'alt' => 'タブレットで英作文を書く高校生',
                    ],
                    [
                        'title' => '部活や塾のスキマで、一次を進めたい方',
                        'text' => '単語とリスニングは通学で、夜に要約1本。教材を増やさず、ひとつのアプリで足ります。',
                        'image' => '/assets/images/grade/jun2kyu-plus/strength-6.jpg',
                        'alt' => 'スマホでスキマ学習をする高校生',
                    ],
                    [
                        'title' => '新級で過去問が少なく、練習量を確保したい方',
                        'text' => '市販の過去問だけでは量が足りないことがあります。同じ形式の類似問題を何度でも解けるので、本番のパターンに慣れられます。',
                        'image' => '/assets/images/grade/jun2kyu-plus/strength-2.jpg',
                        'alt' => '類似問題で練習する生徒',
                    ],
                ],
            ],
            'faq' => [
                ['q' => '準2級プラスと準2級の違いは何ですか？', 'a' => '準2級は日常的な話題、準2級プラスは身近な社会的な話題が中心です。試験時間は2級と同じ（リーディング・ライティング85分、リスニング約25分、面接約7分）で、ライティングには準2級にない英文要約が出ます。二次も3コマのイラスト展開になり、準2級の1枚絵より2級に近い流れです。'],
                ['q' => '準2級プラスの要約問題は練習できますか？', 'a' => 'はい。英文要約の練習ができ、書いた直後にAIが要点のまとめ方・文法・構成をフィードバックします。準2級のEメールから変わる大問なので、初めて取り組む方もその場で直しながら型を覚えられます。'],
                ['q' => '新しい級で過去問が少ないのですが、練習できますか？', 'a' => 'はい。準2級プラスは2025年度新設のため、市販の過去問だけでは量が足りないことがあります。AiKenでは本試験に近い形式の類似問題を繰り返し解けます。本番の過去問そのものは、日本英語検定協会の公式サイトでご確認ください。'],
                ['q' => '二次試験（面接）の練習はできますか？', 'a' => 'はい。二次は約7分で、3コマのイラスト展開と、身近な社会の話題についての意見質問が出ます。AiKenでは本試験に近いカード形式で練習でき、話した内容はAIがその場で採点します。本番の面接官ではありませんが、形式と型に慣れる反復に使えます。'],
                ['q' => '準2級プラスだけ、料金は別ですか？', 'a' => 'いいえ。級ごとの料金はありません。準2級プラスも、5級〜1級と同じプレミアムプランです。' . (open_campaign_active()
                    ? '今なら' . monthly_price_label() . 'です（OPEN記念価格・定価' . monthly_price_regular_label() . '・' . open_campaign_end_label() . 'まで）。'
                    : monthly_price_regular_label() . 'です。')
                    . '詳細は料金ページをご覧ください。'],
                ['q' => '無料で始められますか？', 'a' => '登録から' . FREE_TRIAL_DAYS . '日間は全機能無料です。カード登録は不要で、会員登録の時点では課金は発生しません。'],
                ['q' => '準2級からステップアップしたいのですが向いていますか？', 'a' => 'はい。準2級と2級のギャップを埋める級として設計されています。身近な社会的話題の読解・リスニングと、初めての要約に慣れるのに適しています。'],
                ['q' => '最終目標が2級でも、この級から始めてよいですか？', 'a' => 'はい。一次の時間も面接も2級と同じなので、要約と社会的話題にここで慣らしておくと次の級につながります。級が上がっても同じアプリで続けられます。'],
                ['q' => '保護者が要約を添削できなくても大丈夫ですか？', 'a' => 'はい。書いた内容はAIがその場で添削するので、保護者の方が毎回見なくても、その日のうちに直して次へ進めます。間違えた問題は履歴から復習できます。'],
            ],
            'cta' => [
                'heading' => '準2級プラス対策を、<span class="heading-accent">' . FREE_TRIAL_DAYS . '日間無料</span>で。',
                'lead' => '初めての要約も、身近な社会の話題も、3コマの面接も。カード登録なしで、今日から本試験形式に触れられます。最終目標が2級でも、同じアプリで続けられます。',
                'button' => FREE_TRIAL_DAYS . '日間無料で試す',
                'secondary_label' => '料金を見る',
                'secondary_href' => '/plan',
                'note' => 'カード登録不要・1分で完了',
            ],
        ],

        'jun2kyu' => [
            'level_label' => '高校中級程度',
            'hero_lead' => '英検準2級は、日常的な話題を扱う高校中級程度の級です。AiKenなら、単語・読解・リスニング・Eメール／英作文に加え、スピーキング（面接形式）までアプリで対策できます。',
            'blog_tag_slug' => '英検準2級',
            'sections' => ['word', 'reading', 'listening', 'writing', 'speaking'],
            'word' => [
                'lead' => '学校・趣味・旅行など日常生活の語彙が中心。4択でテンポよく回し、間違えた語だけ履歴で復習するのが効率的です。',
                'vocab_note' => '想定語彙は約3,600〜4,000語レベル。基本動詞・熟語・場面語を優先して固めましょう。',
                'points' => $wordCommonPoints,
                'images' => [
                    ['key' => 'word-1', 'caption' => '4択で意味を選ぶ'],
                    ['key' => 'word-2', 'caption' => '正誤と解説がその場で表示'],
                    ['key' => 'word-3', 'caption' => '履歴で弱点だけ復習'],
                ],
            ],
            'reading' => [
                'lead' => '短文空所・会話空所・長文空所・内容一致。Eメールや説明文など、日常場面の英文が中心です。',
                'tips' => '会話文は流れを、長文は「誰が・何を・いつ」を意識すると読みやすくなります。',
                'parts' => [
                    ['title' => '短文の語句空所補充', 'desc' => '文脈に合う語句を選ぶ問題です。', 'image' => 'reading-1'],
                    ['title' => '会話文の空所補充', 'desc' => '会話の空所に文・語句を補います。', 'image' => 'reading-2'],
                    ['title' => '長文の語句空所補充', 'desc' => '物語文・説明文の空所に語句を補います。', 'image' => 'reading-3'],
                    ['title' => '長文の内容一致選択', 'desc' => 'Eメール・説明文などの内容一致です。', 'image' => 'reading-4'],
                ],
            ],
            'listening' => [
                'lead' => '応答文選択・会話の内容一致・文の内容一致。準2級以上は放送1回のパートがあるため、先読みが重要です。',
                'tips' => '応答文は会話の自然な流れを、内容一致は選択肢のキーワードを先に押さえましょう。',
                'parts' => [
                    ['title' => '会話の応答文選択', 'desc' => '最後の発話への適切な応答を選びます。', 'image' => 'listening-1'],
                    ['title' => '会話の内容一致選択', 'desc' => '会話の内容に関する質問に答えます。', 'image' => 'listening-2'],
                    ['title' => '文の内容一致選択', 'desc' => '短いパッセージの内容を聞き取ります。', 'image' => 'listening-3'],
                ],
            ],
            'writing' => [
                'lead' => '2024年度からEメールが追加され、英作文とあわせて2題。返信の型と、Yes/No＋理由の意見文が基本です。AiKenではAIがリアルタイム添削します。',
                'tips' => 'Eメールは挨拶・本文・締めの型と条件漏れ防止。英作文は中学〜高1文法で十分です。',
                'parts' => [
                    ['title' => 'Eメール', 'desc' => '依頼・質問への返信メールを英文で書きます。', 'image' => 'writing-1'],
                    ['title' => '英作文（意見論述）', 'desc' => '質問に対する意見を論述します。', 'image' => 'writing-2'],
                    ['title' => 'AIによるリアルタイム添削', 'desc' => '文法や条件の満たし方をその場でフィードバック。', 'image' => 'writing-3'],
                ],
            ],
            'speaking' => [
                'lead' => '準2級の二次は、音読・パッセージ質問・イラスト説明・意見質問の流れです。AiKenでは面接に近いカード形式で、イラスト・トピック・意見の質問を繰り返し練習できます。',
                'tips' => '音読の正確さ、イラストの行動描写、身近な質問への短い答えを型として覚えましょう。',
                'parts' => [
                    ['title' => 'イラストの質問', 'desc' => 'Pictureの状況・行動を英語で説明する練習です。', 'image' => 'speaking-1'],
                    ['title' => 'トピックの質問', 'desc' => 'パッセージやトピックに関連した質問への応答を特訓します。', 'image' => 'speaking-2'],
                    ['title' => '意見の質問', 'desc' => '身近な事柄について、理由付きで短く答える練習です。', 'image' => 'speaking-3'],
                ],
            ],
            'faq' => [
                ['q' => '英検準2級対策アプリでスピーキングもできますか？', 'a' => 'はい。準2級はスピーキング（面接形式）の練習に対応しています。イラスト・トピック・意見の質問をカード形式で特訓できます。'],
                ['q' => 'Eメール問題にも対応していますか？', 'a' => 'はい。2024年度から追加されたEメールと英作文の両方を練習でき、AIがリアルタイム添削します。'],
                ['q' => '高校入試前の対策にも使えますか？', 'a' => 'はい。日常話題の語彙・読解・リスニングを本試験形式で反復でき、スキマ時間の学習にも向いています。'],
                ['q' => '無料体験はありますか？', 'a' => '登録から' . FREE_TRIAL_DAYS . '日間は全機能無料です。カード登録は不要です。'],
            ],
        ],

        '3kyu' => [
            'level_label' => '中学卒業程度',
            'hero_lead' => '英検3級は、中学卒業程度の英語力の目安です。AiKenなら、単語・読解・リスニング・Eメール／英作文を本試験形式で対策でき、高校入試前の基礎固めにも向いています。',
            'blog_tag_slug' => '英検3級',
            'sections' => ['word', 'reading', 'listening', 'writing'],
            'word' => [
                'lead' => '中学で学ぶ語彙が中心。4択でテンポよく回し、間違えた語を履歴で復習すると定着が早くなります。',
                'vocab_note' => '想定語彙は約2,100〜2,500語レベル。家族・学校・趣味など身近な場面の語を優先しましょう。',
                'points' => $wordCommonPoints,
                'images' => [
                    ['key' => 'word-1', 'caption' => '4択で意味を選ぶ'],
                    ['key' => 'word-2', 'caption' => '正誤と解説がその場で表示'],
                    ['key' => 'word-3', 'caption' => '履歴で弱点だけ復習'],
                ],
            ],
            'reading' => [
                'lead' => '短文空所・会話空所・長文内容一致。掲示・案内、Eメール、説明文など身近な英文が中心です。',
                'tips' => '長文は「誰が・何を・いつ・どこで」を先に押さえ、設問のキーワードと対応させましょう。',
                'parts' => [
                    ['title' => '短文の語句空所補充', 'desc' => '短文・会話文の空所に語句を選びます。', 'image' => 'reading-1'],
                    ['title' => '会話文の空所補充', 'desc' => '会話の空所に文・語句を補います。', 'image' => 'reading-2'],
                    ['title' => '長文の内容一致選択', 'desc' => '掲示・Eメール・説明文などの内容一致です。', 'image' => 'reading-3'],
                ],
            ],
            'listening' => [
                'lead' => '応答文・会話内容一致・文の内容一致。3級以下は放送2回のパートがあり、1回目で大意・2回目で細部確認が有効です。',
                'tips' => '応答文はイラストと会話の流れをセットでイメージすると選びやすくなります。',
                'parts' => [
                    ['title' => '会話の応答文選択', 'desc' => '補助イラスト付きの応答選択です。', 'image' => 'listening-1'],
                    ['title' => '会話の内容一致選択', 'desc' => '会話の内容に関する質問（放送2回）。', 'image' => 'listening-2'],
                    ['title' => '文の内容一致選択', 'desc' => '短いパッセージの内容一致です。', 'image' => 'listening-3'],
                ],
            ],
            'writing' => [
                'lead' => 'Eメールと英作文の2題。返信の型と、理由付きの短い意見文が基本です。AiKenではAIがリアルタイムで添削します。',
                'tips' => '条件（含める内容・語数目安）をチェックリスト化し、書き漏れを防ぎましょう。',
                'parts' => [
                    ['title' => 'Eメール', 'desc' => '返信メールを英文で書きます。', 'image' => 'writing-1'],
                    ['title' => '英作文（意見論述）', 'desc' => '質問に対する意見を1〜2文で述べます。', 'image' => 'writing-2'],
                    ['title' => 'AIによるリアルタイム添削', 'desc' => '文法や内容の過不足をその場でフィードバック。', 'image' => 'writing-3'],
                ],
            ],
            'faq' => [
                ['q' => '英検3級対策アプリとしてAiKenは向いていますか？', 'a' => 'はい。中学卒業程度の単語・リーディング・リスニング・ライティングを本試験形式で対策できます。'],
                ['q' => '中学生でも使えますか？', 'a' => 'はい。4択単語や短い読解・リスニングから始められ、ライティングはAI添削で家庭学習にも使いやすいです。'],
                ['q' => 'Eメールと英作文の両方に対応していますか？', 'a' => 'はい。どちらも練習でき、提出後はAIがリアルタイム添削します。'],
                ['q' => '無料体験はありますか？', 'a' => '登録から' . FREE_TRIAL_DAYS . '日間は全機能無料です。カード登録は不要です。'],
            ],
        ],

        '4kyu' => [
            'level_label' => '中学中級程度',
            'hero_lead' => '英検4級は、中学中級程度の英語力の目安です。一次にライティングはなく、単語・リーディング・リスニングが中心。AiKenなら本試験形式で効率よく反復できます。',
            'blog_tag_slug' => '英検4級',
            'sections' => ['word', 'reading', 'listening'],
            'word' => [
                'lead' => '中学前半〜中盤の語彙が中心。短い4択で毎日少しずつ回し、間違えた語を履歴で復習しましょう。',
                'vocab_note' => '想定語彙は約1,300〜1,600語レベル。基本動詞・疑問詞・日常場面の語を優先します。',
                'points' => $wordCommonPoints,
                'images' => [
                    ['key' => 'word-1', 'caption' => '4択で意味を選ぶ'],
                    ['key' => 'word-2', 'caption' => '正誤と解説がその場で表示'],
                    ['key' => 'word-3', 'caption' => '履歴で弱点だけ復習'],
                ],
            ],
            'reading' => [
                'lead' => '短文空所・会話空所・語句整序・長文内容一致。掲示・メール・短い説明文など、身近な英文が中心です。',
                'tips' => '語句整序は基本文型（SV / SVO など）を意識。長文は「誰が・何を・いつ」を押さえましょう。',
                'parts' => [
                    ['title' => '短文の語句空所補充', 'desc' => '短文・会話文の空所に語句を選びます。', 'image' => 'reading-1'],
                    ['title' => '会話文の文空所補充', 'desc' => '会話の空所に文・語句を補います。', 'image' => 'reading-2'],
                    ['title' => '語句整序', 'desc' => '日本文の意味に合うよう語句を並べ替えます。', 'image' => 'reading-3'],
                    ['title' => '長文の内容一致選択', 'desc' => '掲示・Eメール・説明文などの内容一致です。', 'image' => 'reading-4'],
                ],
            ],
            'listening' => [
                'lead' => '応答文・会話内容一致・文の内容一致。放送は2回なので、1回目で場面、2回目で細部を確認する練習が有効です。',
                'tips' => 'イラスト付き応答問題は、場面を想像してから選択肢を見ると選びやすくなります。',
                'parts' => [
                    ['title' => '会話の応答文選択', 'desc' => '補助イラスト付きの応答選択です。', 'image' => 'listening-1'],
                    ['title' => '会話の内容一致選択', 'desc' => '会話の内容に関する質問（放送2回）。', 'image' => 'listening-2'],
                    ['title' => '文の内容一致選択', 'desc' => '短いパッセージの内容一致です。', 'image' => 'listening-3'],
                ],
            ],
            'faq' => [
                ['q' => '英検4級対策アプリで何ができますか？', 'a' => '単語・リーディング・リスニングを本試験に近い形式で対策できます。間違えた問題は履歴から復習できます。'],
                ['q' => '4級にライティングはありますか？', 'a' => '英検4級の一次試験にライティングはありません。AiKenの4級ページでも、単語・読解・リスニングを中心に案内しています。'],
                ['q' => '小学生・中学生でも使えますか？', 'a' => 'はい。短い4択やリスニングから始められ、保護者の方も学習の進みを把握しやすいです。'],
                ['q' => '無料で試せますか？', 'a' => '登録から' . FREE_TRIAL_DAYS . '日間は全機能無料です。カード登録は不要です。'],
            ],
        ],

        '5kyu' => [
            'level_label' => '中学初級程度',
            'hero_lead' => '英検5級は、英検の入門級です。身近な話題の短い英文・音声から情報を取る力が中心。AiKenなら、単語・リーディング・リスニングを本試験形式で楽しく始められます。',
            'blog_tag_slug' => '英検5級',
            'sections' => ['word', 'reading', 'listening'],
            'word' => [
                'lead' => '中1中心の基本語彙。be動詞・一般動詞・疑問詞などとセットで、4択クイズを短時間繰り返すのがおすすめです。',
                'vocab_note' => '想定語彙は約600〜800語レベル。自己紹介・学校・好きなものなど、身近な語から始めましょう。',
                'points' => $wordCommonPoints,
                'images' => [
                    ['key' => 'word-1', 'caption' => '4択で意味を選ぶ'],
                    ['key' => 'word-2', 'caption' => '正誤と解説がその場で表示'],
                    ['key' => 'word-3', 'caption' => '履歴で弱点だけ復習'],
                ],
            ],
            'reading' => [
                'lead' => '短文空所・会話空所・語句整序。5級は長文内容一致がなく、短い文の正確な理解が中心です。',
                'tips' => '語順（主語・動詞・目的語・時）を意識した整序練習が、読解の土台になります。',
                'parts' => [
                    ['title' => '短文の語句空所補充', 'desc' => '短文・会話文の空所に語句を選びます。', 'image' => 'reading-1'],
                    ['title' => '会話文の文空所補充', 'desc' => '会話の空所に文・語句を補います。', 'image' => 'reading-2'],
                    ['title' => '語句整序', 'desc' => '日本文の意味に合うよう語句を並べ替えます。', 'image' => 'reading-3'],
                ],
            ],
            'listening' => [
                'lead' => '応答文・会話内容一致・イラストの内容一致。放送は2回。イラスト問題は「誰が何をしているか」を聞き取る練習が有効です。',
                'tips' => '短い英文でも、登場人物と動作に注目して聞く習慣をつけましょう。',
                'parts' => [
                    ['title' => '会話の応答文選択', 'desc' => '補助イラスト付きの応答選択です。', 'image' => 'listening-1'],
                    ['title' => '会話の内容一致選択', 'desc' => '会話の内容に関する質問です。', 'image' => 'listening-2'],
                    ['title' => 'イラストの内容一致選択', 'desc' => '短文を聞き、イラストの動作・状況を選びます。', 'image' => 'listening-3'],
                ],
            ],
            'faq' => [
                ['q' => '英検5級対策アプリとしてAiKenは使えますか？', 'a' => 'はい。単語・リーディング・リスニングを本試験に近い形式で、入門から始められます。'],
                ['q' => '英語が初めてでも大丈夫ですか？', 'a' => 'はい。短い4択とイラスト付きリスニングから進められ、間違えた問題だけ復習できるので負担を抑えやすいです。'],
                ['q' => '5級にライティングはありますか？', 'a' => '英検5級の一次にライティングはありません。AiKenでも単語・読解・リスニングを中心にご案内しています。'],
                ['q' => '無料体験はありますか？', 'a' => '登録から' . FREE_TRIAL_DAYS . '日間は全機能無料です。カード登録は不要です。'],
            ],
        ],
    ];

    return $cache;
}
