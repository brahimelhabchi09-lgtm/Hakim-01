# Frontend Architecture

## Tech Stack

- Vue 3 (Composition API)
- Vite (build tool)
- Pinia (state management)
- Vue Router (routing)
- Tailwind CSS (styling)
- Axios (HTTP client)

## Directory Structure

```
frontend/src/
├── components/
│   ├── ui/           # Reusable UI components
│   ├── layout/       # Layout components (header, footer)
│   ├── cart/         # Cart-related components
│   ├── checkout/     # Checkout flow components
│   ├── product/      # Product detail components
│   └── admin/        # Admin panel components
├── views/            # Page components
│   └── admin/        # Admin pages
├── stores/           # Pinia stores
├── composables/      # Vue composables
├── services/         # API service layer
├── router/           # Route definitions
└── assets/           # Styles and static assets
```

## State Management

### Products Store
Manages product catalog, filters, and pagination.

### Cart Store
Manages shopping cart state with localStorage persistence.

### Auth Store
Manages user authentication, tokens, and profile.

### Wishlist Store
Manages saved products.

## Routing

Routes are defined in `src/router/index.js` with:
- Public routes (home, catalog, product, cart)
- Auth-required routes (checkout, account, orders)
- Admin-required routes (admin/*)

## Styling

Tailwind CSS with custom theme configuration in `tailwind.config.js`.
Global styles in `assets/styles/main.css`.
