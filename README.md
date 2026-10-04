# QuickOrder

QuickOrder is a small Laravel marketplace. Visitors can browse in-stock products without an account. Buyers sign in to place orders, and sellers use their own panel to add products and review the orders they receive.

The interface can be switched between Bengali and English. This changes the interface labels and messages; it does not translate product names or descriptions entered by sellers.

## What it includes

- Public product catalogue
- Buyer registration, sign-in, ordering, and order history
- Seller registration, product creation, and an order list
- Stock checks when an order is placed
- Bengali and English interface text, with the choice kept in the session

There is no payment gateway, product image upload, product editing or deletion, or seller workflow for changing an order's status yet.

## Requirements

- PHP 8.2 or later
- Composer
- XAMPP MySQL/MariaDB running on port `3306`
- PHP's `pdo_mysql` extension; `pdo_sqlite` is also needed to run the tests

## Run locally

Start MySQL from the XAMPP control panel. Create the database once:

```sql
CREATE DATABASE quickorder CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

From the project directory, install dependencies and prepare your environment:

```powershell
composer install
Copy-Item .env.example .env
php artisan key:generate
```

Set the database values in `.env`:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=quickorder
DB_USERNAME=root
DB_PASSWORD=
```

The blank password matches a common local XAMPP setup. Use your own MySQL credentials if they differ. Then create the tables and start Laravel's local server:

```powershell
php artisan migrate
php artisan serve
```

Open http://127.0.0.1:8000. This runs on PHP's built-in development server, not Nginx or XAMPP Apache.

## Using the app

- `/` shows in-stock products to anyone.
- `/register` creates a buyer or seller account.
- `/seller` is where sellers add products and review incoming orders.
- `/my-orders` shows a buyer's order history.
- Use the Bengali and English links in the header to change the interface language.

## Tests

Run the suite with:

```powershell
php artisan test
```

Tests use an in-memory SQLite database, so PHP needs `pdo_sqlite` enabled as well as `pdo_mysql`.

## Before deployment

The checked-in setup is for local XAMPP. A blank root password and `APP_DEBUG=true` are for local development only. In production, use a dedicated database user with a strong password, set `APP_ENV=production` and `APP_DEBUG=false`, and provide the correct `APP_URL`. Keep `.env` and credentials out of source control.

If the application and MySQL run in separate containers, set `DB_HOST` to the MySQL service's network hostname. `127.0.0.1` refers to the application container itself. Once the database is ready, run migrations as part of the release process:

```sh
php artisan migrate --force
```

This repository does not include Docker images, ECS configuration, or deployment automation. The schema has been migrated on XAMPP MariaDB; production MySQL deployment still needs its own verification. See `PROJECT_OVERVIEW.md` for route and data model details.
