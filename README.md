# back-end01

# Backend - Projet de Transfert d'Argent

Ce projet est le backend d'une application de transfert d'argent *MoneyX*, permettant aux utilisateurs d'envoyer et de recevoir de l'argent de manière sécurisée. Ce backend est développé en Laravel, avec PostgreSQL comme base de données, Redis pour la gestion de cache et de session, et JSON Web Tokens (JWT) pour l'authentification sécurisée.

## Technologies Utilisées

- **Framework**: Laravel 10
- **Base de données**: PostgreSQL
- **Cache & Sessions**: Redis
- **Authentification**: JWT
- **Langage**: PHP 8.3

## Fonctionnalités Principales

- **Inscription et connexion des utilisateurs** avec validation OTP et JWT.
- **Gestion des transferts d'argent** entre utilisateurs.
- **Historique des transactions** pour suivre les envois et réceptions.
- **Gestion de compte** : solde, informations personnelles, et historique.
- **Sécurité** : JWT pour l'authentification, validation OTP pour la vérification d'identité.
- **Blacklist de jetons** : Utilisation de Redis pour stocker et vérifier les jetons révoqués.

## Authentification et Sécurité

Ce projet utilise JWT pour sécuriser les routes. Les utilisateurs doivent inclure un token dans les en-têtes de leurs requêtes pour accéder aux endpoints protégés. Redis est utilisé pour stocker les jetons révoqués.


## Gestion de Redis

Redis est utilisé pour :

- **Cache des requêtes**
- **Gestion des sessions**
- **Blacklist de jetons révoqués**


## Licence

Ce projet est sous licence MIT.
