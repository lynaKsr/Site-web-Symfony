# Site-web-Symfony

# Projet de Gestion de Ventes en Ligne (Livres) avec Symfony

Ce projet utilise le framework Symfony pour créer un site de gestion de ventes en ligne de livres. Le projet met en œuvre des fonctionnalités telles que la gestion des utilisateurs, des produits, des paniers et des commandes.

## Fonctionnalités Principales

- Gestion des utilisateurs avec différents rôles : non authentifié, client authentifié, administrateur authentifié, super-administrateur authentifié.
- Création de compte, édition du profil, déconnexion.
- Liste des produits du magasin avec ajout au panier, gestion du panier et commandes.
- Administration des utilisateurs et gestion des clients pour les administrateurs.
- Ajout de produits dans la base de données pour les administrateurs.
- Gestion des super-administrateurs avec création d'administrateurs.

## Installation et Utilisation

1. Clonez le projet depuis le référentiel Git.
2. Assurez-vous que PHP, Composer et Symfony sont installés sur votre système.
3. Installez les dépendances avec `composer install`.
4. Configurez votre base de données dans le fichier `.env`.
5. Créez le fichier de base de données dans le répertoire `dbvente`.
6. Appliquez les migrations avec `php bin/console doctrine:migrations:migrate`.
7. Chargez les données de test avec `php bin/console doctrine:fixtures:load`.
8. Lancez le serveur de développement avec `symfony server:start`.
