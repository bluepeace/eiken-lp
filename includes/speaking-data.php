<?php
/**
 * 級別スピーキング LP（/3kyu/speaking/ など）
 * 4級・5級は二次の面接がないためページを作らない。
 */
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../config.php';
}

/**
 * 学習の進み順。ナビ・相互リンク・サイトマップで使う。
 *
 * @return list<string>
 */
function speaking_grade_slugs(): array
{
    return ['3kyu', 'jun2kyu', 'jun2kyu-plus', '2kyu', 'jun1kyu', '1kyu'];
}

function speaking_page_path(string $slug): ?string
{
    if (!in_array($slug, speaking_grade_slugs(), true)) {
        return null;
    }
    return '/' . $slug . '/speaking/';
}

function speaking_url(string $slug): string
{
    $path = speaking_page_path($slug);
    if ($path === null) {
        return rtrim(SITE_URL, '/') . '/';
    }
    return rtrim(SITE_URL, '/') . $path;
}

function speaking_try_url(string $slug): string
{
    return rtrim(APP_URL, '/') . '/try/speaking/' . rawurlencode($slug);
}

function speaking_signup_url(): string
{
    return rtrim(APP_URL, '/') . '/signup';
}

/**
 * @param array<string, mixed> $grade
 * @param array<string, mixed> $content
 * @return array{title: string, description: string, og_type: string, robots: string, omit_jsonld: bool}
 */
function speaking_meta(array $grade, array $content): array
{
    $name = (string) ($grade['name'] ?? '英検');
    return [
        'title' => $name . 'のスピーキング対策｜AIで面接・発話練習｜' . SITE_NAME,
        'description' => (string) ($content['description'] ?? ''),
        'og_type' => 'website',
        'robots' => '',
        'omit_jsonld' => false,
    ];
}

/**
 * @return list<array{slug: string, name: string, name_short: string, href: string}>
 */
function speaking_nav_items(): array
{
    $items = [];
    foreach (speaking_grade_slugs() as $slug) {
        $grade = get_grade($slug);
        $href = speaking_page_path($slug);
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
function speaking_faq_items(string $slug, array $content): array
{
    $hasTry = !empty($content['has_try']);
    $items = [];

    if ($hasTry) {
        $items[] = [
            'q' => '登録なしで試せますか？',
            'a' => 'はい。イラスト描写と、それに続く1問は、登録なしで採点されます。マイクでも、文字の入力だけでも大丈夫です。音読、残りの質問、フル模擬は登録後です。登録後は、音読と残りの質問も同じ採点で練習できます。',
        ];
        $items[] = [
            'q' => '声を出さなくても練習できますか？',
            'a' => 'はい。体験も本練習も、録音の文字起こしを確認してから採点します。体験は、マイクを使わず入力だけでも採点されます。',
        ];
    } else {
        $items[] = [
            'q' => '登録なしで試せますか？',
            'a' => 'この級は、登録なしの2問体験はありません。無料登録すると、最初の' . FREE_TRIAL_DAYS . '日間はスピーキングを回数の制限なく練習できます。6日目以降の無料プランは1日1セットです。',
        ];
        $items[] = [
            'q' => '声を出さなくても練習できますか？',
            'a' => 'はい。録音の文字起こしを確認してから採点します。マイクを使わず、文字を入力して採点することもできます。',
        ];
    }

    $items[] = [
        'q' => '本番と同じ点数ですか？',
        'a' => '各パート0〜3点の練習採点です。音読の抜け、コマの抜け、意見の理由の有無を見ます。発音の個別スコアは出していません。',
    ];

    $follow = '自動では出ません。3級のNo.5は、最初の答えに一言足す形で練習します。';
    if ($slug !== '3kyu') {
        $follow .= 'この級も、Please tell me more. はその場で追加されません。用意された問いに答えます。';
    }
    $items[] = [
        'q' => '追い質問（Please tell me more.）はありますか？',
        'a' => $follow,
    ];

    $items[] = [
        'q' => '何セットありますか？',
        'a' => 'この級は3セットです。同じセットを、ドリルでパート別に繰り返せます。',
    ];

    $items[] = [
        'q' => '履歴は残りますか？',
        'a' => 'はい。登録後の練習は、合計点、パート別のスコア、フィードバックをあとから見返せます。',
    ];

    return $items;
}

/**
 * @return array<string, mixed>|null
 */
function get_speaking_content(string $slug): ?array
{
    $all = speaking_content_all();
    return $all[$slug] ?? null;
}

/**
 * @return array<string, array<string, mixed>>
 */
function speaking_content_all(): array
{
    static $cache = null;
    if ($cache !== null) {
        return $cache;
    }

    $cache = [
        '3kyu' => [
            'has_try' => true,
            'primary_label' => '登録なしで2問試す',
            'description' => '英検3級のスピーキング・面接・二次試験をアプリで練習。約5分の面接で、音読・イラスト描写・自分のことをAIが日本語で採点します。登録なしで2問試せます。',
            'lead' => '約5分の面接です。音読、短い質問、イラスト1枚、自分のこと。1文で答えられます。',
            'hero_note' => '登録なしで試せるのは、イラスト描写とそれに続く1問です。マイクでも、入力だけでも採点されます。',
            'chips' => ['二次試験', '約5分', '音読あり', '登録なしで2問'],
            'screen_alt' => '英検3級のスピーキング練習画面。School Lunch のパッセージと、給食のイラストが表示されている',
            'screen_caption' => 'School Lunch の練習画面です。タイトルから音読し、イラストの吹き出しと数を話します。',
            'example_kicker' => 'School Lunch',
            'example_lead' => 'オリジナル問題です。過去問の転載ではありません。採点は各パート0〜3点で、形式が合っているかを見ます。',
            'exchanges' => [
                ['label' => 'イラストの行動', 'q' => 'What is the girl going to do?', 'a' => "She's going to wash the dishes."],
                ['label' => '物の数', 'q' => 'How many apples are there on the table?', 'a' => 'There are four apples on the table.'],
            ],
            'feedback' => [
                [
                    'tone' => 'high',
                    'score' => '3点 / 3点',
                    'text' => '思考吹き出しは「これからすること」です。She\'s going to で動作まで言えているので、この問いは十分です。',
                    'model' => "She's going to wash the dishes.",
                ],
                [
                    'tone' => 'low',
                    'score' => '1点 / 3点',
                    'text' => '女の子が何かをするのは伝わっています。吹き出しは「今していること」ではなく「これからすること」なので、She\'s washing ではなく She\'s going to wash にすると形式に合います。',
                    'model' => '',
                ],
            ],
            'after_example' => '音読と残りの質問も、登録後は同じ採点で練習できます。',
            'parts' => [
                ['title' => '音読', 'text' => 'タイトルから読みます。約30語で、黙読は20秒です。'],
                ['title' => 'パッセージの事実', 'text' => '本文に書いてあることを、短く答えます。'],
                ['title' => 'イラストの行動', 'text' => '吹き出しは going to（これからすること）。いまの動作は ~ing です。'],
                ['title' => '物の数', 'text' => 'There are ... で、見えている数を言います。'],
                ['title' => '自分のこと', 'text' => 'カードを裏返してから答えます。I usually ... や Yes. I like ... と一言足します。'],
            ],
            'compare' => '',
            'points' => [
                ['title' => 'タイトルから読む', 'text' => 'パッセージは本文の前に、タイトルを読みます。黙読の20秒で、最初の一文を見ておきます。'],
                ['title' => '吹き出しは「これから」', 'text' => '思考の吹き出しは、今していることではありません。She\'s going to ... で、これからの動作まで言います。'],
                ['title' => 'No.4・5はカードを見ない', 'text' => '自分のことはカードを裏返してから。I usually ... や Yes. I like ... と、一言足す形で足ります。'],
            ],
        ],
        'jun2kyu' => [
            'has_try' => true,
            'primary_label' => '登録なしで2問試す',
            'description' => '英検準2級のスピーキング・面接・二次試験をアプリで練習。約6分。音読のあと、イラストAの動作とイラストBの理由をAIが採点します。登録なしで2問試せます。',
            'lead' => '約6分です。音読のあと、イラストAで動作を3つ、イラストBで理由まで言う面接です。',
            'hero_note' => '登録なしで試せるのは、イラスト描写とそれに続く1問です。マイクでも、入力だけでも採点されます。',
            'chips' => ['二次試験', '約6分', 'イラスト2枚', '登録なしで2問'],
            'screen_alt' => '英検準2級のスピーキング練習画面。パッセージと Picture A・Picture B のイラストが表示されている',
            'screen_caption' => '練習画面の例です（A Summer Festival）。Picture A と Picture B を順に話します。下の答え方は、別セットの After-School Clubs です。',
            'example_kicker' => 'After-School Clubs の答え方',
            'example_lead' => '体験では、イラストAを A boy is ...、イラストBを The boy is ~ing because ~. の形で案内します。問題はオリジナルです。',
            'exchanges' => [
                ['label' => 'イラストA', 'q' => '人の動作を3つ', 'a' => 'A boy is ...（現在進行形で、見えている動作を3つ）'],
                ['label' => 'イラストB', 'q' => '理由まで2文', 'a' => 'The boy is ~ing because ~.'],
            ],
            'feedback' => [
                [
                    'tone' => 'high',
                    'score' => '3点 / 3点',
                    'text' => 'イラストAで動作が3つあり、Bは because まで言えています。現在進行形なので、この問いの形式は十分です。',
                    'model' => 'A boy is ~ing. / The boy is ~ing because ~.',
                ],
                [
                    'tone' => 'low',
                    'score' => '1点 / 3点',
                    'text' => '動作は1つ伝わっています。Aは人数と動作を3つ落とさないこと。Bは理由がないので、because か and で2文にすると形式に合います。',
                    'model' => '',
                ],
            ],
            'after_example' => '音読と残りの質問も、登録後は同じ採点で練習できます。',
            'parts' => [
                ['title' => '音読', 'text' => '約50語のパッセージを、タイトルから読みます。'],
                ['title' => 'パッセージ', 'text' => 'How は By ~ing、Why は Because で答えます。'],
                ['title' => 'イラストA', 'text' => '現在進行形で、見えている動作を3つ言います。'],
                ['title' => 'イラストB', 'text' => 'because または and で、2文にします。理由まで言います。'],
                ['title' => '意見と自分の経験', 'text' => 'カードは非表示です。意見も経験も、それぞれ2文で答えます。'],
            ],
            'compare' => '',
            'points' => [
                ['title' => '黙読で決まり文句を探す', 'text' => '黙読のあいだに、By doing so / In this way / As a result を探します。その前後が、パッセージの答えになります。'],
                ['title' => 'Aは3つ、Bは理由まで', 'text' => 'イラストAは人数と動作を落とさないこと。Bは動作だけで終わらせず、because か and で理由まで言います。'],
                ['title' => '意見と経験の入り方', 'text' => 'No.4 は Yes, I think so. Because ~. No.5 は自分の経験か、なければ But I would like to ~. です。'],
            ],
        ],
        'jun2kyu-plus' => [
            'has_try' => true,
            'primary_label' => '登録なしで2問試す',
            'description' => '英検準2級プラスのスピーキング・面接・二次試験をアプリで練習。約7分。準2級の2枚絵から、3コマの物語と意見に変わります。登録なしで2問試せます。',
            'lead' => '準2級の2枚イラストから、2級と同じ3コマ物語に変わります。約7分です。',
            'hero_note' => '登録なしで試せるのは、イラスト描写とそれに続く1問です。マイクでも、入力だけでも採点されます。',
            'chips' => ['二次試験', '約7分', '3コマ', '登録なしで2問'],
            'screen_alt' => '英検準2級プラスのスピーキング練習画面。Secondhand Clothes の3コマイラストと指定文が表示されている',
            'screen_caption' => 'Secondhand Clothes の練習画面です。指定文から、左のコマの順に話します。',
            'example_kicker' => 'Secondhand Clothes',
            'example_lead' => 'オリジナル問題です。3コマのあと、意見は Yes / No と理由1つで足ります。採点は各パート0〜3点です。',
            'exchanges' => [
                [
                    'label' => '3コマ',
                    'q' => '指定文から、過去形で話す',
                    'a' => 'One day, Ms. Tanaka was shopping at a secondhand store with her son, Ken. Ken said, "I love this jacket." After shopping, she said, "I want to wash this jacket for Ken." The next morning, she looked worried.',
                ],
                [
                    'label' => '意見',
                    'q' => 'Do you think secondhand clothes will become more popular?',
                    'a' => 'Yes. They are cheaper than new clothes, so more people will buy them.',
                ],
            ],
            'feedback' => [
                [
                    'tone' => 'high',
                    'score' => '3点 / 3点',
                    'text' => '左のコマから3つ話し、指定文をそのまま使っています。吹き出しは said、矢印の時間も入っています。意見は Yes と理由1つで足りています。',
                    'model' => 'Yes. They are cheaper than new clothes.',
                ],
                [
                    'tone' => 'low',
                    'score' => '1点 / 3点',
                    'text' => '1コマ目しか話していません。3コマは左から順に、3つとも話します。指定文は自分で作り直さず、書かれている文から始めます。',
                    'model' => '',
                ],
            ],
            'after_example' => '音読と残りの質問も、登録後は同じ採点で練習できます。',
            'parts' => [
                ['title' => '音読', 'text' => '約55語です。タイトルから読みます。'],
                ['title' => 'パッセージ', 'text' => '本文の質問に、短く答えます。'],
                ['title' => '3コマ', 'text' => '準備20秒。指定文から、過去形で話します。吹き出しは said、矢印は時間です。'],
                ['title' => 'カードに関連した意見', 'text' => '3コマの話題について、Yes / No と理由を1つ言います。'],
                ['title' => '一般的な意見', 'text' => 'カードは非表示です。理由は1つで足ります。自分の経験を聞く No.5 はありません。'],
            ],
            'compare' => '準2級は Picture A と Picture B の2枚です。準2級プラスからは、2級と同じ3コマを、指定文・過去形・吹き出し（said）・矢印の時間で話します。自分の経験を聞く質問はありません。',
            'points' => [
                ['title' => '左から、3つとも話す', 'text' => '1コマで止めないこと。左のコマから順に、3つとも話します。'],
                ['title' => '指定文は作り直さない', 'text' => 'Your story should begin with this sentence. の文を、自分の言葉に替えずに始めます。'],
                ['title' => '意見は理由1つ', 'text' => 'Yes / No のあと、理由は1つで足ります。3つ目の理由を足そうとして、時間が足りなくならないようにします。'],
            ],
        ],
        '2kyu' => [
            'has_try' => true,
            'primary_label' => '登録なしで2問試す',
            'description' => '英検2級のスピーキング・面接・二次試験をアプリで練習。約7分。3コマの心情と、社会的な話題の意見をAIが採点します。登録なしで2問試せます。',
            'lead' => '約7分です。3コマに、期待と心配の気持ちが入ります。社会的な話題で意見を言います。',
            'hero_note' => '登録なしで試せるのは、イラスト描写とそれに続く1問です。マイクでも、入力だけでも採点されます。',
            'chips' => ['二次試験', '約7分', '心情あり', '登録なしで2問'],
            'screen_alt' => '英検2級のスピーキング練習画面。3コマイラストと、物語の指定文が表示されている',
            'screen_caption' => '練習画面の例です（Community Sports Parks）。3コマ・指定文・心情まで話します。下の回答は、別セットの Car Sharing です。',
            'example_kicker' => 'Car Sharing',
            'example_lead' => 'オリジナル問題です。3コマは指定文、セリフ、時間、心情の4点。意見は I agree / I disagree を先に言います。',
            'exchanges' => [
                [
                    'label' => '音読の問い',
                    'q' => 'How can people travel more easily without owning a car?',
                    'a' => 'By reserving a car with their smartphones.',
                ],
                [
                    'label' => '3コマ',
                    'q' => '時間と心情まで話す',
                    'a' => 'Thirty minutes later ... was looking forward to seeing the sea. Three hours later ... was worried that they might return the car late.',
                ],
                [
                    'label' => '意見',
                    'q' => 'Some people say ... What do you think?',
                    'a' => 'I agree. Public transportation is good enough in many cities.',
                ],
            ],
            'feedback' => [
                [
                    'tone' => 'high',
                    'score' => '3点 / 3点',
                    'text' => '指定文から始まり、時間、セリフ、心情（was looking forward to / was worried that）まで入っています。意見は I agree を先に言えています。',
                    'model' => 'I agree. Public transportation is good enough in many cities.',
                ],
                [
                    'tone' => 'low',
                    'score' => '1点 / 3点',
                    'text' => '3コマの出来事は伝わっています。心情がないので、was looking forward to と was worried that を入れると形式に合います。意見は I agree / I disagree を先に言います。',
                    'model' => '',
                ],
            ],
            'after_example' => '音読と残りの質問も、登録後は同じ採点で練習できます。',
            'parts' => [
                ['title' => '音読', 'text' => 'タイトルから読みます。黙読のあいだに、In this way の位置を見ます。'],
                ['title' => 'パッセージ', 'text' => 'In this way の直前が、No.1 の答えになることが多いです。How は By ~ing です。'],
                ['title' => '3コマ', 'text' => '指定文、セリフ、時間、心情の4点です。was looking forward to / was worried that を落とさないこと。'],
                ['title' => 'カードに関連した意見', 'text' => 'Some people say ... What do you think? の形です。I agree / I disagree を先に言います。'],
                ['title' => '社会的な話題の意見', 'text' => 'カードは非表示です。結論を先に言い、理由を続けます。'],
            ],
            'compare' => '準2級プラスとの違いは、心情（was looking forward to / was worried that）と、意見の問いが Some people say ... What do you think? になることです。',
            'points' => [
                ['title' => 'In this way の直前', 'text' => 'パッセージの No.1 は、In this way の直前を答えにすることが多いです。黙読でそこを見ておきます。'],
                ['title' => '3コマは4点', 'text' => '指定文、セリフ、時間、心情。出来事だけだと点が落ちます。期待と心配を、文の中に入れます。'],
                ['title' => '意見は結論が先', 'text' => 'I agree. / I disagree. を先に言ってから、理由を続けます。'],
            ],
        ],
        'jun1kyu' => [
            'has_try' => false,
            'primary_label' => '登録してこの4コマで2分話す',
            'description' => '英検準1級のスピーキング・面接・二次試験をアプリで練習。音読はありません。4コマを2分で話し、意見4問をAIが採点します。無料登録から始められます。',
            'lead' => '音読はありません。4コマを1分考えて、2分で話し、そのあと意見が4問。約8分です。',
            'hero_note' => 'この級は登録なしの体験がありません。無料登録すると、Shared Bicycles の4コマから練習を始められます。',
            'chips' => ['二次試験', '約8分', '4コマ', '音読なし'],
            'screen_alt' => '英検準1級のスピーキング練習画面。Shared Bicycles の4コマイラストと指定文が表示されている',
            'screen_caption' => 'Shared Bicycles の練習画面です。指定文から4コマを話し、4コマ目は I\'d be thinking で考えを言います。',
            'example_kicker' => 'Shared Bicycles',
            'example_lead' => '2級の3コマと違い、ナレーションの冒頭と、No.1 の I\'d be thinking が並びます。問題はオリジナルです。',
            'exchanges' => [
                [
                    'label' => 'ナレーション',
                    'q' => '指定文から、2分で4コマ',
                    'a' => 'One day, a woman was walking to the station.',
                ],
                [
                    'label' => 'No.1',
                    'q' => '4コマ目の考え（カードは見える）',
                    'a' => 'I\'d be thinking, "People should not leave shared bicycles on the sidewalk."',
                ],
            ],
            'feedback' => [
                [
                    'tone' => 'high',
                    'score' => '3点 / 3点',
                    'text' => '指定文から始まり、4コマ目の考えを I\'d be thinking で言えています。ナレーションは過去形で、最後は However まで入っていると十分です。',
                    'model' => 'I\'d be thinking, "People should not leave shared bicycles on the sidewalk."',
                ],
                [
                    'tone' => 'low',
                    'score' => '1点 / 3点',
                    'text' => 'ナレーションが途中で止まっています。2分で4コマを話し切り、1コマは2〜3文にします。意見は Yes / No のあと、理由を2文です。',
                    'model' => '',
                ],
            ],
            'after_example' => '登録すると、この4コマで2分話せます。意見の4問も同じ採点です。',
            'parts' => [
                ['title' => 'ナレーション', 'text' => '指定文から、過去形で話します。The next week / Six months later、was pleased to see that、最後は However です。'],
                ['title' => '4コマ目の思考', 'text' => 'I\'d be thinking, "..." で言います。この問いではカードが見えます。'],
                ['title' => 'トピック寄りの意見', 'text' => '4コマの話題に近い問いに、Yes / No と理由を2文で答えます。'],
                ['title' => 'もう一段広い意見', 'text' => '社会の話に広げます。理由は2文です。'],
                ['title' => '抽象的な意見', 'text' => 'カードは非表示です。結論を先に言い、理由を2文続けます。'],
            ],
            'compare' => '2級は音読と3コマです。準1級は音読がなく、4コマを1分考えて2分で話します。そのあと意見が4問です。登録なしの2問体験はないので、最初から登録して練習します。',
            'points' => [
                ['title' => '2分で4コマを話し切る', 'text' => '1コマで丁寧に止めないこと。1コマ2〜3文で、4コマまで届かせます。'],
                ['title' => '時間と However', 'text' => 'The next week / Six months later で時間を進め、最後のコマは However でひっくり返します。'],
                ['title' => '意見は理由2文', 'text' => 'Yes / No のあと、理由を2文。No.1 だけは I\'d be thinking で、4コマ目の考えを言います。'],
            ],
        ],
        '1kyu' => [
            'has_try' => false,
            'primary_label' => '登録してこのトピックで2分話す',
            'description' => '英検1級のスピーキング・面接・二次試験をアプリで練習。イラストはなく、5トピックから1つ選んで2分スピーチと質疑をAIが採点します。無料登録から始められます。',
            'lead' => 'イラストはありません。5つのトピックから1つ選び、1分で構成し、2分スピーチ。そのあと質疑です。約10分です。',
            'hero_note' => 'この級は登録なしの体験がありません。準備中のメモは、本番と同じく取れません。',
            'chips' => ['二次試験', '約10分', '2分スピーチ', 'イラストなし'],
            'screen_alt' => '英検1級のスピーキング準備画面。Education and Work の5トピックと、メモ不可のカウントダウンが表示されている',
            'screen_caption' => 'Education and Work の準備画面です。2分スピーチの構成を考えます。本番はメモ不可、と画面に出ています。',
            'example_kicker' => 'Education and Work',
            'example_lead' => 'オリジナルのトピックです。理由は2つまで。質疑は結論を先に言います。',
            'exchanges' => [
                [
                    'label' => 'トピック',
                    'q' => '5つのうち1つを選ぶ',
                    'a' => 'Should universities focus more on practical job skills than academic theory?',
                ],
                [
                    'label' => '2分スピーチ',
                    'q' => '主張、理由2つ、例、結論',
                    'a' => 'I would like to talk about ... / I believe that ... for two reasons. / First of all ... For example ... / Secondly ... / In conclusion, I firmly believe that ...',
                ],
                [
                    'label' => '質疑',
                    'q' => '反対意見と、日本での適用',
                    'a' => 'I understand that view, but I still think ... / In Japan, ...',
                ],
            ],
            'feedback' => [
                [
                    'tone' => 'high',
                    'score' => '3点 / 3点',
                    'text' => '主張、理由2つ、例、結論の順です。I believe that ... for two reasons. で入れているので、2分の型として十分です。',
                    'model' => 'In conclusion, I firmly believe that ...',
                ],
                [
                    'tone' => 'low',
                    'score' => '1点 / 3点',
                    'text' => '理由が3つあり、2分に収まりません。理由は2つまでにして、First of all と Secondly で話します。質疑は、説明の前に結論を言います。',
                    'model' => '',
                ],
            ],
            'after_example' => '登録すると、このトピックで2分スピーチを始められます。質疑も同じ採点です。',
            'parts' => [
                ['title' => 'トピック選択', 'text' => '5つのトピックから1つ選びます。準備は1分で、メモは取れません。'],
                ['title' => '2分スピーチ', 'text' => '主張、理由2つ、例、結論。3つ目の理由は時間が足りなくなります。'],
                ['title' => '深掘り', 'text' => '自分のスピーチについて聞かれます。結論を先に言い、短く補います。'],
                ['title' => '反対意見', 'text' => 'I understand that view, but I still think ... で、立場を崩さず答えます。'],
                ['title' => '日本での適用', 'text' => 'In Japan, ... で、日本の場面に引きつけます。'],
                ['title' => '誰が責任を持つか', 'text' => '責任や影響を聞かれても、スピーチの立場を先に言ってから補います。'],
            ],
            'compare' => '準1級は4コマのナレーションです。1級にイラストはなく、選んだトピックを2分話したあと、質疑に入ります。準備画面には「本番はメモ不可」と出ています。',
            'points' => [
                ['title' => '理由は2つまで', 'text' => '3つ目を足すと、2分に収まりません。First of all と Secondly で止めて、例を1つ入れます。'],
                ['title' => '質疑は結論が先', 'text' => '説明から入らないこと。I understand that view, but I still think ... のように、立場を先に言います。'],
                ['title' => 'メモは取れない', 'text' => '準備の1分は、本番と同じくメモなしです。型（主張・理由2つ・例・結論）を先に持っておくと、その1分でトピックに入れられます。'],
            ],
        ],
    ];

    return $cache;
}
