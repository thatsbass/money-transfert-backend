#!/bin/bash

cd "$(dirname "$0")/.." || exit

echo "Création des migrations pour les tables..."

# Créer la migration pour la table roles
php artisan make:migration create_roles_table --create=roles
echo "Migration 'roles' créée."

# Créer la migration pour la table users
php artisan make:migration create_users_table --create=users
echo "Migration 'users' créée."

# Créer la migration pour la table clients
php artisan make:migration create_clients_table --create=clients
echo "Migration 'clients' créée."

# Créer la migration pour la table verifications
php artisan make:migration create_verifications_table --create=verifications
echo "Migration 'verifications' créée."

# Créer la migration pour la table accounts
php artisan make:migration create_accounts_table --create=accounts
echo "Migration 'accounts' créée."

# Créer la migration pour la table transfers
php artisan make:migration create_transfers_table --create=transfers
echo "Migration 'transfers' créée."

# Créer la migration pour la table transactions
php artisan make:migration create_transactions_table --create=transactions
echo "Migration 'transactions' créée."

# Créer la migration pour la table payments
php artisan make:migration create_payments_table --create=payments
echo "Migration 'payments' créée."

# Créer la migration pour la table notifications
php artisan make:migration create_notifications_table --create=notifications
echo "Migration 'notifications' créée."

echo "Toutes les migrations ont été exécutées avec succès."
