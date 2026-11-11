# Gestion des Archives

Système de gestion d'archives administratives électroniques avec suivi des emplacements physiques, des fichiers numériques, des utilisateurs et des activités.

## 📋 À propos du projet

Cette application permet de gérer les archives administratives de manière centralisée et sécurisée. Elle maintient les informations sur les documents physiques originaux, leurs emplacements de stockage, les fichiers électroniques attachés, les utilisateurs, les départements et les activités du système.

L'accès aux archives est contrôlé selon le département et le rôle de l'utilisateur, et toutes les actions importantes sont enregistrées dans un journal d'audit.

### Fonctionnalités principales (V1)

- 🔐 Authentification par e-mail et mot de passe
- 👥 Gestion des utilisateurs et des départements
- 📁 Gestion des archives (création, modification, suppression douce, restauration)
- 📎 Téléversement et téléchargement sécurisés de fichiers (PDF, DOC, DOCX, XLS, XLSX)
- 📍 Gestion des emplacements de stockage physiques
- 🔍 Recherche et filtrage des archives
- 📊 Tableaux de bord administrateur et utilisateur
- 📝 Journal d'audit complet (connexion, création, modification, suppression, téléchargement)
- 🌐 Interface en français (arabe prévu pour une version ultérieure)

## 🛠️ Stack technique

| Composant | Technologie |
|-----------|-------------|
| Backend | Laravel 12 / PHP 8.2 |
| Frontend | Blade + Bootstrap 5 + JavaScript |
| Base de données | MySQL 8 |
| Authentification | Laravel Fortify |
| Stockage de fichiers | Laravel Private Storage |
| Build tool | Vite |
| Version control | Git |

## 📦 Prérequis

- PHP 8.2 ou supérieur
- Composer
- Node.js et npm
- MySQL 8
- Git

## 🚀 Installation

### 1. Cloner le dépôt

```bash
git clone https://github.com/YOUR_USERNAME/archive-management.git
cd archive-management