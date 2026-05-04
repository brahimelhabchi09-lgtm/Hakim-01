.PHONY: help up down build migrate seed test format lint fresh

help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' Makefile | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-20s\033[0m %s\n", $$1, $$2}'

up: ## Start all Docker containers
	docker compose up -d

down: ## Stop all Docker containers
	docker compose down

build: ## Build all Docker images
	docker compose build

migrate: ## Run database migrations
	docker exec mundo_backend php artisan migrate

seed: ## Seed the database
	docker exec mundo_backend php artisan db:seed

fresh: ## Fresh migrate and seed
	docker exec mundo_backend php artisan migrate:fresh --seed

test: ## Run all tests
	docker exec mundo_backend php artisan test
	cd frontend && npm run test

test-frontend: ## Run frontend tests
	cd frontend && npm run test

test-backend: ## Run backend tests
	docker exec mundo_backend php artisan test

format: ## Format all code
	docker exec mundo_backend ./vendor/bin/php-cs-fixer fix
	cd frontend && npm run format

lint: ## Lint all code
	docker exec mundo_backend php -l ./app
	cd frontend && npm run lint

logs: ## View container logs
	docker compose logs -f

logs-backend: ## View backend logs
	docker compose logs -f backend

logs-frontend: ## View frontend logs
	docker compose logs -f frontend

shell: ## Access backend container shell
	docker exec -it mundo_backend bash

shell-db: ## Access database shell
	docker exec -it mundo_postgres psql -U wolfstore_user wolfstore_br

cache-clear: ## Clear all caches
	docker exec mundo_backend php artisan cache:clear
	docker exec mundo_backend php artisan config:clear
	docker exec mundo_backend php artisan route:clear
	docker exec mundo_backend php artisan view:clear
