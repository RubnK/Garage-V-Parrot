# Garage V. Parrot

Site du Garage V. Parrot, un projet développé avec Symfony 7.

## Prérequis

- PHP 8.0 ou supérieur
- Composer
- Symfony CLI
- MySQL

## Installation

1. Clonez le dépôt :
    ```bash
    git clone https://github.com/RubnK/Garage-V-Parrot.git
    cd garage
    ```

2. Installez les dépendances avec Composer :
    ```bash
    composer install
    ```

3. Configurez votre base de données dans le fichier `.env` :
    ```env
    DATABASE_URL="mysql://username:password@127.0.0.1:3306/garage"
    ```

4. Créez la base de données et exécutez les migrations :
    ```bash
    php bin/console doctrine:database:create
    php bin/console doctrine:migrations:migrate
    ```

5. Démarrez le serveur Symfony :
    ```bash
    symfony server:start
    ```

## Utilisation

Accédez à l'application via `http://localhost:8000` dans votre navigateur.
