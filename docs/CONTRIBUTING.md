# Contributing Guide

## Development Workflow

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Make your changes
4. Run tests (`composer test` for backend, `npm run test` for frontend)
5. Commit with conventional messages
6. Push and open a Pull Request

## Code Style

- Backend: Follow PSR-12 (run `composer format`)
- Frontend: ESLint + Prettier (run `npm run lint`)

## Commit Messages

Use conventional commits:
- `feat:` new feature
- `fix:` bug fix
- `docs:` documentation
- `refactor:` code refactoring
- `test:` tests
- `chore:` maintenance

## Testing

```bash
# Backend tests
docker exec mundo_backend php artisan test

# Frontend tests
docker exec mundo_frontend npm run test
```

## Pull Request Checklist

- [ ] Tests pass
- [ ] Code follows style guidelines
- [ ] Documentation updated
- [ ] No breaking changes (or documented)
