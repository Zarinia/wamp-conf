@ECHO ON

REM color 1F

chcp 1252 > nul

set CHEMIN=C:\wamp\bin\apache\apache2.4.17\conf\ssl\ssl-cr
set DIRNAME=site
set PATH_OPENSSL=C:\wamp\bin\OpenSSL-Win32\bin\

REM ----------------------------------------
REM   Chemin et Variables d'environnements  
REM ----------------------------------------

:Top
REM set PATH=%CHEMIN%\bin;%PATH%

set OPENSSL_CONF=.\openssl.cnf

REM ------------------
REM   Certificat SSL  
REM ------------------

:Menu
cls
@echo Certificats SSL
@echo ---------------
@echo.
@echo Chemin     = %CHEMIN%
@echo R�pertoire = %DIRNAME%
@echo.
@echo -------------------------------------------------------   -------------------------------------------------------
@echo     Autorit� de certification (CA)                            Autre
@echo -------------------------------------------------------   -------------------------------------------------------
@echo a : Cr�ation d'un Nombre Pseudo-Al�atoire         (RND)   1 : chemin vers apache 2.2.31
@echo b : Cr�ation de la clef priv�e sans mot de passe  (KEY)   2 : chemin vers apache 2.4.17
@echo c : Cr�ation de la demande de signature           (CSR)
@echo d : Cr�ation du certificat auto-sign�             (CRT)   3 : transfert du certificat vers Apache.
@echo e : Visualisation du certificat                           4 : remise � z�ro du r�pertoire
@echo f : Clef Public                                   (PBC)   9 : fin
@echo.
@echo -------------------------------------------------------   -------------------------------------------------------
@echo     Certificat Serveur
@echo -------------------------------------------------------
@echo m : Cr�ation d'un Nombre Pseudo-Al�atoire         (RND)
@echo n : Cr�ation de la clef priv�e sans mot de passe  (KEY)
@echo o : Cr�ation de la demande de signature           (CSR)
@echo p : Cr�ation du certificat par le CA              (CRT)
@echo q : Conversion certificat PEM vers PFX            (PFX)
@echo r : Visualisation du certificat CLIENT PFX
@echo s : Clef public                                   (PBC)
@echo.
@echo -----------------------------------------------------------------------------------------------------------------
@echo.

set choix=
set /p choix=Votre choix ?

if not '%choix%'=='' set choix=%choix:~0,1%

if '%choix%' == 'a' goto :CaA
if '%choix%' == 'b' goto :CaB
if '%choix%' == 'c' goto :CaC

if '%choix%' == 'd' goto :CaD
if '%choix%' == 'e' goto :CaE
if '%choix%' == 'f' goto :CaF

REM ---------------------------

if '%choix%' == 'm' goto :SrA
if '%choix%' == 'n' goto :SrB
if '%choix%' == 'o' goto :SrC

if '%choix%' == 'p' goto :SrD
if '%choix%' == 'q' goto :SrE
if '%choix%' == 'r' goto :SrF

if '%choix%' == 's' goto :SrG

REM ---------------------------

if '%choix%' == '1' goto :Cas1
if '%choix%' == '2' goto :Cas2
if '%choix%' == '3' goto :Cas3

if '%choix%' == '4' goto :Cas4
if '%choix%' == '9' goto :Cas9

REM --------------------
REM   Aucune s�lection  
REM --------------------

@echo.
@echo Veuillez recommencer !
@echo.
goto :menu

REM **************************************
REM *                                    *
REM *     Authorit� de Certification     *
REM *                                    *
REM **************************************
REM
REM -----------------------------------------
REM   Cr�ation d'un Nombre Pseudo-Al�atoire  
REM -----------------------------------------

:CaA
cls

if EXIST %DIRNAME%\Private\Ca.rnd  del %DIRNAME%\Private\Ca.rnd

%PATH_OPENSSL%openssl rand  -out %DIRNAME%/Private/Ca.rnd  -base64  1257

@echo.
pause 
goto :Menu

REM ------------------------------------------------
REM   Cr�ation d'une clef priv�e sans mot de passe  
REM ------------------------------------------------

:CaB
cls

if EXIST %DIRNAME%\Private\Ca.key  del %DIRNAME%\Private\Ca.key

%PATH_OPENSSL%openssl genrsa  -out %DIRNAME%/Private/Ca.key  -rand %DIRNAME%/Private/Ca.rnd  4096

@echo.
pause 
goto :Menu

REM -----------------------------------------------------
REM   Cr�ation de la demande de signature du certificat  
REM -----------------------------------------------------

:CaC
cls

if EXIST %DIRNAME%\Cacerts\Ca.csr  del %DIRNAME%\Cacerts\Ca.csr

%PATH_OPENSSL%openssl req  -new  -sha256  -key %DIRNAME%/Private/Ca.key  -out %DIRNAME%/Cacerts/Ca.csr -config %OPENSSL_CONF% 
REM -subj "/C=FR/ST=Aquitaine/L=Montignac/O=Artemus & Cie/CN=Artemus & Cie"

@echo.
pause 
goto :Menu

REM ----------------------------------------
REM   Cr�ation du CA certificat auto-sign�  
REM ----------------------------------------

:CaD
cls

if EXIST %DIRNAME%\Cacerts\Ca.crt  del %DIRNAME%\Cacerts\Ca.crt

%PATH_OPENSSL%openssl x509  -req  -days 360  -sha256  -in %DIRNAME%/Cacerts/Ca.csr  -signkey %DIRNAME%/Private/Ca.key  -out %DIRNAME%/Cacerts/Ca.crt

@echo.
pause 
goto :Menu

REM -------------------------------
REM   Visualisation du certificat  
REM -------------------------------

:CaE
cls

%PATH_OPENSSL%openssl x509  -in %DIRNAME%/Cacerts/Ca.crt  -noout  -text

@echo.
pause 
goto :Menu

REM ---------------
REM   Clef Public  
REM ---------------

:CaF
cls

%PATH_OPENSSL%openssl rsa  -in %DIRNAME%/Private/Ca.key  -pubout  -out %DIRNAME%/Private/Ca.pbc
@echo.
pause 
goto :Menu

REM *********************************************
REM *                                           *
REM *     Certificat Serveur Pour Localhost     *
REM *                                           *
REM *********************************************
REM
REM -----------------------------------------
REM   Cr�ation d'un Nombre Pseudo-Al�atoire  
REM -----------------------------------------

:SrA
cls

if EXIST %DIRNAME%\Server\Server.rnd  del %DIRNAME%\Server\Server.rnd

%PATH_OPENSSL%openssl rand  -out %DIRNAME%/Server/Server.rnd  -base64  12357

@echo.
pause 
goto :Menu

REM ------------------------------------------------
REM   Cr�ation d'une clef priv�e sans mot de passe  
REM ------------------------------------------------

:SrB
cls

if EXIST %DIRNAME%\Server\Server.key  del %DIRNAME%\Server\Server.key

%PATH_OPENSSL%openssl genrsa  -out %DIRNAME%/Server/Server.key  -rand %DIRNAME%/Server/Server.rnd  4096

@echo.
pause 
goto :Menu

REM -----------------------------------------------------
REM   Cr�ation de la demande de signature du certificat  
REM -----------------------------------------------------

:SrC
cls

if EXIST %DIRNAME%\Server\Server.csr  del %DIRNAME%\Server\Server.csr

%PATH_OPENSSL%openssl req  -new  -sha256  -key %DIRNAME%/Server/Server.key  -out %DIRNAME%/Server/Server.csr -config %OPENSSL_CONF% 
REM -subj "/C=FR/ST=Aquitaine/L=Montignac/O=Artemus & Cie/CN=Artemus & Cie"

@echo.
pause 
goto :Menu

REM ------------------------------------------
REM   Cr�ation du certificat sign� par le CA  
REM ------------------------------------------

:SrD
cls

if EXIST %DIRNAME%\Server\Server.crt  del %DIRNAME%\Server\Server.crt

%PATH_OPENSSL%openssl x509  -req  -days 360  -sha256  -in %DIRNAME%/Server/Server.csr  -CA %DIRNAME%/Cacerts/Ca.crt  -CAkey %DIRNAME%/Private/Ca.key  -CAcreateserial  -out %DIRNAME%/Server/Server.crt

@echo.
pause 
goto :Menu

REM --------------------------------------
REM   Conversion certificat PEM vers PFX    
REM --------------------------------------

:SrE
cls

if EXIST %DIRNAME%\Server\Server.pfx  del %DIRNAME%\Server\Server.pfx

%PATH_OPENSSL%openssl pkcs12  -export  -in %DIRNAME%/Server/Server.crt  -inkey %DIRNAME%/Server/Server.key  -out %DIRNAME%/Server/Server.pfx  -clcerts  -descert  -name "Client Localhost Certificate"

@echo.
pause 
goto :Menu

REM ------------------------------
REM   Visualisation de la pkcs12  
REM ------------------------------

:SrF
cls

%PATH_OPENSSL%openssl pkcs12  -info  -passout file:./%DIRNAME%/Other/Password.txt  -in %DIRNAME%/Server/Server.pfx

@echo.
pause 
goto :Menu

REM ---------------
REM   Clef Public  
REM ---------------

:SrG
cls

%PATH_OPENSSL%openssl rsa  -in %DIRNAME%/Server/Server.key  -pubout  -out %DIRNAME%/Server/Server.pbc

@echo.
pause 
goto :Menu

REM **********************
REM *                    *
REM *     Autres Cas     *
REM *                    *
REM **********************
REM
REM ----------------------------
REM   Chemin vers Apache2.2.31  
REM ----------------------------

:Cas1

set CHEMIN=f:\Wamp\bin\apache\apache2.2.31

goto :Top

REM ----------------------------
REM   Chemin vers Apache2.4.17  
REM ----------------------------

:Cas2

set CHEMIN=f:\Wamp\bin\apache\apache2.4.17

goto :Top

REM -----------------------------
REM   Transfert des certificats  
REM -----------------------------

:Cas3
cls

set DEST=%CHEMIN%\conf\certificat

if not exist "%DEST%" mkdir %DEST%

@echo.
@echo Copie de l'autorit� de certification
@echo ------------------------------------
@echo.

if EXIST %DEST%\Ca\Ca.crt                 del %DEST%\Ca\Ca.crt

copy /A /Y  %DIRNAME%\Cacerts\Ca.crt      %DEST%\Ca\Ca.crt

@echo.
@echo Copie de la clef priv�e
@echo -----------------------
@echo.

if EXIST %DEST%\Site\Localhost.key        del %DEST%\Site\Localhost.key

copy /A /Y  %DIRNAME%\Server\Server.key   %DEST%\Site\Localhost.key

@echo.
@echo Copie du Certificat
@echo -------------------
@echo.

if EXIST %DEST%\Site\Localhost.crt        del %DEST%\Site\Localhost.crt

copy /A /Y  %DIRNAME%\Server\Server.crt   %DEST%\Site\Localhost.crt

@echo.
pause 
goto :Menu

REM -------------------------------
REM   Remise � z�ro du r�pertoire  
REM -------------------------------

:Cas4
cls

REM rmdir /S /Q %DIRNAME%

mkdir .\%DIRNAME%\Cacerts
mkdir .\%DIRNAME%\Other
mkdir .\%DIRNAME%\Private
mkdir .\%DIRNAME%\Server

copy  nul      .\%DIRNAME%\Other\Index.txt
@echo 4688     > .\%DIRNAME%\Other\Serial.txt
@echo azerty   > .\%DIRNAME%\Other\Password.txt
@echo.
@echo Remise � z�ro du r�pertoire 'Certificats'
@echo.
pause
goto :Top

REM ---------------------
REM   Fin du Traitement  
REM ---------------------

:Cas9

pause
REM exit
