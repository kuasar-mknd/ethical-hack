# Projet Laravel
Ce projet Laravel peut être lancé de deux manières différentes : via GitHub Codespaces ou en utilisant Docker en local.

## Table des Matières

1. [Lancement avec GitHub Codespaces](#1-lancement-avec-github-codespaces)
2. [Lancement avec Docker en Local](#2-lancement-avec-docker-en-local)
3. [Configuration Commune Post-Lancement](#configuration-commune-post-lancement)
4. [Mesures de Sécurité Mises en Place](#mesures-de-sécurité-mises-en-place)
5. [Identification des Faiblesses Logicielles Potentielles](#identification-des-faiblesses-logicielles-potentielles)
6. [Problèmes Rencontrés](#problèmes-rencontrés)
7. [Technologies et Librairies Utilisées](#technologies-et-librairies-utilisées)
8. [Rôles et Responsabilités](#rôles-et-responsabilités)


## 1. Lancement avec GitHub Codespaces

Pour lancer le projet avec GitHub Codespaces :

- Cliquez sur le bouton "Code" en haut à droite de la page du repository.
- Sélectionnez "Open with Codespaces".
- Cliquez sur "New codespace" pour créer un nouvel espace.

GitHub Codespaces configurera automatiquement l'environnement et lancera le projet.

Si vous rencontrez des problèmes avec la base de donnée MySQL qui n'est pas accessible, il faut faire un rebuild et si le problème persiste, utilisez docker

## 2. Lancement avec Docker en Local

Pour lancer le projet en local avec Docker :

- Clonez le repository de votre projet :

```bash
git clone https://github.com/kuasar-mknd/ethical-hack.git
```

- Naviguez vers le dossier du projet :

```bash
cd ethical-hack
```

- Lancez Docker et ouvrez le projet dans un DevContainer. Vous pouvez utiliser Visual Studio Code avec l'extension Remote - Containers pour faciliter cette étape.

- **Important :** Une fois le conteneur créé, assurez-vous de supprimer toutes les redirections de port du `devcontainer.json`.

## Configuration Commune Post-Lancement

Une fois le conteneur lancé (que ce soit via Codespaces ou Docker local), vous devez exécuter les migrations de base de données avec les seed. Pour ce faire, utilisez la commande suivante à l'intérieur du conteneur :

```bash
php artisan migrate --force --seed
```

Cette commande va initialiser votre base de données avec les structures nécessaires et les données de départ.

L'utilisateur admin par défaut est 
```bash
admin@example.com
```

```bash
adminpassword
```

---

Après ces étapes, votre projet devrait être opérationnel et prêt à être utilisé sur [localhost](http://localhost).

---

# Mesures de Sécurité Mises en Place

Dans le cadre de notre engagement à assurer la sécurité de notre application, plusieurs mesures ont été mises en place pour protéger à la fois les données des utilisateurs et l'intégrité de l'application. Voici un aperçu détaillé de ces mesures :

## 1. Protection Cross-Site Request Forgery (CSRF)

Tag @csrf dans les Formulaires :

Pour chaque formulaire de l'application, le tag @csrf de Laravel a été utilisé. Cette approche génère un token CSRF pour chaque session utilisateur, empêchant ainsi les attaques CSRF où des requêtes malveillantes pourraient être soumises de sites tiers.

## 2. Gestion des Rôles et Autorisations

Policies et Middleware d'Authentification :

Nous avons utilisé les policies de Laravel pour gérer finement les autorisations d'accès et de modification des ressources. Le middleware d'authentification de Laravel Breeze a été employé pour sécuriser les routes et garantir que seuls les utilisateurs autorisés peuvent accéder à certaines fonctionnalités.

La vérification des rôles pour chaque action se fait dans les [Policies](Policies)

## 3. Sécurisation des Fichiers

Stockage des Fichiers dans un Dossier Privé :

Les fichiers téléchargés sont stockés dans un dossier qui n'est pas accessible directement depuis le Web. Cette mesure empêche l'accès non autorisé aux fichiers sensibles.

## 4. Journalisation des Actions

Insertion de Logs pour Toutes les Actions :

Chaque action significative au sein de l'application est enregistrée. Cela inclut les actions d'authentification, les modifications de données et d'autres interactions clés. Ces logs sont essentiels pour le suivi des activités et l'analyse en cas d'incident de sécurité.

## 5. Authentification

Gestion de l’Authentification par Laravel Breeze :

Laravel Breeze a été utilisé pour implémenter un système d'authentification robuste et sécurisé, offrant une expérience utilisateur fluide tout en garantissant la sécurité des données d'authentification.

[Les différentes routes du projet](routes/web.php) 

## 6. Interaction avec la Base de Données

Sécurité avec Eloquent :

Pour toutes les interactions avec la base de données, nous avons utilisé l'ORM Eloquent de Laravel. Cela assure une protection contre les injections SQL et facilite l'écriture de requêtes de base de données sécurisées.

## 7. Content Security Policy (CSP)

Ajout de la Protection CSP :
    
Une politique de sécurité du contenu (CSP) a été mise en place pour réduire les risques de Cross-Site Scripting (XSS) et d'autres attaques basées sur l'injection de code. Cette politique définit les sources fiables pour le chargement de contenu, renforçant ainsi la sécurité de notre application web.

[La configuration](app/Policies/StrictCspPolicy.php)


# Identification des Faiblesses Logicielles Potentielles

## 1. Utilisation d'un Stockage Cloud (AWS)
>Sécurité et Fiabilité Accrues : Le passage à un service de stockage cloud comme Amazon Web Services (AWS) S3 peut offrir une meilleure sécurité et une plus grande fiabilité. AWS fournit des options avancées de sécurité et de cryptage, ainsi que des garanties de haute disponibilité et de durabilité des données.

>Scalabilité : Avec AWS, notre application peut facilement évoluer en termes de capacité de stockage, s'adaptant ainsi aux besoins croissants sans nécessiter une gestion de l'infrastructure complexe.

## 2. Intégration d'un Antivirus
>Prévention des Malwares : Avant le stockage des fichiers téléchargés, une intégration antivirus pourrait scanner et vérifier les fichiers pour détecter la présence de malwares. Cela ajoute une couche supplémentaire de sécurité pour protéger à la fois le serveur et les utilisateurs finaux.

>Automatisation et Rapports : L'antivirus pourrait fonctionner de manière automatisée et fournir des rapports détaillés en cas de détection de fichiers suspects, permettant une intervention rapide.

## 3. Transition du Mode Développement au Mode Production
>Environnement de Production : Actuellement, notre site est configuré et exécuté en mode développement, ce qui est idéal pour le test et le débogage. Cependant, pour le déploiement en production, il est crucial de passer à un environnement de production. Cette transition implique plusieurs modifications et optimisations importantes :
>
>* Configuration de l'Environnement : Mise à jour des configurations dans le fichier .env pour refléter les paramètres de production, y compris les variables d'environnement de la base de données, les clés API, et d'autres services tiers.
>* Optimisation des Performances : Activation de la mise en cache des configurations et des routes, ainsi que la compilation des vues Blade, pour améliorer les performances globales.
>* Gestion des Erreurs : Dans l'environnement de production, il est important de configurer un système de gestion des erreurs qui enregistre les problèmes sans les afficher aux utilisateurs finaux.
>* Sécurité Accrue : Assurer que toutes les mesures de sécurité, y compris les en-têtes de sécurité HTTP, les politiques CSP et la protection contre les attaques XSS/CSRF, sont pleinement activées et configurées pour l'environnement de production.
>* Tests Rigoureux : Avant le lancement, effectuer une série de tests en conditions réelles pour s'assurer que l'application fonctionne comme prévu en production. Cela inclut les tests de charge, de performance et de sécurité.
## 4. Optimisation des Performances
>Compression et Formatage des Fichiers : Mettre en œuvre des stratégies de compression et de formatage pour optimiser les temps de chargement et réduire l'utilisation de la bande passante, tout en maintenant la qualité et l'intégrité des fichiers.

## 5. Sauvegarde et Récupération
>Stratégies de Sauvegarde : Mettre en place des stratégies de sauvegarde régulières et fiables pour prévenir la perte de données.
>Plans de Récupération en Cas de Sinistre : Élaborer des procédures de récupération en cas de sinistre pour garantir la continuité des activités en cas de défaillance majeure.


# Problèmes Rencontrés
## Validation de l'Identité de l'Administrateur pour Actions Sensibles
### Problème

L'un des défis techniques les plus significatifs rencontrés durant le développement concernait la validation de l'identité de l'administrateur pour des actions sensibles, en particulier pour des requêtes POST comme le changement de rôle des utilisateurs. Le cœur du problème résidait dans la limitation de Laravel qui ne permet pas de rediriger les requêtes POST pour une confirmation de mot de passe, ce qui est essentiel pour sécuriser les actions sensibles.

La tentative initiale d'implémenter un middleware pour redemander l'authentification a révélé que les données du formulaire initial n'étaient pas conservées après la redirection, car Laravel ne gère pas naturellement les redirections pour les requêtes POST.

### Solution et Limitations

La solution retenue a été d'intégrer un champ de mot de passe directement dans le formulaire initial de changement de rôle. Ainsi, lors de la soumission du formulaire, la validation du mot de passe se fait en même temps que la modification du rôle, directement dans le contrôleur.

Cependant, cette solution présente une certaine limitation : elle n'est pas versatile. Chaque formulaire sensible doit être individuellement ajusté pour inclure un champ de validation de mot de passe, au lieu d'avoir une solution globale et centralisée.

# Technologies et Librairies Utilisées
## Laravel 10.10

>Utilisation : Laravel est le framework principal de notre application. Il offre une base solide avec une architecture élégante et une variété de fonctionnalités pour le développement rapide d'applications web.

## PHP 8.3

>Utilisation : PHP est le langage de programmation utilisé pour le développement du backend. La version 8.1 apporte des améliorations de performance et de nouvelles fonctionnalités telles que les types enum, les propriétés en lecture seule, et plus encore.

## Guzzle ^7.2

>Utilisation : Guzzle est une bibliothèque PHP pour la création de requêtes HTTP. Elle est utilisée pour communiquer avec des API externes et des services web de manière efficace et flexible.

## Laravel Tinker ^2.8

>Utilisation : Laravel Tinker est une console REPL (Read-Eval-Print Loop) puissante pour Laravel. Elle permet d'interagir avec l'ensemble de l'application depuis la ligne de commande, facilitant le test et le débogage.

## Spatie Laravel CSP ^2.8

>Utilisation : Cette bibliothèque de Spatie permet de facilement configurer une politique de sécurité du contenu (CSP) pour Laravel, augmentant la sécurité de l'application en définissant des règles strictes sur les ressources chargées par le navigateur.

## Dépendances de Développement
* Laravel Breeze ^1.27
  >Utilisé pour la mise en place rapide de l'authentification, des vues Blade, et du routage.
* Laravel Sail ^1.26
  >Un outil de développement léger pour exécuter Laravel dans Docker.
* Spatie Laravel Ignition ^2.0
  >Une solution élégante pour la gestion des erreurs dans les applications Laravel.

# Rôles et Responsabilités

### Marine
>Mise en place du dashboard administrateur 

### Samuel
>Mise en place de gestionnaire de fichiers partagés, système d’authentification et mise en place de la protection CSP

### Caroline
>Mise en place du chat
