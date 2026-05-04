# API Documentation

## Authentication

### POST /api/register
Register a new user account.

**Body:**
```json
{
  "nom": "string",
  "prenom": "string",
  "email": "string",
  "password": "string",
  "password_confirmation": "string"
}
```

### POST /api/login
Authenticate and receive a Bearer token.

**Body:**
```json
{
  "email": "string",
  "password": "string"
}
```

### POST /api/logout
Logout (requires authentication).

## Products

### GET /api/produits
List all active products with filtering and pagination.

**Query Parameters:**
- `search` - Search by name
- `category_id` - Filter by category
- `marque_id` - Filter by brand
- `min_price` / `max_price` - Price range
- `sort` - Sorting (price_asc, price_desc, newest)
- `page` - Page number

### GET /api/produits/{slug}
Get product details by slug.

## Cart

### POST /api/panier
Add item to cart.

### GET /api/panier
Get current cart contents.

### PUT /api/panier/{id}
Update cart item quantity.

### DELETE /api/panier/{id}
Remove item from cart.

### DELETE /api/panier/clear
Clear entire cart.

## Checkout

### POST /api/checkout
Create a new order.

## Wishlist

### POST /api/wishlist/toggle
Add or remove product from wishlist.

### GET /api/wishlist
Get user's wishlist.

## Reviews

### POST /api/avis
Submit a product review.

## Admin Routes (requires admin role)

### GET /api/admin/dashboard
Get dashboard statistics.

### CRUD /api/admin/produits
Manage products.

### CRUD /api/admin/categories
Manage categories.

### CRUD /api/admin/marques
Manage brands.

### GET /api/admin/commandes
List all orders.

### PATCH /api/admin/commandes/{id}/statut
Update order status.

### GET /api/admin/avis
List all reviews for moderation.

### PATCH /api/admin/avis/{id}/approve
Approve a review.
