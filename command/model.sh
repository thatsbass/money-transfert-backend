#!/bin/bash

# Se déplacer dans le dossier racine du projet Laravel
cd "$(dirname "$0")/.." || exit

# Vérifie si artisan est présent dans le dossier racine
if [ ! -f artisan ]; then
    echo "Ce script doit être exécuté depuis le dossier /commands et le dossier racine doit contenir artisan."
    exit 1
fi

# Création des modèles avec migrations
models=("Role" "User" "Client" "Verification" "Compte" "Transfert" "Transaction" "Paiement" "Notification")

for model in "${models[@]}"; do
    echo "Création du modèle et de la migration pour : $model"
    php artisan make:model $model -m
done

echo "Tous les modèles et migrations ont été créés avec succès."
