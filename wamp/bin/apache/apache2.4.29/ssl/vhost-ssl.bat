@ECHO ON

if not "%1" == "" (
set hostname=%1
) else (
set hostname=server
)

set opensslcnf=c:\wamp\bin\apache\apache2.4.26\conf\openssl.cnf
set path_openssl=C:\wamp\bin\OpenSSL-Win32\bin

REM default password "azerty"

REM Create the OpenSSL Private Key and CSR with OpenSSL
REM for multiple SANs (Subject Alternative Names) into your CSR with OpenSSL
"%path_openssl%\openssl.exe" genrsa -aes256 -out "%hostname%.key" 4096

"%path_openssl%\openssl.exe" req -new -out "%hostname%.csr" -key "%hostname%.key" -config "%opensslcnf%"

REM Check multiple SANs in your CSR with OpenSSL
"%path_openssl%\openssl.exe" req -text -noout -in "%hostname%.csr"
pause
"%path_openssl%\openssl.exe" x509 -text -noout -in "%hostname%.key"
pause

copy "%hostname%.key" "%hostname%.key.original"

"%path_openssl%\openssl.exe" rsa -in "%hostname%.key" -out "%hostname%.key"

"%path_openssl%\openssl.exe" req -new -x509 -nodes -sha256 -key "%hostname%.key" -out "%hostname%.crt" -days 360 -config "%opensslcnf%"

"%path_openssl%\openssl.exe" pkcs12 -export -in "%hostname%.crt" -inkey "%hostname%.key" -out "%hostname%.p12"

dir "%hostname%.*"

:: copy "%hostname%.*" c:\wamp\bin\apache\apache2.4.18\conf\ssl
