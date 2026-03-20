<?php
/**
 * よくあるご質問（本文はこの1ファイルに集約／FTPでも include 漏れしにくい）
 */
$page = 'faq';
require_once __DIR__ . '/config.php';
$canonical = rtrim(SITE_URL, '/') . '/faq';

$faq_categories = [
    [
        'id' => 'intro',
        'title' => 'はじめて・AiKenについて',
        'items' => [
            [
                'q' => 'AiKen（アイケン）はどんなサービスですか？',
                'a' => '英検1級〜5級までを対象に、リーディング・リスニング・ライティング・スピーキングの4技能をひとつのアプリで対策できる英検学習サービスです。AIが級に合わせた問題を出題し、学習履歴で復習しやすく、バディが継続を後押しします。',
            ],
            [
                'q' => 'このサイト（aiken.life）とアプリ（app.aiken.life）の違いは？',
                'a' => 'aiken.life はサービス紹介・コラムなどの公式サイトです。実際の学習・会員登録後の機能は app.aiken.life 上のアプリからご利用ください。',
            ],
            [
                'q' => '「バディ」とは何ですか？',
                'a' => '学習を応援してくれるキャラクターです。愛犬のようにそばにいてくれるイメージで、目標達成まで寄り添うコンセプトの一部です。',
            ],
            [
                'q' => 'アプリを使うのに英検の申し込みは必要ですか？',
                'a' => 'いいえ。AiKen は英検の学習用アプリであり、英検本体のお申し込みとは別です。受験は従来どおり英検公式の手続きが必要です。',
            ],
        ],
    ],
    [
        'id' => 'billing',
        'title' => '料金・会員登録・退会',
        'items' => [
            [
                'q' => '無料でどこまで使えますか？',
                'a' => '会員登録後、単語クイズ・ライティング（AI添削）・リーディング・リスニング・スピーキングなど、主要な機能をご利用いただけます。まずは無料で体験いただき、継続のイメージを掴んでください。',
            ],
            [
                'q' => '料金プランやキャンペーンはどこで確認できますか？',
                'a' => '料金・お試し期間・キャンペーンは時期により変わることがあります。最新情報は本サイトの「料金」ページ、またはアプリ内の案内をご確認ください。',
            ],
            [
                'q' => '退会・解約はできますか？',
                'a' => 'はい。アプリ内の設定からいつでも退会できます。',
            ],
            [
                'q' => 'ログインできない・パスワードを忘れた場合は？',
                'a' => 'アプリのログイン画面にある「パスワードを忘れた場合」等の案内に従って再設定してください。解決しない場合はお問い合わせフォームからご連絡ください。',
            ],
            [
                'q' => '複数端末から同じアカウントで使えますか？',
                'a' => 'ブラウザで利用する想定のため、一般的には複数の端末・ブラウザから同じアカウントでログインして学習できます。同時利用の制限がある場合はアプリ内の案内に従ってください。',
            ],
        ],
    ],
    [
        'id' => 'exam',
        'title' => '英検の級・試験・学習の進め方',
        'items' => [
            [
                'q' => '英検の何級に対応していますか？',
                'a' => '5級・4級・3級・準2級・2級・準1級・1級に対応しています。級別の出題形式に合わせた単語・各技能の練習が可能です。',
            ],
            [
                'q' => '一次試験と二次試験（面接・スピーキング）の両方の対策はできますか？',
                'a' => 'はい。リーディング・リスニングなど一次向けの練習に加え、ライティングやスピーキング（面接の流れに近い練習）にも取り組めます。級によって対応範囲が異なる場合があります。',
            ],
            [
                'q' => '英検の日程に合わせて勉強の計画を立てられますか？',
                'a' => 'はい。目標の試験日を設定し、日々の学習提案を受けながら計画的に進められるよう設計されています。',
            ],
            [
                'q' => '準2級プラスにも対応していますか？',
                'a' => '級の選択や出題形式の更新に合わせてアプリ側も拡張しています。アプリ内で選択できる級・メニューでご確認ください。',
            ],
            [
                'q' => '過去問そのものはアプリにありますか？',
                'a' => '英検の過去問の「そのもの」の掲載は著作権等の関係で行っていない場合があります。級の形式に沿ったオリジナル問題や類似形式の練習で対策できるようになっています。',
            ],
        ],
    ],
    [
        'id' => 'features',
        'title' => 'AI・ライティング・スピーキングなど機能について',
        'items' => [
            [
                'q' => 'AIのライティング添削はどう役立ちますか？',
                'a' => '自分の英文に対して、文法・語彙・構成などのフィードバックを得やすくします。独学で伸びにくい英作文対策を、アプリ内で繰り返し行えます。',
            ],
            [
                'q' => 'スピーキング（面接）の練習はどのように行いますか？',
                'a' => '級に合った流れで、音読・描写・意見を述べるなどの練習に取り組めるようになっています。本番の面接官ではありませんが、形式に慣れるための反復に役立ちます。',
            ],
            [
                'q' => 'リスニングは何回でも聞けますか？',
                'a' => '学習画面の仕様に従い、再生や見直しができるようになっています。級・問題タイプによって挙動が異なる場合があります。',
            ],
            [
                'q' => '単語はどのように覚えさせてくれますか？',
                'a' => '級に関連する語彙をクイズ形式で出題し、学習履歴と組み合わせて復習しやすくします。忘れかけたタイミングで再度出るなど、定着を意識した流れです。',
            ],
            [
                'q' => 'AIの回答は100％正しいですか？',
                'a' => 'AIは学習支援のための参考情報です。試験本番や学校の採点基準と完全に一致するとは限りません。公式の出題趣旨や教材もあわせてご確認ください。',
            ],
        ],
    ],
    [
        'id' => 'parents',
        'title' => '保護者の方へ',
        'items' => [
            [
                'q' => '小学生・中学生のお子さまでも使えますか？',
                'a' => 'はい。5級〜3級など、お子さまのレベルに合わせた対策が可能です。スマートフォン・タブレット・PCのブラウザから利用できます。',
            ],
            [
                'q' => 'お子さまが「何をしているアプリか」保護者にも分かりますか？',
                'a' => '本ページや「AiKenとは」のページで、英検のどの部分をどのように練習できるかをご確認いただけます。利用にあたっては、ご家庭のルール（利用時間・端末など）とあわせてご検討ください。',
            ],
            [
                'q' => 'アカウントは保護者名義と子ども名義、どちらがよいですか？',
                'a' => 'サービス利用規約・プライバシーポリシーに沿って、ご家庭で管理しやすい方法をお選びください。お子さまのみで登録する場合は、保護者の同意・監督のもとでの利用をおすすめします。',
            ],
        ],
    ],
    [
        'id' => 'support',
        'title' => '利用環境・トラブル・お問い合わせ',
        'items' => [
            [
                'q' => 'スマートフォン・タブレット・PCのどれでも使えますか？',
                'a' => 'はい。一般的なモダンブラウザからご利用いただける想定です。OSやブラウザの古い端末では表示や動作に制限がある場合があります。',
            ],
            [
                'q' => '通信はどのくらい使いますか？',
                'a' => '音声・画像の読み込みにより、リスニングや画像付きの画面では通信量が増えることがあります。Wi-Fi 利用や、モバイルデータの残量にご注意ください。',
            ],
            [
                'q' => '不具合が起きたときは？',
                'a' => '一度ブラウザの更新やキャッシュ削除、別ブラウザでの試行をお試しください。改善しない場合は、発生時刻・端末・ブラウザの種類を添えてお問い合わせください。',
            ],
            [
                'q' => 'お問い合わせはどこから行えますか？',
                'a' => 'アプリのお問い合わせページ（' . APP_URL . '/contact）からご連絡いただけます。',
            ],
        ],
    ],
];

include __DIR__ . '/includes/header.php';
?>
<section class="border-b border-slate-100 bg-gradient-to-b from-[#e8f8f9] to-white px-4 py-12 sm:py-16" aria-labelledby="faq-page-heading">
  <div class="mx-auto max-w-3xl text-center">
    <h1 id="faq-page-heading" class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">よくあるご質問</h1>
    <p class="mt-3 text-slate-600"><?php echo br_after_period('AiKen の使い方・料金・英検対策・保護者の方へ、などカテゴリ別にまとめました。'); ?></p>
  </div>
</section>

<nav class="border-b border-slate-100 bg-white px-4 py-6" aria-label="カテゴリへの移動">
  <div class="mx-auto max-w-3xl">
    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">カテゴリ</p>
    <ul class="mt-3 flex flex-wrap gap-2">
      <?php foreach ($faq_categories as $cat): ?>
      <li>
        <a class="inline-flex rounded-full border border-slate-200 bg-slate-50 px-3 py-1.5 text-sm font-medium text-slate-700 transition hover:border-[#50c2cb]/50 hover:bg-[#50c2cb]/10 hover:text-slate-900" href="#faq-<?php echo htmlspecialchars($cat['id']); ?>"><?php echo htmlspecialchars($cat['title']); ?></a>
      </li>
      <?php endforeach; ?>
    </ul>
  </div>
</nav>

<div class="bg-slate-50/50 px-4 py-12 sm:py-16">
  <div class="mx-auto max-w-3xl space-y-14">
    <?php foreach ($faq_categories as $cat): ?>
    <section id="faq-<?php echo htmlspecialchars($cat['id']); ?>" class="scroll-mt-24" aria-labelledby="faq-heading-<?php echo htmlspecialchars($cat['id']); ?>">
      <h2 id="faq-heading-<?php echo htmlspecialchars($cat['id']); ?>" class="border-b border-[#50c2cb]/40 pb-2 text-xl font-bold text-slate-900 sm:text-2xl"><?php echo htmlspecialchars($cat['title']); ?></h2>
      <dl class="mt-6 space-y-3">
        <?php foreach ($cat['items'] as $faq): ?>
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
          <dt class="px-5 py-4 font-semibold text-slate-900"><?php echo htmlspecialchars($faq['q']); ?></dt>
          <dd class="border-t border-slate-100 px-5 py-4 text-sm leading-relaxed text-slate-600"><?php echo br_after_period(nl2br(htmlspecialchars($faq['a']))); ?></dd>
        </div>
        <?php endforeach; ?>
      </dl>
    </section>
    <?php endforeach; ?>
  </div>
</div>
<?php
include __DIR__ . '/includes/sections/cta.php';
include __DIR__ . '/includes/footer.php';
