@echo off
title BoliviaTravel Cloud - Servidor Local
echo ============================================
echo   BoliviaTravel Cloud - Iniciando servidor
echo ============================================
echo.

cd /d "%~dp0"

:: Verificar MySQL Laragon
tasklist /FI "IMAGENAME eq mysqld.exe" 2>NUL | find /I "mysqld.exe" >NUL
if errorlevel 1 (
    echo [INFO] Iniciando MySQL de Laragon...
    start "" /B "C:\laragon\bin\mysql\mysql-8.0.30-winx64\bin\mysqld.exe" --defaults-file="C:\laragon\bin\mysql\mysql-8.0.30-winx64\my.ini"
    timeout /t 5 /nobreak >NUL
)

echo [INFO] Servidor disponible en: http://127.0.0.1:8000
echo.
echo   Cuentas demo:
echo   - admin@andesexplorer.bo / password
echo   - contacto@amazoniaverde.bo / password
echo   - info@valleencantado.bo / password
echo.
echo   Presiona Ctrl+C para detener el servidor.
echo ============================================
echo.

php artisan serve --host=127.0.0.1 --port=8000
