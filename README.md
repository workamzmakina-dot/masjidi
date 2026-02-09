# Mosque SaaS Platform

Multi-tenant SaaS platform for mosques with a Laravel 11 API backend and a React 18 frontend.

## Structure

```
/backend   Laravel 11 API
/frontend  React 18 + Vite + Tailwind
```

## Backend (Laravel 11)

```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

## Frontend (React 18)

```bash
cd frontend
npm install
cp .env.example .env
npm run dev
```

## Default Accounts

- Platform Admin: `admin@mosquesaas.com` / `password`
- Tenant Admin (Al-Markaz): `admin@al-markaz.org` / `password`

## Key Endpoints

- `POST /api/auth/login`
- `POST /api/auth/logout`
- `GET /api/auth/me`
- `GET /api/health`

Tenant resolution uses `X-Tenant-Slug` or the `{slug}` URL parameter.
