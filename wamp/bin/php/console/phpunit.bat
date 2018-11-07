@ECHO ON

:: set path_php=d:\wamp\bin\php\php5.4.45
:: set path_php=d:\wamp\bin\php\php7.0.16
set path_php=d:\wamp\bin\php\php7.0.30
set path_console=d:\wamp\bin\php\console

REM %path_php%\php.exe %path_php%\phpunit-4.8.23.phar %*
REM %path_php%\php.exe %path_php%\phpunit-5.2.10.phar %*

:: %~dp0php.exe %~dp0phpunit-3.7.38.phar %*
:: %path_php%\php.exe %path_php%\phpunit-4.8.36.phar %*
:: %path_php%\php.exe %path_php%\phpunit-5.7.25.phar %*
:: call php7.bat "%path_console%\phpunit-6.4.4.phar" %*
%path_php%\php.exe %path_console%\phpunit-6.5.8.phar %*