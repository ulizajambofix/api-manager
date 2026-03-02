# API Management Portal

Production-ready API Management Portal architecture using Laravel + Inertia.js + Vue 3 + Tailwind.

## Folder Structure

```text
app/
  Enums/                # Domain enums (roles)
  Http/
    Controllers/
      Api/              # REST endpoints for app modules and analytics
      Web/              # Inertia page controllers
    Middleware/         # RBAC, tenant context, API key rate limiting
    Requests/           # Form request validation objects
    Resources/          # API response transformers
  Models/               # Eloquent entities and relationships
  Policies/             # Authorization rules per model
  Repositories/         # Data access abstractions
  Services/             # Business logic orchestration
config/
  l5-swagger.php        # OpenAPI generation config
database/
  migrations/           # PostgreSQL schema + indexes + FK + soft deletes
  seeders/              # Roles and demo seed data
docs/openapi/
  openapi.yaml          # Versioned API contract
resources/js/
  Components/           # Reusable Vue UI widgets
  Layouts/              # Admin shell
  Pages/                # Inertia views
routes/
  web.php               # Inertia routes
  api.php               # REST API routes + middleware
docker/
  nginx/default.conf    # Development reverse proxy
docker-compose.yml      # App/Postgres/Redis/Nginx local stack
Dockerfile              # PHP-FPM app image
```

## Core Features Implemented

- Sanctum-ready auth route grouping + email verification middleware flow.
- RBAC (Admin, Developer, Viewer) with route middleware and policies.
- API CRUD with versioning, status toggles, rate limits.
- API key lifecycle: generate, assign, expire, revoke, regenerate.
- Request logging model + filtered pagination endpoint.
- Dashboard metrics and chart-ready analytics endpoint.
- Custom API-key-based rate limiter middleware (Redis or DB fallback).
- OpenAPI documentation scaffold + Swagger config.
- Webhook endpoint registration + dispatch service.
- Usage billing preparation model/service.
- Multi-tenant support via tenant context middleware and tenant-bound models.
- Inertia + Vue 3 reusable components (DataTable, Modal, FormInput) and pages.
- Dockerized local development environment.

## Setup

1. Copy this repository into a Laravel 12 application skeleton (or add framework bootstrap files).
2. Install dependencies:
   - `composer install`
   - `npm install`
3. Configure `.env` with PostgreSQL, Redis, mail, Sanctum stateful domains.
4. Run migrations and seeders:
   - `php artisan migrate --seed`
5. Build frontend:
   - `npm run dev`
6. Serve app:
   - `php artisan serve`

## Suggested Composer Packages

- `laravel/sanctum`
- `spatie/laravel-permission` (optional alternative to custom RBAC)
- `darkaonline/l5-swagger`
- `laravel/horizon` (optional for webhook and usage jobs)

## Swagger

- Source spec: `docs/openapi/openapi.yaml`
- Generate docs (after installing L5 Swagger): `php artisan l5-swagger:generate`

## Docker

- `docker compose up --build`
- Services: app (php-fpm), nginx, postgres, redis, node

