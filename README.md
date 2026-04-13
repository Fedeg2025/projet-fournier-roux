# Fournier Roux — Des bâtisseurs exceptionnels

Projet de fin de formation réalisé individuellement dans une mise en situation fictive : un site web pédagogique développé en **PHP (architecture MVC)** avec **MySQL**, intégrant un espace utilisateur, un back-office d’administration et une consultation d’observations via l’API **iNaturalist**.

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
- une **demande de suppression de compte**.

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

Le projet applique une logique de suppression fonctionnelle combinant :

- une anonymisation des données utilisateurs ;
- une dissociation des relations (clé étrangère mise à NULL).

Cette approche permet de préserver l’intégrité des données tout en respectant la confidentialité des utilisateurs.

Dans certains cas (ex : messages de contact), les données restent conservées 
même après suppression du compte, mais la relation avec l’utilisateur est supprimée 
(id_utilisateur NULL), garantissant ainsi l’intégrité des données tout en respectant la confidentialité.

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

Le dépôt contient :

- `database/schema.sql` → structure de la base ;
- `database/seed.sql` → données de démonstration pour tester le projet en local.

Le fichier `seed.sql` permet notamment d’insérer :

- un **compte administrateur de démonstration** ;
- des utilisateurs, catégories, contenus et médias de test ;
- les données nécessaires à une démonstration locale du projet.

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
- séparation de la configuration sensible via un fichier `.env` ;
- fichier `.env` non versionné ;
- logique de contrôle d’accès selon le rôle utilisateur ;
- gestion sécurisée de l’authentification ;
- stockage sécurisé des mots de passe (**hashage côté serveur**) ;
- traitement encadré des données utilisateur.

---

## Données et fichiers exclus du dépôt

Le dépôt GitHub a été préparé pour rester propre, léger et installable.

Sont notamment exclus du versionnement :

- `.env`
- certains fichiers volumineux
- certains contenus d’upload utilisateur
- les éléments non nécessaires à l’installation du projet

Le fichier `.env.example` est fourni afin de faciliter la réinstallation locale du projet.

---

## Installation du projet

### 1) Cloner le dépôt

```bash
git clone <URL_DU_REPO>
cd <NOM_DU_PROJET>
```

### 2) Configurer l’environnement

Créer un fichier `.env` à partir du fichier fourni :

```bash
cp .env.example .env
```

Puis compléter les variables d’environnement selon votre configuration locale.

Exemple :

```env
DB_HOST=localhost
DB_NAME=fournier_roux_db
DB_USER=root
DB_PASS=
```

---

## Installation de la base de données

### 1) Créer une base de données

Créer une base vide dans **phpMyAdmin** (ou MySQL), par exemple :

```sql
CREATE DATABASE fournier_roux_db;
```

### 2) Importer la structure

Importer le fichier :

```txt
database/schema.sql
```

### 3) Importer les données de démonstration

Importer ensuite :

```txt
database/seed.sql
```

### 4) Vérifier les fichiers médias

Le projet utilise également des fichiers médias présents dans :

```txt
public/uploads
```

Ces fichiers doivent être conservés pour que les articles et contenus de démonstration s’affichent correctement.

---

## Lancer le projet

Le projet doit être placé dans un environnement local compatible **PHP + MySQL**.

Exemples :

- **XAMPP**
- **WAMP**
- **MAMP**

Une fois la base configurée et le fichier `.env` renseigné, lancer le serveur local puis accéder au projet via le navigateur.

Exemple d’accès local :

```txt
http://localhost/web/fournier_roux/
```

L’URL exacte peut varier selon votre configuration locale.

---

## Compte administrateur de démonstration

Un compte administrateur de démonstration est créé automatiquement lors de l’import de :

```txt
database/seed.sql
```

Ce compte permet de tester localement les principales fonctionnalités d’administration du projet.

---

## Pistes d’amélioration

Le projet pourrait évoluer avec :

- une gestion plus avancée des rôles utilisateurs ;
- une modération plus fine du contenu ;
- une meilleure gestion des médias ;
- des validations/formulaires plus poussés ;
- une amélioration de l’UX du back-office ;
- une mise en production complète.

---

## Auteur

Projet réalisé par **Federico Garcia** dans le cadre d’une formation de développement web full stack.