Guide d'installation et d'utilisation: Ce dépôt contient le code source pour ce projet.

Avant de commencer, assurez-vous d'avoir installé WAMP (ou tout autre serveur web tel que MAMP pour macOS ou LAMP pour Linux) pour exécuter l'application localement.

Installation

Cloner le dépôt dans le dossier www (pour wamp) :

> git clone https://github.com/merahsamia/TaskMis

Accéder au répertoire cloné :

> cd TaskMis

Installer les dépendances PHP avec Composer :

> composer install

Installer les dépendances JavaScript avec yarn :

> yarn install

Copier le fichier d'environnement exemple et le renommer :

> copy .env.example .env

Générer une clé d'application Laravel :

> php artisan key:generate

Ouvrir le fichier .env:

DB_CONNECTION=mysql : Créer votre bdd



Effectuer les migrations de la base de données :

> php artisan migrate

Remplir la base de données avec des données de test :

> php artisan db:seed

Installer Laravel Passport : 

> php artisan passport:install
> php artisan passport:keys --force

Compiler les ressources frontales :

> yarn run watch

Vous pouvez accéder à l'application à l'adresse : http://localhost/TAskMis.
L'utilisateur Admin: admin@app.com
Tous les mots de passe sont par défaut: password

