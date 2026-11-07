<?php
/**
 * 英検の試験日程と「本番まであと◯日」
 *
 * 日程が過ぎると、自動で次の試験に切り替わる（日本時間で判定）。
 * 新しい日程が公表されたら、lp_exam_events() の末尾に足すだけでよい。
 * 登録済みの最後の試験が過ぎると、カウントダウンは表示されなくなる。
 *
 * 出典: 日本英語検定協会の公表日程（docs/blog/research/01_英検2026年度日程_調査メモ.md）
 */
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../config.php';
}

/**
 * @return array<int, array{
 *   name: string, short: string, kind: string, dates: string[], date_labels?: string[],
 *   grades: string[], apply_until?: string
 * }>
 * dates: 本会場の試験日（Y-m-d）。複数ある場合は早い順（二次の A日程・B日程など）。
 * kind: first（一次）/ second（二次）。
 * grades: 対象の級スラッグ。二次試験は 4級・5級にない。
 * apply_until: 個人申込の締切（Y-m-d）。この日までは締切も表示する。
 */
function lp_exam_events(): array
{
    $all = ['1kyu', 'jun1kyu', '2kyu', 'jun2kyu-plus', 'jun2kyu', '3kyu', '4kyu', '5kyu'];
    $interview = ['1kyu', 'jun1kyu', '2kyu', 'jun2kyu-plus', 'jun2kyu', '3kyu'];

    return [
        [
            'name' => '2026年度 第3回 一次試験',
            'short' => '一次試験',
            'kind' => 'first',
            'dates' => ['2027-01-24'],
            'grades' => $all,
            'apply_until' => '2026-12-14',
        ],
        [
            'name' => '2026年度 第3回 二次試験',
            'short' => '二次試験',
            'kind' => 'second',
            'dates' => ['2027-02-28', '2027-03-07'],
            'date_labels' => ['A日程', 'B日程'],
            'grades' => $interview,
        ],
        // 2027年度 第1回の日程が公表されたら、ここに一次試験・二次試験の順で足す
    ];
}

function lp_exam_today(): DateTimeImmutable
{
    return new DateTimeImmutable('today', new DateTimeZone('Asia/Tokyo'));
}

function lp_exam_day(string $ymd): DateTimeImmutable
{
    return new DateTimeImmutable($ymd, new DateTimeZone('Asia/Tokyo'));
}

/** 2027-01-24 → 1月24日（日）。年が今年と違えば年も付ける */
function lp_exam_date_label(string $ymd, bool $with_year = false): string
{
    $d = lp_exam_day($ymd);
    $w = ['日', '月', '火', '水', '木', '金', '土'][(int) $d->format('w')];
    return ($with_year ? $d->format('Y') . '年' : '') . $d->format('n月j日') . '（' . $w . '）';
}

/**
 * 次の試験（今日以降に試験日が残っている最初のもの）
 * @param string $grade 級スラッグ。空なら全級共通で判定（トップなど）
 * @param DateTimeImmutable|null $today 確認用。省略時は日本時間の今日
 * @param string $kind first / second で絞る。空ならどちらでも
 * @return array{event: array, date: string, days: int, apply_until: string}|null
 */
function lp_next_exam(string $grade = '', ?DateTimeImmutable $today = null, string $kind = ''): ?array
{
    $today = $today ?? lp_exam_today();
    foreach (lp_exam_events() as $event) {
        if ($grade !== '' && !in_array($grade, $event['grades'], true)) {
            continue;
        }
        if ($kind !== '' && ($event['kind'] ?? '') !== $kind) {
            continue;
        }
        foreach ($event['dates'] as $ymd) {
            $day = lp_exam_day($ymd);
            if ($day < $today) {
                continue;
            }
            $apply = (string) ($event['apply_until'] ?? '');
            return [
                'event' => $event,
                'date' => $ymd,
                'days' => (int) $today->diff($day)->days,
                'apply_until' => ($apply !== '' && lp_exam_day($apply) >= $today) ? $apply : '',
            ];
        }
    }
    return null;
}

/** 試験日の表示（二次は「A日程 2月28日（日）／B日程 3月7日（日）」） */
function lp_exam_dates_text(array $event): string
{
    $parts = [];
    foreach ($event['dates'] as $i => $ymd) {
        $label = (string) ($event['date_labels'][$i] ?? '');
        $parts[] = ($label !== '' ? $label . ' ' : '') . lp_exam_date_label($ymd);
    }
    return implode('／', $parts);
}
