# Apache et VirtualHost SSL avec un wildcard ou multi-site

La configuration d'Apache (1.3, 2.0 ou 2.2) pour faire du SSL avec plusieurs noms de site, que ce soit avec un certificat Wildcard ou multi-site, nécessite une configuration avancée. Cette configuration n'est pas bien décrite dans la doc officielle.

## Ecoute des ports

Il faut indiquer spécifiquement sur quelle adresse IP et port le serveur doit écouter. Et il faut déclarer l'usage du nom virtuel en même temps. Bien sur, nous recommandons d'écrire la même chose dans les 2 instructions. Exemple

`Listen 213.186.35.102:443`

`NameVirtualHost 213.186.35.102:443`

Si vous avez la chance d'être déjà compatible IPv6, faites de même:

`Listen [2001:41D0:1:266::1]:443`

`NameVirtualHost [2001:41D0:1:266::1]:443`

## Déclaration des sites

Sur cette base, vous pouvez déclarer autant de sites que souhaités. Utilisez d'abord la déclaration du virtualhost:

`<VirtualHost 213.186.35.102:443 >`

ou avec l'IPv6

`<VirtualHost 213.186.35.102:443 [2001:41D0:1:266::1]:443 >`

A l'intérieur, placez le mot clef ServerName qui va identifier le nom du site, et éventuellement un ou plusieurs ServerAlias

Enfin, placez les instructions propres à SSL

`SSLEngine on`
`SSLCertificateFile conf/ssl.crt/cert-1138-8747.cer`
`SSLCertificateKeyFile conf/ssl.key/wild.cert.com.2006.key`
`SSLCertificateChainFile  conf/ssl.crt/chain-1138-8747.txt`
`SSLVerifyClient none`

Puis les autres instructions normales d'un VirtualHost.

Vous pouvez alors définir autant de VirtualHost que nécessaire.

Exemple de configuration minimum

`<VirtualHost _default_:443>`

DocumentRoot /var/www/html
ErrorLog logs/ssl-error_log
TransferLog logs/ssl-access_log

SSLEngine on

`# 128-bit mini anti-beast`
`#SSLCipherSuite !EDH:!ADH:!DSS:!RC2:RC4-SHA:RC4-MD5:HIGH:MEDIUM:+AES128:+3DES`
`# 128-bit mini PFS favorisé`
`#SSLCipherSuite !EDH:!ADH:!DSS:!RC2:HIGH:MEDIUM:+3DES:+RC4`
`# 128-bit securité maximale`
`SSLCipherSuite !EDH:!ADH:!DSS:!RC4:HIGH:+3DES`

`SSLProtocol all -SSLv2 -SSLv3`
`SSLHonorCipherSuite on  # apache 2.1+`

SSLCertificateFile conf/ssl/cert-0000000000-12983.cer
SSLCertificateKeyFile conf/ssl/multisite.key
SSLCertificateChainFile conf/ssl/chain-0000000000-12983.txt
</VirtualHost>

`NameVirtualHost *:443`

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

