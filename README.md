# WolfStore BR - E-Commerce Platform

A full-stack e-commerce application built with Laravel (backend) and Vue.js (frontend), containerized with Docker.

## Tech Stack

- **Backend**: Laravel 11, PostgreSQL, Redis
- **Frontend**: Vue 3, Vite, Pinia, Tailwind CSS
- **Infrastructure**: Docker, Nginx, Mailpit, pgAdmin

## Getting Started

### Prerequisites

- Docker & Docker Compose
- Node.js 20+ (for local development)

### Quick Start

```bash
# Clone the repository
git clone https://github.com/brahimelhabchi09-lgtm/Hakim-01.git
cd Hakim-01

# Start all services
docker compose up -d

# Run migrations
docker exec mundo_backend php artisan migrate

# Access the application
# Frontend: http://localhost:3000
# Backend API: http://localhost:8000
# Mailpit: http://localhost:8025
# pgAdmin: http://localhost:5050
```

## Project Structure

```
├── backend/          # Laravel API
├── frontend/         # Vue.js SPA
├── nginx/            # Nginx configuration
└── docker-compose.yml
```

## API Documentation

See [docs/API.md](docs/API.md) for endpoint documentation.

## License

MIT
