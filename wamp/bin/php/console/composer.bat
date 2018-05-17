@ECHO ON

set path_composer=C:\wamp\bin\php\console

:: %~dp0php.exe %~dp0composer.phar %*
call php71 "%path_composer%\composer.phar" %*
