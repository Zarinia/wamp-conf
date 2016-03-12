# NGINX rewrite for CakePHP
TUESDAY, JUNE 19TH, 2012	CAKEPHP, NGINX, PHP

This weekend, I wanted to change my web server from Apache to NGINX. The installation was easy, like the basic configuration, but I had a “little big” problem with CakePHP… Nothing was being displayed on my screen, or a 500 error was being shown. What should I do now?

Both CakePHP and WordPress were designed to work with Apache, because they come with some .htaccess for us. My challenge was exactly that! Rewriting the CakePHP .htaccess to do NGINX start working like Apache was working.

Opening the .htaccess from CakePHP’s root dir, we have:

```
RewriteEngine on
RewriteRule    ^$   app/webroot/    [L]
RewriteRule    (.*) app/webroot/$1  [L]
```

Opening the .htaccess at /app:

```
RewriteEngine on
RewriteRule    ^$    webroot/    [L]
RewriteRule    (.*)  webroot/$1  [L]
```

And finally, the .htaccess from /app/webroot:

```
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.*)$ index.php?/$1 [QSA,L]
```

Observing these rules, the logic that I understood was: ROOT DIRECTS TO APP, THAT DIRECTS TO WEBROOT, THAT TREATS THE URL. Then I wrote a rule so that NGINX could do the same thing. Remembering that my CakePHP project was inside a subdir at the root of my web server, so if the root was public_html, my project was a subdir inside public_html. Suppose it’s name is foobar, the rule stayed like this:

```
location /foobar {
    rewrite ^/foobar/(.*)$ /foobar/app/webroot/$1 break;
    try_files $uri $uri/ /foobar/app/webroot/index.php?q=$uri&amp;$args;
}
```

If anyone knows any better way, share it on comments… I recommend the reading of this link: http://wiki.nginx.org/Pitfalls

from: https://blog.heitorsilva.com/en/php/rewrite-do-nginx-para-cakephp/





