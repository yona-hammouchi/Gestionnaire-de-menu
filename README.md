# Projet : Gestionnaire de Menu pour Restaurateurs

## Description

Le projet consiste à développer une application web permettant aux restaurateurs de créer, personnaliser et partager le menu de leur restaurant. Les restaurateurs peuvent ajouter des plats, modifier les menus, gérer les ingrédients des plats et organiser les plats en catégories. Le système inclut également un tableau de bord pour le restaurateur, un système de connexion sécurisé et une interface conviviale.

Technologies
PHP : Backend pour la gestion des pages et des sessions.
MySQL : Base de données.
HTML/CSS : Structure et design des pages.

### Fonctionnalités principales :
- **Dashboard utilisateur** : Affichage des menus et plats créés par l'utilisateur, gestion des plats.
- **Création et gestion de plats** : Ajout, modification et suppression de plats avec détails (nom, description, prix, image, catégorie).
- **Gestion des ingrédients** : Chaque plat peut être associé à des ingrédients.
- **Gestion des catégories** : Ajout et suppression de catégories pour organiser les plats.
- **Système de connexion** : Authentification sécurisée pour les restaurateurs afin d’accéder à leur tableau de bord.
- **Affichage du menu** : Les utilisateurs peuvent afficher les menus créés sur la page d'accueil.

---

## Structure des Pages
- **index.php** : Page d'accueil affichant le menu avec les plats créés.
- **dashboard.php** : Tableau de bord où les restaurateurs peuvent gérer leur menu.
- **connexion.php** : Formulaire de connexion pour les restaurateurs.
- **creer_plat.php** : Formulaire pour créer un nouveau plat.
- **modifier_plat.php** : Formulaire pour modifier un plat existant.
- **gerer_categories.php** : Gestion des catégories de plats (ajout, suppression).

---

## Base de données
### Tables :
- **users** : `id`, `login`, `password`, `role`, `created_at`.
- **plats** : `id`, `user_id`, `name`, `description`, `price`, `category_id`, `created_at`.
- **ingredients** : `id`, `plat_id`, `ingredient_name`, `created_at`.
- **categories** : `id`, `name`, `created_at`.
