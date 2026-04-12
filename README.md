# AllSystem

Plataforma modular para PyMEs con Laravel 12 + Vue 3 + Inertia + SQLite.

## Instalación local

1. `composer install`
2. `npm install`
3. `cp .env.example .env`
4. `php artisan key:generate`
5. `touch database/database.sqlite`
6. Verifica `DB_CONNECTION=sqlite` y `DB_DATABASE=database/database.sqlite` en `.env`
7. `php artisan migrate --seed`
8. `npm run dev`
9. `php artisan serve`

## Credenciales demo

- Admin: `admin@demo.local` / `password123`
- Operador: `operador@demo.local` / `password123`
