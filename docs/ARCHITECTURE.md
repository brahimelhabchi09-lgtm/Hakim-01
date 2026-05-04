# Architecture Overview

## System Design

```
┌─────────────────────────────────────────────────┐
│                    Nginx                        │
│         (Reverse Proxy + Static Files)          │
└──────────────┬──────────────────┬───────────────┘
               │                  │
    ┌──────────▼──────┐  ┌───────▼──────────────┐
    │   Frontend       │  │      Backend          │
    │   (Vue.js SPA)   │  │   (Laravel API)       │
    │   :3000          │  │   :8000               │
    └──────────────────┘  └───────┬──────────────┘
                                   │
              ┌────────────────────┼─────────────┐
              │                    │             │
    ┌─────────▼──────┐  ┌────────▼─────┐  ┌────▼─────┐
    │  PostgreSQL     │  │    Redis      │  │  Mailpit  │
    │  :5432          │  │  :6379        │  │ :1025/8025│
    └────────────────┘  └───────────────┘  └──────────┘
```

## Backend Architecture

```
app/
├── Controllers/    # Request handling
├── Models/         # Eloquent models
├── Services/       # Business logic
├── DTOs/           # Data transfer objects
├── Events/         # Domain events
├── Listeners/      # Event handlers
├── Notifications/  # User notifications
├── Policies/       # Authorization
├── Rules/          # Validation rules
├── Traits/         # Reusable model behavior
├── Observers/      # Model observers
├── Providers/      # Service providers
└── Helpers/        # Utility functions
```

## Data Flow

1. Request → Nginx → Laravel API
2. Controller validates via FormRequest
3. Service layer handles business logic
4. Events dispatched for side effects
5. Response returned via API Resources
