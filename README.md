# AiKen LP（ランディングページ）

英検対策アプリ **AiKen** の公式ランディングページ用リポジトリです。  
ドメイン **aiken.life** で公開し、アプリ本体（**app.aiken.life**）への導線として使います。

**構成の詳細メモ** → [docs/構成メモ.md](docs/構成メモ.md)

## 技術構成

- **PHP** で共通部品（ヘッダー・フッター・各セクション）を `include` し、メンテナンスしやすく構成
- **Tailwind CSS（CDN）** で既存TOPのデザインを再現（ビルド不要）
- **SEO**: canonical・meta description・OGP・JSON-LD（WebApplication）を `config.php` と `includes/head.php` で一元管理

## ページ一覧

| URL | 説明 |
|-----|------|
| `/` | TOP（総合） |
| `/about` | AiKenとは（初訪問者向け）※実体は `about.php`（Rewrite） |
| `/faq` | よくあるご質問（カテゴリ別）※実体は `faq.php` |
| `/terms` | 利用規約 |
| `/privacy` | プライバシーポリシー |
| `/tokushoho` | 特定商取引法に基づく表記（noindex） |
| `/1kyu/` | 英検1級＋AI対策 |
| `/jun1kyu/` | 英検準1級＋AI対策 |
| `/2kyu/` | 英検2級＋AI対策 |
| `/jun2kyu/` | 英検準2級＋AI対策 |
| `/3kyu/` | 英検3級＋AI対策 |
| `/4kyu/` | 英検4級＋AI対策 |
| `/5kyu/` | 英検5級＋AI対策 |

`/about`・`/faq`・`/terms`・`/privacy`・`/tokushoho` のメタは `config.php` の `$PAGE_META` で管理しています。フッター著作権は **Bluepiece Lab.** → `BLUEPIECE_LAB_URL`（`https://bluepiece.me/link`）。  
各級ページのタイトル・description は `config.php` の `$GRADES` で管理しています。

**本番アップロード:** `about.php` と `faq.php` は**本文をファイル内に直書き**してあり、`includes/sections/about_content.php` などの追加ファイルは不要です（FTP で1本だけ上げても本文まで反映されます）。共通の `header.php` / `cta.php` / `footer.php` は従来どおり `includes/` 側を更新してください。

## サイトマップ・robots

- **`sitemap.php`** … `SITE_URL`・`/about`・`/faq`・`/terms`・`/privacy`・`/blog/`・級別 URL などを出力（`/tokushoho` は除外）。本番では **`https://aiken.life/sitemap.xml`** で配信（`.htaccess` の Rewrite）。
- **`robots.txt`** … `Sitemap:` に上記 URL を記載。ステージング用ドメインでは `robots.txt` の1行を書き換えてください。
- ローカル: `http://localhost:8000/sitemap.xml`（`router.php` 使用時）。

`/plan` はページ未作成のためサイトマップに含めていません。公開後は `sitemap.php` の `$entries` に追加してください。

`/tokushoho`（特定商取引法）は **`noindex, follow`**（`meta` + `X-Robots-Tag`）かつ**サイトマップ未掲載**です。本文は [app.aiken.life/tokushoho](https://app.aiken.life/tokushoho) と同趣旨で掲載しています。

## ディレクトリ構成

```
eiken-lp/
├── config.php              # サイト名・URL・$GRADES・メタ情報
├── index.php               # TOP ページ
├── grade.php               # 級別入り口（?level=1kyu など）
├── .htaccess               # Rewrite: /1kyu/ → grade.php?level=1kyu
├── includes/
│   ├── head.php            # <head>（級ページ時は get_grade_meta でメタ出力）
│   ├── header.php
│   ├── footer.php
│   ├── structured-data.php
│   └── sections/
│       ├── hero.php
│       ├── problems.php
│       ├── features.php
│       ├── grade_links.php # TOP用：級別ページへのリンク一覧
│       ├── grade_hero.php  # 級ページ用
│       ├── grade_features.php
│       ├── grade_cta.php
│       ├── target.php
│       ├── howto.php
│       ├── faq.php
│       └── cta.php
├── assets/
│   ├── css/style.css
│   └── images/logo-aiken.png
└── README.md
```

## ローカルで確認

PHP が入っている環境で、プロジェクトルートで次のいずれかを実行します。

**Windows（ダブルクリック or ターミナル）**

```bat
dev.bat
```

**PowerShell**

```powershell
.\dev.ps1
```

**手動（macOS / Linux / 共通）**

```bash
cd eiken-lp
php -S localhost:8000 router.php
```

ブラウザで **http://localhost:8000** を開く。

- `router.php` により、組み込みサーバーでも **級ページ**（`/1kyu/` など）がそのまま動きます。
- `router.php` を付けずに `php -S localhost:8000` だけだと `.htaccess` が効かないため、級ページは `http://localhost:8000/grade.php?level=1kyu` のように指定してください。

Cursor / VS Code では **タスク「PHP: localhost:8000 (AiKen LP)」** からも起動できます。

## ロゴ画像

`eiken-app/public/logo-aiken.png` を `assets/images/logo-aiken.png` にコピーしてください。

## 級ページの追加・修正

- **文言の変更**: `config.php` の `$GRADES` の該当キーで `name`・`name_short`・`description` を編集
- **新規の級を追加する場合**: `$GRADES` にキー（URLスラッグ）と配列を追加し、`.htaccess` の `RewriteRule` の括弧内にスラッグを追加（例: `|newkyu`）

## その他ページを増やす場合

1. `config.php` の `$PAGE_META` にキーを追加
2. 新しい `○○.php` をルートに作成し、`$page = '○○'` を設定して `includes/header.php` と必要な `sections/*.php` を include
3. セクションの追加・差し替えは `includes/sections/` にファイルを追加し、該当ページの PHP から include

## 運用

- **aiken.life** はレンサバや静的ホスティングで運用する想定です
- ログイン・会員登録リンクはすべて **app.aiken.life**（`config.php` の `APP_URL`）に向けています
