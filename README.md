# Fournier Roux — Des bâtisseurs exceptionnels

Projet de fin de formation réalisé individuellement dans le cadre d’une mise en situation fictive : il s’agit d’un site web pédagogique développé en **PHP (architecture MVC)** avec **MySQL**, intégrant un espace utilisateur, un back-office d’administration ainsi qu’une consultation d’observations via l’API **iNaturalist**.

---

## Présentation du projet

**Fournier Roux — Des bâtisseurs exceptionnels** est un site web pédagogique consacré au **Fournier roux** (*Furnarius rufus*), un oiseau connu pour ses nids en terre.

Le projet a été conçu comme une application web complète permettant de proposer :

- une **partie publique** de consultation ;
- un **espace utilisateur authentifié** ;
- un **back-office administrateur** pour la gestion du contenu et des utilisateurs.

L’objectif du projet est de proposer un site vitrine structuré, pédagogique et accessible, tout en mettant en œuvre une architecture backend propre, maintenable et cohérente avec un contexte de développement full stack.

---

## Objectifs du projet

Ce projet répond à plusieurs objectifs :

- valoriser un sujet pédagogique autour du Fournier roux ;
- proposer une navigation claire et accessible à un large public ;
- permettre la consultation de contenus informatifs, visuels et dynamiques ;
- intégrer une logique de gestion utilisateur avec authentification ;
- mettre en place un espace d’administration pour gérer certaines données du site ;
- exploiter une **API externe** afin d’enrichir le contenu du site avec des données réelles.

Le projet s’inscrit dans une logique conforme au **cahier des charges**, avec une séparation claire entre front-office, espace utilisateur et back-office.

---

## Fonctionnalités principales

### Front-office

La partie publique du site permet notamment :

- l’affichage d’une **page d’accueil** de présentation ;
- la consultation de pages de contenu autour du **Fournier roux** et de son environnement ;
- une page dédiée à la **construction du nid** ;
- une **galerie de contenus visuels** ;
- un **formulaire de contact** ;
- la consultation d’**observations récentes** via l’API **iNaturalist** ;
- une navigation pensée pour être **responsive**.

### Espace utilisateur

L’espace utilisateur permet :

- l’**inscription** ;
- la **connexion / déconnexion** ;
- l’accès à un **espace personnel** ;
- la consultation des informations liées au compte ;
- la **suppression du compte directement depuis le profil**.

### Back-office administrateur

L’espace administrateur permet :

- l’**authentification administrateur** ;
- la **gestion des utilisateurs** ;
- la **gestion des contenus / actualités** ;
- la consultation et la suppression des **messages de contact** ;

---

## Respect du cahier des charges

Le projet a été développé dans le respect des grandes lignes du **cahier des charges**, notamment :

- séparation des espaces **public / utilisateur / administrateur** ;
- mise en place d’un **système d’authentification** ;
- création d’un **back-office de gestion** ;
- intégration d’une **API externe** ;
- développement selon une **architecture MVC** ;
- utilisation d’une **base de données relationnelle MySQL** ;
- prise en compte de la **sécurité**, de la **protection des données** et de la **maintenabilité du code**.

Le projet final correspond donc à une mise en œuvre concrète et cohérente des besoins fonctionnels et techniques définis dans la phase de conception.

---

## Gestion des comptes utilisateurs

Le projet propose une fonctionnalité simple de gestion des comptes utilisateurs.

La suppression du compte est accessible directement depuis l’espace utilisateur (profil).

Lors de la suppression, les données liées au compte (notamment les messages) sont supprimées afin de conserver une structure cohérente dans la base de données et éviter les incohérences.

---

## Stack technique

### Back-end

- **PHP**
- Architecture **MVC**
- **PDO** pour l’accès sécurisé à la base de données
- **MySQL**

### Front-end

- **HTML5**
- **CSS3 / SCSS**
- **JavaScript**

### Outils

- **Git / GitHub**
- **phpMyAdmin**
- Environnement local type **XAMPP / MAMP / WAMP**

## Compilation des styles

Les fichiers CSS sont déjà compilés et inclus dans le dépôt.

Conformément aux consignes, les outils de compilation (Sass, Node.js, etc.) ne sont pas versionnés.

Le projet est donc directement fonctionnel sans étape de build supplémentaire.

---

## Architecture du projet

Le projet suit une organisation en **architecture MVC** :

- **Models** : gestion des données et interactions avec la base ;
- **Views** : affichage des pages et composants d’interface ;
- **Controllers** : traitement des requêtes et de la logique applicative.

Cette structure permet :

- une meilleure lisibilité du code ;
- une séparation claire des responsabilités ;
- une maintenance plus simple ;
- une meilleure évolutivité du projet.

---

## Base de données

Le projet utilise une base de données **MySQL**.

Le dépôt contient un fichier unique :

- `database/schema.sql` → structure et données de démonstration du projet.

Ce fichier permet d’installer directement une version complète du projet en local.

---

## API externe

Le projet intègre l’API **iNaturalist** afin d’afficher des observations récentes liées au **Fournier roux**.

Cette intégration permet :

- de récupérer des données externes dynamiques ;
- d’enrichir le contenu pédagogique du site ;
- d’apporter une dimension plus réaliste et interactive à l’expérience utilisateur.

L’affichage repose sur des requêtes permettant d’exploiter les données retournées par l’API.

---

## Accessibilité, responsive et qualité de l’interface

Le projet a été pensé avec une attention particulière portée à :

- la **lisibilité du contenu** ;
- une **navigation claire** ;
- une structure de page cohérente ;
- l’adaptation à différents formats d’écran (**responsive design**) ;
- une hiérarchie visuelle simple et compréhensible.

L’objectif était de proposer une interface accessible, claire et pédagogique, en cohérence avec le public visé par le projet.

---

## Sécurité

Plusieurs bonnes pratiques ont été intégrées dans le projet :

- utilisation de **requêtes préparées (PDO)** ;
- contrôle d’accès selon le rôle utilisateur ;
- gestion de l’authentification ;
- stockage sécurisé des mots de passe (**hashage côté serveur**) ;
- protection basique contre les failles courantes (XSS, SQL).

---

## Données et fichiers exclus du dépôt

Le dépôt GitHub a été préparé pour rester propre, léger et facilement installable.

Sont exclus du versionnement :

- certains fichiers volumineux ;
- certains contenus d’upload utilisateur ;
- les éléments non nécessaires au fonctionnement du projet.

---

## Installation du projet

### 1) Cloner le dépôt

```bash
git clone <URL_DU_REPO>
cd <NOM_DU_PROJET>
```

### 2) Configurer la base de données

Les identifiants de connexion sont externalisés dans un fichier de configuration pour des raisons de sécurité.

1. Copier le fichier :

config/db-config.example.php

2. Le renommer en :

config/db-config.php

3. Adapter les valeurs selon votre environnement local :

- host
- dbname
- user
- password

Le fichier `config/db-config.php` est volontairement exclu du dépôt pour des raisons de sécurité.

### 3) Installer la base de données

Importer le fichier :

`database/schema.sql`

### 4) Lancer le projet

Placer le projet dans un environnement local compatible **PHP + MySQL** (XAMPP, WAMP ou MAMP), puis démarrer le serveur.

Assurez-vous que votre serveur local (Apache et MySQL) est bien démarré.

Accéder ensuite au projet via votre navigateur (selon votre configuration locale) :

http://localhost/<nom_du_projet>/


---

## Auteur

Projet réalisé par Federico Garcia dans le cadre d’une formation de développement web full stack.