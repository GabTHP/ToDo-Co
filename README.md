# Projet 8 : Améliorez un projet existant

Lien vers le projet : https://github.com/GabTHP/ToDo-Co

## Code Validation

[![SymfonyInsight](https://insight.symfony.com/projects/7f181bbe-ce4d-4513-a89f-2a4006ea754f/big.svg)](https://insight.symfony.com/projects/7f181bbe-ce4d-4513-a89f-2a4006ea754f)

Lien vers analyse du projet Symfony Insight : https://insight.symfony.com/projects/7f181bbe-ce4d-4513-a89f-2a4006ea754f/analyses/63

## Versions :

- Symfony : 4.4
- PHP : 7.4

## Installation du projet :

1. Télecharcher le repository ToDo

2. Placez dans à la racine du projet et lancer la commande ci-dessous pour installer les librairies du projet :

   - composer install

3. Configuration de l'environnement :

   - créez les fichiers .env.local et .env.local.test, à la racine du projet.
   - Remplissez les fichier à partir en prenenat le fichier ".env" pour modèle. Le fichier .env.local correspond à l'ennvironnement de développement, et le fichier .env.local.test à l'environnement de test. Il faut donc utilisez deux bases de données différentes.

4. Lancer les commandes ci-dessous pour créer la base de données :

   - php bin/console doctrine:database:create
   - php bin/console doctrine:schema:update --force

5. Lancez les Fixtures :

- Environnement de dev -> php bin/console doctrine:fixtures:load --group=group-demo
- Ennvironnement de test -> php bin/console --env=test doctrine:fixtures:load --group=group-test

Remarque : Lors de l'éxecution des tests, les fixtures se lancent automatiquement ainsi que la purge des données

5. Jeu de données initial:

Les fixturees permettent de bénéficier d'un jeu de données initiales avec la création de comptes utilisateurs et de tâches, les identifiants sopont les suivants :

- user :

  - id = simple-user
  - mdp = azerty

- admin :

  - id = gab
  - mdp = azerty

6. Lancer le serveur local avec la commande suivante :

- symfony local:server:start

Bonne utilisation !
