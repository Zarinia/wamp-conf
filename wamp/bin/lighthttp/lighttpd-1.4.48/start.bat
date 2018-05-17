@ECHO ON

:: https://redmine.lighttpd.net/projects/lighttpd/wiki


if "%1" == "verify" (lighttpd -t -f "config\lighttpd.conf")

if "%1" == "start" (lighttpd)

if "%1" == "stop" (taskkill /f /IM lighttpd.exe)









