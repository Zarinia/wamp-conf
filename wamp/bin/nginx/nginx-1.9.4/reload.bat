@ECHO ON

nginx.exe -t
nginx.exe -s reload

:: EXIT
pause