# Contribuer au projet Todo & Co - Informations et Consignes pour les développeurs

---

## Versionning du projet

Le projet Todo & Co est disponible au sein d'un repository GitLab : https://github.com/GabTHP/ToDo-Co.

Le versionning du projet a pour objectif de suivre les modifications et ajouts de code ainsi que faciliter la collaboration des développeurs.

Deux branches principales composent le projet :

- master
- development

La branche master est uniquement destinée à recevoir un code fonctionnel et intégre. La branche development est destinée à recevoir le code pour être testé localement.

Le développement d'une nouvelle fonctionnalités implique de préparer les issues correspondantes au sein du repository pour faciliter la coopération.

Toutes nouvelles fonctionnalités ou modifications du code doivent être travaillées sur des sous branches de la branche développement

Commandes utiles :

- git pull origin master

Récupérer le code en local de la branche master étant la version la plus à jour du projet

- git checkout development

Se placer dans la branche de développement

- git checkout -b new_branche_name development

Créer une nouvelle sous branche de développement et se placer dedans

- git push orign branche_name

Envoyer le code dans la branche du repository distant

Sur l'interface GitLab réaliser et vérifier l'intégriter des pull requests et mergez les ensuite.

## Tester l'application

L'ajout d'une nouvelle fonctionnalités ne doit pas entraver le fonctionnement de l'existant. Dans ce cadre, il faut réaliser des tests fonctionnelles et unitaires, afin de s'assurer du bon fonctionnement de l'intégratlité de l'application, avant de déployer du code en production.

Pour éxécuter les tests, lancez la commande suivante en se plaçant à la racine du projet :

> ./vendor/bin/phpunit

Afin de s'assurer que les tests reflètent bien l'intégralité de l'application, il est nécessaire qu'ils recouvrent au minimum 70% des fonctionnaltés.

Pour obtenir un coverage report des tests, lancez la commande suivante :

> XDEBUG_MODE=coverage ./vendor/bin/phpunit --coverage-html ../public/test-coverage

A noter : Les tests sont réalisé à partir d'une base de données test, qui est chargé et cleané au cours chaque éxecution, à partir de la fixtures "TestFixtures". Si nécessaire, il faut adapter la fixture pour l'éxécution de nouvelles séquences de tests. Veillez bien à ce que chaque test soit indépendant.

## Respect des normes et convention de développement

Le respect des normes et convention de développement permet d'harmoniser le code de l'application. Ainsi la lecture et la compréhension du code est facilité pour l'équipe de développeur et les nouveaux arrivants. Les pratiques à mettre en places sont les suivantes.

- Respect des normes PSR
  - le code PHP doit utiliser le tag " <?php ?>"
  - le code doit être encodé en UTF-8
  - nommage des Class et Namespace doit être en StudlyCaps
  - nommage des méthodes doit être en camelCase()
  - Respecter l'indentation
  - Ne doit pas contenir de ligne de code supérieur à 120 caractères
  - Les accolades doivent être placé à la ligne à après déclaration de la class ou de la méthod et à la ligne suivant le script
  - php keywords doivent être écrits en smallcase

Vous trouverez l'ensemble des normes psr au sein du lien suivant : https://www.php-fig.org/psr/

Nous conseillons aux développeurs d'utiliser un IDE avec l'extention code Prettier pour faciliter la gestion de la lisibilité du code et du respect des normes PSR.

## Vérifier la qualité du code

Lors d'un push au sein de la branche master ou development du repository, la qualité du code est automatiquement analysé via Symfony Insight.

Le lien vers les analyses se trouvent au sein du lien suivant : https://insight.symfony.com/projects/7f181bbe-ce4d-4513-a89f-2a4006ea754f

Veillez à ce que le grade soit au minimum argent.

## Déploiement en production

L'application Todo & Co est disponible en production à l'url suivante : https://todo-co.herokuapp.com/

Hébergé sur Heroku, le mécanisme de déploiement est simple. Le code est automatiquement intégré au serveur à partir de la branche master du repository GitLab dés lors qu'un pull request est détecté..

---

L'équipe de Todo & Co vous remercie de votre participation
