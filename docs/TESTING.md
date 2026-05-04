# Testing Guide

## Backend Tests

```bash
# Run all tests
docker exec mundo_backend php artisan test

# Run unit tests only
docker exec mundo_backend php artisan test --testsuite=Unit

# Run feature tests only
docker exec mundo_backend php artisan test --testsuite=Feature

# Run specific test file
docker exec mundo_backend php artisan test tests/Feature/AuthTest.php

# Run with coverage
docker exec mundo_backend php artisan test --coverage
```

## Frontend Tests

```bash
# Run all tests
cd frontend && npm run test

# Run in watch mode
cd frontend && npm run test:watch

# Run with coverage
cd frontend && npm run test -- --coverage
```

## Test Structure

- **Unit tests**: Model relationships, service logic, DTOs, rules, helpers
- **Feature tests**: API endpoints, authentication, authorization, validation
- **Component tests**: Vue UI components rendering and interactions
- **Store tests**: Pinia state management actions
- **Composable tests**: Vue composition functions

## Factories

All models have factories with states:
- UserFactory: `->admin()`
- ProduitFactory: `->onSale()`, `->outOfStock()`
- CommandeFactory: with automatic numero generation
