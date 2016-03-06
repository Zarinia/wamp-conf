@ECHO ON

echo Checks the configuration for correct syntax
nginx.exe -t

echo Configuration, start the new worker process with a new configuration
nginx.exe -s reload

echo Print nginx version
nginx.exe -v
::echo Print nginx version, compiler version, and configure parameters
::nginx.exe -V

::EXIT
pause
