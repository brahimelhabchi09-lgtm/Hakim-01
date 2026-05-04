# Deployment Guide

## Production Deployment

### Docker Compose

```bash
# Build and start
docker compose -f docker-compose.prod.yml up -d --build

# Run migrations
docker exec mundo_backend php artisan migrate --force

# Clear caches
docker exec mundo_backend php artisan config:cache
docker exec mundo_backend php artisan route:cache
docker exec mundo_backend php artisan view:cache
```

### Environment Variables

Set the following in production:
- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_KEY=<generated-key>`
- Database credentials
- Redis credentials
- Mail/SMTP settings

### SSL

Configure Nginx with SSL certificates via Let's Encrypt.

### Health Checks

- Backend: `GET /api/health`
- Frontend: `GET /`
- Database: `pg_isready`

### Backups

```bash
# Database backup
docker exec mundo_postgres pg_dump -U wolfstore_user wolfstore_br > backup.sql

# Restore
docker exec -i mundo_postgres psql -U wolfstore_user wolfstore_br < backup.sql
```
