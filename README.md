# Projet Laravel

Ce projet Laravel peut être lancé de deux manières différentes : via GitHub Codespaces ou en utilisant Docker en local.

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

## 3. Sécurisation des Fichiers

    Stockage des Fichiers dans un Dossier Privé :

    Les fichiers téléchargés sont stockés dans un dossier qui n'est pas accessible directement depuis le Web. Cette mesure empêche l'accès non autorisé aux fichiers sensibles.

## 4. Journalisation des Actions

    Insertion de Logs pour Toutes les Actions :

    Chaque action significative au sein de l'application est enregistrée. Cela inclut les actions d'authentification, les modifications de données et d'autres interactions clés. Ces logs sont essentiels pour le suivi des activités et l'analyse en cas d'incident de sécurité.

## 5. Authentification

    Gestion de l’Authentification par Laravel Breeze :

    Laravel Breeze a été utilisé pour implémenter un système d'authentification robuste et sécurisé, offrant une expérience utilisateur fluide tout en garantissant la sécurité des données d'authentification.

## 6. Interaction avec la Base de Données

    Sécurité avec Eloquent :

    Pour toutes les interactions avec la base de données, nous avons utilisé l'ORM Eloquent de Laravel. Cela assure une protection contre les injections SQL et facilite l'écriture de requêtes de base de données sécurisées.

## 7. Content Security Policy (CSP)

    Ajout de la Protection CSP :
    
    Une politique de sécurité du contenu (CSP) a été mise en place pour réduire les risques de Cross-Site Scripting (XSS) et d'autres attaques basées sur l'injection de code. Cette politique définit les sources fiables pour le chargement de contenu, renforçant ainsi la sécurité de notre application web.
