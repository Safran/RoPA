# Registre des activités de traitement

*Lire dans d'autres langues : [Anglais](README.md), [Français](README.fr.md).*

Le registre des activités de traitement est un outil distribué librement par [Safran](https://www.safran-group.com/) afin de réaliser les analyses de conformité avec la réglementation en matière de protection des données personnelles. Cette application se déploie sur un serveur afin d’en donner l’accès via un navigateur web.

Avantages de l'outil : 
- contient le questionnaire du [registre PME](https://www.cnil.fr/fr/rgpd-et-tpepme-un-nouveau-modele-de-registre-plus-simple-et-plus-didactique) de la CNIL ;
- gestion des questions de l'analyse (création, modification, suppression) ;
- workflow de validation ;
- 3 rôles : 
	- administrateur qui gère les questions et les utilisateurs ;
	- DPO qui gère les analyses ;
	- salarié qui renseigne des analyses.
- adaptable à toute taille de structure (gestion multi-sociétés des traitements) ;
- possibilité de créer des modèles d'analyses.

## Pour commencer

### Pré-requis

Apache 2.4+  
PHP 7.1.3+  
Node.js 6.14.x  
npm 3.10.10  
Mysql 5.5.x  
Composer

#### Configuration PHP
- safe mode : disabled
- register_globals : off
- session.nocache_limiter : nocache
- session.auto_start : 0
- magic_quotes_gpc: off
- memory_limit = 3000M
- upload_max_filesize = 128M
- post_max_size = 128M
- max_execution_time = 120s
- date.timezone = "Europe/Paris"

#### Extensions PHP
MySQLi, Zlib compression functions, DOM functions, Session support, PCRE functions, PHP-CLI, Curl, Multibyte string functions, Exif functions, GD, SOAP, LDAP, Memcache, OpenSSL, PDO, Tokenizer, XML, JSON, CType

#### Configuration Apache
Le DocumentRoot doit pointer vers le dossier RoPA/public.  
Le répertoire RoPA doit être défini sur AllowOverride All.

#### Modules Apache
php_module, rewrite, headers, deflate, expires.

#### MySQL
La variable max_allowed_packet de MySQL doit être à 512M.

### Installation

Récupérer le code source : `git clone https://github.com/Safran/RoPA.git`

#### *Base de données*

Créer une base de données et importer le fichier database.sql.

#### *Compilation*

Placer le répertoire RoPA à la racine du serveur.

Se placer dans le répertoire RoPA.

Éditer la variable APP_URL du fichier .env pour renseigner l'URL du serveur.
> **Note :** l'URL devrait être identique au "ServerName" de votre serveur apache.

Éditer le fichier .env pour renseigner l'hôte, le nom, le nom d'utilisateur et le mot de passe de la base de données.

Entrer la commande `composer install`.

Entrer `npm install`.

Entrer `npm run production`.

Entrer `php artisan RoPA:install` et répondre `yes` pour générer la clé de l'application.

#### *Accès*

Vous devriez pouvoir charger la page `http://[APP_URL]/fr/login` pour vous connecter avec un compte local.  
Si vous souhaitez utiliser une authentification SAMLv2, vous devez charger la page `http://[APP_URL]`.

### Déploiement

#### *SAMLv2 / LDAP*

Modifier les variables suivantes dans le fichier .env :  
SAML2_SP_x509="file://[CHEMIN COMPLET]/certs/saml.crt"  
SAML2_SP_PRIVATEKEY="file://[CHEMIN COMPLET]/certs/saml.pem"

L'URL des métadata est : [APP_URL]/saml2/metadata

Vous pouvez configurer le LDAP dans le fichier .env et dans le fichier config/authcompany.php pour synchroniser les utilisateurs avec le LDAP.

#### *Planification et files d'attente*

Un cron doit être activé : 
````
* * * * * php /[YOU FULLPATH]/artisan schedule:run >> /dev/null 2>&1
* * * * * pgrep php > /dev/null || php /[YOU FULLPATH]/artisan queue:work >> /dev/null 2>&1
````

> **Note :** Vous pouvez éditer le fichier app/Console/Kernel.php pour ne plus recevoir de notifications par email lors de la planification : 
Ajouter ['--disable-notifications'] en second paramètre de command.

#### *Compte*

Un compte local est défini :  
Administrateur :  
Identifiant : admin  
Mot de passe : admin

DPO :  
Identifiant : dpo  
Mot de passe : admin

Salarié :  
Identifiant : employee  
Mot de passe : admin

#### *E-mail*

Les e-mails peuvent être configurés dans le fichier .env.

#### *Images*

Vous pouvez modifier le favicon dans RoPA/public/images/favicon.png  
Vous pouvez modifier le logo dans : 
- RoPA/public/images/logo.png
- RoPA/public/images/logo.svg
- RoPA/public/images/general/logo.svg
- RoPA/resources/assets/img/general/logo.svg

Par défaut, les images principales sont liés à `localhost` mais vous pouvez recharger les images dans le panneau d'administration : `[APP_URL]/admin/settings`

## Installation

L'application a été installée sur Redhat 7, Debian 9, MAMP 4.2 et 5.1.

## Licence

Ce projet est sous licence GNU GPLv3 - voir le fichier [LICENSE](LICENSE) pour plus de détails.  
Toute contribution ou travail de contributeur tel que décrit dans la version 3 de la Licence publique générale GNU en tant que « version contributeur » deviendra une contribution régie par la Licence publique générale GNU version 3.
