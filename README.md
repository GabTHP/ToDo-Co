# Projet 7 : Améliorez un projet existant

Lien vers le projet : https://github.com/GabTHP/ToDo-Co

## Code Validation

[![SymfonyInsight](https://insight.symfony.com/projects/7f181bbe-ce4d-4513-a89f-2a4006ea754f/big.svg)](https://insight.symfony.com/projects/7f181bbe-ce4d-4513-a89f-2a4006ea754f)

Lien vers analyse du projet Symfony Insight : https://insight.symfony.com/projects/7f181bbe-ce4d-4513-a89f-2a4006ea754f/analyses/40

## Versions :

- Symfony : 3.4.0
- PHP : 5.6

## Installation du projet :

1. Télecharcher le repository ToDo

2. Placez dans à la racine du projet et lancer la commande ci-dessous pour installer les librairies du projet :

   - composer install

3. Mettre à jour ou créer le fichier params.yml, au sein du dossier : "/app/config". Utilisez le fichier /app/config/parameters.yml.dist comme modèle.

4. Lancer les commandes ci-dessous pour créer la base de données :

   - php bin/console doctrine:database:create
   - php bin/console doctrine:migrations:migrate

5. Utilisez la commande ci-dessous pour générer un jeu de données et bénéficier d'une démo de l'app Todo !

- php bin/console doctrine:fixtures:load

- Indentfiants :
  > user :

* id = le user
* mdp = azerty
  > admin :
* id = gab
* mdp = azerty

6. Lancer le serveur local avec la commande suivante :

- symfony local:server:start

Bonne utilisation !
