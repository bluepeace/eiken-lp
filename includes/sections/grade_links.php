<?php
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../../config.php';
}
global $GRADES;

$skill_columns = [
    'vocabulary' => ['label' => '単語', 'detail' => '4択・音声・例文'],
    'reading' => ['label' => 'リーディング', 'detail' => '級別の読解形式'],
    'listening' => ['label' => 'リスニング', 'detail' => '級別の音声問題'],
    'writing' => ['label' => 'ライティング', 'detail' => 'AI採点・添削'],
    'speaking' => ['label' => 'スピーキング', 'detail' => '面接・AI採点'],
];

$writing_labels = [
    '3kyu' => 'Eメール・英作文',
    'jun2kyu' => 'Eメール・英作文',
    'jun2kyu-plus' => '要約・英作文',
    '2kyu' => '要約・英作文',
    'jun1kyu' => '要約・英作文',
    '1kyu' => '要約・英作文',
];
$speaking_labels = [
    '3kyu' => '面接練習',
    'jun2kyu' => '面接練習',
    'jun2kyu-plus' => '面接練習',
    '2kyu' => '面接練習',
    'jun1kyu' => '面接練習',
    '1kyu' => 'スピーチ・Q&A',
];

function top_skill_link(string $grade, string $skill): string
{
    return rtrim(grade_url($grade), '/') . '/' . $skill . '/';
}

function top_skill_cell(string $grade, string $skill, array $writing_labels, array $speaking_labels): ?array
{
    $labels = [
        'vocabulary' => '4択・音声・例文',
        'reading' => '級別の読解問題',
        'listening' => '級別の音声問題',
    ];
    if ($skill === 'writing') {
        return isset($writing_labels[$grade])
            ? ['label' => $writing_labels[$grade], 'url' => top_skill_link($grade, $skill)]
            : null;
    }
    if ($skill === 'speaking') {
        return isset($speaking_labels[$grade])
            ? ['label' => $speaking_labels[$grade], 'url' => top_skill_link($grade, $skill)]
            : null;
    }
    return ['label' => $labels[$skill], 'url' => top_skill_link($grade, $skill)];
}
?>
<section id="grade-skill-coverage" class="grade-skill-coverage border-t border-slate-100 bg-white px-4 py-16 sm:py-20" aria-labelledby="grade-links-heading">
  <div class="lp-container">
    <p class="section-badge section-badge--center" aria-hidden="true">GRADES &amp; SKILLS</p>
    <h2 id="grade-links-heading" class="text-center text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">英検5級〜1級、<span class="heading-accent">級別・技能別</span>に対策</h2>
    <p class="mx-auto mt-3 max-w-3xl text-center leading-relaxed text-slate-600"><?php echo br_after_period('AiKenは、目標級に合わせて英検単語・リーディング・リスニングを練習できます。3級以上はライティングとスピーキングにも対応し、英作文・要約・面接をAI採点とフィードバックで振り返れます。'); ?></p>

    <div class="grade-skill-table-wrap mt-10" tabindex="0" role="region" aria-label="級別・技能別の対応一覧">
      <table class="grade-skill-table">
        <thead>
          <tr>
            <th scope="col">目標級</th>
            <?php foreach ($skill_columns as $column): ?>
            <th scope="col"><span><?php echo htmlspecialchars($column['label']); ?></span><small><?php echo htmlspecialchars($column['detail']); ?></small></th>
            <?php endforeach; ?>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($GRADES as $slug => $g): ?>
          <tr>
            <th scope="row"><a href="<?php echo htmlspecialchars(grade_url($slug)); ?>"><?php echo htmlspecialchars($g['name']); ?></a></th>
            <?php foreach ($skill_columns as $skill => $column):
                $cell = top_skill_cell($slug, $skill, $writing_labels, $speaking_labels);
                ?>
            <td>
              <?php if ($cell !== null): ?>
              <a href="<?php echo htmlspecialchars($cell['url']); ?>"><span class="grade-skill-table__check" aria-hidden="true">✓</span><?php echo htmlspecialchars($cell['label']); ?></a>
              <?php else: ?>
              <span class="grade-skill-table__none" aria-label="専用ページなし">—</span>
              <?php endif; ?>
            </td>
            <?php endforeach; ?>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <p class="mt-3 text-center text-xs leading-relaxed text-slate-500">表は横にスクロールできます。各項目から、その級・技能の詳しい学習内容と実際の問題画面を確認できます。</p>

    <nav class="grade-skill-guides mt-8" aria-label="英検対策の関連ガイド">
      <a href="/eiken/"><strong>英検対策コンテンツ</strong><span>日程・レベル・勉強法をまとめて確認</span></a>
      <a href="/blog/eiken-apps/"><strong>英検対策アプリ7選を比較</strong><span>対応技能・料金・向いている学習を比べる</span></a>
      <a href="/blog/"><strong>級別の英検コラム</strong><span>単語・4技能の勉強法を記事で読む</span></a>
    </nav>
  </div>
</section>
