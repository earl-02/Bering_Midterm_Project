# Game Collection (Laravel 10+)

Requirements:
- PHP 8.1+
- Composer
- MySQL
- Node.js (for assets)
- Laravel 10+

Quick install:

1. composer install
2. cp .env.example .env
3. Edit .env and set DB_CONNECTION, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD
4. php artisan key:generate
5. php artisan migrate --seed
6. npm install
7. npm run dev
8. php artisan serve

Notes / Checklist:
- Confirm DB credentials in .env
- Install Laravel Breeze or Jetstream for authentication scaffolding if not already installed:
  - composer require laravel/breeze --dev
  - php artisan breeze:install
  - npm install && npm run dev
  - php artisan migrate --seed
- If using Breeze, ensure auth routes are enabled (require __DIR__.'/auth.php' in routes/web.php).
