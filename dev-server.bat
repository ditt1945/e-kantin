@echo off
echo ========================================
echo   e-Kantin - Development Server
echo ========================================
echo.

cd /d %~dp0

echo Starting Laravel development server...
echo URL: http://localhost:8000
echo.
echo Untuk akses dari HP:
echo 1. Cloudflare Tunnel: .\start-with-tunnel.bat
echo 2. Ngrok: .\start-with-ngrok.bat
echo.

php artisan serve --host=127.0.0.1 --port=8000