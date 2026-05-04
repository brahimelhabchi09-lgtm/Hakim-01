# Database Schema

## Tables

### categories
- id, nom, slug, description, parent_id, created_at, updated_at

### marques
- id, nom, slug, description, created_at, updated_at

### origins
- id, nom, slug, created_at, updated_at

### produits
- id, category_id, marque_id, origin_id, nom, slug, description, prix, prix_promo, stock, image, statut, created_at, updated_at

### tags
- id, nom, slug, created_at, updated_at

### produit_tag (pivot)
- produit_id, tag_id

### users
- id, nom, prenom, email, password, telephone, is_admin, created_at, updated_at

### commandes
- id, user_id, numero, total, statut, adresse_livraison, ville, statut_paiement, methode_paiement, created_at, updated_at

### ligne_commandes
- id, commande_id, produit_id, quantite, prix_unitaire, created_at, updated_at

### paiements
- id, commande_id, montant, methode, statut, transaction_id, created_at, updated_at

### wishlists
- id, user_id, created_at, updated_at

### wishlist_items
- id, wishlist_id, produit_id, created_at, updated_at

### avis
- id, produit_id, user_id, note, commentaire, approuve, created_at, updated_at

### notifications
- id, type, notifiable_id, data, read_at, created_at, updated_at

## Relationships

- Category 1:N Produit
- Marque 1:N Produit
- Origin 1:N Produit
- Produit N:M Tag
- User 1:N Commande
- Commande 1:N LigneCommande
- Commande 1:1 Paiement
- User 1:1 Wishlist
- Wishlist 1:N WishlistItem
- Produit 1:N Avis
- User 1:N Avis
