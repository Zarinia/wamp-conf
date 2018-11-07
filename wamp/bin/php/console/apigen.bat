@ECHO ON

set path_php=d:\wamp\bin\php\php5.4.45
set path_console=d:\wamp\bin\php\console

%path_php%\php.exe %path_console%\apigen.phar %*
