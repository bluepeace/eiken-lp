<?php
/**
 * 級別ライティング LP（/3kyu/writing/ など）
 * 4級・5級は一次にライティングがないためページを作らない。
 */
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../config.php';
}

/**
 * @return list<string>
 */
function writing_grade_slugs(): array
{
    return ['3kyu', 'jun2kyu', 'jun2kyu-plus', '2kyu', 'jun1kyu', '1kyu'];
}

function writing_page_path(string $slug): ?string
{
    if (!in_array($slug, writing_grade_slugs(), true)) {
        return null;
    }
    return '/' . $slug . '/writing/';
}

function writing_url(string $slug): string
{
    $path = writing_page_path($slug);
    if ($path === null) {
        return rtrim(SITE_URL, '/') . '/';
    }
    return rtrim(SITE_URL, '/') . $path;
}

function writing_try_slug(string $slug): string
{
    if ($slug === 'jun2kyu-plus') {
        return 'jun2kyuplus';
    }
    return $slug;
}

function writing_try_url(string $slug): string
{
    return rtrim(APP_URL, '/') . '/try/writing/' . rawurlencode(writing_try_slug($slug));
}

function writing_signup_url(): string
{
    return rtrim(APP_URL, '/') . '/signup';
}

/**
 * @param array<string, mixed> $grade
 * @param array<string, mixed> $content
 * @return array{title: string, description: string, og_type: string, robots: string, omit_jsonld: bool}
 */
function writing_meta(array $grade, array $content): array
{
    $name = (string) ($grade['name'] ?? '英検');
    $tail = (string) ($content['meta_tail'] ?? '英作文をAI添削');
    return [
        'title' => $name . 'ライティング対策｜' . $tail . '｜' . SITE_NAME,
        'description' => (string) ($content['description'] ?? ''),
        'og_type' => 'website',
        'robots' => '',
        'omit_jsonld' => false,
    ];
}

/**
 * @return list<array{slug: string, name: string, name_short: string, href: string}>
 */
function writing_nav_items(): array
{
    $items = [];
    foreach (writing_grade_slugs() as $slug) {
        $grade = get_grade($slug);
        $href = writing_page_path($slug);
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
function writing_faq_items(string $slug, array $content): array
{
    $name = (string) ($content['faq_name'] ?? 'この級');
    $second = (string) ($content['second_kind'] ?? 'summary');
    $items = [
        [
            'q' => $name . 'のライティング対策はできますか？',
            'a' => (string) ($content['faq_can'] ?? ''),
        ],
    ];
    if ($second === 'email') {
        $items[] = [
            'q' => 'Eメールの練習はできますか？',
            'a' => '登録後にできます。登録なしの体験は英作文1問です。この級に英文要約はありません。',
        ];
    } else {
        $items[] = [
            'q' => '英文要約の練習はできますか？',
            'a' => '登録後にできます。登録なしの体験は英作文1問です。',
        ];
    }
    $items[] = [
        'q' => 'AIはどのような観点で添削しますか？',
        'a' => '語彙、文法、内容、構成、指示遵守です。各0〜5点で、総合はその平均です。添削文は文法と綴りの修正だけで、意見の中身は変えません。修正箇所は赤字・太字です。本番のCSEスコアではありません。',
    ];
    $items[] = [
        'q' => '英作文が苦手でも利用できますか？',
        'a' => (string) ($content['faq_beginner'] ?? '短い答案でも添削は返ります。ヒントに、その級の型が出ます。'),
    ];
    $items[] = [
        'q' => 'スマートフォンやiPadでも使えますか？',
        'a' => 'ブラウザ、iPhone、iPadで使えます。ノートに書いた答案は、写真から読み取れます。',
    ];
    $items[] = [
        'q' => 'ライティング以外の技能も対策できますか？',
        'a' => (string) ($content['faq_more'] ?? '同じアカウントで、単語、リーディング、リスニング、スピーキングも練習できます。'),
    ];
    return $items;
}

/**
 * @return array<string, mixed>|null
 */
function get_writing_content(string $slug): ?array
{
    $all = writing_content_all();
    return $all[$slug] ?? null;
}

/**
 * @return array<string, array<string, mixed>>
 */
function writing_content_all(): array
{
    static $cache = null;
    if ($cache !== null) {
        return $cache;
    }

    $cache = [
        '3kyu' => [
            'meta_tail' => '英作文・EメールをAI添削',
            'h1_sub' => 'AI添削で英作文・Eメールを練習',
            'description' => '英検3級のライティング対策を、英検対策アプリで。英作文は25〜35語、Eメールは15〜25語。書いた英文は語彙・文法・内容・構成・指示遵守でAI添削します。登録なしで英作文を1問試せます。',
            'lead' => '理由2つの英作文（25〜35語）と、友達への返信メール（15〜25語）。書いた英文は、その場で5つの観点で添削されます。',
            'hero_lines' => [
                '英作文とEメールを、級の語数に合わせて練習できる',
                '文法の修正箇所、日本語のコメント、模範解答が返る',
                '登録なしで、英作文を1問添削できる',
            ],
            'chips' => ['英作文', 'Eメール', '25〜35語', '登録なしで1問'],
            'secondary_label' => '無料登録してEメールも練習する',
            'worries' => [
                '英作文で、何を書けばいいか分からない',
                '理由を2つ、文につなげられない',
                '文法や語数が合っているか、出すまで分からない',
                '返ってきたあと、どこを直せばよいか自分では見えない',
                '友達のメールに、質問へ答えて返信できない',
            ],
            'form_text' => '3級は英作文とEメールです。英文要約はありません。',
            'hint_text' => '「わからないときはヒントを確認」で、意見、理由2つ、結論の型が出ます。Eメールは挨拶、質問への答え、締めです。',
            'length_text' => '目安は英作文25〜35語、Eメール15〜25語です。書いているあいだ、いまの語数が画面に出ます。',
            'faq_name' => '英検3級',
            'faq_can' => '英作文とEメールができます。英文要約は、この級にはありません。',
            'faq_beginner' => 'Yes、First、Second をボタンで入れられます。ヒントに、意見、理由2つ、結論の型があります。短い答案でも添削は返ります。',
            'faq_more' => '同じアカウントで、単語、リーディング、リスニング、スピーキングも練習できます。',
            'second_kind' => 'email',
            'after_label' => '登録してEメールも練習する',
            'bridge' => '3級なら、英作文のあと、面接のイラスト描写へ続けられます。',
            'screen_alt' => '英検3級の英作文画面。What do you like to do in winter? と、25〜35語の回答欄',
            'screen_caption' => 'What do you like to do in winter? の入力画面です。下の見本は、理由が1つで語数が足りない書きかけです。画面の答案とは別の見本です。',
            'result_alt' => '英検3級の添削結果画面。総合点と、語彙・文法・内容・構成・指示遵守の5つの点数',
            'result_caption' => '添削結果の並びです。総合点、5つの点数、赤字の添削文、日本語のコメント、模範解答が返ります。',
            'essay' => [
                'question' => 'What do you like to do in winter?',
                'weak' => 'I like winter. I can ski with my family.',
                'comment' => '冬の過ごし方には答えています。理由は First と Second で2つにし、それぞれ1文足すと25語前後になります。',
                'model' => 'I like to ski in winter. First, I can play with my family on the mountain. Second, hot soup after skiing is delicious. For these reasons, I like winter.',
            ],
            'second' => [
                'kicker' => 'Eメール',
                'lead' => '友達からの2つの質問に、返信で答えます。質問に触れていないと、指示遵守の点が下がります。',
                'shot_alt' => '英検3級のEメール問題。Mike からのテニス部についての質問',
                'shot_caption' => 'Mike から、部活に入っているか、そこで何をするかを聞かれています。語数の目安は15〜25語です。',
                'model' => 'Hi, Mike! Thank you for your e-mail. Yes, I belong to the tennis club. I practice tennis after school. Your friend, Ken',
                'pitfall' => '挨拶だけで終わると、下線の質問に答えていません。2つの質問の両方に、短い文で答えます。',
            ],
            'points' => [
                ['title' => '最初の1文で答えを言う', 'text' => 'What do you like には、好きなことを先に書きます。質問からずれると内容点が下がります。'],
                ['title' => '理由は2つ', 'text' => 'First と Second で、中身の違う理由を1つずつ。1つで終わると、指示と語数の両方に届きません。'],
                ['title' => '25〜35語', 'text' => '理由を単語で止めず、何をするかを1文足すと届きます。長くしすぎないことも、この級の目安です。'],
                ['title' => 'Eメールは質問に答える', 'text' => '15〜25語。友達の質問を読んでから、その答えを本文に入れます。質問と関係ない文だけだと点が下がります。'],
            ],
        ],
        'jun2kyu' => [
            'meta_tail' => '英作文・EメールをAI添削',
            'h1_sub' => 'AI添削で英作文・Eメールを練習',
            'description' => '英検準2級のライティング対策を、英検対策アプリで。英作文は50〜60語、Eメールは40〜50語。書いた英文は語彙・文法・内容・構成・指示遵守でAI添削します。登録なしで英作文を1問試せます。',
            'lead' => '身近な話題への意見と理由2つ（50〜60語）と、下線への質問を2つ含む返信メール（40〜50語）。書いた英文は、その場で5つの観点で添削されます。',
            'hero_lines' => [
                '英作文とEメールを、級の語数に合わせて練習できる',
                '文法の修正箇所、日本語のコメント、模範解答が返る',
                '登録なしで、英作文を1問添削できる',
            ],
            'chips' => ['英作文', 'Eメール', '50〜60語', '登録なしで1問'],
            'secondary_label' => '無料登録してEメールも練習する',
            'worries' => [
                '意見のあとに、理由を2つ思いつかない',
                'First と Second で書けと言われると、文が続かない',
                '文法や語数が合っているか、出すまで分からない',
                '返却後に、どこを直せばよいか自分では見えない',
                '友達のメールに、質問へ答えて返信できない',
            ],
            'form_text' => '準2級は英作文とEメールです。英文要約はありません。Eメールでは、下線部について質問を2つ書きます。',
            'hint_text' => '「わからないときはヒントを確認」で、意見、理由2つ、結論の型が出ます。Eメールは相手の文への返事と、下線への質問2つです。',
            'length_text' => '目安は英作文50〜60語、Eメール40〜50語です。書いているあいだ、いまの語数が画面に出ます。',
            'faq_name' => '英検準2級',
            'faq_can' => '英作文とEメールができます。英文要約は、準2級プラスからです。',
            'faq_beginner' => 'Yes、First、Second をボタンで入れられます。ヒントに、意見、理由2つ、結論の型があります。短い答案でも添削は返ります。',
            'faq_more' => '同じアカウントで、単語、リーディング、リスニング、スピーキングも練習できます。',
            'second_kind' => 'email',
            'after_label' => '登録してEメールも練習する',
            'bridge' => '準2級なら、英作文のあと、面接の1枚絵の描写へ続けられます。',
            'screen_alt' => '英検準2級の英作文画面。手書きを学ぶことはまだ大切か、という QUESTION',
            'screen_caption' => 'Do you think it is still important for students to learn handwriting? の入力画面です。下の見本は、理由が1つで語数が足りない書きかけです。',
            'result_alt' => '英検準2級の添削結果画面。総合点と5つの観点',
            'result_caption' => '添削結果の並びです。総合点、5つの点数、赤字の添削文、日本語のコメント、模範解答が返ります。',
            'essay' => [
                'question' => 'Do you think it is still important for students to learn handwriting?',
                'weak' => 'I think handwriting is important. Students can write their names.',
                'comment' => '意見は書けています。理由は First と Second で2つにし、それぞれ具体例を1文足すと50語前後になります。',
                'model' => 'I think it is still important for students to learn handwriting. First, they need it to write their names on tests and forms. Second, writing by hand helps them remember new words. Therefore, schools should keep teaching handwriting.',
            ],
            'second' => [
                'kicker' => 'Eメール',
                'lead' => '相手のメールに返信し、下線部について具体的な質問を2つ書きます。語数の目安は40〜50語です。',
                'shot_alt' => '英検準2級のEメール問題。Emma からの週末の過ごし方についてのメール',
                'shot_caption' => 'Emma のメールでは、日曜の朝に公園へ行く文に下線があります。その特徴を聞く質問を2つ書きます。',
                'model' => 'Hi, Emma! Thank you for your e-mail. I also like spending weekends with my family. What do you do at the park on Sunday morning? How long do you stay there? Best wishes,',
                'pitfall' => '意見だけ書いて、下線への質問が2つないと、指示遵守の点が下がります。Best wishes のあとに自分の名前は不要です。',
            ],
            'points' => [
                ['title' => '最初の1文で Yes か No', 'text' => 'QUESTION への意見を先に書きます。話題からずれると内容点が下がります。'],
                ['title' => '理由は2つ。具体例を足す', 'text' => 'First と Second で、重ならない理由にします。それぞれ、誰が何をするかを1文足すと50語に届きます。'],
                ['title' => '50〜60語', 'text' => '理由を1文で終わらせず、身近な例を足します。80語を超える必要は、この級ではありません。'],
                ['title' => 'Eメールは質問を2つ', 'text' => '40〜50語。下線の特徴を聞く質問を2つ。返事の感想だけでは、課題の条件を満たしません。'],
            ],
        ],
        'jun2kyu-plus' => [
            'meta_tail' => '英作文・英文要約をAI添削',
            'h1_sub' => 'AI添削で英作文・英文要約を練習',
            'description' => '英検準2級プラスのライティング対策を、英検対策アプリで。英作文は50〜60語、英文要約は25〜35語。書いた英文は語彙・文法・内容・構成・指示遵守でAI添削します。登録なしで英作文を1問試せます。',
            'lead' => '意見と理由2つの英作文（50〜60語）と、短い英文の要約（25〜35語）。書いた英文は、その場で5つの観点で添削されます。',
            'hero_lines' => [
                '英作文と英文要約の両方を、級の語数に合わせて練習できる',
                '文法の修正箇所、日本語のコメント、模範解答が返る',
                '登録なしで、英作文を1問添削できる',
            ],
            'chips' => ['英作文', '英文要約', '50〜60語', '登録なしで1問'],
            'secondary_label' => '無料登録して要約も練習する',
            'worries' => [
                '意見のあとに、理由を2つ思いつかない',
                'First と Second で書けと言われると、文が続かない',
                '文法や語数が合っているか、出すまで分からない',
                '返却後に、どこを直せばよいか自分では見えない',
                '英文要約で、自分の意見を書いてしまいそうになる',
            ],
            'form_text' => '準2級プラスは英作文と英文要約です。Eメールはありません。',
            'hint_text' => '「わからないときはヒントを確認」で、意見、理由2つ、結論と出ます。要約は、利点と問題の両方です。',
            'length_text' => '目安は英作文50〜60語、要約25〜35語です。書いているあいだ、いまの語数が画面に出ます。',
            'faq_name' => '英検準2級プラス',
            'faq_can' => '英作文と英文要約ができます。Eメールは3級と準2級だけです。',
            'faq_beginner' => 'Yes、First、Second をボタンで入れられます。ヒントに、意見、理由2つ、結論の型があります。短い答案でも添削は返ります。',
            'faq_more' => '同じアカウントで、単語、リーディング、リスニング、スピーキングも練習できます。準2級プラスなら、要約のあと面接の3コマ練習へ続けられます。',
            'second_kind' => 'summary',
            'after_label' => '登録して英文要約も練習する',
            'bridge' => '準2級プラスなら、要約のあと、面接の3コマ練習へ続けられます。',
            'screen_alt' => '英検準2級プラスの英作文画面。公共交通をもっと使うべきか、という QUESTION',
            'screen_caption' => 'Do you think people should use public transportation more often to protect the environment? の入力画面です。下の見本は、理由が1つで約28語の書きかけです。画面に出ている完成答案とは別の見本です。',
            'result_alt' => '英検準2級プラスの添削結果。総合5.0と、語彙・文法・内容・構成・指示遵守が各5点のレーダー',
            'result_caption' => '添削結果の並びです。総合点、5つの点数、レーダー、赤字・太字の添削文、音声で聞く、日本語のコメント、模範解答が返ります。この画面は満点の例で、下の書きかけそのものではありません。',
            'essay' => [
                'question' => 'Do you think people should use public transportation more often to protect the environment?',
                'weak' => 'I think public transportation is good for the environment. Buses and trains produces less pollution than cars. I use the train every day.',
                'comment' => '環境の話には答えられています。理由は First と Second で2つにし、それぞれ1文足すと50語前後になります。添削文の赤字は、produces を produce にする綴りと形の修正だけです。意見そのものは書き換えません。',
                'model' => 'I think people should use public transportation more often. First, buses and trains produce less pollution than cars. Second, many people can share one vehicle, so we can reduce traffic jams. Therefore, using public transportation helps protect the environment.',
                'aside' => 'Yes で賛成を明らかにし、First は大気汚染、Second は渋滞、と理由の中身を分けます。',
            ],
            'second' => [
                'kicker' => '英文要約',
                'lead' => '原文は3段落で、話題、利点、問題です。画面の題材は博物館です。自分の意見は書かず、利点と問題の両方を入れます。',
                'shot_alt' => '英検準2級プラスの英文要約画面。博物館についての英文と、25〜35語の入力欄',
                'shot_caption' => 'Visiting museums の要約問題です。目安は25〜35語、約15分です。',
                'model' => 'Visiting museums is popular because people can learn through films and models. However, museums can be too crowded on holidays, so visitors cannot enjoy the exhibits quietly.',
                'pitfall' => '点が落ちる典型は、自分の意見を足すことと、利点だけ書いて However 以降を落とすことです。要約になっていないと、指示遵守の点が下がります。',
            ],
            'points' => [
                ['title' => '最初の1文で Yes か No', 'text' => 'QUESTION からずれると内容点が下がります。賛成か反対かを、最初の1文で言い切ります。'],
                ['title' => '理由は2つ。中身を分ける', 'text' => '大気汚染と渋滞のように、重ならない話題にします。同じ理由を言い換えて2つにしないことです。'],
                ['title' => '50〜60語', 'text' => '理由を1文で終わらせず、何が起きるかを足すと届きます。'],
                ['title' => '要約は25〜35語', 'text' => '各段落の要点を入れ、具体例は短く言い換え、自分の意見は書きません。'],
            ],
        ],
        '2kyu' => [
            'meta_tail' => '英作文・英文要約をAI添削',
            'h1_sub' => 'AI添削で英作文・英文要約を練習',
            'description' => '英検2級のライティング対策を、英検対策アプリで。英作文は80〜100語、英文要約は45〜55語。POINTSは使わなくても書けます。AIが語彙・文法・内容・構成・指示遵守で添削します。登録なしで英作文を1問試せます。',
            'lead' => '意見と理由2つの英作文（80〜100語）と、英文要約（45〜55語）。POINTSは理由の参考で、使わなくても大丈夫です。書いた英文は、その場で5つの観点で添削されます。',
            'hero_lines' => [
                '英作文と英文要約を、級の語数に合わせて練習できる',
                '文法の修正箇所、日本語のコメント、模範解答が返る',
                '登録なしで、英作文を1問添削できる',
            ],
            'chips' => ['英作文', '英文要約', '80〜100語', '登録なしで1問'],
            'secondary_label' => '無料登録して要約も練習する',
            'worries' => [
                'POINTSのどれを理由にすればよいか分からない',
                '理由は書けても、説明が1文で終わる',
                '文法や語数が合っているか、出すまで分からない',
                '返却後に、どこを直せばよいか自分では見えない',
                '英文要約で、利点だけ書いて問題を落としそうになる',
            ],
            'form_text' => '2級は英作文と英文要約です。POINTSは理由を書くときの参考で、それ以外の観点でも書けます。Eメールはありません。',
            'hint_text' => '「わからないときはヒントを確認」で、意見、理由2つと説明、結論の型が出ます。要約は利点と問題の両方です。',
            'length_text' => '目安は英作文80〜100語、要約45〜55語です。書いているあいだ、いまの語数が画面に出ます。',
            'faq_name' => '英検2級',
            'faq_can' => '英作文と英文要約ができます。POINTSは使わなくても採点されます。Eメールは3級と準2級だけです。',
            'faq_beginner' => 'Yes、First、Second をボタンで入れられます。ヒントに、意見、理由、説明、結論の型があります。短い答案でも添削は返ります。',
            'faq_more' => '同じアカウントで、単語、リーディング、リスニング、スピーキングも練習できます。2級なら、要約のあと面接の3コマ練習へ続けられます。',
            'second_kind' => 'summary',
            'after_label' => '登録して英文要約も練習する',
            'bridge' => '2級なら、要約のあと、面接の3コマ練習へ続けられます。',
            'screen_alt' => '英検2級の英作文画面。学生のアルバイトはよいか、POINTS は Time management, Money, Responsibility',
            'screen_caption' => 'Is it a good idea for students to have part-time jobs? の入力画面です。POINTSは参考で、使わなくても書けます。下の見本は、理由の説明が足りない書きかけです。',
            'result_alt' => '英検2級の添削結果画面。総合点と5つの観点',
            'result_caption' => '添削結果の並びです。総合点、5つの点数、レーダー、赤字の添削文、日本語のコメント、模範解答が返ります。',
            'essay' => [
                'question' => 'Is it a good idea for students to have part-time jobs?',
                'weak' => 'I think part-time jobs are good. Students can get money. They can also learn time.',
                'comment' => '意見は書けています。POINTSのどれを使うかは自由です。理由は2つにし、それぞれ「だから何が起きるか」を1〜2文足すと80語前後になります。',
                'model' => 'I think students should have part-time jobs. First, a job teaches them how to manage time. They must finish homework before a shift, so they learn to plan the day. Second, they learn how to use money. When they earn their own pay, they think before they buy something. Therefore, a part-time job can help students grow, if the hours are not too long.',
                'aside' => 'POINTSの Time management と Money を理由にし、それぞれ説明を足しています。Responsibility を使わなくても、指示の範囲です。',
            ],
            'second' => [
                'kicker' => '英文要約',
                'lead' => '画面の題材はオンラインショッピングです。利点の段落と、問題の段落の両方を、45〜55語にまとめます。',
                'shot_alt' => '英検2級の英文要約画面。オンラインショッピングについての英文',
                'shot_caption' => 'Online shopping の要約問題です。目安は45〜55語、約15分です。',
                'model' => 'Online shopping lets people compare prices and buy at any time, so busy people can save time. However, customers cannot try products first, delivery can be slow, and some people worry about the security of personal information.',
                'pitfall' => '利点だけ書いて However 以降を落とすと、内容と指示遵守が下がります。自分の「私はネットで買うべきだ」は、要約ではありません。',
            ],
            'points' => [
                ['title' => '意見を先に、理由は2つ', 'text' => 'TOPICへの立場を最初に書きます。理由は2つで、POINTSから選んでも、自分の観点でも大丈夫です。'],
                ['title' => '理由に説明を足す', 'text' => '理由の文だけで終わらせず、だから何が起きるかを書きます。ここが80語へ届く部分です。'],
                ['title' => '80〜100語', 'text' => '理由を3つに増やすより、2つの理由を説明した方が、語数と構成の両方に合います。'],
                ['title' => '要約は45〜55語', 'text' => '利点と問題の両方を入れ、具体例は短く言い換えます。自分の意見は書きません。'],
            ],
        ],
        'jun1kyu' => [
            'meta_tail' => '英作文・英文要約をAI添削',
            'h1_sub' => 'AI添削で英作文・英文要約を練習',
            'description' => '英検準1級のライティング対策を、英検対策アプリで。英作文は120〜150語でPOINTSから2つ、英文要約は60〜70語で賛成と反対の両方です。AIが5つの観点で添削します。登録なしで英作文を1問試せます。',
            'lead' => '社会的なテーマへの意見（120〜150語。POINTSから2つ）と、賛成と反対を含む英文要約（60〜70語）。書いた英文は、その場で5つの観点で添削されます。',
            'hero_lines' => [
                '英作文と英文要約を、級の語数に合わせて練習できる',
                '文法の修正箇所、日本語のコメント、模範解答が返る',
                '登録なしで、英作文を1問添削できる',
            ],
            'chips' => ['英作文', '英文要約', '120〜150語', '登録なしで1問'],
            'secondary_label' => '無料登録して要約も練習する',
            'worries' => [
                'POINTSのどれを理由にすればよいか分からない',
                '理由を2つ選んでも、説明が短くて語数に届かない',
                '文法や語数が合っているか、出すまで分からない',
                '返却後に、どこを直せばよいか自分では見えない',
                '英文要約で、一方の意見だけをまとめそうになる',
            ],
            'form_text' => '準1級の英作文は、POINTSから2つを使って書きます。要約は賛成と反対の両方です。Eメールはありません。',
            'hint_text' => '「わからないときはヒントを確認」で、導入、理由2つ、結論の型が出ます。要約は両方の立場を入れます。',
            'length_text' => '目安は英作文120〜150語、要約60〜70語です。書いているあいだ、いまの語数が画面に出ます。',
            'faq_name' => '英検準1級',
            'faq_can' => '英作文と英文要約ができます。英作文はPOINTSから2つを使います。Eメールはありません。',
            'faq_beginner' => '導入、理由、結論の型がヒントに出ます。POINTSを2つに絞れないときも、短い答案で添削を見てから書き直せます。',
            'faq_more' => '同じアカウントで、単語、リーディング、リスニング、スピーキングも練習できます。準1級なら、要約のあと4コマの面接練習へ続けられます。',
            'second_kind' => 'summary',
            'after_label' => '登録して英文要約も練習する',
            'bridge' => '準1級なら、要約のあと、面接の4コマ練習へ続けられます。',
            'screen_alt' => '英検準1級の英作文画面。必須医薬品の特許を制限すべきか。POINTS は Access, Innovation, Pharmaceutical profits, Developing countries',
            'screen_caption' => 'Should patents on essential medicines be limited so cheaper versions can be produced sooner? の入力画面です。POINTSから2つを使います。下の見本は、理由が1つで語数が足りない書きかけです。',
            'result_alt' => '英検準1級の添削結果画面。総合点と5つの観点',
            'result_caption' => '添削結果の並びです。総合点、5つの点数、レーダー、赤字の添削文、日本語のコメント、模範解答が返ります。',
            'essay' => [
                'question' => 'Should patents on essential medicines be limited so cheaper versions can be produced sooner?',
                'weak' => 'Yes, patents should be limited. Poor people cannot buy expensive medicine.',
                'comment' => '立場は書けています。POINTSから2つ選び、それぞれ説明を足して120語前後にします。1つの理由だけでは内容と語数の両方に届きません。',
                'model' => 'Yes, patents on essential medicines should be limited so cheaper versions can be produced sooner. First, access to treatment should not depend on income. When a patent keeps the price high, many patients cannot buy the medicine they need. A cheaper version would let hospitals treat more people. Second, this matters even more in developing countries. Families may spend most of their income on one drug, and public hospitals have small budgets. Earlier production of cheaper versions would save lives there. Some people worry that lower prices will reduce innovation. Companies still need a fair period to recover research costs, but that period should not block essential treatment. In conclusion, limited patents can protect both new research and patients who need medicine now.',
                'aside' => 'POINTSの Access と Developing countries を2つの理由にしています。Innovation は結論の前で、反対側の心配として短く触れています。',
            ],
            'second' => [
                'kicker' => '英文要約',
                'lead' => '画面の題材は夜間の配送規制です。規制を支持する理由と、物流側の反対の両方を、60〜70語にまとめます。',
                'shot_alt' => '英検準1級の英文要約画面。Night Delivery Restrictions の記事',
                'shot_caption' => 'Night Delivery Restrictions の要約問題です。目安は60〜70語、約20分です。',
                'model' => 'Some cities may limit late-night truck deliveries because noise disturbs sleep and adds to evening traffic. Supporters say quieter nights and daytime deliveries could help residents and road space. However, delivery companies argue that the change may raise costs and food prices, and could move congestion to the daytime.',
                'pitfall' => '支持側だけ、または反対側だけだと、記事の要点が半分になります。自分の「規制すべきだ」は書きません。',
            ],
            'points' => [
                ['title' => 'POINTSから2つ', 'text' => '4つのうち2つを理由にします。4つ全部を並べると、120〜150語では各理由の説明が薄くなります。'],
                ['title' => '理由のあとに説明', 'text' => '理由を言ったあと、誰が困るのか、何が起きるのかを書きます。ここが語数の本体です。'],
                ['title' => '120〜150語', 'text' => '導入、理由2つ、結論。反対の心配を1文入れると、社会的なテーマの答案として整います。'],
                ['title' => '要約は両方の立場', 'text' => '60〜70語。賛成と反対の両方を入れ、自分の意見は書きません。'],
            ],
        ],
        '1kyu' => [
            'meta_tail' => '英作文・英文要約をAI添削',
            'h1_sub' => 'AI添削で英作文・英文要約を練習',
            'description' => '英検1級のライティング対策を、英検対策アプリで。英作文は200〜240語で理由3つ、英文要約は90〜110語です。AIが語彙・文法・内容・構成・指示遵守で添削します。登録なしで英作文を1問試せます。',
            'lead' => '理由3つの英作文（200〜240語）と、英文要約（90〜110語）。書いた英文は、その場で5つの観点で添削されます。',
            'hero_lines' => [
                '英作文と英文要約を、級の語数に合わせて練習できる',
                '文法の修正箇所、日本語のコメント、模範解答が返る',
                '登録なしで、英作文を1問添削できる',
            ],
            'chips' => ['英作文', '英文要約', '200〜240語', '登録なしで1問'],
            'secondary_label' => '無料登録して要約も練習する',
            'worries' => [
                '理由を3つ、200語前後で書き切れない',
                '導入が長くて、3つ目の理由まで届かない',
                '文法や語数が合っているか、出すまで分からない',
                '返却後に、どこを直せばよいか自分では見えない',
                '英文要約で、記事の一方の主張だけを残しそうになる',
            ],
            'form_text' => '1級の英作文は理由を3つ、導入・本体・結論で書きます。要約は90〜110語です。Eメールはありません。',
            'hint_text' => '「わからないときはヒントを確認」で、導入、理由3つ、結論の型が出ます。要約は記事の主張と懸念の両方です。',
            'length_text' => '目安は英作文200〜240語、要約90〜110語です。書いているあいだ、いまの語数が画面に出ます。',
            'faq_name' => '英検1級',
            'faq_can' => '英作文と英文要約ができます。英作文は理由を3つ書きます。Eメールはありません。',
            'faq_beginner' => '導入、理由3つ、結論の型がヒントに出ます。200語に届かない答案でも添削は返るので、足りない理由を見てから書き直せます。',
            'faq_more' => '同じアカウントで、単語、リーディング、リスニング、スピーキングも練習できます。1級なら、要約のあと2分スピーチの練習へ続けられます。',
            'second_kind' => 'summary',
            'after_label' => '登録して英文要約も練習する',
            'bridge' => '1級なら、要約のあと、2分スピーチの面接練習へ続けられます。',
            'screen_alt' => '英検1級の英作文画面。絶滅の危機にある言語をもっと守るべきか、理由は3つ、200〜240語',
            'screen_caption' => 'Should more be done to preserve endangered languages? の入力画面です。理由は3つ、目安は200〜240語です。下の見本は、理由が2つで語数が足りない書きかけの骨子です。',
            'result_alt' => '英検1級の添削結果画面。総合点と5つの観点',
            'result_caption' => '添削結果の並びです。総合点、5つの点数、レーダー、赤字の添削文、日本語のコメント、模範解答が返ります。',
            'essay' => [
                'question' => 'Should more be done to preserve endangered languages?',
                'weak' => 'Yes, we should preserve endangered languages. They are part of culture. They also help science.',
                'comment' => '立場は書けています。理由は3つ必要です。それぞれ、消えると何が失われるかを説明し、200語前後まで広げます。',
                'model' => 'Yes, more should be done to preserve endangered languages. First, a language carries the history and identity of a community. When it disappears, stories and knowledge that were never written down disappear with it. Second, languages contain words for local plants, weather, and ways of living. Scientists and local people use that knowledge to take care of the environment. Third, children who can use their family language and a national language often understand school subjects more deeply, because they can think in both. For these reasons, governments and schools should record endangered languages, train teachers, and give communities the support to keep using them.',
                'aside' => '導入で立場を言い、First、Second、Third で理由を3つに分けています。語数の目安は200〜240語なので、各理由の説明をもう1文足すと範囲に入ります。',
            ],
            'second' => [
                'kicker' => '英文要約',
                'lead' => '画面の題材は培養肉の規制です。推進側の主張と、安全・農家・費用への懸念の両方を、90〜110語にまとめます。',
                'shot_alt' => '英検1級の英文要約画面。Regulating Lab-Grown Meat の記事',
                'shot_caption' => 'Regulating Lab-Grown Meat の要約問題です。目安は90〜110語、約20分です。',
                'model' => 'Cultivated meat is grown from animal cells and may reduce greenhouse gases, land use, and animal suffering while adding protein. However, consumers and farmers question safety, labels, and religious rules, and the energy for bioreactors may weaken the climate benefit. Regulators are preparing inspections and clearer labels, while public research funding tries to lower costs that are still far above conventional meat.',
                'pitfall' => '利点だけを残すと、記事の論争が消えます。90語に届かない短さ、または自分の賛否を足すと、指示遵守の点が下がります。',
            ],
            'points' => [
                ['title' => '理由は3つ', 'text' => '2つで終わると指示に合いません。3つ目を足すために、導入は短くします。'],
                ['title' => '各理由に説明', 'text' => '理由の宣言だけで200語には届きません。誰が、何を失うのかを各理由に書きます。'],
                ['title' => '200〜240語', 'text' => '導入、理由3つ、結論。240語を大きく超える必要はなく、3つの説明がそろっているかが先です。'],
                ['title' => '要約は90〜110語', 'text' => '記事の主張と懸念の両方を入れ、自分の意見は書きません。'],
            ],
        ],
    ];

    return $cache;
}
