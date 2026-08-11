# スクショ差し替えガイド（単語・ライティング・リスニング）

WP All Importで `投稿-Export-機能紐づけ-単語WL-980円.csv` を既存ID上書きしたあと、各記事の「【スクショ差し替え】」付き画像をメディアライブラリの実ファイルに差し替えてください。

仮URLは `https://aiken.life/blog/wp-content/uploads/REPLACE/ファイル名` になっています（画像はまだ無いので、公開前に必ず差し替え）。

## 用意する画面（推奨）

| 種類 | 撮る画面 | ポイント |
|---|---|---|
| 単語 | 単語クイズ | 級・問題文・選択肢が見える |
| ライティング | 課題入力 or AI添削結果 | 「AI添削」が一目で分かる |
| リスニング | リスニング演習 | 再生ボタン＋設問が見える |

級ごとに撮れると理想ですが、同じ技能でUIが同じなら **代表級のスクショを流用**してもOKです（figcaptionの級名だけ記事に合わせて調整）。

## 記事別ファイル名目安

| ID | 級 | 種類 | ファイル名目安 | 画面 |
|---|---|---|---|---|
| 70 | 5級 | vocab | `aiken-vocab-5kyu.png` | 単語クイズ（級選択が見えるとベター） |
| 72 | 4級 | vocab | `aiken-vocab-4kyu.png` | 単語クイズ（級選択が見えるとベター） |
| 74 | 3級 | vocab | `aiken-vocab-3kyu.png` | 単語クイズ（級選択が見えるとベター） |
| 76 | 準2級 | vocab | `aiken-vocab-jun2kyu.png` | 単語クイズ（級選択が見えるとベター） |
| 78 | 準2級プラス | vocab | `aiken-vocab-jun2kyu-plus.png` | 単語クイズ（級選択が見えるとベター） |
| 80 | 2級 | vocab | `aiken-vocab-2kyu.png` | 単語クイズ（級選択が見えるとベター） |
| 82 | 準1級 | vocab | `aiken-vocab-jun1kyu.png` | 単語クイズ（級選択が見えるとベター） |
| 84 | 1級 | vocab | `aiken-vocab-1kyu.png` | 単語クイズ（級選択が見えるとベター） |
| 157 | 3級 | writing | `aiken-writing-3kyu.png` | ライティング課題＋AI添削結果 |
| 159 | 準2級 | writing | `aiken-writing-jun2kyu.png` | ライティング課題＋AI添削結果 |
| 161 | 準2級プラス | writing | `aiken-writing-jun2kyu-plus.png` | ライティング課題＋AI添削結果 |
| 163 | 2級 | writing | `aiken-writing-2kyu.png` | ライティング課題＋AI添削結果 |
| 165 | 準1級 | writing | `aiken-writing-jun1kyu.png` | ライティング課題＋AI添削結果 |
| 167 | 1級 | writing | `aiken-writing-1kyu.png` | ライティング課題＋AI添削結果 |
| 192 | 5級 | listening | `aiken-listening-5kyu.png` | リスニング問題（再生UI＋設問） |
| 194 | 4級 | listening | `aiken-listening-4kyu.png` | リスニング問題（再生UI＋設問） |
| 196 | 3級 | listening | `aiken-listening-3kyu.png` | リスニング問題（再生UI＋設問） |
| 198 | 準2級 | listening | `aiken-listening-jun2kyu.png` | リスニング問題（再生UI＋設問） |
| 200 | 準2級プラス | listening | `aiken-listening-jun2kyu-plus.png` | リスニング問題（再生UI＋設問） |
| 202 | 2級 | listening | `aiken-listening-2kyu.png` | リスニング問題（再生UI＋設問） |
| 204 | 準1級 | listening | `aiken-listening-jun1kyu.png` | リスニング問題（再生UI＋設問） |
| 206 | 1級 | listening | `aiken-listening-1kyu.png` | リスニング問題（再生UI＋設問） |

## 差し替え手順（WP）

1. メディアにスクショをアップロード
2. 該当記事を編集 → 「【スクショ差し替え】」の画像ブロックを選択
3. 「置換」でアップロード画像を指定
4. alt / キャプションを整える（キャプションの【スクショ差し替え】文言は削除してよい）

## インポート対象

- ファイル: `c:/Users/sugur/Documents/project/aiken.life/docs/blog/imports/投稿-Export-機能紐づけ-単語WL-980円.csv`
- 件数: 22本（単語・ライティング・リスニングのみ更新。他記事は元のまま同梱）
- WP All Import: **Update existing / Match by Post ID**
