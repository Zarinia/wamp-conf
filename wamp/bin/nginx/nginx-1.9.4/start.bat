@ECHO ON

set php_path=c:\wamp\bin\php
set php_version=php5.4.45
set host=127.0.0.1

start nginx.exe
start "PHP FastCGI" "%php_path%\%php_version%\php-cgi.exe" -b "%host%:9000" -c "%php_path%\%php_version%\php.ini"
ping "%host%" -n 1 >NUL
echo Starting nginx
echo .
echo ..
echo ...
ping "%host%" >NUL

:: EXIT
pause