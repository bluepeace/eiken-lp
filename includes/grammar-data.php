<?php
/**
 * 級別文法 LP（/5kyu/grammar/ から /2kyu/grammar/）
 * 5級・4級・3級・準2級・準2級プラス・2級のみ。1級と準1級はない。
 * テーマ一覧は AiKen 独自カリキュラム（2026-11-15）。公式の文法項目リストではない。
 */
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../config.php';
}

/**
 * @return list<string>
 */
function grammar_grade_slugs(): array
{
    return ['2kyu', 'jun2kyu-plus', 'jun2kyu', '3kyu', '4kyu', '5kyu'];
}

function grammar_page_path(string $slug): ?string
{
    if (!in_array($slug, grammar_grade_slugs(), true)) {
        return null;
    }
    return '/' . $slug . '/grammar/';
}

function grammar_url(string $slug): string
{
    $path = grammar_page_path($slug);
    if ($path === null) {
        return rtrim(SITE_URL, '/') . '/';
    }
    return rtrim(SITE_URL, '/') . $path;
}

function grammar_signup_url(): string
{
    return rtrim(APP_URL, '/') . '/signup';
}

function grammar_shot_url(string $slug, string $key): string
{
    if ($key === '' || !in_array($slug, grammar_grade_slugs(), true)) {
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
function grammar_meta(array $grade, array $content): array
{
    $name = (string) ($grade['name'] ?? '英検');
    return [
        'title' => $name . 'の文法｜英検対策アプリ｜' . SITE_NAME,
        'description' => (string) ($content['description'] ?? ''),
        'og_type' => 'website',
        'robots' => '',
        'omit_jsonld' => false,
    ];
}

/**
 * @return list<array{slug: string, name: string, name_short: string, href: string}>
 */
function grammar_nav_items(): array
{
    $items = [];
    foreach (grammar_grade_slugs() as $slug) {
        $grade = get_grade($slug);
        $href = grammar_page_path($slug);
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
function grammar_faq_items(array $content): array
{
    $name = (string) ($content['faq_name'] ?? 'この級');
    $count = (int) ($content['theme_count'] ?? 0);
    $questions = (int) ($content['question_count'] ?? 0);
    return [
        [
            'q' => $name . 'の文法の練習はできますか？',
            'a' => $name . 'は' . $count . 'テーマ、確認問題' . $questions . '問です。1テーマは解説を読んで、4択を5問解いて終わります。' . (string) ($content['lead'] ?? '') . (string) ($content['note'] ?? ''),
        ],
        [
            'q' => '英検協会の公式な文法リストですか？',
            'a' => 'AiKen独自のカリキュラムです。英検協会が公式に定めた文法項目の一覧ではありません。全範囲を網羅したことや、合格点を約束するものでもありません。1級と準1級の文法テーマはありません。',
        ],
        [
            'q' => '1テーマは何問ですか？',
            'a' => '4択が5問です。正解は1つで、選択肢の順番は固定です。英文だけで答えが決まり、日本語訳は答えたあとに出ます。語句整序や英作文ではありません。',
        ],
        [
            'q' => '文法の回数に上限はありますか？',
            'a' => 'ありません。単語と同じく、登録後も回数の制限なく使えます。リーディング、リスニング、ライティング、スピーキングの1日1セットには入りません。連続学習の日数にはカウントされます。',
        ],
        [
            'q' => '間違えた問題はあとから見られますか？',
            'a' => 'ログインすると、1問ごとに結果が保存されます。5問すべて終わったとき、学習ログが残ります。テーマ一覧には、未学習か、これまでの正答数と正答率が出ます。間違えた問題は履歴で見られます。',
        ],
        [
            'q' => 'Webとアプリの両方で使えますか？',
            'a' => '使えます。ブラウザからも、スマートフォンのアプリからも、同じ文法のテーマを確認できます。',
        ],
    ];
}

/**
 * @return array<string, array<string, mixed>>
 */
function grammar_catalog(): array
{
    static $catalog = null;
    if ($catalog !== null) {
        return $catalog;
    }
    $catalog = [
        '2kyu' => [
            'h1_sub' => '長文のまえに、構文を5問で。',
            'lead' => '長文の前に確認したい構文を、1テーマ5問で確かめます。分詞構文、仮定法、話法、強調、無生物主語などです。',
            'description' => '英検2級の文法を1テーマ5問で確認できます。分詞構文、仮定法、話法、強調、無生物主語などを扱います。20テーマ・100問。AiKen独自のカリキュラムで、回数の上限はありません。',
            'scope' => '完了の発展、時と条件の節、受け身の発展、分詞構文、複合関係詞、仮定法の応用、強調、話法、使役の have / get を扱います。',
            'later' => '1級と準1級の文法テーマはありません。',
            'curriculum_lead' => '長文で読み飛ばしがちな形を、1テーマ5問で確認する。',
            'theme_count' => 20,
            'question_count' => 100,
            'themes' => [
                ['category' => '時制', 'title' => '完了形の発展', 'summary' => '未来のある時点までに終えていることと、過去まで続いていた動作を分けます。'],
                ['category' => '時制', 'title' => '時・条件の節の時制', 'summary' => '未来のことでも、時や条件の節の中は現在形にします。'],
                ['category' => '助動詞', 'title' => 'had better と would rather', 'summary' => '忠告は had better、希望は would rather で表します。'],
                ['category' => '態', 'title' => '受け身の発展', 'summary' => '句動詞の前置詞は残し、言われていることは is said to で表します。'],
                ['category' => '不定詞・動名詞', 'title' => '不定詞の発展', 'summary' => 'すでに起きたことは to have、人柄は of、状況は for で表します。'],
                ['category' => '不定詞・動名詞', 'title' => '動名詞の発展', 'summary' => 'worth や no use のうしろは -ing にし、誰の動作かは所有格で表します。'],
                ['category' => '分詞', 'title' => '分詞構文', 'summary' => '分詞の主語は主節と同じにし、先に終えたことは Having で表します。'],
                ['category' => '関係詞', 'title' => '非制限用法と what', 'summary' => 'カンマの which は前の内容を受け、先行詞がなければ what を使います。'],
                ['category' => '関係詞', 'title' => '複合関係詞', 'summary' => 'whatever は譲歩、whoever は「〜する人」と「誰が〜しても」を形で分けます。'],
                ['category' => '比較', 'title' => '比較の発展', 'summary' => '倍数は as 原級 as、二者は the 比較級、強める語は比較級の前に置きます。'],
                ['category' => '仮定法', 'title' => '仮定法の応用', 'summary' => '今と違う仮定と、過去の事実に反する仮定を、時点で切り替えます。'],
                ['category' => '文の形', 'title' => '強調構文と so / neither', 'summary' => '強調は It is ... that、同意は前の文の助動詞に合わせます。'],
                ['category' => '文の形', 'title' => '無生物主語', 'summary' => '物や出来事を主語にして、人がどうなるかを続けます。'],
                ['category' => '文の形', 'title' => '名詞節と同格', 'summary' => '知らせの内容は that、文頭の「〜かどうか」は whether で表します。'],
                ['category' => '接続詞・前置詞', 'title' => '目的・譲歩・条件', 'summary' => '目的は so that、仮定の譲歩は even if、事実の譲歩は even though です。'],
                ['category' => '接続詞・前置詞', 'title' => '並列表現', 'summary' => 'not only と either と neither は、近いほうの語に動詞を合わせます。'],
                ['category' => '接続詞・前置詞', 'title' => '動詞の語法と前置詞', 'summary' => 'apologize、succeed、consist、result は、動詞ごとに前置詞が決まっています。'],
                ['category' => '文の形', 'title' => 'have / get の使役', 'summary' => 'have は人のあとが原形、get は to、物をしてもらうときは過去分詞です。'],
                ['category' => '文の形', 'title' => '話法の転換', 'summary' => '平叙文を said や told で伝え、時制と時の語句をずらします。'],
                ['category' => '文の形', 'title' => '形式主語・形式目的語', 'summary' => 'It や it が、うしろの that 節や to を受けます。'],
            ],
        ],
        'jun2kyu-plus' => [
            'h1_sub' => '似た形の、意味の違い。',
            'lead' => '似た形の意味の違いを、1テーマ5問で確認します。事実か仮定か、比べている相手は誰かを読みます。',
            'description' => '英検準2級プラスの文法を1テーマ5問で確認できます。事実と仮定、比較の対象、譲歩など、似た形の意味の違いが中心です。20テーマ・100問。AiKen独自のカリキュラムで、回数の上限はありません。',
            'scope' => '一つの過去の中の時点、事実と仮定、such / so、比較の対象、譲歩、前置詞つきの関係詞、意味が変わる不定詞と動名詞を扱います。',
            'later' => '長文で迷う構文の整理は2級です。',
            'curriculum_lead' => '一文の中の関係を読む。事実か仮定か、比べる相手は誰か、うしろの形は何か。',
            'theme_count' => 20,
            'question_count' => 100,
            'themes' => [
                ['category' => '時制', 'title' => '過去の時点を整理する', 'summary' => '一つの過去の場面で、一点の出来事、進行中の動作、それより前を分けます。'],
                ['category' => '仮定法', 'title' => '事実と仮定の使い分け', 'summary' => '前文の事実を読んで、現実の条件か、今と違う仮定か、過去と違う仮定かを選びます。'],
                ['category' => '時制', 'title' => '過去の習慣', 'summary' => '繰り返した動作は would、過去の状態は used to で表します。'],
                ['category' => '文の形', 'title' => '結果の such と so', 'summary' => 'so の直後は形容詞か副詞、such の直後は名詞のまとまりです。'],
                ['category' => '比較', 'title' => '比較の対象', 'summary' => '比べる相手を、not as、than の節、that of、those of で明確にします。'],
                ['category' => '接続', 'title' => '接続副詞', 'summary' => '前の文との関係を、逆接、結果、例、追加、対比で選びます。'],
                ['category' => '接続', 'title' => '譲歩と対比', 'summary' => '譲歩と対比は、うしろが節か、名詞か、別の文かで形を選びます。'],
                ['category' => '関係詞', 'title' => '前置詞と関係代名詞', 'summary' => '動詞が必要とする前置詞を、which または whom の前に置きます。'],
                ['category' => '不定詞', 'title' => '名詞を説明する to 不定詞', 'summary' => '最初にすること、するための人や物は、名詞のあとで to と原形を使います。'],
                ['category' => '文の形', 'title' => '長い主語と動詞', 'summary' => 'あいだに入った句ではなく、主役の名詞に動詞を合わせます。'],
                ['category' => '不定詞・動名詞', 'title' => '不定詞と動名詞の意味', 'summary' => 'mean、regret、go on は、to と -ing で意味が変わります。'],
                ['category' => '不定詞', 'title' => '疑問詞 + to', 'summary' => '何をするか、どこでするかは、疑問詞のあとで to と原形を使います。'],
                ['category' => '不定詞', 'title' => '予期しない結果', 'summary' => '意図したことと違う結果は、only to と動詞の原形で表します。'],
                ['category' => '時制', 'title' => '思っていたことの時制', 'summary' => 'thought や knew が過去なら、そのとき頭にあった内容も過去にします。'],
                ['category' => '否定', 'title' => '部分否定', 'summary' => 'すべてではないことと、一つもないことを、続きの文で分けます。'],
                ['category' => '接続', 'title' => '手段・目的・原因', 'summary' => '方法は by、目的は to、原因は because で、うしろの形も見て選びます。'],
                ['category' => '文の形', 'title' => '並列と選択', 'summary' => '両方、ではなく本当は、よりも、の形で、選んだものを明確にします。'],
                ['category' => '不定詞・動名詞', 'title' => '提案と助言の形', 'summary' => 'suggest と recommend は -ing、advise と encourage は人のあとで to です。'],
                ['category' => '時制', 'title' => '修飾を越えた主節の時制', 'summary' => '関係詞節や挿入の時制ではなく、主節の時点に動詞を合わせます。'],
                ['category' => '助動詞', 'title' => '規則・見込み・可能性', 'summary' => '規則、人の見通し、目の前の兆候、今まさに、を四つの形で分けます。'],
            ],
        ],
        'jun2kyu' => [
            'h1_sub' => '完了と関係詞を、使い分けまで。',
            'lead' => '完了と関係詞を、使い分けまで確認します。to と -ing で意味が変わる動詞と、仮定法の入口も含みます。',
            'description' => '英検準2級の文法を1テーマ5問で確認できます。完了形と関係詞を、使い分けまで扱います。20テーマ・100問。AiKen独自のカリキュラムで、回数の上限はありません。',
            'scope' => '完了形の使い分け、助動詞の推量、受動態の応用、不定詞と動名詞の意味の差、関係詞、比較の応用、仮定法の入口、知覚動詞と使役動詞を扱います。',
            'later' => '節と節の関係、意味が変わる形の整理は準2級プラス以降です。',
            'curriculum_lead' => '完了、関係詞、仮定の入口まで。3級の「知っている」を「使い分ける」に進める。',
            'theme_count' => 20,
            'question_count' => 100,
            'themes' => [
                ['category' => '時制', 'title' => '現在完了形・現在完了進行形', 'summary' => '継続・経験・完了を、have または has と過去分詞で表します。'],
                ['category' => '時制', 'title' => '過去完了形', 'summary' => '2つの過去の出来事のうち、先に起きたことを表します。'],
                ['category' => '時制', 'title' => '完了形の使い分け', 'summary' => 'いつ起きたかと、現在や別の過去との関係で時制を選びます。'],
                ['category' => '助動詞', 'title' => '助動詞の推量・過去形・完了形', 'summary' => '推量の強さと、過去のことへの regret や確信を助動詞で表します。'],
                ['category' => '態', 'title' => '受動態の応用', 'summary' => 'される側を主語にし、時制や助動詞と組み合わせて受け身を作ります。'],
                ['category' => '不定詞・動名詞・分詞', 'title' => '不定詞の応用', 'summary' => 'to + 動詞の原形で、目的・程度・評価の文を作ります。'],
                ['category' => '不定詞・動名詞・分詞', 'title' => '動名詞の応用', 'summary' => '動詞の -ing を名詞のように使い、前置詞のあとにも置きます。'],
                ['category' => '不定詞・動名詞・分詞', 'title' => '不定詞と動名詞の使い分け', 'summary' => 'to do と doing で、これからすることとすでにしたことが変わる動詞があります。'],
                ['category' => '不定詞・動名詞・分詞', 'title' => '分詞の形容詞的用法・後置修飾', 'summary' => '分詞で名詞を後ろから説明し、していることとされたことを区別します。'],
                ['category' => '関係詞', 'title' => '関係代名詞', 'summary' => 'who、which、that、whose で、前の名詞を後ろの文から説明します。'],
                ['category' => '関係詞', 'title' => '関係代名詞の目的格・省略', 'summary' => '後ろの文の目的語になる関係代名詞は、省けることがあります。'],
                ['category' => '関係詞', 'title' => '関係副詞の基礎', 'summary' => 'where、when、why で、場所・時・理由を後ろから説明します。'],
                ['category' => '比較・仮定法', 'title' => '比較表現の応用', 'summary' => '同じ程度、差、最上級、比例の形を文の型で見分けます。'],
                ['category' => '比較・仮定法', 'title' => '仮定法の基礎', 'summary' => '今の事実と違う願いと、過去の事実と違う後悔を形で分けます。'],
                ['category' => '接続詞・前置詞', 'title' => '接続詞の使い分け', 'summary' => '文と文をつなぐ語と、名詞につながる語を混同しないようにします。'],
                ['category' => '接続詞・前置詞', 'title' => '前置詞の使い分け', 'summary' => '動詞や形容詞と決まった組になる前置詞を、意味のまとまりで覚えます。'],
                ['category' => '文の形', 'title' => '知覚動詞・使役動詞', 'summary' => '見た・聞かせた・させた、のあとの動詞の形を使い分けます。'],
                ['category' => '文の形', 'title' => '間接疑問文', 'summary' => '疑問の内容を文の一部にするとき、語順を平叙文に戻します。'],
                ['category' => '文の形', 'title' => '文型と語順', 'summary' => '動詞のあとに何が続くかで、語の順番を決めます。'],
                ['category' => '品詞', 'title' => '形容詞・副詞の使い分け', 'summary' => '様子を表す語が名詞にかかるか、動詞にかかるかで形を変えます。'],
            ],
        ],
        '3kyu' => [
            'h1_sub' => '時制を選んで、文を組み立てる。',
            'lead' => 'いつなのかを選んで、文を組み立てます。現在完了は経験と継続の入口です。受動態、関係代名詞、誰に何を、間接疑問まで入ります。',
            'description' => '英検3級の文法を1テーマ5問で確認できます。時制の選択と、現在完了の入口、受動態、関係代名詞が中心です。16テーマ・80問。AiKen独自のカリキュラムで、回数の上限はありません。',
            'scope' => '現在・過去・未来の選択、現在完了の入口、助動詞、不定詞と動名詞の使い分け、比較、受動態、関係代名詞、接続詞、文型、間接疑問を扱います。',
            'later' => '完了の使い分け、仮定法、関係副詞は準2級以降です。',
            'curriculum_lead' => 'いつなのか、受け身か、誰のことを説明しているかを選ぶ段階。',
            'theme_count' => 16,
            'question_count' => 80,
            'themes' => [
                ['category' => '時制', 'title' => '現在形・過去形・未来表現', 'summary' => 'いつのことかで形を選びます。未来は、前からの予定か、今決めたことかで分けます。'],
                ['category' => '時制', 'title' => '進行形の使い分け', 'summary' => '現在形は習慣や事実、現在進行形は今進んでいる動作です。'],
                ['category' => '時制', 'title' => '現在完了形の基礎', 'summary' => 'have または has と過去分詞で、経験と継続だけを表します。'],
                ['category' => '助動詞', 'title' => '助動詞の基本', 'summary' => 'can、must、should、may のあとは、動詞の原形です。'],
                ['category' => '文の形', 'title' => '疑問詞を使った疑問文', 'summary' => 'what や where を文の最初に置き、そのあとで do、does、did を使います。'],
                ['category' => '不定詞・動名詞', 'title' => '不定詞の基本用法', 'summary' => 'to と動詞の原形で、「〜すること」「〜するための」「〜するために」を表します。'],
                ['category' => '不定詞・動名詞', 'title' => '動名詞の基本', 'summary' => '動詞の -ing を、「〜すること」という名詞として使います。'],
                ['category' => '不定詞・動名詞', 'title' => '不定詞と動名詞の使い分け', 'summary' => 'うしろに to を置く動詞と、-ing を置く動詞を分けます。'],
                ['category' => '比較', 'title' => '比較級・最上級・as ～ as', 'summary' => '差があるとき、一番のとき、同じくらいのときで形を変えます。'],
                ['category' => '態', 'title' => '受動態の基本', 'summary' => '「〜される」は、be 動詞と過去分詞で表します。'],
                ['category' => '関係詞', 'title' => '関係代名詞', 'summary' => 'who、which、that で、前の名詞をうしろの動詞につなぎます。'],
                ['category' => '接続詞・前置詞', 'title' => '接続詞', 'summary' => 'when、if、because、although のあとには、主語と動詞のある文が続きます。'],
                ['category' => '接続詞・前置詞', 'title' => '前置詞の使い分け', 'summary' => '時と場所で、in、on、at を使い分けます。'],
                ['category' => '文の形', 'title' => '第4文型・第5文型の基礎', 'summary' => '第4文型は「誰に何を」、第5文型は「目的語がどのような状態か」です。'],
                ['category' => '文の形', 'title' => '間接疑問文', 'summary' => '疑問の内容を文の一部にするとき、主語を動詞の前に戻します。'],
                ['category' => '分詞', 'title' => '分詞の形容詞的用法', 'summary' => '-ing と過去分詞を名詞の前に置きます。'],
            ],
        ],
        '4kyu' => [
            'h1_sub' => '過去と未来と、「〜するために」まで。',
            'lead' => '5級の文を、過去の否定と疑問、未来、比較、「〜するために」まで広げます。依頼は Could you、一緒にしようは Shall we です。',
            'description' => '英検4級の文法を1テーマ5問で確認できます。過去の否定と疑問、未来、比較、不定詞まで広げます。16テーマ・80問。AiKen独自のカリキュラムで、回数の上限はありません。',
            'scope' => '過去の否定と疑問、過去進行、will と be going to、must や could、不定詞と動名詞の入口、比較、because / so、There was / were、丁寧な依頼と提案を扱います。',
            'later' => '時制の選択、受動態、関係詞、文型は3級以降です。',
            'curriculum_lead' => '5級で作った文を、過去・未来・比べる・頼むまで広げる。',
            'theme_count' => 16,
            'question_count' => 80,
            'themes' => [
                ['category' => '時制', 'title' => '一般動詞の過去', 'summary' => 'したこと、しなかったこと、たずねることを、過去の形と did で作ります。'],
                ['category' => '時制', 'title' => 'be動詞の過去', 'summary' => 'was と were を、主語、否定、疑問で使い分けます。'],
                ['category' => '時制', 'title' => '過去進行形', 'summary' => 'そのとき進行中だったことは、was または were と -ing です。'],
                ['category' => '時制', 'title' => '未来表現', 'summary' => 'will と be going to の形、否定、疑問、be の一致を覚えます。'],
                ['category' => '助動詞', 'title' => '助動詞の発展', 'summary' => 'しなければならない、昔できた、かもしれないを、原形とセットで使います。'],
                ['category' => '不定詞', 'title' => '不定詞の基本', 'summary' => 'to と原形で、すること、するためのもの、人への依頼、目的を表します。'],
                ['category' => '動名詞', 'title' => '動名詞の基本', 'summary' => '-ing を「〜すること」として、提案、動詞のあと、時間のあと、趣味に使います。'],
                ['category' => '比較', 'title' => '比較', 'summary' => '二つを比べる形、一番の形、同じ数を、手がかりに合わせて選びます。'],
                ['category' => '接続詞', 'title' => '接続詞', 'summary' => '理由、結果、軽い逆接、前の時点、今の条件を、つなぐ語で分けます。'],
                ['category' => '文の形', 'title' => 'There is / are の数と時制', 'summary' => 'ある・いたの数と時制に、is、are、was、were を合わせます。'],
                ['category' => '文の形', 'title' => '代名詞・所有代名詞', 'summary' => '動作の相手、誰のものか、前に出たものの言い換えを分けます。'],
                ['category' => '文の形', 'title' => '疑問詞の発展', 'summary' => '数、量、長さ、頻度、どちら、を疑問詞でたずねます。'],
                ['category' => '前置詞', 'title' => '前置詞の使い分け', 'summary' => '起点と終点、交通手段、一緒にいる人、期間、隣の位置を前置詞で分けます。'],
                ['category' => '文の形', 'title' => '数量表現', 'summary' => '数えられるもの、数えられないもの、少し、ある、ない、を数量語で分けます。'],
                ['category' => '文の形', 'title' => '命令・依頼・提案', 'summary' => '丁寧に頼む、一緒にしようと誘う、相手のために申し出る形を分けます。'],
                ['category' => '文の形', 'title' => '感嘆文', 'summary' => 'すごいと思ったとき、What と How を、名詞の有無と a の有無で分けます。'],
            ],
        ],
        '5kyu' => [
            'h1_sub' => 'はじめての英文を、骨格から。',
            'lead' => 'はじめての英文の骨格を、1テーマ5問で確認します。be、一般動詞、疑問、命令、これとあれ、There is が中心です。過去は「昨日した」の肯定だけで、用語から入りません。',
            'description' => '英検5級の文法を1テーマ5問で確認できます。be、一般動詞、疑問、命令、これとあれ、There is が中心です。16テーマ・80問。AiKen独自のカリキュラムで、回数の上限はありません。',
            'scope' => '現在の文の骨格です。be、一般動詞、否定と疑問、can、疑問詞、命令と Let\'s、代名詞、所有、複数、冠詞、これとあれ、場所と時、There is / There are、and / but / or、よく使う過去の肯定を扱います。',
            'later' => '過去の否定と疑問、未来、比較、不定詞は4級以降です。',
            'curriculum_lead' => '中学に入ったばかりの文。現在が中心で、過去は「昨日した」の肯定だけ。',
            'theme_count' => 16,
            'question_count' => 80,
            'themes' => [
                ['category' => '文の形', 'title' => 'be動詞の文', 'summary' => 'am、is、are を、主語、否定、疑問、返事で使い分けます。'],
                ['category' => '時制', 'title' => '一般動詞の現在', 'summary' => 'I や複数は原形、一人のときは s か es、have は has にします。'],
                ['category' => '文の形', 'title' => 'don\'t / doesn\'t と Do / Does', 'summary' => '一般動詞の否定と疑問は do を使い、うしろは原形に戻します。'],
                ['category' => '時制', 'title' => '今していること', 'summary' => '今進んでいることは、am、is、are と -ing で言います。'],
                ['category' => '助動詞', 'title' => 'can', 'summary' => 'できること、できないこと、できるか聞くこと、その返事を学びます。'],
                ['category' => '文の形', 'title' => '疑問詞', 'summary' => '何、どこ、だれ、いつ、何歳かを、文の最初の語で聞き分けます。'],
                ['category' => '文の形', 'title' => '命令文と Let\'s', 'summary' => 'してほしいこと、しないでほしいこと、一緒にすることを、元の形で言います。'],
                ['category' => '文の形', 'title' => '人をさすことば', 'summary' => 'すでに出た人や物を、動詞の前で he、she、it、we、they と言い換えます。'],
                ['category' => '文の形', 'title' => 'だれのもの', 'summary' => '名詞の直前で、my、his、her、their と、名前の \'s を使い分けます。'],
                ['category' => '文の形', 'title' => '一つとたくさん', 'summary' => '多くの名詞は s、決まった語は es、child の複数は children です。'],
                ['category' => '文の形', 'title' => 'a / an / the', 'summary' => '初めて出る一つには a か an、すでに出たものと太陽には the を付けます。'],
                ['category' => '文の形', 'title' => 'これとあれ', 'summary' => '近いか遠いか、一つか複数かで、this、that、these、those を分けます。'],
                ['category' => '前置詞', 'title' => '場所と時の前置詞', 'summary' => '中、上、下、時刻、曜日で、in、on、under、at を分けます。'],
                ['category' => '文の形', 'title' => 'There is / There are', 'summary' => '今あるものの数に合わせて、is と are を使います。'],
                ['category' => '接続詞', 'title' => 'and / but / or', 'summary' => '両方、反対、どちらかで、and、but、or を分けます。'],
                ['category' => '時制', 'title' => 'よく使う過去', 'summary' => '昨日の be は was か were、多くの動詞は ed、go の過去は went です。'],
            ],
        ],
    ];
    return $catalog;
}

/**
 * @return array<string, mixed>|null
 */
function get_grammar_content(string $slug): ?array
{
    $catalog = grammar_catalog();
    if (!isset($catalog[$slug])) {
        return null;
    }
    $grade = get_grade($slug);
    $content = $catalog[$slug];
    $content['faq_name'] = (string) ($grade['name'] ?? 'この級');
    $content['note'] = 'AiKen独自のカリキュラムです。英検協会が公式に定めた文法項目の一覧ではありません。';
    $content['chips'] = ['1テーマ5問', '日本語の解説', '回数の上限なし'];
    $content['hero_lines'] = [
        '1テーマは、解説を読んで4択を5問',
        '英文だけで答えが決まり、訳はあとに出る',
        '単語と同じく、回数の上限はない',
    ];
    return $content;
}
