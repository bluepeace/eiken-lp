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
| `/1kyu/` | 英検1級＋AI対策 |
| `/jun1kyu/` | 英検準1級＋AI対策 |
| `/2kyu/` | 英検2級＋AI対策 |
| `/jun2kyu/` | 英検準2級＋AI対策 |
| `/3kyu/` | 英検3級＋AI対策 |
| `/4kyu/` | 英検4級＋AI対策 |
| `/5kyu/` | 英検5級＋AI対策 |

各級ページのタイトル・description は `config.php` の `$GRADES` で管理しています。

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

PHP が入っている環境で:

```bash
cd eiken-lp
php -S localhost:8080
```

ブラウザで `http://localhost:8080` を開く。  
級ページは **Rewrite が効かない環境**（PHP 組み込みサーバーなど）では `http://localhost:8080/grade.php?level=1kyu` のように `?level=` で指定して確認できます。

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
