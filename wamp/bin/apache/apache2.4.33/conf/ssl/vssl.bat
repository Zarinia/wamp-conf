@ECHO ON

if not "%1" == "" (
set hostname=%1
) else (
set hostname=server
)

set path_openssl=C:\wamp\bin\OpenSSL-Win32\bin

:: Création du certificat serveur
:: Génération de la clé privée
"%path_openssl%\openssl.exe" genrsa 1024 -out servwiki.key
type servwiki.key
:: A partir de votre clé, vous allez maintenant créer un fichier de demande de signature de certificat (CSR Certificate Signing Request).
"%path_openssl%\openssl.exe" req -new -key servwiki.key -out servwiki.csr
type servwiki.csr

:: Création du certificat de l'autorité de certification
"%path_openssl%\openssl.exe" genrsa -des3 1024 -out ca.key
type ca.key
:: Ensuite, à partir de la clé privée, on crée un certificat x509 pour une durée de validité d'un an auto-signé :
"%path_openssl%\openssl.exe" req -new -x509 -days 365 -key ca.key -out ca.crt
type ca.crt

"%path_openssl%\openssl.exe" x509 -req -in servwiki.csr -out servwiki.crt -CA ca.crt -CAkey ca.key -CAcreateserial -CAserial ca.srl
type servwiki.crt

