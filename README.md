# SOAPS - Simple Office Administration and Personnel System

A modern web application for office administration and personnel management. Built on Laravel 12 with Vite-powered assets and clean architecture.

---

## 1. Tech Stack

- **Backend:** PHP 8.2, Laravel 12
- **Frontend:** Vite, Vue 3, Inertia.js, TailwindCSS 4
- **Database:** SQLite (default) / MySQL / MariaDB
- **Runtime:** Node.js 18+, Composer 2+
- **Recommended Dev Environment:** Laragon on Windows (ships with required PHP extensions)

---

## 2. System Requirements

| Component | Minimum Version | Notes |
|-----------|-----------------|-------|
| PHP | 8.2.x | Enable `fileinfo`, `openssl`, `pdo_sqlite/pdo_mysql`, `mbstring`, `curl`, `zip` |
| Composer | 2.6+ | Used for PHP dependency management |
| Node.js / npm | Node 18+, npm 9+ | Required for Vite asset build |
| Database | SQLite 3+ (default) / MySQL 8 / MariaDB 10.5 | Update `.env` with credentials |
| Git | latest | Source control |

> **Windows users:** Laragon includes PHP, MySQL, and Node out of the box. Ensure PHP is added to your PATH before running artisan commands from terminals outside Laragon.

---

## 3. Quick Start (Fresh Install)

```bash
# 1. Clone project
git clone <repository-url>
cd SOAPS

# 2. Install PHP dependencies
composer install

# 3. Environment + app key
cp .env.example .env
php artisan key:generate

# 4. Configure .env (optional - defaults work for development)
#   - DB_CONNECTION=sqlite (default) or mysql for production
#   - DB_DATABASE=soaps (for MySQL)
#   - DB_USERNAME=root
#   - DB_PASSWORD=your_password
#   - APP_URL=http://soaps.test (or your domain)

#   - MAIL_MAILER=smtp
#   - MAIL_HOST=smtp.gmail.com
#   - MAIL_PORT=587
#   - MAIL_USERNAME=your-email@gmail.com
#   - MAIL_PASSWORD=your-app-password
#   - MAIL_ENCRYPTION=tls
#   - MAIL_FROM_ADDRESS=your-email@gmail.com
#   - MAIL_FROM_NAME="${APP_NAME}"

# 5. Run migrations + seeders (creates default user)
php artisan migrate --seed

# 6. Link storage for uploaded files (REQUIRED)
php artisan storage:link

# 7. Install and compile assets
npm install
npm run build   # production assets
# or npm run dev for hot reload during development

# 8. Serve application
php artisan serve
# Visit: http://127.0.0.1:8000
```

---

## 4. Seeded Accounts

| Role | Email | Password |
|------|-------|----------|
| Default User | test@example.com | password |

> Update credentials immediately in production. Additional users can be created through the application interface or by modifying `database/seeders/DatabaseSeeder.php`.

---

## 5. Useful Artisan & npm Commands

| Command | Purpose |
|---------|---------|
| `php artisan migrate:fresh --seed` | Reset database and reseed demo data |
| `php artisan storage:link` | **Important:** expose `storage/app/public` via `public/storage` |
| `php artisan queue:work` | Run queued jobs (if using notifications or async tasks) |
| `php artisan optimize:clear` | Clear config, route, view caches |
| `php artisan config:clear && php artisan cache:clear` |
| `npm run dev` | Watch + hot reload assets |
| `npm run build` | Compile & minify production assets |
| `npm run build:ssr` | Build with server-side rendering support |

### Composer Scripts

- `composer run dev` ⇒ boots Laravel server, queue listener, and Vite concurrently (if configured)
- `composer run setup` ⇒ full install workflow (composer + key + migrate + npm build) (if configured)

---

## 6. Environment Tips

- **File Uploads:** uploaded files live in `storage/app/public`. Missing images usually mean `php artisan storage:link` was skipped.
- **Sessions:** configured via `config/session.php`; adjust timeout/security as needed.
- **Mail & Queues:** set `MAIL_*` + queue driver in `.env` before enabling email alerts or background jobs.
- **Database:** Default uses SQLite for easy setup. Switch to MySQL/MariaDB for production by updating `DB_CONNECTION` and related settings.
- **Logging:** check `storage/logs/laravel.log` when debugging.

---

## 7. Project Map

```
app/
├── Http/
│   ├── Controllers/        # Web controllers
│   ├── Middleware/         # Custom middleware
│   └── Kernel.php          # Middleware registration
├── Models/                 # Eloquent models (User, etc.)
└── Services/               # Business logic services

database/
├── migrations/             # Schema definition
└── seeders/                # Default data seeding

resources/
├── views/                  # Blade templates
├── js/                     # Vue.js components and entry points
│   ├── app.ts             # Main application entry
│   └── ssr.ts             # Server-side rendering entry
└── css/                    # TailwindCSS styles

public/
├── storage/ -> ../storage/app/public (symlink)
└── build/                  # Vite compiled assets
```

---

## 8. Testing & Quality

```bash
# Run automated tests
php artisan test

# Code formatting (if Pint is installed)
./vendor/bin/pint

# Lint JavaScript/TypeScript (if configured)
npm run lint
```

---

## 9. Common Issues & Solutions

### Vite Manifest Not Found Error
If you encounter `ViteManifestNotFoundException`, run:
```bash
npm run build
```
This generates the missing `public/build/manifest.json` file.

### Storage Link Issues
If uploaded files are not displaying:
```bash
php artisan storage:link
```

### Cache Issues
After environment changes, clear caches:
```bash
php artisan optimize:clear
```

---

## 10. Maintenance Checklist

- Clear caches after env/config changes:
  ```bash
  php artisan optimize:clear
  ```
- Update dependencies regularly:
  ```bash
  composer update
  npm update
  ```
- Back up `.env` and database before deployment.
- Configure HTTPS and trusted proxies when deploying behind load balancers.
- For production, switch from SQLite to MySQL/MariaDB and configure proper database credentials.

---

## 11. Development Workflow

1. **Setup:** Follow the Quick Start guide above
2. **Development:** Use `npm run dev` for hot reload during frontend changes
3. **Backend:** Use `php artisan serve` for the Laravel development server
4. **Testing:** Run `php artisan test` before committing changes
5. **Deployment:** Use `npm run build` to compile production assets

---

## 12. License & Attribution

This project is released under the [MIT License](LICENSE).

<div align="center">
  <sub>Maintained by the SOAPS development team.</sub>
</div>
