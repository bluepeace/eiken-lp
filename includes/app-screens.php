<?php
/**
 * アプリの実画面とストア掲載画像。
 *
 * 他のページからは app_screen('vocabulary')、または app_screens('phone'|'tablet'|'store')。
 * 料金の金額が写っている画面は含めていません。
 * phone は iPhone の画面、tablet は幅の広い画面、store は紹介文付きのストア掲載画像です。
 */
declare(strict_types=1);

/**
 * @return array<string, array{src: string, width: int, height: int, alt: string, caption: string, group: string, layout: string}>
 */
function app_screen_catalog(): array
{
    static $catalog = null;
    if ($catalog !== null) {
        return $catalog;
    }

    $phone = ['width' => 1170, 'height' => 2532, 'group' => 'phone', 'layout' => 'phone'];
    $tablet = ['width' => 2064, 'height' => 2752, 'group' => 'tablet', 'layout' => 'tablet'];
    $store = ['width' => 1284, 'height' => 2778, 'group' => 'store', 'layout' => 'phone'];

    $catalog = [
        'home' => $phone + [
            'src' => '/assets/images/app/phone/home.png',
            'alt' => 'AiKenのホーム。サンプルアカウントのあいさつ、今日の学習時間、連続学習日数、累計学習時間、目標級',
            'caption' => 'ホームです。表示中の名前、学習時間、プランの期限、試験までの日数は、撮影時点のサンプルです。',
        ],
        'skills' => $phone + [
            'src' => '/assets/images/app/phone/skills.png',
            'alt' => 'AiKenのホームにある学習メニュー。単語、リーディング、ライティング、リスニング、スピーキング',
            'caption' => 'ホームの学習メニューです。',
        ],
        'vocabulary' => $phone + [
            'src' => '/assets/images/app/phone/vocabulary.png',
            'alt' => 'AiKenの英検準2級プラスの単語画面。comfortの意味を4択で選び、正解と例文が表示されている',
            'caption' => '英検準2級プラスの単語画面です。',
        ],
        'reading' => $phone + [
            'src' => '/assets/images/app/phone/reading.png',
            'alt' => 'AiKenの準2級リーディング画面。会話文の空所補充で、正解と解説が表示されている',
            'caption' => '準2級の会話文の空所補充です。',
        ],
        'reading-setup' => $phone + [
            'src' => '/assets/images/app/phone/reading-setup.png',
            'alt' => 'AiKenのリーディング開始画面。5級から1級と、短文・会話文・長文の空所補充、長文の内容一致を選ぶ',
            'caption' => 'リーディングの開始画面です。級と問題タイプを選びます。',
        ],
        'listening' => $phone + [
            'src' => '/assets/images/app/phone/listening.png',
            'alt' => 'AiKenの準1級リスニング画面。SituationとQuestion、再生済み、正解の選択肢',
            'caption' => '準1級のリスニングです。',
        ],
        'writing-setup' => $phone + [
            'src' => '/assets/images/app/phone/writing-setup.png',
            'alt' => 'AiKenのライティング開始画面。3級から1級と、英作文・要約の形式を選ぶ',
            'caption' => 'ライティングの開始画面です。級と形式を選びます。',
        ],
        'writing-summary' => $phone + [
            'src' => '/assets/images/app/phone/writing.png',
            'alt' => 'AiKenの英検2級要約画面。英文と、45から55語の入力欄、語数の目安',
            'caption' => '英検2級の要約です。',
        ],
        'speaking' => $phone + [
            'src' => '/assets/images/app/phone/speaking.png',
            'alt' => 'AiKenの準2級プラスのスピーキング画面。パッセージ、3コマイラスト、審査員の質問、回答ボタン',
            'caption' => '準2級プラスのスピーキングです。',
        ],
        'profile' => $phone + [
            'src' => '/assets/images/app/phone/profile.png',
            'alt' => 'AiKenのプロフィール。一緒に学習するバディ、目標級、目標の受験回',
            'caption' => 'プロフィールです。バディ、目標級、受験回を選べます。',
        ],
        'tablet-home' => $tablet + [
            'src' => '/assets/images/app/tablet/home.jpg',
            'alt' => 'AiKenのホーム（横幅の広い画面）。学習時間、連続日数、技能メニュー、体験期間の表示',
            'caption' => '横幅の広い画面のホームです。体験の残り日数は、撮影時点の表示です。',
        ],
        'tablet-vocabulary' => $tablet + [
            'src' => '/assets/images/app/tablet/vocabulary.jpg',
            'alt' => 'AiKenの英検2級の単語画面。considerの意味を4択で選ぶ',
            'caption' => '英検2級の単語画面です。',
        ],
        'tablet-reading' => $tablet + [
            'src' => '/assets/images/app/tablet/reading.jpg',
            'alt' => 'AiKenの英検2級リーディング画面。長文の内容一致。A Weekend Library Project',
            'caption' => '英検2級の長文の内容一致です。',
        ],
        'tablet-listening' => $tablet + [
            'src' => '/assets/images/app/tablet/listening.jpg',
            'alt' => 'AiKenの英検2級リスニング画面。会話の内容一致。放送を聞くボタンと4つの選択肢',
            'caption' => '英検2級の会話の内容一致です。',
        ],
        'tablet-writing' => $tablet + [
            'src' => '/assets/images/app/tablet/writing.jpg',
            'alt' => 'AiKenの英検2級英作文画面。TOPIC、80から100語の回答、AI添削に出すボタン',
            'caption' => '英検2級の英作文です。',
        ],
        'tablet-speaking' => $tablet + [
            'src' => '/assets/images/app/tablet/speaking.jpg',
            'alt' => 'AiKenのスピーキング画面。Car Sharingのフル模擬ナレーション。20秒の準備と3コマイラスト',
            'caption' => 'フル模擬のナレーションです。準備時間は20秒です。',
        ],
        'vocabulary-history' => $tablet + [
            'src' => '/assets/images/app/tablet/vocabulary-history.jpg',
            'alt' => 'AiKenの単語クイズ履歴。間違えた語は次のクイズで優先出題される説明と、正誤の一覧',
            'caption' => '単語クイズの履歴です。日付と正誤は、サンプルの記録です。',
        ],
        'store-overview' => $store + [
            'src' => '/assets/images/app/store/overview.png',
            'alt' => 'ストア掲載画像。英検5級から1級、これ1つで。準2級プラスの単語画面',
            'caption' => '「英検5級〜1級、これ1つで。」',
        ],
        'store-skills' => $store + [
            'src' => '/assets/images/app/store/skills.png',
            'alt' => 'ストア掲載画像。単語と4技能をまとめて対策。ホームの学習メニュー',
            'caption' => '「単語＋4技能 まとめて対策」',
        ],
        'store-library' => $store + [
            'src' => '/assets/images/app/store/library.png',
            'alt' => 'ストア掲載画像。10,000問以上を収録。準2級のリーディング画面',
            'caption' => '「10,000問以上 問題を収録」',
        ],
        'store-reading' => $store + [
            'src' => '/assets/images/app/store/reading.png',
            'alt' => 'ストア掲載画像。リーディング。級と問題タイプの選択画面',
            'caption' => '「リーディング」',
        ],
        'store-listening' => $store + [
            'src' => '/assets/images/app/store/listening.png',
            'alt' => 'ストア掲載画像。リスニング。準1級の問題と正解',
            'caption' => '「リスニング」',
        ],
        'store-writing' => $store + [
            'src' => '/assets/images/app/store/writing.png',
            'alt' => 'ストア掲載画像。ライティング。英検2級の要約',
            'caption' => '「ライティング」',
        ],
        'store-speaking' => $store + [
            'src' => '/assets/images/app/store/speaking.png',
            'alt' => 'ストア掲載画像。スピーキング。準2級プラスの問題カード',
            'caption' => '「スピーキング」',
        ],
        'store-profile' => $store + [
            'src' => '/assets/images/app/store/profile.png',
            'alt' => 'ストア掲載画像。かわいい愛犬を選択。バディと目標級の画面',
            'caption' => '「かわいい愛犬を選択」',
        ],
    ];

    return $catalog;
}

/**
 * @return array{src: string, width: int, height: int, alt: string, caption: string, group: string, layout: string}
 */
function app_screen(string $key): array
{
    $catalog = app_screen_catalog();
    if (!isset($catalog[$key])) {
        throw new InvalidArgumentException('Unknown app screen: ' . $key);
    }

    return $catalog[$key];
}

/**
 * @return list<array{key: string, src: string, width: int, height: int, alt: string, caption: string, group: string, layout: string}>
 */
function app_screens(string $group): array
{
    $items = [];
    foreach (app_screen_catalog() as $key => $screen) {
        if ($screen['group'] !== $group) {
            continue;
        }
        $screen['key'] = $key;
        $items[] = $screen;
    }

    return $items;
}

function app_screen_class(array $screen): string
{
    if (($screen['group'] ?? '') === 'store') {
        return 'mx-auto h-auto w-full max-w-[11rem] rounded-[1.1rem] border border-slate-200 bg-white';
    }
    if (($screen['layout'] ?? '') === 'tablet') {
        return 'mx-auto h-auto w-full max-w-md rounded-xl border border-slate-200 bg-slate-50';
    }

    return 'mx-auto h-auto w-full max-w-[17.5rem] rounded-[1.25rem] border border-slate-200 bg-slate-50';
}
