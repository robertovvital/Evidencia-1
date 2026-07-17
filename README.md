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

## Evidence 3 - Frontend (Native CSS)

This evidence adds native CSS styling on top of the existing Evidence 2 logic, using plain CSS only with no CSS framework.

### CSS files created
- `public/css/app.css` - shared design tokens, base layout, navbar, page shell, buttons, forms, tables, status badges and utility helpers.
- `public/css/auth.css` - all styling for the guest/public search screen and the employee login card, including the result block for invoice lookup.
- `public/css/dashboard.css` - responsive dashboard card grid for the summary links and the dashed "add new" variant.
- `public/css/users.css` - small user-module additions, including active/inactive pills and the department select width helper.
- `public/css/orders.css` - order-specific evidence photo grid and the highlighted conditional upload field for status changes.

Global/shared styles live in `app.css`, while the other files only add page-specific rules on top of that shared visual system.

### Evidence 2 logic remains intact
- Models: `Department`, `User`, `Order`, `OrderEvidence` with their relationships are still present and unchanged in this delivery.
- Migrations: the four primary tables with their keys and constraints remain in place.
- Controllers: `Home`, `Auth\Login`, `Dashboard`, `User`, `Order`, and `ArchivedOrder` remain unchanged in behavior.
- Seeders / factories: department, admin + demo user, and sample order data remain intact.
- Basic views: dashboard, users, orders, archived orders, and the public search/login views remain in place and still drive the same flows.

### How to run this project
- Clone the repository and open the project folder.
- Copy `.env.example` to `.env` if it is not already present.
- Run `composer install` to install the PHP dependencies.
- Run `php artisan key:generate` to generate the app key.
- Configure the database connection for this project. The current repository setup uses SQLite, so the expected `.env` values are:
  - `DB_CONNECTION=sqlite`
  - `DB_DATABASE=database/database.sqlite`
  - If you prefer MySQL instead, update `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` accordingly.
- Ensure the SQLite file exists, then run `php artisan migrate:fresh --seed` to rebuild the schema and load the sample data.
- Run `php artisan storage:link` so the order evidence photos can be served from `public/storage`.
- Start the application with `php artisan serve`.
- Seeded login credentials:
  - Admin: `admin@halcon.com` / `admin123`
  - Sales: `sales@halcon.com` / `password`
  - Purchasing: `purchasing@halcon.com` / `password`
  - Warehouse: `warehouse@halcon.com` / `password`
  - Route: `route@halcon.com` / `password`
