# Apache et VirtualHost SSL avec un wildcard ou multi-site

La configuration d'Apache (1.3, 2.0 ou 2.2) pour faire du SSL avec plusieurs noms de site, que ce soit avec un certificat Wildcard ou multi-site, nécessite une configuration avancée. Cette configuration n'est pas bien décrite dans la doc officielle.

## Ecoute des ports

Il faut indiquer spécifiquement sur quelle adresse IP et port le serveur doit écouter. Et il faut déclarer l'usage du nom virtuel en même temps. Bien sur, nous recommandons d'écrire la même chose dans les 2 instructions. 

Exemple

```
Listen 213.186.35.102:443
NameVirtualHost 213.186.35.102:443
```

Si vous avez la chance d'être déjà compatible IPv6, faites de même:

```
Listen [2001:41D0:1:266::1]:443
NameVirtualHost [2001:41D0:1:266::1]:443
```

## Déclaration des sites

Sur cette base, vous pouvez déclarer autant de sites que souhaités. Utilisez d'abord la déclaration du virtualhost:

```
<VirtualHost 213.186.35.102:443>
```

ou avec l'IPv6

```
<VirtualHost 213.186.35.102:443 [2001:41D0:1:266::1]:443>
```

A l'intérieur, placez le mot clef ServerName qui va identifier le nom du site, et éventuellement un ou plusieurs ServerAlias.

Enfin, placez les instructions propres à SSL:

```
SSLEngine on
SSLCertificateFile conf/ssl.crt/cert-1138-8747.cer
SSLCertificateKeyFile conf/ssl.key/wild.cert.com.2006.key
SSLCertificateChainFile  conf/ssl.crt/chain-1138-8747.txt
SSLVerifyClient none
```

Puis les autres instructions normales d'un VirtualHost.

Vous pouvez alors définir autant de VirtualHost que nécessaire.

Exemple de configuration minimum:

```
<VirtualHost _default_:443>

DocumentRoot /var/www/html
ErrorLog logs/ssl-error_log
TransferLog logs/ssl-access_log

SSLEngine on

# 128-bit mini anti-beast
# SSLCipherSuite !EDH:!ADH:!DSS:!RC2:RC4-SHA:RC4-MD5:HIGH:MEDIUM:+AES128:+3DES
# 128-bit mini PFS favorisé
# SSLCipherSuite !EDH:!ADH:!DSS:!RC2:HIGH:MEDIUM:+3DES:+RC4
# 128-bit securité maximale
SSLCipherSuite !EDH:!ADH:!DSS:!RC4:HIGH:+3DES

SSLProtocol all -SSLv2 -SSLv3
SSLHonorCipherSuite on  # apache 2.1+

SSLCertificateFile conf/ssl/cert-0000000000-12983.cer
SSLCertificateKeyFile conf/ssl/multisite.key
SSLCertificateChainFile conf/ssl/chain-0000000000-12983.txt
</VirtualHost>


NameVirtualHost *:443

<VirtualHost *:443>

DocumentRoot /home/site1/public_html
ServerName gestion.site1.fr
ServerAlias v8.site1.fr cyber.site1.fr
</VirtualHost>


<VirtualHost *:443>

DocumentRoot /home/site2/public_html
ServerName gestcom.site2.fr
ServerAlias commercial.site2.fr,prospect.site2.fr
</VirtualHost>
```

# Installer OpenSSL sur un poste windows

Pour effectuer certaines opérations de cryptographie (création d'une clef privée, génération d'un CSR, conversion d'un certificat...) sur un poste windows nous pouvons utiliser l'outil OpenSSL.

* Accéder au site officiel : http://www.openssl.org/
Puis télécharger le programme "binaire" pour Windows : `> related > Binaries` :
https://www.openssl.org/community/binaries.html

* Pour les opérations standards de cryptographie liées aux certificats, la version "Lite" suffira à nos besoins. Pour certaines versions de systèmes Windows (Windows 2000, windows XP...), il vous faudra aussi installer "Visual C++ 2008 Redistributables".

## Utiliser OpenSSL sur un poste Windows

L'installation standard d'OpenSSL sur un poste Windows est effectuée sur `"C:\OpenSSL-Win32"` et l'exécutable est situé dans le sous répertoire `"bin"`. Ainsi pour exécuter le programme dans "l'invite de commandes" Windows il vous faudra donner le chemin complet :
```
>C:\OpenSSL-Win32\bin\openssl.exe ( ou >C:\OpenSSL-Win64\bin\openssl.exe )
```

### a) Fichier de configuration par défaut : `openssl.cnf`

- La version 1.0 d'openSSL en téléchargement nécessite la présence d'un fichier de configuration `"openssl.cnf"`. Le répertoire `/usr/local/openssl` n'étant pas présent sur les postes Windows.
* a.1) Vous pouvez télécharger ce fichier d'exemple `openssl-dem-server-cert-thvs.cnf` et l'enregistrer dans le dossier `>C:\OpenSSL-Win32\ ( ou >C:\OpenSSL-Win64\ )` en le renommant `"openssl.cnf"`

* a.2) Saisissez cette commande :
```
set OPENSSL_CONF=c:\OpenSSL-Win32\openssl.cnf 
```
ou
```
set OPENSSL_CONF=c:\OpenSSL-Win64\openssl.cnf 
```

N.B.: Pour executer cette commande sur Windows vous devez être connecté avec une session ayant les droits d'administration.

- Pour le postes ayant installés Apache, vous pouvez utiliser cette option :
```
-config "C:\Program Files\Apache Software Foundation\Apache2.2\conf\openssl.cnf"
```
Si vous continuer à rencontrer l'erreur :

WARNING: can't open config file: `/usr/local/ssl/openssl.cnf`
openssl:Error: '-config' is an invalid command.

Exécutez au préalable la commande suivante : 
```
set OPENSSL_CONF=C:\Program Files\Apache Software Foundation\Apache2.2\conf\openssl.cnf
```

- Pour la version `"OpenSSL v0.9.8t Light"` nulle besoin de la présence du fichier opens.cnf, une configuration par défaut sera alors prise en compte.

### b) Générer la clef privée (.key) et le CSR (Certificate Signing Request - Demande de certificat)

Dans le cadre de l'obtention (ou d'un renouvellement ou d'une re-fabrication) d'un certificat, vous allez devoir générer une clef privée et le CSR associé. Pour effectuer cela nous vous conseillons d'utiliser notre assistant en ligne pour exécuter la bonne commande OpenSSL avec les paramètres adéquats.

Exemple de la ligne de commande à executer :
```
>C:\OpenSSL-Win32\bin\openssl.exe req -new -newkey rsa:2048 -nodes -out www.monsite.fr.csr -keyout www.monsite.fr.key -subj "/C=FR/ST=Calvados/L=CAEN/O=Mon organisation/CN=www.mon-site.fr"
```

Gardez en sécurité et sauvegardez le fichier contenant la clef privée .key, et copiez / collez seulement le contenue du fichier .csr dans le formulaire de commande.

Problèmes rencontrés sur Windows lors de la génération d'un CSR en une commande

Selon la version d'OpenSSL installée ou la méthode d'installation sur le poste Windows, il arrive parfois que l'on rencontre des messages d'erreur du type :

config ou req n'est pas reconnu comme commande interne ou externe 
Vérifiez bien la syntaxe, les guillemets lors de l’exécution de votre commande.

Unable to load config info from /usr/local/ssl/openssl.cnf 
La version OpenSSL s'appuie ici sur une arborescence par défaut de monde linux.
Solution : exécuter des commandes simplifiées :

Rappel: 
- Pour lancer l'invite de commande, aller dans le menu démarrer, puis exécuter "cmd". 
- Pour coller les lignes de commandes suivantes dans "l'invite de commande dos" faites un clique droit de votre souris puis choisissez "coller". 
- Pour se positionner dans le répertoire où est installé le programme OpenSSL exécutez ceci

```
cd c:\
cd OpenSSL (ou cd OpenSSL-Win32)
cd bin
```

On génère la clef privée avec la commande suivante en définissant un nom de fichier qui vous correspond :
```
C:\OpenSSL\bin\openssl.exe genrsa 2048 > fichier-site.key
```

puis utilisez cette commande pour générer le CSR :
```
C:\OpenSSL\bin\openssl.exe req -new -key fichier-site.key > fichier-site.csr
```

ou cette commande :
```
C:\OpenSSL\bin\openssl.exe req -new -key fichier-site.key -config "C:\OpenSSL\openssl.cnf" -out fichier-site.csr
```
Sur certaines plateformes, le fichier openssl.cnf qu'OpenSSL lit par défaut pour créer le CSR n'est pas bon ou inexistant. Dans ce cas vous pouvez télécharger le notre et le placer, par exemple, dans `C:\OpenSSL\openssl.cnf` :

Pour les certificats serveur Symantec ou Thawte: `openssl-dem-server-cert-thvs.cnf`

Pour les certificats serveur TBS X509 ou Comodo: `openssl-dem-server-cert.cnf`

Le système va vous demander de saisir des champs ; remplissez-les en respectant les instructions (plus d'info sur Obtenir un certificat serveur) 

```
Country Name (2 letter code) []: (le plus souvent FR)
State or Province Name (full name) [Some-State]: (le nom de votre département en toutes lettres)
Locality Name (eg, city) []: (le nom de votre ville)
Organization Name (eg, company) []: (le nom de votre organisation)
Organizational Unit Name (eg, section) []: (laisser vide -recommandé - ou entrer un terme générique comme "Service Informatique")
Common Name (eg, YOUR name) []: (le nom du site a sécuriser)
Email Address []: (ne rien mettre, laisser vide)
```

Pour les champs suivants laissez les vide, ils sont optionnels.

Ainsi vous obtenez 2 fichiers fichier-site.key et fichier-site.csr. Gardez précieusement de manière sécurisée le fichier de clef privée (fichier-site.key), puis copiez / collez le contenu du fichier-site.csr dans le formulaire de commande chez tbs-Internet.

Attention : Ne jamais nous transmettre ou à un tiers la clef privée ( fichier-site.key ) sinon la sécurité de votre site peut ne plus être assurée.
