"""
メディア向け素材（/media からダウンロードする ZIP）を作り直す。

使い方（リポジトリのルートで）:
    python scripts/build-media-kit.py

画像を差し替えたら実行して、できた assets/media-kit/aiken-media-kit.zip もコミットする。
ZIP 内のファイル名は、Windows で文字化けしないよう英数字にしている。
"""
from __future__ import annotations

import io
import zipfile
from pathlib import Path

from PIL import Image

ROOT = Path(__file__).resolve().parent.parent
IMG = ROOT / "assets" / "images"
OUT = ROOT / "assets" / "media-kit" / "aiken-media-kit.zip"
TOP = "aiken-media-kit"

# (ZIP 内のフォルダ, 元ファイル, ZIP 内のファイル名)
FILES: list[tuple[str, Path, str]] = [
    ("01_logo", IMG / "logo-aiken.png", "aiken-logo.png"),
]
for name in ["home", "skills", "vocabulary", "reading-setup", "reading", "listening",
             "writing-setup", "writing", "speaking", "profile"]:
    FILES.append(("02_screens_smartphone", IMG / "app" / "phone" / f"{name}.png", f"{name}.png"))
for name in ["home", "vocabulary", "vocabulary-history", "reading", "listening", "writing", "speaking"]:
    FILES.append(("03_screens_tablet", IMG / "app" / "tablet" / f"{name}.jpg", f"{name}.jpg"))
for name in ["overview", "skills", "library", "reading", "listening", "writing", "speaking", "profile"]:
    FILES.append(("04_store_images", IMG / "app" / "store" / f"{name}.png", f"{name}.png"))
FILES += [
    ("05_ai_scoring", IMG / "grade" / "2kyu" / "writing-3.webp", "writing-result_grade2.png"),
    ("05_ai_scoring", IMG / "grade" / "3kyu" / "speaking-3.png", "speaking_grade3.png"),
]
for slug in ["mame", "choco", "koro", "moko", "marron", "shiro", "tia", "luke", "sora", "jin"]:
    FILES.append(("06_buddies", IMG / "buddies" / f"{slug}.png", f"{slug}.png"))

README = """AiKen（アイケン）メディア向け素材
====================================

英検対策アプリ AiKen の紹介用素材です。

01_logo                 ロゴ
02_screens_smartphone   スマートフォンのアプリ画面
03_screens_tablet       タブレット（幅の広い画面）のアプリ画面
04_store_images         App Store / Google Play に掲載している紹介画像
05_ai_scoring           AI添削（英検2級ライティング）とスピーキング（英検3級）の画面
06_buddies              バディ10匹（マメ、チョコ、コロ、モコ、マロン、シロ、ティア、ルーク、ソラ、ジン）

・画面はすべて実際のアプリの画面です。
・画面に写っている名前、日付、学習記録はサンプルです。
・AI添削の点数は1つの答案の結果で、平均点や合格の目安ではありません。
・料金が写った画面は含めていません。最新の料金は https://aiken.life/plan をご覧ください。

サービスの基本情報: https://aiken.life/media
ご紹介資料（PDF）: https://aiken.life/assets/media-kit/aiken-media-guide.pdf
お問い合わせ: info@aiken.life ／ https://aiken.life/contact
運営: Bluepiece Lab.
"""


def png_bytes(path: Path) -> bytes:
    """webp など、受け取る側で開けないことがある形式は PNG にする。"""
    buf = io.BytesIO()
    with Image.open(path) as im:
        im.save(buf, format="PNG", optimize=True)
    return buf.getvalue()


def main() -> None:
    OUT.parent.mkdir(parents=True, exist_ok=True)
    with zipfile.ZipFile(OUT, "w", compression=zipfile.ZIP_DEFLATED) as z:
        z.writestr(f"{TOP}/README.txt", "﻿" + README.replace("\n", "\r\n"))
        for folder, src, name in FILES:
            arc = f"{TOP}/{folder}/{name}" if folder else f"{TOP}/{name}"
            if src.suffix.lower() == ".webp":
                z.writestr(arc, png_bytes(src))
            else:
                z.write(src, arc)
    print(f"{OUT.relative_to(ROOT)}  {OUT.stat().st_size / 1024 / 1024:.1f}MB  {len(FILES)} files")


if __name__ == "__main__":
    main()
