# Learning Management System (LMS)

A full-featured Laravel-based Learning Management System for running an online course business with role-based access for admin, instructor, and student users.

This repository is organized for real project development, including backend/admin operations, instructor workflows, student enrollment/purchase flow, content management, reporting, and test tooling.

## Project Overview

This LMS supports end-to-end course operations:

- User authentication (email/password + Google OAuth)
- Role-based access control (Admin, Instructor, User) using Spatie Permissions
- Course catalog with categories and subcategories
- Course creation and curriculum management (sections, lectures, goals)
- Wishlist and cart flow
- Checkout and payment integration (Stripe)
- Coupons and discount management
- Orders and enrollment tracking
- Reviews and Q&A
- Blog module (categories + posts)
- SMTP and site settings management
- Instructor/user chat and dashboard views
- Reporting by date, month, and year

## Tech Stack

- Backend: Laravel 10, PHP 8.1+
- Frontend tooling: Vite, TailwindCSS, Alpine.js, Vue 3
- Database: MySQL
- Auth extras: Laravel Sanctum, Laravel Socialite
- PDF/Export: DomPDF, Laravel Excel
- Permissions: Spatie Laravel Permission
- Payments: Stripe PHP SDK
- E2E Tests: Playwright

## Repository Structure

- `app/Http/Controllers` -> Admin, Instructor, User, Frontend, and auth controllers
- `routes/web.php` -> Web routes for all role-specific modules
- `resources/views` -> Blade templates
- `database/migrations` -> Schema changes
- `database/seeders` -> Seeders for roles, users, settings, categories, and bulk demo LMS data
- `public/` -> Public assets

## Prerequisites

Install these before setup:

- PHP `>= 8.1`
- Composer `>= 2`
- Node.js `>= 18` and npm
- MySQL `>= 8` (or compatible)
- Git

## Installation and Setup

1. Clone the repository and enter the project directory.
2. Install PHP dependencies:

```bash
composer install
```

3. Install Node dependencies:

```bash
npm install
```

4. Create environment file:

```bash
cp .env.example .env
```

On Windows PowerShell:

```powershell
Copy-Item .env.example .env
```

5. Generate app key:

```bash
php artisan key:generate
```

6. Configure database values in `.env`:

- `DB_CONNECTION`
- `DB_HOST`
- `DB_PORT`
- `DB_DATABASE`
- `DB_USERNAME`
- `DB_PASSWORD`

7. Run migrations and seeders:

```bash
php artisan migrate --seed
```

8. Start backend server:

```bash
php artisan serve
```

9. Start frontend dev server:

```bash
npm run dev
```

## Optional Environment Integrations

Set these only if you use the features:

- Google OAuth: `GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET`, `GOOGLE_REDIRECT_URI`
- Stripe payments: `STRIPE_KEY`, `STRIPE_SECRET`
- Mail delivery: `MAIL_*`

## Seeded Demo Accounts

The seeders create default users (password: `111`):

- Admin: `admin@gmail.com`
- Instructor: `instructor@gmail.com`
- User: `user@gmail.com`

Security note: change all default credentials immediately in non-local environments.

## Development Commands

- Build production assets:

```bash
npm run build
```

- Run PHP tests:

```bash
php artisan test
```

- Prepare E2E data:

```bash
npm run e2e:prepare
```

- Install Playwright browser:

```bash
npm run e2e:install
```

- Run E2E tests:

```bash
npm run e2e
```

## Security First

Security is a mandatory baseline for this project:

- Never commit secrets (`.env`, API keys, tokens, private keys)
- Use `.env` values per environment and keep production secrets in secure secret managers
- Rotate exposed credentials immediately
- Enforce least-privilege DB/API credentials
- Validate/authorize every role-sensitive route and action
- Keep dependencies updated and patch vulnerabilities quickly

If you discover a security issue, report it privately to the maintainers before opening a public issue.

## Contributing

Contributions are welcome. Please follow this workflow:

1. Fork the repository
2. Create a feature branch from `main`
3. Keep commits clear and scoped (prefer conventional commit style)
4. Run tests locally before pushing
5. Open a Pull Request with a clear summary and validation steps

## License

This project is licensed under the MIT License.

If you need a formal license file, add a `LICENSE` file with the MIT text at the repository root.
