/**
 * LPお知らせの原本（app.aiken.life/docs/lp-announcements/items.mjs）から、
 * LP表示用の includes/lp-announcements.json を作る。
 *
 *   node scripts/sync-lp-announcements.mjs
 *
 * アプリのリポジトリが隣のフォルダ（../app.aiken.life）にない場合は、
 * AIKEN_APP_DIR にそのパスを指定する。
 */
import { writeFileSync } from "node:fs";
import { dirname, join, resolve } from "node:path";
import { fileURLToPath, pathToFileURL } from "node:url";

const root = join(dirname(fileURLToPath(import.meta.url)), "..");
const appDir = resolve(process.env.AIKEN_APP_DIR || join(root, "..", "app.aiken.life"));
const source = join(appDir, "docs", "lp-announcements", "items.mjs");
const outPath = join(root, "includes", "lp-announcements.json");

const { items, reviewedThrough } = await import(pathToFileURL(source).href);

const ids = new Set();
const rows = items.map((item) => {
  if (ids.has(item.id)) throw new Error(`duplicate id: ${item.id}`);
  ids.add(item.id);
  if (!/^\d{4}-\d{2}-\d{2}$/.test(item.date)) throw new Error(`bad date: ${item.id}`);
  const places = [...new Set(item.places)];
  if (places.length === 0) throw new Error(`no places: ${item.id}`);
  return { id: item.id, date: item.date, text: item.text, places };
});

// 新しい順（同じ日は原本の並び順）
rows.sort((a, b) => (a.date < b.date ? 1 : a.date > b.date ? -1 : 0));

writeFileSync(
  outPath,
  JSON.stringify({ reviewedThrough, items: rows }, null, 2) + "\n",
  "utf8",
);
console.log(`wrote ${outPath}`);
console.log(`items ${rows.length} / through ${reviewedThrough}`);
