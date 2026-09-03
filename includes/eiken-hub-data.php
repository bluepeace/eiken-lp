<?php
/**
 * 英検対策コンテンツ（/eiken/）用データ
 * ブログURLは公開済み記事のみ。推測URLは含めない。
 */
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../config.php';
}

/** @return string */
function eiken_blog_url(string $slug): string
{
    return rtrim(SITE_URL, '/') . '/blog/' . rawurlencode($slug) . '/';
}

/**
 * @return list<array{id: string, label: string}>
 */
function eiken_hub_toc(): array
{
    return [
        ['id' => 'eiken-schedule', 'label' => '英検の日程'],
        ['id' => 'eiken-levels', 'label' => '各級のレベル'],
        ['id' => 'eiken-exam', 'label' => '試験内容'],
        ['id' => 'eiken-study', 'label' => '勉強法'],
        ['id' => 'eiken-materials', 'label' => 'おすすめ教材'],
        ['id' => 'eiken-past', 'label' => '過去問'],
        ['id' => 'eiken-by-grade', 'label' => '級別の対策'],
        ['id' => 'eiken-aiken', 'label' => '英検対策アプリ'],
    ];
}

/**
 * 級一覧（表示順: 5級→1級）
 *
 * @return list<array<string, mixed>>
 */
function eiken_hub_grades(): array
{
    $blog = static function (string $slug): string {
        return eiken_blog_url($slug);
    };

    return [
        [
            'slug' => '5kyu',
            'name' => '英検5級',
            'short' => '5級',
            'level' => '中学初級程度',
            'lp' => '/5kyu/',
            'official_exam' => 'https://www.eiken.or.jp/eiken/exam/grade_5/',
            'primary_skills' => ['単語・語彙', 'リーディング', 'リスニング'],
            'writing' => false,
            'speaking_note' => 'スピーキングは別日程の録音型（一次にライティングなし）',
            'articles' => [
                ['label' => '英検5級のレベルと勉強法', 'url' => $blog('eiken-5kyu-level-benkyou')],
                ['label' => '英検5級の単語・語彙対策', 'url' => $blog('eiken-5kyu-tango-goi')],
                ['label' => '英検5級の文法対策', 'url' => $blog('eiken-5kyu-grammar')],
                ['label' => '英検5級のリーディング対策', 'url' => $blog('eiken-5kyu-reading')],
                ['label' => '英検5級のリスニング対策', 'url' => $blog('eiken-5kyu-listening')],
            ],
        ],
        [
            'slug' => '4kyu',
            'name' => '英検4級',
            'short' => '4級',
            'level' => '中学中級程度',
            'lp' => '/4kyu/',
            'official_exam' => 'https://www.eiken.or.jp/eiken/exam/grade_4/',
            'primary_skills' => ['単語・語彙', 'リーディング', 'リスニング'],
            'writing' => false,
            'speaking_note' => 'スピーキングは別日程の録音型（一次にライティングなし）',
            'articles' => [
                ['label' => '英検4級のレベルと勉強法', 'url' => $blog('eiken-4kyu-level-benkyou')],
                ['label' => '英検4級の単語・語彙対策', 'url' => $blog('eiken-4kyu-tango-goi')],
                ['label' => '英検4級の文法対策', 'url' => $blog('eiken-4kyu-grammar')],
                ['label' => '英検4級のリーディング対策', 'url' => $blog('eiken-4kyu-reading')],
                ['label' => '英検4級のリスニング対策', 'url' => $blog('eiken-4kyu-listening')],
            ],
        ],
        [
            'slug' => '3kyu',
            'name' => '英検3級',
            'short' => '3級',
            'level' => '中学卒業程度',
            'lp' => '/3kyu/',
            'official_exam' => 'https://www.eiken.or.jp/eiken/exam/grade_3/',
            'primary_skills' => ['単語・語彙', 'リーディング', 'リスニング', 'ライティング', 'スピーキング'],
            'writing' => true,
            'speaking_note' => '二次は面接形式',
            'articles' => [
                ['label' => '英検3級のレベルと勉強法', 'url' => $blog('eiken-3kyu-level-benkyou')],
                ['label' => '英検3級の単語・語彙対策', 'url' => $blog('eiken-3kyu-tango-goi')],
                ['label' => '英検3級の文法対策', 'url' => $blog('eiken-3kyu-grammar')],
                ['label' => '英検3級のリーディング対策', 'url' => $blog('eiken-3kyu-reading')],
                ['label' => '英検3級のリスニング対策', 'url' => $blog('eiken-3kyu-listening')],
                ['label' => '英検3級のライティング対策', 'url' => $blog('eiken-3kyu-writing')],
            ],
        ],
        [
            'slug' => 'jun2kyu',
            'name' => '英検準2級',
            'short' => '準2級',
            'level' => '高校中級程度',
            'lp' => '/jun2kyu/',
            'official_exam' => 'https://www.eiken.or.jp/eiken/exam/grade_p2/',
            'primary_skills' => ['単語・語彙', 'リーディング', 'リスニング', 'ライティング', 'スピーキング'],
            'writing' => true,
            'speaking_note' => '二次は面接形式（AiKenでは面接形式の練習に対応）',
            'articles' => [
                ['label' => '英検準2級のレベルと勉強法', 'url' => $blog('eiken-jun2kyu-level-benkyou')],
                ['label' => '英検準2級の単語・語彙対策', 'url' => $blog('eiken-jun2kyu-tango-goi')],
                ['label' => '英検準2級の文法対策', 'url' => $blog('eiken-jun2kyu-grammar')],
                ['label' => '英検準2級のリーディング対策', 'url' => $blog('eiken-jun2kyu-reading')],
                ['label' => '英検準2級のリスニング対策', 'url' => $blog('eiken-jun2kyu-listening')],
                ['label' => '英検準2級のライティング対策', 'url' => $blog('eiken-jun2kyu-writing')],
            ],
        ],
        [
            'slug' => 'jun2kyu-plus',
            'name' => '英検準2級プラス',
            'short' => '準2級プラス',
            'level' => '準2級と2級の間（高校上級程度）',
            'lp' => '/jun2kyu-plus/',
            'official_exam' => 'https://www.eiken.or.jp/eiken/exam/grade_p2plus/',
            'primary_skills' => ['単語・語彙', 'リーディング', 'リスニング', 'ライティング', 'スピーキング'],
            'writing' => true,
            'speaking_note' => '二次は面接形式',
            'featured' => true,
            'articles' => [
                ['label' => '英検準2級プラスのレベルと勉強法', 'url' => $blog('eiken-jun2kyu-plus-level-benkyou')],
                ['label' => '英検準2級プラスの単語・語彙対策', 'url' => $blog('eiken-jun2kyu-plus-tango-goi')],
                ['label' => '英検準2級プラスの文法対策', 'url' => $blog('eiken-jun2kyu-plus-grammar')],
                ['label' => '英検準2級プラスのリーディング対策', 'url' => $blog('eiken-jun2kyu-plus-reading')],
                ['label' => '英検準2級プラスのリスニング対策', 'url' => $blog('eiken-jun2kyu-plus-listening')],
                ['label' => '英検準2級プラスのライティング対策', 'url' => $blog('eiken-jun2kyu-plus-writing')],
                ['label' => '英検の出題傾向の変化と準2級プラス新設', 'url' => $blog('eiken-shutendoukou-henka-2024')],
            ],
        ],
        [
            'slug' => '2kyu',
            'name' => '英検2級',
            'short' => '2級',
            'level' => '高校卒業程度',
            'lp' => '/2kyu/',
            'official_exam' => 'https://www.eiken.or.jp/eiken/exam/grade_2/',
            'primary_skills' => ['単語・語彙', 'リーディング', 'リスニング', 'ライティング', 'スピーキング'],
            'writing' => true,
            'speaking_note' => '二次は面接形式',
            'articles' => [
                ['label' => '英検2級のレベルと勉強法', 'url' => $blog('eiken-2kyu-level-benkyou')],
                ['label' => '英検2級の単語・語彙対策', 'url' => $blog('eiken-2kyu-tango-goi')],
                ['label' => '英検2級の文法対策', 'url' => $blog('eiken-2kyu-grammar')],
                ['label' => '英検2級のリーディング対策', 'url' => $blog('eiken-2kyu-reading')],
                ['label' => '英検2級のリスニング対策', 'url' => $blog('eiken-2kyu-listening')],
                ['label' => '英検2級のライティング対策', 'url' => $blog('eiken-2kyu-writing')],
            ],
        ],
        [
            'slug' => 'jun1kyu',
            'name' => '英検準1級',
            'short' => '準1級',
            'level' => '大学中級程度',
            'lp' => '/jun1kyu/',
            'official_exam' => 'https://www.eiken.or.jp/eiken/exam/grade_p1/',
            'primary_skills' => ['単語・語彙', 'リーディング', 'リスニング', 'ライティング', 'スピーキング'],
            'writing' => true,
            'speaking_note' => '二次は面接形式',
            'articles' => [
                ['label' => '英検準1級のレベルと勉強法', 'url' => $blog('eiken-jun1kyu-level-benkyou')],
                ['label' => '英検準1級の単語・語彙対策', 'url' => $blog('eiken-jun1kyu-tango-goi')],
                ['label' => '英検準1級の文法対策', 'url' => $blog('eiken-jun1kyu-grammar')],
                ['label' => '英検準1級のリーディング対策', 'url' => $blog('eiken-jun1kyu-reading')],
                ['label' => '英検準1級のリスニング対策', 'url' => $blog('eiken-jun1kyu-listening')],
                ['label' => '英検準1級のライティング対策', 'url' => $blog('eiken-jun1kyu-writing')],
            ],
        ],
        [
            'slug' => '1kyu',
            'name' => '英検1級',
            'short' => '1級',
            'level' => '大学上級程度',
            'lp' => '/1kyu/',
            'official_exam' => 'https://www.eiken.or.jp/eiken/exam/grade_1/',
            'primary_skills' => ['単語・語彙', 'リーディング', 'リスニング', 'ライティング', 'スピーキング'],
            'writing' => true,
            'speaking_note' => '二次は面接形式',
            'articles' => [
                ['label' => '英検1級のレベルと勉強法', 'url' => $blog('eiken-1kyu-level-benkyou')],
                ['label' => '英検1級の単語・語彙対策', 'url' => $blog('eiken-1kyu-tango-goi')],
                ['label' => '英検1級の文法対策', 'url' => $blog('eiken-1kyu-grammar')],
                ['label' => '英検1級のリーディング対策', 'url' => $blog('eiken-1kyu-reading')],
                ['label' => '英検1級のリスニング対策', 'url' => $blog('eiken-1kyu-listening')],
                ['label' => '英検1級のライティング対策', 'url' => $blog('eiken-1kyu-writing')],
            ],
        ],
    ];
}

/**
 * テーマ別の既存記事（存在確認済み）
 *
 * @return list<array{heading: string, links: list<array{label: string, url: string}>}>
 */
function eiken_hub_theme_links(): array
{
    $blog = static function (string $slug): string {
        return eiken_blog_url($slug);
    };

    return [
        [
            'heading' => '全体の基礎知識',
            'links' => [
                ['label' => '【2026年度】英検の試験日程はいつ？', 'url' => $blog('eiken-2026-schedule')],
                ['label' => '英検の級とレベル一覧｜5級～1級の違い', 'url' => $blog('eiken-grade-level-guide')],
                ['label' => '英検の持ち物リスト【前日チェック】', 'url' => $blog('eiken-mochimono-checklist')],
                ['label' => '英検の出題傾向はどう変わった？2024年リニューアルと準2級プラス', 'url' => $blog('eiken-shutendoukou-henka-2024')],
                ['label' => '英検の合否・結果はどこで見れる？', 'url' => $blog('eiken-goukaku-kekka-dokode-mireru')],
                ['label' => '英検の合格率は公表されている？', 'url' => $blog('eiken-goukakuritu-kouhyou')],
                ['label' => '英検はいつから受けられる？', 'url' => $blog('eiken-itsukara-jidoshi-chugakusei')],
                ['label' => '英検の入試でのメリットは？', 'url' => $blog('eiken-nyushi-merit')],
                ['label' => '英検は就活で有利？', 'url' => $blog('eiken-shukatsu-merit')],
            ],
        ],
    ];
}

/**
 * 公式サイトなど外部リンク
 *
 * @return array<string, string>
 */
function eiken_hub_official_urls(): array
{
    return [
        'schedule' => 'https://www.eiken.or.jp/eiken/schedule/',
        'schedule_2026' => 'https://www.eiken.or.jp/eiken/schedule/2026-examinee.html',
        'apply' => 'https://www.eiken.or.jp/eiken/apply/',
        'exam' => 'https://www.eiken.or.jp/eiken/exam/',
        'cbt' => 'https://www.eiken.or.jp/cbt/',
        'association' => 'https://www.eiken.or.jp/',
    ];
}
