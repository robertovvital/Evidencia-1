<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Deliverable 2 - Application Logic

### 1. Models
- Department - defines the five system roles (`Admin`, `Sales`, `Purchasing`, `Warehouse`, `Route`) and has many `User` records.
- User - extends Laravel's `Authenticatable`, belongs to a `Department`, has many created/updated orders, and stores uploaded `OrderEvidence` records; includes `isAdmin()`, `isRoute()`, and `isWarehouse()` helpers.
- Order - uses `SoftDeletes`, belongs to `User` as `creator` and `updater`, and has many `OrderEvidence` rows; it also exposes status constants and helper methods for route/delivery evidence and status labels.
- OrderEvidence - stores order photo evidence, belongs to its `Order` and the `User` who uploaded it, and distinguishes route vs. delivered evidence with enum constants.

### 2. Migrations
- departments - creates the `departments` table with `id`, unique `name` (50), nullable `description`, and timestamps.
- users - extends the default users table with `department_id` as a nullable FK to `departments`, `active` boolean default `true`, and the required auth fields.
- orders - creates the order lifecycle table with `invoice_number` unique, customer metadata, status enum (`ordered`, `in_process`, `in_route`, `delivered`), `status_changed_at`, `created_by` and `updated_by` FKs, timestamps, and `softDeletes()` for archive behavior.
- order_evidences - creates the evidence table with `order_id` FK, enum `type` (`route` / `delivered`), `photo_path`, and `uploaded_by` FK.

### 3. Controllers
- HomeController - public landing/search controller that checks the order status by invoice number from the query string.
- Auth/LoginController - handles login form display, authentication, inactive-user rejection, and logout.
- DashboardController - returns the counters used on the dashboard summary links.
- UserController - admin-only controller for listing users, creating new employees, editing profiles, and logically deactivating them.
- OrderController - authenticated employees use it to list, create, view, edit, update status, and logically archive orders.
- ArchivedOrderController - lists soft-deleted orders and restores them back into the active list.

### 4. Seeders / factories
- Running `php artisan db:seed` populates the five departments, creates the default admin user `admin@halcon.com` with password `admin123`, and seeds demo users for the operational departments (`sales@halcon.com`, `purchasing@halcon.com`, `warehouse@halcon.com`, `route@halcon.com`) with password `password`.
- `OrderSeeder` creates the sample invoices `INV-0001` (`ordered`), `INV-0002` (`in_process`), `INV-0003` (`in_route` with a route evidence photo), and `INV-0004` (`delivered` with both route and delivered evidence photos), then adds 15 additional random orders and 2 archived soft-deleted orders.
- `UserFactory` generates random users assigned to a random department, and `OrderFactory` builds random orders with sequential invoice numbers starting from `INV-1001`.

### 5. Basic views
- Public views: `home.blade.php` provides the customer invoice lookup screen, while `auth/login.blade.php` provides the employee login form.
- Protected views: `dashboard.blade.php` provides the authenticated dashboard menu and summary counts; `users/*` handles the user list, create/edit flow, and logical deactivation; `orders/*` handles the newest-first order list, create/edit flow, detail view, status change, photo evidence upload for `Route`/`Admin`, and logical archive; `orders/archived.blade.php` lists archived orders and lets the user restore them.

### How to run this deliverable locally
- Copy or rename `.env.example` to `.env` and set the application key.
- Run `php artisan migrate:fresh --seed` to create the database structure and fill the sample data.
- Run `php artisan storage:link` so evidence photos are accessible under `/storage/evidences/...`.
- Start the app with `php artisan serve`.
- Default login: `admin@halcon.com` / `admin123`.
