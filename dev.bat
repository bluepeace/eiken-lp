@echo off
cd /d "%~dp0"
where php >nul 2>&1
if errorlevel 1 (
    echo PHP が見つかりません。PATH に php を追加するか、PHP をインストールしてください。
    echo https://windows.php.net/download/
    exit /b 1
)
echo http://localhost:8000 で起動します（終了は Ctrl+C）
php -S localhost:8000 router.php
