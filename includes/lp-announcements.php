<?php
/**
 * LPお知らせ（級別・技能別の更新履歴）
 * データ: includes/lp-announcements.json
 *   原本は app.aiken.life/docs/lp-announcements/items.mjs。
 *   更新したら `node scripts/sync-lp-announcements.mjs` で JSON を作り直す。
 * 掲載先（places）: general / grade:2級 / 2級:speaking など
 */
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../config.php';
}

/** NEW を付ける日数 */
const LP_ANNOUNCEMENT_NEW_DAYS = 14;

/** 技能ページの $page => 表示名 */
function lp_announcement_skills(): array
{
    return [
        'vocabulary' => '単語',
        'reading' => 'リーディング',
        'listening' => 'リスニング',
        'writing' => 'ライティング',
        'speaking' => 'スピーキング',
    ];
}

/** @return array<int, array{id: string, date: string, text: string, places: string[]}> */
function lp_announcement_all(): array
{
    static $items = null;
    if ($items !== null) {
        return $items;
    }
    $items = [];
    $json = @file_get_contents(__DIR__ . '/lp-announcements.json');
    $data = is_string($json) ? json_decode($json, true) : null;
    if (is_array($data) && is_array($data['items'] ?? null)) {
        $items = $data['items'];
    }
    return $items;
}

/** 表示中のページの掲載先キー（級LP: grade:2級 / 技能LP: 2級:speaking / それ以外: 空） */
function lp_announcement_place(): string
{
    global $page, $GRADES;
    $level = lp_current_grade();
    if ($level === '') {
        return '';
    }
    $label = (string) $GRADES[$level]['name_short'];
    if (($page ?? '') === 'grade') {
        return 'grade:' . $label;
    }
    if (isset(lp_announcement_skills()[$page ?? ''])) {
        return $label . ':' . $page;
    }
    return '';
}

/** @return array<int, array{id: string, date: string, text: string, places: string[]}> 新しい順 */
function lp_announcements_for(string $place): array
{
    if ($place === '') {
        return [];
    }
    return array_values(array_filter(
        lp_announcement_all(),
        static fn ($item) => in_array($place, (array) ($item['places'] ?? []), true)
    ));
}

/** 2026-11-07 → 2026年11月7日 */
function lp_announcement_date(string $iso): string
{
    $p = explode('-', $iso);
    if (count($p) !== 3) {
        return $iso;
    }
    return (int) $p[0] . '年' . (int) $p[1] . '月' . (int) $p[2] . '日';
}

function lp_announcement_is_new(string $iso): bool
{
    $ts = strtotime($iso . ' 00:00:00 Asia/Tokyo');
    return $ts !== false && (time() - $ts) < LP_ANNOUNCEMENT_NEW_DAYS * 86400;
}
