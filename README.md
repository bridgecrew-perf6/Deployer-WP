# WI - WordPress install

WI est un installateur WordPress.


## Installation

Avant, vous devez ajouter les plugins nécessaires au fichier composer.jspon. Vous pouvez trouver les dépendances sur le site [WPackagist](https://wpackagist.org/). Choisissez la version de votre plugin.

> :warning: **Si vous ne trouvez pas votre plugin sur WPackagist, veuillez l'ajouter dans les exceptions.**

Veuillez entrer la commande suivante pour installer vos paquets :

```bash
composer install
```

Vos plugins et WordPress sont installés. Dupliquer le fichier wp-config-sample.php en wp-config.php.

Changer le WP_CONTENT_URL avec votre url :

```bash
define ('WP_CONTENT_URL', 'replace_url' . '/wp-content' );

```

## Config

Dans le back-office de Wordpress, changer 'WordPress Address (URL)' qui est dans les paramètres et ajouter à la fin '/public'.

```bash
http://yoururl.local/public
```
