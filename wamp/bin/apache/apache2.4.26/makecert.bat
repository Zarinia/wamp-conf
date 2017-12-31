@echo off

set SITE_NAME=server
if not "%1" == "" set SITE_NAME=%1

set OPENSSL_CONF=.\conf\openssl.cnf

if not exist .\conf\ssl.crt mkdir .\conf\ssl.crt
if not exist .\conf\ssl.key mkdir .\conf\ssl.key

.\bin\openssl.exe req -new -out %SITE_NAME%.csr
.\bin\openssl.exe rsa -in privkey.pem -out %SITE_NAME%.key
.\bin\openssl.exe x509 -in %SITE_NAME%.csr -out %SITE_NAME%.crt -req -signkey %SITE_NAME%.key -days 365

set OPENSSL_CONF=
del .rnd
REM del privkey.pem
REM del %SITE_NAME%.csr

move /y %SITE_NAME%.crt .\conf\ssl.crt
move /y %SITE_NAME%.key .\conf\ssl.key

set SITE_NAME=

echo.
echo -----
echo Das Zertifikat wurde erstellt.
echo The certificate was provided.
echo Le certificat a ete fourni.
echo.
pause
