<?php
/**
 * バディ（愛犬）の名簿と、説明用の吹き出し。
 * 他のページでは buddy_say('mame', 'マメ', 'ひとこと')。
 */
declare(strict_types=1);

/**
 * @return list<array{name: string, slug: string, text: string}>
 */
function buddy_cast(): array
{
    return [
        [
            'name' => 'マメ',
            'slug' => 'mame',
            'text' => '明るくポジティブ。失敗しても「大丈夫！」と前を向ける。困ったときは自然とみんなをまとめる。',
        ],
        [
            'name' => 'チョコ',
            'slug' => 'choco',
            'text' => '優しくて共感力が高い。「大丈夫かな？」とすぐ相手を気にする。少し心配性だけど、その優しさでみんなを支える。',
        ],
        [
            'name' => 'コロ',
            'slug' => 'koro',
            'text' => '人懐っこく天真爛漫。誰とでもすぐ仲良くなれる。気づくと周りに犬が集まっている。',
        ],
        [
            'name' => 'モコ',
            'slug' => 'moko',
            'text' => '小柄で物静か。感情を大きく出さないけれど、実は誰よりもよく見ている。困ったときに的確な一言をくれる。',
        ],
        [
            'name' => 'マロン',
            'slug' => 'marron',
            'text' => 'とにかく懐っこい。初対面でも距離を縮めるのが上手。「ねえねえ！」と自然に懐に入ってくる。',
        ],
        [
            'name' => 'シロ',
            'slug' => 'shiro',
            'text' => '上品で穏やか。憧れられる存在だけど、実はただのんびり屋。そっとそばで、みんなのペースに寄り添う。',
        ],
        [
            'name' => 'ティア',
            'slug' => 'tia',
            'text' => 'しっかり者でまとめ役。誰とでも話せるけれど、気を遣いすぎて疲れることも。それでも自然と、みんなをまとめる。',
        ],
        [
            'name' => 'ルーク',
            'slug' => 'luke',
            'text' => '自分をしっかり持っていて頼もしい。小柄だけど、みんなに頼られる兄貴タイプ。困ったときは、いちばん先に動く。',
        ],
        [
            'name' => 'ソラ',
            'slug' => 'sora',
            'text' => '体を動かすのが大好き。いつも走り回っていて、面白いものを見つけるとすぐカバンに入れる。',
        ],
        [
            'name' => 'ジン',
            'slug' => 'jin',
            'text' => '知識が豊富で物知り。自慢はせず、謙虚で物静か。聞かれたときに、そっと正しい答えをくれる。',
        ],
    ];
}

function buddy_say(string $slug, string $name, string $line, string $size = 'md'): void
{
    $size_class = $size === 'sm' || $size === 'lg' ? ' buddy-say--' . $size : '';
    $src = '/assets/images/buddies/' . rawurlencode($slug) . '.png';
    echo '<figure class="buddy-say' . $size_class . '">';
    echo '<img class="buddy-say__img" src="' . htmlspecialchars($src, ENT_QUOTES, 'UTF-8') . '" alt="' . htmlspecialchars('バディ「' . $name . '」', ENT_QUOTES, 'UTF-8') . '" width="320" height="320" decoding="async">';
    echo '<blockquote class="buddy-say__bubble">';
    echo '<p>' . htmlspecialchars($line, ENT_QUOTES, 'UTF-8') . '</p>';
    echo '<cite class="buddy-say__name">' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '</cite>';
    echo '</blockquote>';
    echo '</figure>';
}
