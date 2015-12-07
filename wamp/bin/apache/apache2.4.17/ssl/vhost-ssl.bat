@ECHO ON

if not "%1" == "" (
set hostname=%1
) else (
set hostname=server
)

set path_openssl=C:\wamp\bin\OpenSSL-Win32\bin

REM default password "azerty"

"%path_openssl%\openssl.exe" genrsa -aes256 -out %hostname%.key 2048

copy %hostname%.key %hostname%.key.backup

"%path_openssl%\openssl.exe" rsa -in %hostname%.key -out %hostname%.key

"%path_openssl%\openssl.exe" req -new -x509 -nodes -sha1 -key %hostname%.key -out %hostname%.crt -days 360 -config "c:\wamp\bin\apache\apache2.4.17\conf\openssl.cnf"

dir %hostname%.*

:: copy %hostname%.* c:\wamp\bin\apache\apache2.4.17\conf\ssl
