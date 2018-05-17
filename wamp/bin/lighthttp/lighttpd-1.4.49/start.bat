@ECHO ON

set php_path=c:\wamp\bin\php
set php_version=php5.4.45
set php_version=php5.5.38
set host=127.0.0.1

:: https://redmine.lighttpd.net/projects/lighttpd/wiki


if "%1" == "verify" (lighttpd -t -f "config\lighttpd.conf")

if "%1" == "start" (
start "PHP FastCGI" "%php_path%\%php_version%\php-cgi.exe" -b "%host%:9000" -c "%php_path%\%php_version%\php.ini"
lighttpd
)

if "%1" == "stop" (taskkill /f /IM lighttpd.exe)









