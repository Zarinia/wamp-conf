@ECHO ON

set php_console=C:\wamp\bin\php\console
set path_php=C:\wamp\bin\php\php5.4.45
set path_php=C:\wamp\bin\php\php7.0.30

%path_php%\php.exe %php_console%\php-cs-fixer.phar %*
