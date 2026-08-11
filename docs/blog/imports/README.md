# ブログ WP All Import 用ファイル

WP All Export で出したCSVを加工したインポート資産です。  
**運用の正本はここ**（Downloads のコピーは作業用）。

## ファイル一覧

| ファイル | 用途 | インポート方法 |
|----------|------|----------------|
| `投稿-Export-機能紐づけ-単語WL-980円.csv` | **現行の推奨一括ファイル**。全56本（980円CTA）＋単語/W/L 22本に機能セクション | Update existing / **Match by Post ID** |
| `投稿-Export-2026-8月-11-CTA更新-980円.csv` | 980円CTA差し替えのみ（機能セクションなし） | 同上（機能版を使うなら不要） |
| `blog-pillar-eiken-taisaku-app-import.csv` | 柱記事（新規）。ID空・下書き想定 | **Create new**（Update by ID にしない） |
| `blog-screenshot-guide-単語ライティングリスニング.md` | スクショ差し替え手順 | インポート後に手作業 |
| `../SEO方針_英検対策アプリ.md` | タイトル・メタ・訴求の方針 | 編集時の参照 |
| `../posts/67_英検対策アプリ_おすすめ_保護者向け.html` | 柱記事の本文正本 | 手動投稿 or CSV |

## WP All Import 手順（既存上書き）

1. All Import → New Import  
2. `投稿-Export-機能紐づけ-単語WL-980円.csv` を選択  
3. Post Type: **Posts**  
4. **Update existing posts** + Match by **Post ID**（列 `ID`）  
5. 「Updating existing」になっていることを確認して実行  
6. 単語/W/L記事の【スクショ差し替え】画像をメディアに置換  

## 柱記事

- タイトル案・本文の正本は `posts/67_英検対策アプリ_おすすめ_保護者向け.html`  
- SEO方針は `SEO方針_英検対策アプリ.md`  
- CSVで入れる場合は `blog-pillar-eiken-taisaku-app-import.csv`（公開前にタイトル/抜粋が新方針と一致しているか確認）

## 再生成

加工スクリプトは `app.aiken.life` リポジトリ側：

- `scripts/replace-blog-cta.mjs`
- `scripts/enhance-blog-feature-sections.mjs`

出力先をこの `imports/` に変更して再実行するか、生成後にここへコピーしてください。

## 注意

- 新規インポート（Create only）で既存CSVを流すと**記事が二重**になります  
- Status が `publish` の行は公開のまま更新されます  
- 価格キャンペーン文言（980円・定価1,480円・2026-12-31）を変えるときは、方針ドキュメントと一括置換の両方を更新すること  
