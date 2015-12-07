@ECHO ON

nginx.exe -s stop
taskkill /f /IM nginx.exe
taskkill /f /IM php-cgi.exe

:: EXIT
pause