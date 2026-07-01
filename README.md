# AllSystem

Plataforma modular para PyMEs construida con Laravel 12, Inertia, Vue 3, Tailwind y SQLite.

## Requisitos

- PHP 8.2+
- Composer 2+
- Node.js 20+
- NPM 10+

## Instalación desde cero

1. `composer install`
2. `npm install`
3. Copia `.env.example` a `.env`
4. `php artisan key:generate`
5. Crea la base SQLite si no existe:
   Windows PowerShell: `New-Item -ItemType File database/database.sqlite -Force`
   macOS/Linux: `touch database/database.sqlite`
6. `php artisan migrate --seed`
7. `npm run build`
8. `php artisan serve`

Para desarrollo con recarga en vivo:

1. `php artisan serve`
2. `npm run dev`

Si alguna vez se interrumpe Vite y la aplicación intenta seguir cargando assets del dev server, elimina `public/hot` y vuelve a ejecutar `npm run build`.

## Credenciales demo

- Admin: `admin@demo.local` / `password123`
- Operador: `operador@demo.local` / `password123`

## Comandos útiles

- Tests: `php artisan test`
- Formato PHP: `vendor\\bin\\pint`
- Build frontend: `npm run build`
