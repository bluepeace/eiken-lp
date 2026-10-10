<?php
/**
 * 級別単語 LP（/5kyu/vocabulary/ など）
 * 登録なしで3セットまで。登録後の単語クイズに回数制限はない。
 */
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../config.php';
}

/**
 * @return list<string>
 */
function vocabulary_grade_slugs(): array
{
    return ['1kyu', 'jun1kyu', '2kyu', 'jun2kyu-plus', 'jun2kyu', '3kyu', '4kyu', '5kyu'];
}

function vocabulary_page_path(string $slug): ?string
{
    if (!in_array($slug, vocabulary_grade_slugs(), true)) {
        return null;
    }
    return '/' . $slug . '/vocabulary/';
}

function vocabulary_url(string $slug): string
{
    $path = vocabulary_page_path($slug);
    if ($path === null) {
        return rtrim(SITE_URL, '/') . '/';
    }
    return rtrim(SITE_URL, '/') . $path;
}

function vocabulary_level_label(string $slug): string
{
    $labels = [
        '1kyu' => '1級',
        'jun1kyu' => '準1級',
        '2kyu' => '2級',
        'jun2kyu-plus' => '準2級プラス',
        'jun2kyu' => '準2級',
        '3kyu' => '3級',
        '4kyu' => '4級',
        '5kyu' => '5級',
    ];
    return $labels[$slug] ?? '';
}

function vocabulary_try_url(string $slug): string
{
    $level = vocabulary_level_label($slug);
    return rtrim(APP_URL, '/') . '/vocabulary?level=' . rawurlencode($level);
}

function vocabulary_signup_url(): string
{
    return rtrim(APP_URL, '/') . '/signup';
}

function vocabulary_shot_url(string $slug, string $key): string
{
    if ($key === '') {
        return '';
    }
    $dir = __DIR__ . '/../assets/images/grade/' . $slug . '/';
    foreach (['.webp', '.jpg', '.png'] as $ext) {
        if (is_file($dir . $key . $ext)) {
            return '/assets/images/grade/' . rawurlencode($slug) . '/' . $key . $ext;
        }
    }
    return '';
}

/**
 * @param array<string, mixed> $grade
 * @param array<string, mixed> $content
 * @return array{title: string, description: string, og_type: string, robots: string, omit_jsonld: bool}
 */
function vocabulary_meta(array $grade, array $content): array
{
    $name = (string) ($grade['name'] ?? '英検');
    $tail = (string) ($content['meta_tail'] ?? '英単語テストで語彙力を鍛える');
    return [
        'title' => $name . 'の単語対策アプリ｜' . $tail . '｜' . SITE_NAME,
        'description' => (string) ($content['description'] ?? ''),
        'og_type' => 'website',
        'robots' => '',
        'omit_jsonld' => false,
    ];
}

/**
 * @return list<array{slug: string, name: string, name_short: string, href: string}>
 */
function vocabulary_nav_items(): array
{
    $items = [];
    foreach (vocabulary_grade_slugs() as $slug) {
        $grade = get_grade($slug);
        $href = vocabulary_page_path($slug);
        if ($grade === null || $href === null) {
            continue;
        }
        $items[] = [
            'slug' => $slug,
            'name' => (string) $grade['name'],
            'name_short' => (string) $grade['name_short'],
            'href' => $href,
        ];
    }
    return $items;
}

/**
 * @param array<string, mixed> $content
 * @return list<array{q: string, a: string}>
 */
function vocabulary_faq_items(array $content): array
{
    $name = (string) ($content['faq_name'] ?? 'この級');
    return [
        [
            'q' => $name . 'の単語対策はできますか？',
            'a' => (string) ($content['faq_can'] ?? ''),
        ],
        [
            'q' => '単語テストは何度でも利用できますか？',
            'a' => '登録なしでは3セットまでです。無料登録のあと、単語クイズは回数の上限なく使えます。',
        ],
        [
            'q' => '間違えた単語を復習できますか？',
            'a' => 'ログインすると、間違えた回数が多い順に一覧へ残ります。次の10問には、その語が最大4語入ります。正解が間違いより多くなった語は、優先から外れます。ゲストのお試し3回には、履歴も優先出題もありません。',
        ],
        [
            'q' => '単語帳の代わりに使えますか？',
            'a' => '意味を眺めて覚える一覧ではなく、テストで確認する使い方です。各語に発音、日本語の意味、例文と訳があります。',
        ],
        [
            'q' => 'スマートフォンやiPadでも利用できますか？',
            'a' => 'ブラウザ、iPhone、iPadで使えます。発音と例文は、その端末の読み上げです。',
        ],
        [
            'q' => '単語以外の技能も対策できますか？',
            'a' => (string) ($content['faq_more'] ?? ''),
        ],
    ];
}

/**
 * @return array<string, mixed>|null
 */
function get_vocabulary_content(string $slug): ?array
{
    $all = vocabulary_content_all();
    return $all[$slug] ?? null;
}

/**
 * @return array<string, array<string, mixed>>
 */
function vocabulary_content_all(): array
{
    static $cache = null;
    if ($cache !== null) {
        return $cache;
    }

    $quiz = '英単語と発音記号が出て、日本語の意味を4つから選びます。単語の読み上げボタンがあります。音声は端末の読み上げです。誤答は、同じ級で品詞や分野が近い意味から出ます。正解の位置は毎回変わります。';
    $after = '選んだ直後に、正解か不正解かが出ます。間違えたときは正しい意味も出ます。例文と日本語訳があり、例文は音声で聞けます。';
    $priority = 'ログイン中は、間違えた語が次の10問に最大4語入ります。正解が間違いより多くなった語は、優先から外れます。';
    $history = '履歴に「間違えた単語」と「解答履歴」があります。間違えた回数、意味、例文の再生が見られます。1語だけを指定して解くボタンはありません。';
    $limits = '一覧で眺める単語帳、スペルを書くテスト、出る順の並び、自分で単語を追加する機能、英英の定義問題はありません。';
    $result_note = 'ページ用の見本です。正答数はセットごとに変わります。「もう一度」で次の10問に進めます。1セットの目安は約5分です。';
    $history_note = 'ログイン後の「間違えた単語」です。回数が多い順に並び、例文を聞けます。画面の注意書きどおり、これらの単語は次回のクイズで優先されます。このキャプチャの一覧には、別の級で間違えた語も並んでいます。';

    $base_worries_plus = [
        'パス単を開いても、どこまで覚えたか分からない',
        '見れば分かる語が、4択だと別の意味と迷う',
        '準2級と2級のどちらから手を付けるか迷う',
        '単語帳を買っても、1日分で止まってしまう',
        '昨日間違えた語が、今日の勉強に戻ってこない',
    ];

    $cache = [
        'jun2kyu-plus' => [
            'meta_tail' => '単語一覧・英単語テスト',
            'h1_sub' => '英単語テストで語彙力を鍛える',
            'description' => '英検対策アプリで、英検準2級プラスの単語を10問の4択で確認できます。登録なしで3セットまで。登録後は回数制限なく、間違えた語が次のセットに戻ります。',
            'lead' => '準2級プラスの語を、10問の4択で確認します。単語帳をめくるのではなく、意味を選んで、その場で覚えたかを見ます。',
            'hero_lines' => [
                '級の単語だけが、1セット10問で出る',
                '発音、正解の意味、例文と日本語訳をその場で確認できる',
                '登録なしで3セットまで試せる。登録後は回数制限なく続けられる',
            ],
            'chips' => ['10問', '4択', '登録なし3セット', '登録後は回数制限なし'],
            'faq_name' => '英検準2級プラス',
            'blog_slug' => 'eiken-jun2kyu-plus-tango-goi',
            'worries' => $base_worries_plus,
            'vocab_line' => '準2級プラスは、準2級と2級の中間です。目安は高校2年、3000語レベルで、句動詞と連語が準2級より増えます。',
            'form_text' => '級を選ぶと、その級の単語だけで10問出ます。5級から1級、準2級プラスまで切り替えられます。全レベル混在もあります。',
            'bridge' => '同じアカウントで、リーディング、リスニング、ライティング、スピーキングも練習できます。準2級プラスなら、単語のあと長文の内容一致と英作文へ行けます。',
            'faq_can' => '準2級プラスの語だけで、10問の4択ができます。5級から1級まで、級を選んで切り替えられます。',
            'faq_more' => '同じアカウントで、リーディング、リスニング、ライティング、スピーキングも練習できます。単語以外は、登録から5日を過ぎると1日1セットです。',
            'points' => [
                ['title' => 'この級の4択で意味の差を見る', 'text' => '準2級の基本語を飛ばして2級だけに進むより、この級の4択で意味の差を確認します。目安は高校2年、3000語レベルです。'],
                ['title' => '単語と日本語をセットで見る', 'text' => '選んだあとの例文で、その意味が文でどう使われるかを見ます。'],
                ['title' => '新しい語と復習が混ざる', 'text' => '10問のうち最大4問は、前に間違えた語です。ログイン後のセットに、新しい語と復習が混ざります。'],
                ['title' => '迷った語は次のセットに戻る', 'text' => '品詞が同じ別の意味と並ぶと迷います。迷った語は履歴に残り、次のセットで戻ってきます。'],
            ],
            'screen_alt' => '英検準2級プラスの単語テスト。advocate の4択。選ぶ前',
            'screen_caption' => '1問目（全10問）。選ぶ前の画面です。発音記号と読み上げボタンがあります。',
            'shots' => [
                [
                    'image' => 'word-1',
                    'kicker' => '問題',
                    'alt' => '英検準2級プラスの単語クイズ。advocate',
                    'caption' => '1問目、全10問。選ぶ前です。',
                    'question' => 'advocate',
                    'note' => '選択肢は、経験する、投票する、支持する・擁護する・提唱者、放送する、です。正解の位置は毎回変わります。',
                ],
                [
                    'image' => 'word-2',
                    'kicker' => '選択直後',
                    'alt' => 'advocate の正解は支持する・擁護する・提唱者',
                    'caption' => '同じ問題で、選んだ直後です。',
                    'question' => '支持する・擁護する・提唱者',
                    'note' => '画面の正解は C です。下に「正解！」と、例文を聞くボタンが出ます。',
                ],
                [
                    'image' => '',
                    'kicker' => '10問の終わり',
                    'alt' => '',
                    'caption' => 'ページ用の見本です。',
                    'question' => '8 / 10 問 正解',
                    'note' => $result_note,
                ],
                [
                    'image' => 'word-3',
                    'kicker' => '間違えた単語',
                    'alt' => '単語クイズの間違えた単語一覧',
                    'caption' => 'ログイン後の履歴です。',
                    'question' => '間違えた回数が多い順',
                    'note' => $history_note,
                ],
            ],
        ],
    ];

    $grades = [
        '1kyu' => [
            'meta_tail' => '英単語テストで語彙力を鍛える',
            'description' => '英検対策アプリで、英検1級の単語を10問の4択で確認できます。登録なしで3セットまで。登録後は回数制限なく、間違えた語が次のセットに戻ります。',
            'lead' => '1級の語を、10問の4択で確認します。抽象的な語の意味の差を、その場で切り分けます。',
            'worry_swap' => '抽象的な語の意味の差を、4択で切り分けたい',
            'vocab_line' => '1級は大学上級で、抽象度の高い語が中心です。',
            'point' => '抽象度の高い語は、似た日本語が4つ並びます。文脈ではなく、その語の意味の差で切り分けます。',
            'bridge' => '同じアカウントで、リーディング、リスニング、ライティング、スピーキングも練習できます。',
            'faq_can' => '1級の語だけで、10問の4択ができます。5級から1級まで、級を選んで切り替えられます。',
            'faq_more' => '同じアカウントで、リーディング、リスニング、ライティング、スピーキングも練習できます。単語以外は、登録から5日を過ぎると1日1セットです。',
            'blog_slug' => 'eiken-1kyu-tango-goi',
            'screen_alt' => '英検1級の単語テスト。perennial の4択。選ぶ前',
            'screen_caption' => '2問目（全10問）。選ぶ前の画面です。',
            'shots' => [
                [
                    'image' => 'word-1',
                    'kicker' => '問題',
                    'alt' => '英検1級の単語クイズ。perennial',
                    'caption' => '2問目、全10問。選ぶ前です。',
                    'question' => 'perennial',
                    'note' => '選択肢は、不可欠な、派生的な、不変の、永続的な、です。',
                ],
                [
                    'image' => 'word-2',
                    'kicker' => '選択直後',
                    'alt' => 'perennial の正解は永続的な',
                    'caption' => '同じ問題で、選んだ直後です。',
                    'question' => '永続的な',
                    'note' => '画面の正解は D です。下に「正解！」と、例文を聞くボタンが出ます。',
                ],
            ],
        ],
        'jun1kyu' => [
            'meta_tail' => '英単語テストで語彙力を鍛える',
            'description' => '英検対策アプリで、英検準1級の単語を10問の4択で確認できます。登録なしで3セットまで。登録後は回数制限なく、間違えた語が次のセットに戻ります。',
            'lead' => '準1級の語を、10問の4択で確認します。社会的な話題の語を、意味の差で切り分けます。',
            'worry_swap' => '抽象的な語の意味の差を、4択で切り分けたい',
            'vocab_line' => '準1級は大学中級で、社会的な話題の語が増えます。',
            'point' => '社会的な話題の語は、尊敬と退屈のように分野の違う意味が並ぶことがあります。発音を聞いてから、核になる意味を残します。',
            'bridge' => '同じアカウントで、リーディング、リスニング、ライティング、スピーキングも練習できます。',
            'faq_can' => '準1級の語だけで、10問の4択ができます。5級から1級まで、級を選んで切り替えられます。',
            'faq_more' => '同じアカウントで、リーディング、リスニング、ライティング、スピーキングも練習できます。単語以外は、登録から5日を過ぎると1日1セットです。',
            'blog_slug' => 'eiken-jun1kyu-tango-goi',
            'screen_alt' => '英検準1級の単語テスト。boredom の4択。選ぶ前',
            'screen_caption' => '1問目（全10問）。選ぶ前の画面です。',
            'shots' => [
                [
                    'image' => 'word-1',
                    'kicker' => '問題',
                    'alt' => '英検準1級の単語クイズ。boredom',
                    'caption' => '1問目、全10問。選ぶ前です。',
                    'question' => 'boredom',
                    'note' => '選択肢は、尊敬・評価、退屈・倦怠、労働力、預金する・堆積物、です。選ぶ前なので、正解の色はまだ付いていません。',
                ],
                [
                    'image' => 'word-2',
                    'kicker' => '選択直後',
                    'alt' => 'boredom の正解は退屈・倦怠',
                    'caption' => '同じ問題で、選んだ直後です。',
                    'question' => '退屈・倦怠',
                    'note' => '画面の正解は B「退屈・倦怠」です。下に「正解！」が出ます。',
                ],
            ],
        ],
        '2kyu' => [
            'meta_tail' => '英単語テストで効率よく学習',
            'description' => '英検対策アプリで、英検2級の単語を10問の4択で確認できます。登録なしで3セットまで。登録後は回数制限なく、間違えた語が次のセットに戻ります。',
            'lead' => '2級の語を、10問の4択で確認します。高校卒業程度の語を、意味の差で切り分けます。',
            'worry_swap' => '抽象的な語の意味の差を、4択で切り分けたい',
            'vocab_line' => '2級は高校卒業程度で、目安は約5,100語です。',
            'point' => '処方箋と生息地のように、話題の違う意味が並びます。知っているつもりの語ほど、4つの日本語を最後まで見ます。',
            'bridge' => '同じアカウントで、リーディング、リスニング、ライティング、スピーキングも練習できます。',
            'faq_can' => '2級の語だけで、10問の4択ができます。5級から1級まで、級を選んで切り替えられます。',
            'faq_more' => '同じアカウントで、リーディング、リスニング、ライティング、スピーキングも練習できます。単語以外は、登録から5日を過ぎると1日1セットです。',
            'blog_slug' => 'eiken-2kyu-tango-goi',
            'screen_alt' => '英検2級の単語テスト。prescription の4択。選ぶ前',
            'screen_caption' => '3問目（全10問）。選ぶ前の画面です。',
            'shots' => [
                [
                    'image' => 'word-1',
                    'kicker' => '問題',
                    'alt' => '英検2級の単語クイズ。prescription',
                    'caption' => '3問目、全10問。選ぶ前です。',
                    'question' => 'prescription',
                    'note' => '選択肢は、生息地、爆発、処方箋、悲劇、です。選ぶ前なので、正解の色はまだ付いていません。',
                ],
                [
                    'image' => 'word-2',
                    'kicker' => '選択直後',
                    'alt' => 'prescription の正解は処方箋',
                    'caption' => '同じ問題で、選んだ直後です。',
                    'question' => '処方箋',
                    'note' => '画面の正解は C「処方箋」です。下に「正解！」が出ます。',
                ],
            ],
        ],
        'jun2kyu' => [
            'meta_tail' => '英単語テストで覚える',
            'description' => '英検対策アプリで、英検準2級の単語を10問の4択で確認できます。登録なしで3セットまで。登録後は回数制限なく、間違えた語が次のセットに戻ります。',
            'lead' => '準2級の語を、10問の4択で確認します。高校中級の語を、意味と例文で確認します。',
            'worry_swap' => '見れば分かる語が、4択だと別の意味と迷う',
            'vocab_line' => '準2級は高校中級で、目安は約3,600語です。',
            'point' => '自由と金額のように、品詞が近くても意味が離れています。選んだあとの例文で、その意味が文でどう使われるかを見ます。',
            'bridge' => '同じアカウントで、リーディング、リスニング、ライティング、スピーキングも練習できます。',
            'faq_can' => '準2級の語だけで、10問の4択ができます。5級から1級まで、級を選んで切り替えられます。',
            'faq_more' => '同じアカウントで、リーディング、リスニング、ライティング、スピーキングも練習できます。単語以外は、登録から5日を過ぎると1日1セットです。',
            'blog_slug' => 'eiken-jun2kyu-tango-goi',
            'screen_alt' => '英検準2級の単語テスト。liberty の正解は自由・解放',
            'screen_caption' => '2問目（全10問）。選んだ直後です。',
            'shots' => [
                [
                    'image' => 'word-1',
                    'kicker' => '選択直後',
                    'alt' => '英検準2級の単語クイズ。liberty',
                    'caption' => '2問目、全10問。選んだ直後です。',
                    'question' => 'liberty',
                    'note' => '画面の正解は C「自由・解放」です。例文は We value liberty and justice. で、例文を聞くボタンがあります。',
                ],
                [
                    'image' => 'word-2',
                    'kicker' => '別の問題',
                    'alt' => '英検準2級の単語クイズ。rapid の正解は速い',
                    'caption' => '1問目、全10問。選んだ直後です。',
                    'question' => 'rapid',
                    'note' => '画面の正解は A「速い」です。例文は The city has seen rapid growth. です。',
                ],
            ],
        ],
        '3kyu' => [
            'meta_tail' => '英単語テストで基礎を身につける',
            'description' => '英検対策アプリで、英検3級の単語を10問の4択で確認できます。登録なしで3セットまで。登録後は回数制限なく、間違えた語が次のセットに戻ります。',
            'lead' => '3級の語を、10問の4択で確認します。中学卒業程度の基本語を、短時間で回します。',
            'worry_swap' => '中学の基本語を、短時間で回したい',
            'vocab_line' => '3級は中学卒業程度の語彙です。',
            'point' => '現れると気づくのように、基本語でも日本語が複数あります。1セット10問で、意味をその場で確認します。',
            'bridge' => '同じアカウントで、リーディング、リスニング、ライティング、スピーキングも練習できます。',
            'faq_can' => '3級の語だけで、10問の4択ができます。5級から1級まで、級を選んで切り替えられます。',
            'faq_more' => '同じアカウントで、リーディング、リスニング、ライティング、スピーキングも練習できます。単語以外は、登録から5日を過ぎると1日1セットです。',
            'blog_slug' => 'eiken-3kyu-tango-goi',
            'screen_alt' => '英検3級の単語テスト。appear の正解は現れる',
            'screen_caption' => '4問目（全10問）。選んだ直後です。',
            'shots' => [
                [
                    'image' => 'word-1',
                    'kicker' => '選択直後',
                    'alt' => '英検3級の単語クイズ。appear',
                    'caption' => '4問目、全10問。選んだ直後です。',
                    'question' => 'appear',
                    'note' => '画面の正解は A「現れる」です。ほかに、絶滅する、〜かなと思う、計画する、が並びます。',
                ],
                [
                    'image' => 'word-2',
                    'kicker' => '別の問題',
                    'alt' => '英検3級の単語クイズ。notice の正解は気づく',
                    'caption' => '1問目、全10問。選んだ直後です。',
                    'question' => 'notice',
                    'note' => '画面の正解は C「気づく」です。気にする、〜かなと思う、ひどく嫌う、と並んでいます。',
                ],
            ],
        ],
        '4kyu' => [
            'meta_tail' => '英単語テストで語彙力アップ',
            'description' => '英検対策アプリで、英検4級の単語を10問の4択で確認できます。登録なしで3セットまで。登録後は回数制限なく、間違えた語が次のセットに戻ります。',
            'lead' => '4級の語を、10問の4択で確認します。中学中級の基本語を、短時間で回します。',
            'worry_swap' => '中学の基本語を、短時間で回したい',
            'vocab_line' => '4級は中学中級の語彙です。',
            'point' => '学校、家族、日常の動作など、中学中級の語を10問ずつ回します。見れば分かる語も、4つの日本語と並べて確認します。',
            'bridge' => '同じアカウントで、リーディングとリスニングも練習できます。',
            'faq_can' => '4級の語だけで、10問の4択ができます。5級から1級まで、級を選んで切り替えられます。',
            'faq_more' => '同じアカウントで、リーディングとリスニングも練習できます。単語以外は、登録から5日を過ぎると1日1セットです。',
            'blog_slug' => 'eiken-4kyu-tango-goi',
            'screen_alt' => '英検4級の単語テスト',
            'screen_caption' => '',
            'shots' => [
                [
                    'image' => '',
                    'kicker' => '問題',
                    'alt' => '',
                    'caption' => 'ページ用の見本です。登録後の画面では、英単語、発音記号、4つの日本語が出ます。',
                    'question' => 'library',
                    'note' => '選択肢の例は、図書館、病院、駅、公園、です。正解の位置は毎回変わります。放送ではなく、画面の読み上げボタンで単語を聞けます。',
                ],
            ],
        ],
        '5kyu' => [
            'meta_tail' => '英単語テストで基本単語を覚える',
            'description' => '英検対策アプリで、英検5級の単語を10問の4択で確認できます。登録なしで3セットまで。登録後は回数制限なく、間違えた語が次のセットに戻ります。',
            'lead' => '5級の語を、10問の4択で確認します。身近な名詞と動詞を、短時間で回します。',
            'worry_swap' => '中学の基本語を、短時間で回したい',
            'vocab_line' => '5級は中学初級で、身近な名詞と動詞が中心です。',
            'point' => 'りんご、犬、学校のように、絵がなくても意味が一つに決まる語から回します。10問の終わりに正答数が出ます。',
            'bridge' => '同じアカウントで、リーディングとリスニングも練習できます。',
            'faq_can' => '5級の語だけで、10問の4択ができます。5級から1級まで、級を選んで切り替えられます。',
            'faq_more' => '同じアカウントで、リーディングとリスニングも練習できます。単語以外は、登録から5日を過ぎると1日1セットです。',
            'blog_slug' => 'eiken-5kyu-tango-goi',
            'screen_alt' => '英検5級の単語テスト',
            'screen_caption' => '',
            'shots' => [
                [
                    'image' => '',
                    'kicker' => '問題',
                    'alt' => '',
                    'caption' => 'ページ用の見本です。登録後の画面では、英単語、発音記号、4つの日本語が出ます。',
                    'question' => 'apple',
                    'note' => '選択肢の例は、りんご、いぬ、ねこ、ほん、です。正解の位置は毎回変わります。',
                ],
            ],
        ],
    ];

    foreach ($grades as $slug => $row) {
        $worries = [
            'パス単を開いても、どこまで覚えたか分からない',
            (string) $row['worry_swap'],
            'どの級の単語から手を付けるか迷う',
            '単語帳を買っても、1日分で止まってしまう',
            '昨日間違えた語が、今日の勉強に戻ってこない',
        ];
        $shots = $row['shots'];
        $shots[] = [
            'image' => '',
            'kicker' => '10問の終わり',
            'alt' => '',
            'caption' => 'ページ用の見本です。',
            'question' => '8 / 10 問 正解',
            'note' => $result_note,
        ];
        if (vocabulary_shot_url($slug, 'word-3') !== '') {
            $shots[] = [
                'image' => 'word-3',
                'kicker' => '間違えた単語',
                'alt' => '単語クイズの間違えた単語一覧',
                'caption' => 'ログイン後の履歴です。',
                'question' => '間違えた回数が多い順',
                'note' => $history_note,
            ];
        }
        $cache[$slug] = [
            'meta_tail' => $row['meta_tail'],
            'h1_sub' => '英単語テストで語彙力を鍛える',
            'description' => $row['description'],
            'lead' => $row['lead'],
            'hero_lines' => [
                '級の単語だけが、1セット10問で出る',
                '発音、正解の意味、例文と日本語訳をその場で確認できる',
                '登録なしで3セットまで試せる。登録後は回数制限なく続けられる',
            ],
            'chips' => ['10問', '4択', '登録なし3セット', '登録後は回数制限なし'],
            'faq_name' => '英検' . vocabulary_level_label($slug),
            'blog_slug' => $row['blog_slug'],
            'worries' => $worries,
            'vocab_line' => $row['vocab_line'],
            'form_text' => '級を選ぶと、その級の単語だけで10問出ます。5級から1級、準2級プラスまで切り替えられます。全レベル混在もあります。',
            'bridge' => $row['bridge'],
            'faq_can' => $row['faq_can'],
            'faq_more' => $row['faq_more'],
            'points' => [
                ['title' => '級の語彙から始める', 'text' => $row['point']],
                ['title' => '単語と日本語をセットで見る', 'text' => '選んだあとの例文で、その意味が文でどう使われるかを見ます。'],
                ['title' => '新しい語と復習が混ざる', 'text' => '10問のうち最大4問は、前に間違えた語です。ログイン後のセットに、新しい語と復習が混ざります。'],
                ['title' => '迷った語は次のセットに戻る', 'text' => '品詞が同じ別の意味と並ぶと迷います。迷った語は履歴に残り、次のセットで戻ってきます。'],
            ],
            'screen_alt' => $row['screen_alt'],
            'screen_caption' => $row['screen_caption'],
            'shots' => $shots,
            'quiz_text' => $quiz,
            'after_text' => $after,
            'priority_text' => $priority,
            'history_text' => $history,
            'limits_text' => $limits,
        ];
    }

    $cache['jun2kyu-plus']['quiz_text'] = $quiz;
    $cache['jun2kyu-plus']['after_text'] = $after;
    $cache['jun2kyu-plus']['priority_text'] = $priority;
    $cache['jun2kyu-plus']['history_text'] = $history;
    $cache['jun2kyu-plus']['limits_text'] = $limits;

    return $cache;
}
