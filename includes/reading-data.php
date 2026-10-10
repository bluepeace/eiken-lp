<?php
/**
 * 級別リーディング LP（/5kyu/reading/ など）
 * リーディングは5級から1級まである。登録なしの1問体験はない。
 */
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../config.php';
}

/**
 * @return list<string>
 */
function reading_grade_slugs(): array
{
    return ['1kyu', 'jun1kyu', '2kyu', 'jun2kyu-plus', 'jun2kyu', '3kyu', '4kyu', '5kyu'];
}

function reading_page_path(string $slug): ?string
{
    if (!in_array($slug, reading_grade_slugs(), true)) {
        return null;
    }
    return '/' . $slug . '/reading/';
}

function reading_url(string $slug): string
{
    $path = reading_page_path($slug);
    if ($path === null) {
        return rtrim(SITE_URL, '/') . '/';
    }
    return rtrim(SITE_URL, '/') . $path;
}

function reading_signup_url(): string
{
    return rtrim(APP_URL, '/') . '/signup';
}

/**
 * 級フォルダの画像だけを返す。共通の読み替え画面は使わない。
 */
function reading_shot_url(string $slug, string $key): string
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
function reading_meta(array $grade, array $content): array
{
    $name = (string) ($grade['name'] ?? '英検');
    return [
        'title' => $name . 'リーディング対策｜英検対策アプリ｜' . SITE_NAME,
        'description' => (string) ($content['description'] ?? ''),
        'og_type' => 'website',
        'robots' => '',
        'omit_jsonld' => false,
    ];
}

/**
 * @return list<array{slug: string, name: string, name_short: string, href: string}>
 */
function reading_nav_items(): array
{
    $items = [];
    foreach (reading_grade_slugs() as $slug) {
        $grade = get_grade($slug);
        $href = reading_page_path($slug);
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
function reading_faq_items(array $content): array
{
    $name = (string) ($content['faq_name'] ?? 'この級');
    return [
        [
            'q' => $name . 'のリーディング対策はできますか？',
            'a' => (string) ($content['faq_can'] ?? ''),
        ],
        [
            'q' => '英検本番に近い形式で練習できますか？',
            'a' => (string) ($content['faq_format'] ?? ''),
        ],
        [
            'q' => '苦手な問題を復習できますか？',
            'a' => '間違えた回数が多い順に残り、同じ問題で再演習できます。短文は、次に解くとき間違えた問題が優先されます。',
        ],
        [
            'q' => '単語学習も一緒にできますか？',
            'a' => (string) ($content['faq_vocab'] ?? ''),
        ],
        [
            'q' => 'スマートフォンやiPadでも利用できますか？',
            'a' => 'ブラウザ、iPhone、iPadで使えます。',
        ],
        [
            'q' => 'リーディング以外の技能も対策できますか？',
            'a' => (string) ($content['faq_more'] ?? ''),
        ],
    ];
}

/**
 * @return array<string, mixed>|null
 */
function get_reading_content(string $slug): ?array
{
    $all = reading_content_all();
    return $all[$slug] ?? null;
}

/**
 * @return array<string, array<string, mixed>>
 */
function reading_content_all(): array
{
    static $cache = null;
    if ($cache !== null) {
        return $cache;
    }

    $hint_short = '短文の画面では「わからないときはヒントを確認」が開けます。長文の画面には、このヒントはありません。';
    $hint_talk = '短文と会話の画面では「わからないときはヒントを確認」が開けます。長文の画面には、このヒントはありません。';
    $hint_order = '短文、会話、語句整序の画面では「わからないときはヒントを確認」が開けます。';
    $explain_choice = '4択で選ぶと、その場で正解・不正解と日本語の解説が出ます。短文は空所を埋めた全文を、長文は正解を入れた本文を、音声で聞けます。';
    $review_formats = '4択で、級に出る形式だけを解きます。本番と同じ制限時間のタイマーはありません。学習にかかった時間は記録されます。';
    $vocab_long = '同じアカウントで単語クイズができます。長文を解き終えると、その文章の訳とポイント・単語も見られます。単語クイズとは別の表示です。';
    $vocab_short = '同じアカウントで単語クイズができます。リーディングの画面とは別のメニューです。';

    $cache = [
        '1kyu' => [
            'h1_sub' => '問題演習で読解力を伸ばす',
            'description' => '英検対策アプリで、英検1級のリーディングを練習。短文の空所、長文の空所、長文の内容一致を、級の形式だけで練習できます。選んだ直後に正解と日本語の解説が返ります。',
            'lead' => '短文の空所、長文の空所、長文の内容一致。級の形式だけが出て、選んだ直後に正解と解説が返ります。',
            'hero_lines' => [
                '短文の空所、長文の空所、内容一致を、形式ごとに練習できる',
                '1問ごとに、なぜその選択肢かを日本語で確認できる',
                '登録すると、その日から演習を始められる',
            ],
            'chips' => ['短文10問', '長文の空所', '内容一致', '直後に解説'],
            'secondary_label' => '1級の出題形式を見る',
            'faq_name' => '英検1級',
            'worries' => [
                '評論文で、主張と根拠の関係がつかめない',
                '句動詞や語法の差を、文全体で判断できない',
                '言い換えられた選択肢を、本文の事実と照合できない',
                '解き終わっても、間違えた理由が残らない',
                '同じ種類のミスを、次も繰り返してしまう',
            ],
            'form_text' => '1級は、短文の語句空所補充、長文の語句空所補充、長文の内容一致選択です。会話文の空所補充と語句整序は出ません。',
            'explain_text' => $explain_choice,
            'forms' => [
                ['icon' => 'book-text', 'title' => '長文の空所は説明文1本', 'text' => '空所ごとに4択です。解き終えると正答数と、正解を入れた本文の音声が出ます。'],
                ['icon' => 'book-open', 'title' => '内容一致は問ごとに解く', 'text' => '英文1本を問ごとに解きます。最後に正答数、本文と音声、訳、ポイント・単語、全問の解説が出ます。'],
            ],
            'hint_text' => '短文の画面では「わからないときはヒントを確認」が開けます。1級の短文は、句動詞のように形の近い語を文全体で切り分けます。長文の画面には、このヒントはありません。',
            'repeat_text' => '形式を選んで、短文10問、または長文1本で繰り返せます。',
            'vocab_text' => '長文の結果で、訳とポイント・単語を確認できます。単語そのものは、同じアカウントの単語メニューで続けられます。',
            'bridge' => '1級なら、読んだあとに要約と、2分スピーチの練習へ続けられます。',
            'day6' => '短文10問、または長文1本を始めると、その日の1セットになります。',
            'faq_can' => '短文の語句空所補充、長文の語句空所補充、長文の内容一致選択ができます。会話文の空所補充は準2級までです。',
            'faq_format' => $review_formats,
            'faq_vocab' => $vocab_long,
            'faq_more' => '同じアカウントで、単語、リスニング、ライティング、スピーキングも練習できます。1級なら、要約のあと2分スピーチの練習へ続けられます。',
            'points' => [
                ['title' => '短文は文全体で選ぶ', 'text' => '空所の前後だけでなく、文の主張に合う語を選びます。句動詞は、似た形の意味の差で切り分けます。'],
                ['title' => '長文の空所は段落の役割', 'text' => 'その文だけでなく、前の段落とのつながりで選びます。逆接と追加を取り違えないようにします。'],
                ['title' => '内容一致は根拠に戻る', 'text' => '選択肢の言葉が本文と少し違っていても、同じ事実なら正解になりえます。主張、根拠、数字は本文に戻って確認します。'],
                ['title' => '問ごとに理由を言葉にする', 'text' => '1本を読み切ってからまとめて答えず、問ごとに根拠を決めます。アプリも1問ずつ解説が出るので、その場で理由を言葉にできます。'],
            ],
            'screen_alt' => '英検1級の短文空所。問2/10で fend off が正解',
            'screen_caption' => '問2/10。選んだ直後です。正解は緑、解説は日本語、下に空所を埋めた全文が出ます。',
            'shots' => [
                [
                    'image' => 'reading-1',
                    'kicker' => '短文の語句空所補充',
                    'alt' => '英検1級の短文空所。fend off が正解',
                    'caption' => '問2/10。選んだ直後です。',
                    'question' => 'Reina joined the fencing team and discovered that she had a natural talent for the sport. Her opponents were unable to _____ her attacks, so she usually won her matches.',
                    'note' => '画面の正解は fend off です。解説は「彼女の攻撃を防げなかった」で、fend off は防ぐ、かわす、という意味です。',
                ],
                [
                    'image' => 'reading-2',
                    'kicker' => '長文の語句空所補充',
                    'alt' => '英検1級の長文空所。The Origins of Writing',
                    'caption' => 'The Origins of Writing。空所に入った句が緑で残る結果画面です。',
                    'question' => 'The Origins of Writing',
                    'note' => '画面では This suggests a practical origin、That view is no longer tenable、The impact of writing was profound が緑で入っています。',
                ],
                [
                    'image' => 'reading-3',
                    'kicker' => '長文の内容一致選択',
                    'alt' => '英検1級の内容一致。The Speed of Cultural Change',
                    'caption' => '問1/5。The Speed of Cultural Change を読んでいる画面です。問ごとに選択肢と解説が出ます。',
                    'question' => 'The Speed of Cultural Change',
                    'note' => '文化の変化がゆるやかに進むのか、接触のあとで急に進むのかを読む文章です。根拠になる段落を、問ごとに決めます。',
                ],
            ],
        ],
        'jun1kyu' => [
            'h1_sub' => '問題演習で読解力を伸ばす',
            'description' => '英検対策アプリで、英検準1級のリーディングを練習。短文の空所、長文の空所、長文の内容一致を繰り返し練習できます。選んだ直後に正解と日本語の解説が返ります。',
            'lead' => '短文の空所、長文の空所、長文の内容一致。級の形式だけが出て、選んだ直後に正解と解説が返ります。',
            'hero_lines' => [
                '短文の空所、長文の空所、内容一致を、形式ごとに練習できる',
                '1問ごとに、なぜその選択肢かを日本語で確認できる',
                '登録すると、その日から演習を始められる',
            ],
            'chips' => ['短文10問', '長文の空所', '内容一致', '直後に解説'],
            'secondary_label' => '準1級の出題形式を見る',
            'faq_name' => '英検準1級',
            'worries' => [
                '抽象的な英文で、論旨を見失う',
                '似た語の差を、文脈で切り分けられない',
                '根拠になる段落を、設問と対応させられない',
                '解き終わっても、間違えた理由が残らない',
                '同じ種類のミスを、次も繰り返してしまう',
            ],
            'form_text' => '準1級は、短文の語句空所補充、長文の語句空所補充、長文の内容一致選択です。会話文の空所補充と語句整序は出ません。',
            'explain_text' => $explain_choice,
            'forms' => [
                ['icon' => 'book-text', 'title' => '長文の空所は説明文1本', 'text' => '空所は3つで、それぞれ4択です。解き終えると正答数と、正解を入れた本文の音声が出ます。'],
                ['icon' => 'book-open', 'title' => '内容一致は問ごとに解く', 'text' => '英文1本を問ごとに解きます。最後に正答数、本文と音声、訳、ポイント・単語、全問の解説が出ます。'],
            ],
            'hint_text' => $hint_short,
            'repeat_text' => '形式を選んで、短文10問、または長文1本で繰り返せます。',
            'vocab_text' => '長文の結果で、訳とポイント・単語を確認できます。単語そのものは、同じアカウントの単語メニューで続けられます。',
            'bridge' => '準1級なら、読んだあとに要約と、4コマの面接練習へ続けられます。',
            'day6' => '短文10問、または長文1本を始めると、その日の1セットになります。',
            'faq_can' => '短文の語句空所補充、長文の語句空所補充、長文の内容一致選択ができます。会話文の空所補充は準2級までです。',
            'faq_format' => $review_formats,
            'faq_vocab' => $vocab_long,
            'faq_more' => '同じアカウントで、単語、リスニング、ライティング、スピーキングも練習できます。準1級なら、要約のあと4コマの面接練習へ続けられます。',
            'points' => [
                ['title' => '似た語は文脈で切る', 'text' => '短文は、空所の前後と文全体の意味で選びます。綴りが近い語は、文が述べている事実に合うかで切り分けます。'],
                ['title' => '長文の空所は論の転換', 'text' => 'Nevertheless や However は、前の段落と意見が折れる場所です。その文だけで選ばず、前後の主張を見ます。'],
                ['title' => '内容一致は言い換えを追う', 'text' => '選択肢の言葉が本文と少し違っていても、同じ事実なら正解になりえます。研究結果や理由は、本文の段落に戻します。'],
                ['title' => '問ごとに理由を言葉にする', 'text' => '1本を読み切ってからまとめて答えず、問ごとに根拠を決めます。アプリも1問ずつ解説が出るので、その場で理由を言葉にできます。'],
            ],
            'screen_alt' => '英検準1級の短文空所。問5/10で reduce が正解',
            'screen_caption' => '問5/10。選んだ直後です。正解は緑、解説は日本語です。',
            'shots' => [
                [
                    'image' => 'reading-1',
                    'kicker' => '短文の語句空所補充',
                    'alt' => '英検準1級の短文空所。reduce が正解',
                    'caption' => '問5/10。選んだ直後です。',
                    'question' => 'The company will _____ its workforce by 10 percent to cut costs. The layoffs will affect several departments.',
                    'note' => '画面の正解は reduce です。解説は「コスト削減のため従業員を10%削減する」。revive、revise、reveal はこの文の意味に合いません。',
                ],
                [
                    'image' => 'reading-2',
                    'kicker' => '長文の語句空所補充',
                    'alt' => '英検準1級の長文空所。The Role of Museums in Society',
                    'caption' => 'The Role of Museums in Society。3/3問正解の結果です。Nevertheless、However、Yet が緑で入っています。',
                    'question' => 'The Role of Museums in Society',
                    'note' => '博物館の役割が保存から公開へ広がり、そのあとで返還の議論に折れる文章です。接続の語は、段落の転換で選びます。',
                ],
                [
                    'image' => 'reading-3',
                    'kicker' => '長文の内容一致選択',
                    'alt' => '英検準1級の内容一致。Sleep and Memory',
                    'caption' => '問1/5。Sleep and Memory を読んでいる画面です。問ごとに選択肢と解説が出ます。',
                    'question' => 'Sleep and Memory',
                    'note' => '睡眠と記憶の関係を扱う説明文です。研究が何を示したかを、段落ごとに対応させます。',
                ],
            ],
        ],
        '2kyu' => [
            'h1_sub' => '問題演習で読解力を伸ばす',
            'description' => '英検対策アプリで、英検2級のリーディングを練習。短文の空所、長文の空所、長文の内容一致で実践力を身につけられます。選んだ直後に正解と日本語の解説が返ります。',
            'lead' => '短文の空所、長文の空所、長文の内容一致。級の形式だけが出て、選んだ直後に正解と解説が返ります。',
            'hero_lines' => [
                '短文の空所、長文の空所、内容一致を、形式ごとに練習できる',
                '1問ごとに、なぜその選択肢かを日本語で確認できる',
                '登録すると、その日から演習を始められる',
            ],
            'chips' => ['短文10問', '長文の空所', '内容一致', '直後に解説'],
            'secondary_label' => '2級の出題形式を見る',
            'faq_name' => '英検2級',
            'worries' => [
                '説明文の要点を、段落ごとに整理できない',
                '接続の語を、前後の関係で選べない',
                '選択肢の言葉が本文と少し違うと、正解を外してしまう',
                '解き終わっても、間違えた理由が残らない',
                '同じ種類のミスを、次も繰り返してしまう',
            ],
            'form_text' => '2級は、短文の語句空所補充、長文の語句空所補充、長文の内容一致選択です。会話文の空所補充と語句整序は出ません。',
            'explain_text' => $explain_choice,
            'forms' => [
                ['icon' => 'book-text', 'title' => '長文の空所は説明文1本', 'text' => '空所は3つで、それぞれ4択です。解き終えると正答数と、正解を入れた本文の音声が出ます。'],
                ['icon' => 'book-open', 'title' => '内容一致は問ごとに解く', 'text' => '英文1本を問ごとに解きます。最後に正答数、本文と音声、訳、ポイント・単語、全問の解説が出ます。'],
            ],
            'hint_text' => $hint_short,
            'repeat_text' => '形式を選んで、短文10問、または長文1本で繰り返せます。',
            'vocab_text' => '長文の結果で、訳とポイント・単語を確認できます。単語そのものは、同じアカウントの単語メニューで続けられます。',
            'bridge' => '2級なら、読んだあとに要約と、面接の練習へ続けられます。',
            'day6' => '短文10問、または長文1本を始めると、その日の1セットになります。',
            'faq_can' => '短文の語句空所補充、長文の語句空所補充、長文の内容一致選択ができます。会話文の空所補充は準2級までです。',
            'faq_format' => $review_formats,
            'faq_vocab' => $vocab_long,
            'faq_more' => '同じアカウントで、単語、リスニング、ライティング、スピーキングも練習できます。2級なら、要約のあと面接の練習へ続けられます。',
            'points' => [
                ['title' => '短文は文脈で語を決める', 'text' => '空所の前後と、文が言っている事実で選びます。職業や原因のように、話題に合う語を残します。'],
                ['title' => '説明文は段落の要点', 'text' => '長文の空所は、例示、結果、逆接のどれかを段落の流れで決めます。For example と As a result を取り違えないようにします。'],
                ['title' => '内容一致は情報を拾う', 'text' => '誰が、何を、なぜ、を段落ごとに整理します。選択肢の言葉が違っても、同じ事実なら本文に戻して判断します。'],
                ['title' => '問ごとに理由を言葉にする', 'text' => '1本を読み切ってからまとめて答えず、問ごとに根拠を決めます。アプリも1問ずつ解説が出るので、その場で理由を言葉にできます。'],
            ],
            'screen_alt' => '英検2級の短文空所。問4/10で occupation が正解',
            'screen_caption' => '問4/10。選んだ直後です。正解は緑、解説は日本語です。',
            'shots' => [
                [
                    'image' => 'reading-1',
                    'kicker' => '短文の語句空所補充',
                    'alt' => '英検2級の短文空所。occupation が正解',
                    'caption' => '問4/10。選んだ直後です。',
                    'question' => 'After working as a taxi driver for more than 10 years, Sue has decided to try a new _____. She is now training to become a nurse.',
                    'note' => '画面の正解は occupation です。解説は「新しい職業」。device、complaint、proverb はこの文に合いません。',
                ],
                [
                    'image' => 'reading-2',
                    'kicker' => '長文の語句空所補充',
                    'alt' => '英検2級の長文空所。Honeybee Decline',
                    'caption' => 'Honeybee Decline。1/3問正解の結果です。For example は緑、ほかの空所は選んだ語と別の選択肢が赤字で並んでいます。',
                    'question' => 'Honeybee Decline',
                    'note' => 'ミツバチの減少と、農業への影響を扱う説明文です。接続の語は、例示か結果かで選びます。',
                ],
                [
                    'image' => 'reading-3',
                    'kicker' => '長文の内容一致選択',
                    'alt' => '英検2級の内容一致。The Mirror Test',
                    'caption' => '問1/5。The Mirror Test を読んでいる画面です。問ごとに選択肢と解説が出ます。',
                    'question' => 'The Mirror Test',
                    'note' => '鏡を使った自己認識の実験を扱う説明文です。実験で何が起きたかを、段落から拾います。',
                ],
            ],
        ],
        'jun2kyu-plus' => [
            'h1_sub' => '問題演習で読解力を伸ばす',
            'description' => '英検対策アプリで、英検準2級プラスのリーディングを練習。短文の空所、長文の空所、長文の内容一致を練習できます。選んだ直後に正解と日本語の解説が返ります。',
            'lead' => '短文の空所、長文の空所、長文の内容一致。級の形式だけが出て、選んだ直後に正解と解説が返ります。',
            'hero_lines' => [
                '本番と同じ3形式を、形式ごとに練習できる',
                '1問ごとに、なぜその選択肢かを日本語で確認できる',
                '登録すると、その日から演習を始められる',
            ],
            'chips' => ['短文10問', '長文の空所', '内容一致', '直後に解説'],
            'secondary_label' => '準2級プラスの出題形式を見る',
            'faq_name' => '英検準2級プラス',
            'worries' => [
                '長文を最後まで読む前に、どこを見ればよいか分からない',
                '単語の意味はなんとなく分かるが、空所に入る語を選べない',
                '選択肢がどれも本文に書いてあるように見える',
                '解き終わっても、間違えた理由が残らない',
                '同じ種類のミスを、次も繰り返してしまう',
            ],
            'form_text' => '準2級プラスは、短文の語句空所補充、長文の語句空所補充、長文の内容一致選択です。会話文の空所補充と語句整序は出ません。',
            'explain_text' => $explain_choice,
            'forms' => [
                ['icon' => 'book-text', 'title' => '長文の空所は説明文1本', 'text' => '空所は3つで、それぞれ4択です。解き終えると正答数と、正解を入れた本文の音声が出ます。'],
                ['icon' => 'book-open', 'title' => '内容一致は問ごとに解く', 'text' => '英文1本を問ごとに解きます。最後に正答数、本文と音声、訳、ポイント・単語、全問の解説が出ます。'],
            ],
            'hint_text' => '短文の画面では「わからないときはヒントを確認」が開けます。準2級プラスでは、句動詞と、文脈で意味を決めるコツです。長文の画面には、このヒントはありません。',
            'repeat_text' => '形式を選んで、短文10問、または長文1本で繰り返せます。',
            'vocab_text' => '長文の結果で、訳とポイント・単語を確認できます。単語そのものは、同じアカウントの単語メニューで続けられます。',
            'bridge' => '準2級プラスなら、読んだあとに要約と、面接の3コマ練習へ続けられます。',
            'day6' => '短文10問、または長文1本を始めると、その日の1セットになります。',
            'faq_can' => '短文の語句空所補充、長文の語句空所補充、長文の内容一致選択ができます。会話文の空所補充は準2級までです。',
            'faq_format' => $review_formats,
            'faq_vocab' => $vocab_long,
            'faq_more' => '同じアカウントで、単語、リスニング、ライティング、スピーキングも練習できます。準2級プラスなら、読んだあとに要約と面接の3コマ練習へ続けられます。',
            'points' => [
                ['title' => '短文は空所の前後で選ぶ', 'text' => '空所の前後と文全体の意味で選びます。形が似た語は、句動詞と連語で切り分けます。'],
                ['title' => '長文の空所は段落のつながり', 'text' => 'その文だけでなく、前の段落とのつながりで選びます。Therefore と However を取り違えないようにします。'],
                ['title' => '内容一致は根拠に戻る', 'text' => '選択肢の言葉が本文と少し違っていても、同じ事実なら正解になりえます。数字、理由、依頼内容は本文に戻って確認します。'],
                ['title' => '問ごとに理由を言葉にする', 'text' => '1本を読み切ってからまとめて答えず、問ごとに根拠を決めます。アプリも1問ずつ解説が出るので、その場で理由を言葉にできます。'],
            ],
            'screen_alt' => '英検準2級プラスの短文空所。問1/10で look after が正解',
            'screen_caption' => '問1/10。選んだ直後です。正解は緑、解説は日本語、下に空所を埋めた全文が出ます。',
            'shots' => [
                [
                    'image' => 'reading-1',
                    'kicker' => '短文の語句空所補充',
                    'alt' => '英検準2級プラスの短文空所。look after が正解',
                    'caption' => '問1/10。選んだ直後です。',
                    'question' => 'A: Can you _____ my cat while I am on vacation next week? B: Sure! I would be happy to help.',
                    'note' => '画面の正解は look after です。解説は、留守中の猫の世話は look after。run after は追いかける、jump at は飛びつく、です。',
                ],
                [
                    'image' => 'reading-2',
                    'kicker' => '長文の語句空所補充',
                    'alt' => '英検準2級プラスの長文空所。E-books',
                    'caption' => 'E-books。3/3問正解の結果です。In this way、Nevertheless、Adjustable text が緑で入っています。',
                    'question' => 'E-books',
                    'note' => '電子書籍の利点と、紙の本を好む読者の対比です。接続の語と、段落の内容に合う句を選びます。',
                ],
                [
                    'image' => 'reading-3',
                    'kicker' => '長文の内容一致選択',
                    'alt' => '英検準2級プラスの内容一致。Internship offer',
                    'caption' => '問1/3。Internship offer のメールを読んでいる画面です。問ごとに選択肢と解説が出ます。',
                    'question' => 'Internship offer',
                    'note' => 'インターンの期間、勤務日、初日の集合場所が書かれたメールです。数字と依頼内容は本文に戻して確認します。',
                ],
            ],
        ],
        'jun2kyu' => [
            'h1_sub' => '問題演習で読解力を伸ばす',
            'description' => '英検対策アプリで、英検準2級のリーディングを練習。短文、会話の空所、長文の空所、内容一致を効率よく練習できます。選んだ直後に正解と日本語の解説が返ります。',
            'lead' => '短文の空所、会話の空所、長文の空所、長文の内容一致。級の4形式だけが出て、選んだ直後に正解と解説が返ります。',
            'hero_lines' => [
                '短文、会話、長文の空所、内容一致を、形式ごとに練習できる',
                '1問ごとに、なぜその選択肢かを日本語で確認できる',
                '登録すると、その日から演習を始められる',
            ],
            'chips' => ['短文10問', '会話の空所', '長文の空所', '内容一致'],
            'secondary_label' => '準2級の出題形式を見る',
            'faq_name' => '英検準2級',
            'worries' => [
                '会話の空所で、返答が自然かどうかを判断できない',
                '単語の意味はなんとなく分かるが、空所に入る語を選べない',
                '長文の空所で、前後のつながりを取り違える',
                '選択肢がどれも本文に書いてあるように見える',
                '同じ種類のミスを、次も繰り返してしまう',
            ],
            'form_text' => '準2級は、短文の語句空所補充、会話文の空所補充、長文の語句空所補充、長文の内容一致選択です。4形式すべてが出ます。',
            'explain_text' => $explain_choice,
            'forms' => [
                ['icon' => 'book-text', 'title' => '会話は10問で1セット', 'text' => '会話の空所に、流れに合う文を4択で選びます。選んだ直後に正解と日本語の解説が出ます。'],
                ['icon' => 'book-open', 'title' => '長文は1本ずつ', 'text' => '長文の空所と内容一致は、それぞれ英文1本です。空所は4択、内容一致は問ごとに解きます。解き終えると正答数と、本文の音声が出ます。'],
            ],
            'hint_text' => $hint_talk,
            'repeat_text' => '形式を選んで、短文10問、会話10問、または長文1本で繰り返せます。',
            'vocab_text' => '長文の結果で、訳とポイント・単語を確認できます。単語そのものは、同じアカウントの単語メニューで続けられます。',
            'bridge' => '準2級なら、読んだあとにEメールと英作文、面接の練習へ続けられます。',
            'day6' => '短文10問、会話10問、または長文1本を始めると、その日の1セットになります。',
            'faq_can' => '短文の語句空所補充、会話文の空所補充、長文の語句空所補充、長文の内容一致選択ができます。',
            'faq_format' => $review_formats,
            'faq_vocab' => $vocab_long,
            'faq_more' => '同じアカウントで、単語、リスニング、ライティング、スピーキングも練習できます。準2級なら、Eメールと英作文、面接の練習へ続けられます。',
            'points' => [
                ['title' => '会話は自然な返答', 'text' => '相手の提案に対して、理由まで含めて受けたり断ったりする文を選びます。単語の意味だけで決めません。'],
                ['title' => '短文は連語で選ぶ', 'text' => 'evidence that のように、うしろに続く形も含めて選びます。似た名詞は、文の話題で切り分けます。'],
                ['title' => '長文の空所は場面の流れ', 'text' => '物語や説明の、いつ・どこで・何が起きたかで選びます。接続の句は、前の文とのつながりで決めます。'],
                ['title' => '内容一致は依頼と日時', 'text' => 'メールや案内では、場所、時刻、持っていくものを本文に戻して確認します。問ごとに根拠を決めます。'],
            ],
            'screen_alt' => '英検準2級の短文空所。問1/10で evidence が正解',
            'screen_caption' => '問1/10。選んだ直後です。下に空所を埋めた全文と、音声で聞くボタンがあります。',
            'shots' => [
                [
                    'image' => 'reading-1',
                    'kicker' => '短文の語句空所補充',
                    'alt' => '英検準2級の短文空所。evidence が正解',
                    'caption' => '問1/10。選んだ直後です。',
                    'question' => 'The police found _____ that the man was at the scene. His fingerprints were on the door.',
                    'note' => '画面の正解は evidence です。解説は「その男が現場にいた証拠」は evidence that。',
                ],
                [
                    'image' => 'reading-2',
                    'kicker' => '会話文の空所補充',
                    'alt' => '英検準2級の会話空所。放課後の勉強の誘い',
                    'caption' => '問1/10。会話の空所を選んだ直後です。',
                    'question' => 'A: Do you want to study together after school? B: _____. I have to watch the soccer game at 5.',
                    'note' => '画面の正解は I would love to, but I will not be able to stay long です。5時にサッカーを見るので、長時間は無理だという流れです。',
                ],
                [
                    'image' => 'reading-3',
                    'kicker' => '長文の語句空所補充',
                    'alt' => '英検準2級の長文空所。The Summer Festival',
                    'caption' => 'The Summer Festival。2/2問正解の結果です。At the end と It was a wonderful memory が緑で入っています。',
                    'question' => 'The Summer Festival',
                    'note' => '祭りの夜の思い出を語る文章です。いつ花火を見たか、その記憶をどう言うかで空所を選びます。',
                ],
                [
                    'image' => 'reading-4',
                    'kicker' => '長文の内容一致選択',
                    'alt' => '英検準2級の内容一致。Community Coding Workshop',
                    'caption' => '問1/5。Community Coding Workshop の招待メールを読んでいる画面です。',
                    'question' => 'Where will the workshop be held?',
                    'note' => '場所は Green Plaza Library、開始は土曜の3:30 p.m. です。日時と持ち物は本文に戻して確認します。',
                ],
            ],
        ],
        '3kyu' => [
            'h1_sub' => '問題演習で読解力を伸ばす',
            'description' => '英検対策アプリで、英検3級のリーディングを練習。短文の空所、会話の空所、掲示やメールの内容一致を練習できます。選んだ直後に正解と日本語の解説が返ります。',
            'lead' => '短文の空所、会話の空所、長文の内容一致。級の形式だけが出て、選んだ直後に正解と解説が返ります。',
            'hero_lines' => [
                '短文、会話、内容一致を、形式ごとに練習できる',
                '1問ごとに、なぜその選択肢かを日本語で確認できる',
                '登録すると、その日から演習を始められる',
            ],
            'chips' => ['短文10問', '会話の空所', '内容一致', '直後に解説'],
            'secondary_label' => '3級の出題形式を見る',
            'faq_name' => '英検3級',
            'worries' => [
                '掲示やメールで、頼まれていることを読み落とす',
                '単語の意味はなんとなく分かるが、空所に入る語を選べない',
                '会話の返事が、自然かどうかを判断できない',
                '選択肢がどれも本文に書いてあるように見える',
                '解き終わっても、間違えた理由が残らない',
            ],
            'form_text' => '3級は、短文の語句空所補充、会話文の空所補充、長文の内容一致選択です。語句整序と、長文の語句空所補充は出ません。',
            'explain_text' => '4択で選ぶと、その場で正解・不正解と日本語の解説が出ます。短文は空所を埋めた全文を音声で聞けます。',
            'forms' => [
                ['icon' => 'book-text', 'title' => '会話は10問で1セット', 'text' => '会話の空所に、流れに合う文を4択で選びます。選んだ直後に正解と日本語の解説が出ます。'],
                ['icon' => 'book-open', 'title' => '内容一致は案内を問ごとに読む', 'text' => '掲示、メール、説明文を1本読み、問ごとに解きます。最後に正答数、本文と音声、訳、ポイント・単語、全問の解説が出ます。'],
            ],
            'hint_text' => $hint_talk,
            'repeat_text' => '形式を選んで、短文10問、会話10問、または長文1本で繰り返せます。',
            'vocab_text' => '長文の結果で、訳とポイント・単語を確認できます。単語そのものは、同じアカウントの単語メニューで続けられます。',
            'bridge' => '3級なら、読んだあとにEメールと英作文、面接の練習へ続けられます。',
            'day6' => '短文10問、会話10問、または長文1本を始めると、その日の1セットになります。',
            'faq_can' => '短文の語句空所補充、会話文の空所補充、長文の内容一致選択ができます。語句整序と長文の語句空所補充はありません。',
            'faq_format' => $review_formats,
            'faq_vocab' => $vocab_long,
            'faq_more' => '同じアカウントで、単語、リスニング、ライティング、スピーキングも練習できます。',
            'points' => [
                ['title' => '短文は話題に合う語', 'text' => '空所のうしろに続く文が、何の話かを見ます。仕事、場所、理由のどれに合う語かを決めます。'],
                ['title' => '会話は断りと受け', 'text' => 'Would you like への返事は、受けるか断るかです。お腹がいっぱいなら No, thank you. のように、理由とセットで見ます。'],
                ['title' => '掲示とメールは日時', 'text' => '誰が、いつ、どこで、何を頼まれているかを印にします。曜日と日付が違う選択肢は、本文の一文に戻します。'],
                ['title' => '問ごとに根拠を決める', 'text' => '案内を最後まで読んでから感覚で選ばず、問の答えが書いてある文を決めます。アプリも1問ずつ解説が出ます。'],
            ],
            'screen_alt' => '英検3級の短文空所。問2/10で interview が正解',
            'screen_caption' => '問2/10。選んだ直後です。正解は緑、解説は日本語です。',
            'shots' => [
                [
                    'image' => 'reading-1',
                    'kicker' => '短文の語句空所補充',
                    'alt' => '英検3級の短文空所。interview が正解',
                    'caption' => '問2/10。選んだ直後です。',
                    'question' => 'John has an _____ tomorrow. He hopes to get a new job.',
                    'note' => '画面の正解は interview です。解説は「新しい仕事を得たい」ので面接が文脈に合う、です。',
                ],
                [
                    'image' => 'reading-2',
                    'kicker' => '会話文の空所補充',
                    'alt' => '英検3級の会話空所。デザートを断る返事',
                    'caption' => '問1/10。会話の空所を選んだ直後です。',
                    'question' => 'Waiter: Would you like dessert? Customer: _____ I am full.',
                    'note' => '画面の正解は No, thank you. です。お腹がいっぱいと言っているので、断る返事です。',
                ],
                [
                    'image' => 'reading-3',
                    'kicker' => '長文の内容一致選択',
                    'alt' => '英検3級の内容一致。Book Week at Our School',
                    'caption' => '問1/2。Book Week at Our School の案内です。When will the writer visit the school? の正解は On Wednesday, June 7. です。',
                    'question' => 'When will the writer visit the school?',
                    'note' => '作家の訪問は Wednesday, June 7。Book Week の開始日である Monday とは別の日です。',
                ],
            ],
        ],
        '4kyu' => [
            'h1_sub' => '問題演習で読解力を伸ばす',
            'description' => '英検対策アプリで、英検4級のリーディングを練習。短文、会話、語句整序、長文の内容一致を練習できます。選んだ直後に正解と日本語の解説が返ります。',
            'lead' => '短文の空所、会話の空所、語句整序、長文の内容一致。級の形式だけが出て、選んだ直後に正解と解説が返ります。',
            'hero_lines' => [
                '短文、会話、語句整序、内容一致を、形式ごとに練習できる',
                '1問ごとに、なぜその答えかを日本語で確認できる',
                '登録すると、その日から演習を始められる',
            ],
            'chips' => ['短文10問', '会話10問', '語句整序10問', '内容一致'],
            'secondary_label' => '4級の出題形式を見る',
            'faq_name' => '英検4級',
            'worries' => [
                '掲示やメールで、頼まれていることを読み落とす',
                '単語の意味はなんとなく分かるが、空所に入る語を選べない',
                '会話の流れに合う文を選べない',
                '並べ替えで、語の順番が決まらない',
                '解き終わっても、間違えた理由が残らない',
            ],
            'form_text' => '4級は、短文の語句空所補充、会話文の空所補充、語句整序、長文の内容一致選択です。長文の語句空所補充は出ません。',
            'explain_text' => '短文と会話は4択です。選ぶと、その場で正解と日本語の解説が出ます。語句整序は、語句を並べると正解の英文と語順の解説が出ます。',
            'forms' => [
                ['icon' => 'book-text', 'title' => '会話と語句整序は各10問', 'text' => '会話は空所に合う文を4択で選びます。語句整序は、日本文の意味に合うように語句を並べます。どちらも10問で1セットです。'],
                ['icon' => 'book-open', 'title' => '内容一致はメールを1本', 'text' => 'メールや案内を1本読み、問ごとに解きます。最後に正答数、本文と音声、訳、ポイント・単語、全問の解説が出ます。'],
            ],
            'hint_text' => '短文、会話、語句整序の画面では「わからないときはヒントを確認」が開けます。長文の画面には、このヒントはありません。',
            'repeat_text' => '短文・会話・語句整序は各10問、長文の内容一致は1本で繰り返せます。',
            'vocab_text' => '長文の結果で、訳とポイント・単語を確認できます。単語そのものは、同じアカウントの単語メニューで続けられます。',
            'bridge' => '4級は、単語とリスニングも同じアカウントで続けられます。',
            'day6' => '短文・会話・語句整序の10問、または長文1本を始めると、その日の1セットになります。',
            'faq_can' => '短文の語句空所補充、会話文の空所補充、語句整序、長文の内容一致選択ができます。長文の語句空所補充はありません。',
            'faq_format' => '短文と会話は4択、語句整序は語句の並べ替えです。級に出る形式だけを解きます。本番と同じ制限時間のタイマーはありません。学習にかかった時間は記録されます。',
            'faq_vocab' => $vocab_long,
            'faq_more' => '同じアカウントで、単語とリスニングも練習できます。',
            'points' => [
                ['title' => '短文はうしろの文を見る', 'text' => '空所のあとに、何の話かが続きます。休日、場所、人のどれに合う語かを決めます。'],
                ['title' => '会話は相手の言葉に返す', 'text' => 'なくした、と言われたあとに探す場所を聞く、のように、直前の発話への返事を選びます。'],
                ['title' => '並べ替えは語順の型', 'text' => '主語、be動詞、様子、時、の順を先に決めます。during は「〜の間」で、時をうしろに置きます。'],
                ['title' => 'メールは日時と返事', 'text' => 'いつ、どこで、何を持っていくか、返事の期限はいつか。質問の言葉と、本文の日付を対応させます。'],
            ],
            'screen_alt' => '英検4級の短文空所。問2/10で holiday が正解',
            'screen_caption' => '問2/10。選んだ直後です。正解は緑、解説は日本語、下に空所を埋めた全文が出ます。',
            'shots' => [
                [
                    'image' => 'reading-1',
                    'kicker' => '短文の語句空所補充',
                    'alt' => '英検4級の短文空所。holiday が正解',
                    'caption' => '問2/10。選んだ直後です。',
                    'question' => 'After the big game yesterday, the soccer team was very happy. Today is a _____, so the players can relax.',
                    'note' => '画面の正解は holiday です。解説は、試合の翌日に休んでリラックスする日は休日。bank は銀行、pool はプール、です。',
                ],
                [
                    'image' => 'reading-2',
                    'kicker' => '会話文の空所補充',
                    'alt' => '英検4級の会話空所。ソファの下を探す',
                    'caption' => '問1/10。会話の空所を選んだ直後です。',
                    'question' => 'Brother: I can not find my keys. Sister: _____ Brother: Thanks. They were under the sofa.',
                    'note' => '画面の正解は Have you checked under the sofa? です。鍵がソファの下にあった、と続くので、探す場所を聞いています。',
                ],
                [
                    'image' => 'reading-3',
                    'kicker' => '語句整序',
                    'alt' => '英検4級の語句整序。教室はとても静かでした',
                    'caption' => '問3/10。語句を並べた直後です。正解の英文と、語順の解説が出ます。',
                    'question' => '数学のテストの間、教室はとても静かでした。',
                    'note' => '画面の正解は The classroom was very quiet during the math test です。解説は、主語、be動詞、補語、時の順。during は「〜の間」です。',
                ],
                [
                    'image' => 'reading-4',
                    'kicker' => '長文の内容一致選択',
                    'alt' => '英検4級の内容一致。Birthday party のメール',
                    'caption' => '問1/3。Birthday party の往復メールです。When is Tom\'s birthday party? を本文の日時に戻して答えます。',
                    'question' => 'When is Tom\'s birthday party?',
                    'note' => 'Tom の招待では May 25 at 3:00 p.m. です。Yuki の返事にある 2:30 p.m. は、到着する時刻です。',
                ],
            ],
        ],
        '5kyu' => [
            'h1_sub' => '問題演習で読解力を伸ばす',
            'description' => '英検対策アプリで、英検5級のリーディングを練習。短文、会話、語句整序を各10問で練習できます。選んだ直後に正解と日本語の解説が返ります。5級に長文はありません。',
            'lead' => '短文の空所、会話の空所、語句整序。それぞれ10問で、選んだ直後に正解と解説が返ります。5級に長文はありません。',
            'hero_lines' => [
                '短文、会話、語句整序を、形式ごとに練習できる',
                '1問ごとに、なぜその答えかを日本語で確認できる',
                '登録すると、その日から演習を始められる',
            ],
            'chips' => ['短文10問', '会話10問', '語句整序10問', '直後に解説'],
            'secondary_label' => '5級の出題形式を見る',
            'faq_name' => '英検5級',
            'worries' => [
                '短い文なのに、空所の語が選べない',
                '会話の返事が、自然かどうかを判断できない',
                '並べ替えで、語の順番が決まらない',
                '解き終わっても、間違えた理由が残らない',
                '長文が出ないので、短文・会話・並べ替えのどこが弱いか分からない',
            ],
            'form_text' => '5級は、短文の語句空所補充、会話文の空所補充、語句整序です。各10問です。長文はありません。',
            'explain_text' => '短文と会話は4択です。選ぶと、その場で正解と日本語の解説が出ます。短文は空所を埋めた全文を音声で聞けます。語句整序は、語句を並べると正解の英文と語順の解説が出ます。',
            'forms' => [
                ['icon' => 'book-text', 'title' => '会話は10問で1セット', 'text' => '会話の空所に、流れに合う文を4択で選びます。選んだ直後に正解と日本語の解説が出ます。'],
                ['icon' => 'book-open', 'title' => '語句整序は10問で1セット', 'text' => '日本文の意味に合うように語句を並べます。正解の英文と、主語や動詞の順の解説が出ます。'],
            ],
            'hint_text' => $hint_order . '5級は三形式とも、このヒントが開けます。',
            'repeat_text' => '短文、会話、語句整序を、それぞれ10問で繰り返せます。',
            'vocab_text' => '単語は、同じアカウントの単語メニューで続けられます。リーディングの履歴とは別のメニューです。',
            'bridge' => '5級は、単語とリスニングも同じアカウントで続けられます。',
            'day6' => '短文・会話・語句整序のどれか10問を始めると、その日の1セットになります。',
            'faq_can' => '短文の語句空所補充、会話文の空所補充、語句整序ができます。各10問です。5級に長文はありません。',
            'faq_format' => '短文と会話は4択、語句整序は語句の並べ替えです。級に出る形式だけを解きます。本番と同じ制限時間のタイマーはありません。学習にかかった時間は記録されます。',
            'faq_vocab' => $vocab_short,
            'faq_more' => '同じアカウントで、単語とリスニングも練習できます。',
            'points' => [
                ['title' => '短文は主語と動詞', 'text' => '誰がするかを先に見ます。She のあとは takes のように、主語に合う形を選びます。'],
                ['title' => '会話は聞かれたことに返す', 'text' => 'What sport do you like? には、スポーツの名前で返します。場所や Yes だけでは、質問に答えていません。'],
                ['title' => '並べ替えは疑問文の型', 'text' => 'Who の疑問は、Who、be動詞、主語の順です。that girl は「あの女の子」で、うしろに置きます。'],
                ['title' => '弱い形式を履歴で見る', 'text' => '長文がないので、短文・会話・並べ替えのどこで間違えたかが、そのまま弱点です。間違えた問題は一覧に残ります。'],
            ],
            'screen_alt' => '英検5級の短文空所。問1/10で takes が正解',
            'screen_caption' => '問1/10。選んだ直後です。下に空所を埋めた全文と、音声で聞くボタンがあります。',
            'shots' => [
                [
                    'image' => 'reading-1',
                    'kicker' => '短文の語句空所補充',
                    'alt' => '英検5級の短文空所。takes が正解',
                    'caption' => '問1/10。選んだ直後です。',
                    'question' => 'Julia likes her camera. She often _____ pictures.',
                    'note' => '画面の正解は takes です。解説は「写真を撮る」は take pictures で、主語が She なので takes、です。',
                ],
                [
                    'image' => 'reading-2',
                    'kicker' => '会話文の空所補充',
                    'alt' => '英検5級の会話空所。好きなスポーツ',
                    'caption' => '問1/10。会話の空所を選んだ直後です。',
                    'question' => 'Girl: What sport do you like? Boy: _____',
                    'note' => '画面の正解は I like baseball. です。どんなスポーツが好きか、にはスポーツ名で答えます。',
                ],
                [
                    'image' => 'reading-3',
                    'kicker' => '語句整序',
                    'alt' => '英検5級の語句整序。あの女の子はだれですか',
                    'caption' => '問1/10。語句を並べた直後です。正解の英文と、語順の解説が出ます。',
                    'question' => 'あの女の子はだれですか。',
                    'note' => '画面の正解は who is that girl です。解説は、Who の疑問文は Who、be動詞、主語の順。that girl はあの女の子、です。',
                ],
            ],
        ],
    ];

    return $cache;
}
