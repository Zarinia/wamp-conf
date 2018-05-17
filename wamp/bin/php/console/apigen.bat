@ECHO ON

set path_php=C:\wamp\bin\php\php5.4.45
set path_console=C:\wamp\bin\php\console

%path_php%\php.exe %path_console%\apigen.phar %*
