@ECHO ON

set php_console=d:\wamp\bin\php\console
set path_php=d:\wamp\bin\php\php5.4.45
set path_php=d:\wamp\bin\php\php7.0.30

%path_php%\php.exe %php_console%\php-cs-fixer.phar %*
