# Mercado Brasileiro 🇧🇷🇲🇦

Boutique e-commerce de produits brésiliens authentiques destinés au marché marocain.

## Stack Technique

- **Backend:** Laravel 10.x + PHP 8.2
- **Frontend:** Vue.js 3 + Vite + TailwindCSS + Pinia
- **Base de données:** MySQL 8.0
- **Cache/Queue:** Redis
- **Containerisation:** Docker + Docker Compose
- **Authentification:** Laravel Sanctum

## Prérequis

- Docker >= 20.10
- Docker Compose >= 2.0
- Git

## Installation

### 1. Cloner le projet

```bash
git clone <repository-url>
cd Hakim-01
```

### 2. Configurer les variables d'environnement

```bash
cp backend/.env.example backend/.env
```

### 3. Lancer les conteneurs

```bash
docker compose up -d
```

### 4. Installer les dépendances backend

```bash
docker compose exec backend composer install
docker compose exec backend cp .env.example .env
docker compose exec backend php artisan key:generate
```

### 5. Migrer et peupler la base de données

```bash
docker compose exec backend php artisan migrate --seed
```

### 6. Installer les dépendances frontend

```bash
docker compose exec frontend npm install
```

### 7. Accéder à l'application

- **Frontend:** http://localhost:3000
- **Backend API:** http://localhost:8000/api
- **Nginx (prod):** http://localhost:80

## Commandes utiles

```bash
# Voir les logs
docker compose logs -f backend
docker compose logs -f frontend

# Arrêter les conteneurs
docker compose down

# Reconstruire les images
docker compose up -d --build

# Exécuter les tests
docker compose exec backend php artisan test

# Lancer les workers queue
docker compose exec backend php artisan queue:work

# Accéder au shell backend
docker compose exec backend bash

# Accéder au shell frontend
docker compose exec frontend sh
```

## Comptes de test

| Rôle  | Email              | Mot de passe |
|-------|--------------------|--------------|
| Admin | admin@mercado.ma   | password123  |
| Client| client@mercado.ma  | password123  |

## Structure du projet

```
├── backend/          # API Laravel
├── frontend/         # Application Vue.js
├── nginx/            # Configuration Nginx
└── docker-compose.yml
```

## API Endpoints

### Authentification
- `POST /api/auth/register` - Inscription
- `POST /api/auth/login` - Connexion
- `POST /api/auth/logout` - Déconnexion
- `GET /api/auth/user` - Utilisateur connecté

### Produits
- `GET /api/produits` - Liste produits (paginée, filtres)
- `GET /api/produits/en-vedette` - Produits en vedette
- `GET /api/produits/{slug}` - Détail produit

### Catégories
- `GET /api/categories` - Toutes les catégories
- `GET /api/categories/{slug}` - Détail catégorie

### Commandes
- `GET /api/commandes` - Mes commandes (auth)
- `POST /api/commandes` - Créer une commande

### Panier
- `GET /api/panier` - Contenu du panier
- `POST /api/panier/ajouter` - Ajouter au panier
- `PUT /api/panier/{rowId}` - Modifier quantité
- `DELETE /api/panier/{rowId}` - Supprimer du panier

## License

MIT
