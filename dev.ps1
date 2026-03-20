Set-Location $PSScriptRoot
if (-not (Get-Command php -ErrorAction SilentlyContinue)) {
    Write-Error "PHP が見つかりません。PATH に php を追加するか、PHP をインストールしてください。 https://windows.php.net/download/"
    exit 1
}
Write-Host "http://localhost:8000 で起動します（終了は Ctrl+C）"
php -S localhost:8000 router.php
