@ECHO ON

set "path_composer=d:\wamp\bin\php\console"
set "php_memory_limit=-d memory_limit=2G"
set "php_memory_limit=-d memory_limit=-1"
REM set "php_memory_limit="
set "php_exe=php72"
set "php_exe=php72x64"

:: %~dp0php.exe %~dp0composer.phar %*
:: https://getcomposer.org/doc/articles/troubleshooting.md#memory-limit-errors
call %php_exe% -r "echo 'memory_limit='.ini_get('memory_limit').PHP_EOL;"
:: COMPOSER_MEMORY_LIMIT=-1
call %php_exe% %php_memory_limit% "%path_composer%\composer.phar" %*
