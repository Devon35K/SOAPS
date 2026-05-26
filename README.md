# Sports and Cultural Management System (2IT) Group 6

A comprehensive web-based Document Archiver and Achievement Management System for the Sports and Cultural Office of the University of Southeastern Philippines (USeP) Tagum-Mabini Campus. Built on Laravel 12 with Vue 3, Inertia.js, and TailwindCSS, featuring document submissions, point-based evaluations, and campus-wide leaderboards.

## System Overview

The Sports and Cultural Management System serves as a digital solution for the USeP Tagum-Mabini Campus Sports and Cultural Office to:
- Manage student/alumni sports and cultural participation and achievements
- Handle document submissions and approval workflows with digital archiving
- Implement point-based evaluation system for awards and recognitions
- Provide secure three-tier role management (Super Admin, Admin, and Student roles)
- Streamline administrative operations for sports and cultural activities
- Display campus-wide leaderboards for achievement rankings
- Facilitate fast data retrieval, filtering, and comparison capabilities

---

## 2. Key Features

### User Management
- **Three-Tier Role System**: Super Admin, Admin (Faculty/Staff), and Student users
- **Account Approval Workflow**: Students submit registration requests with supporting documents for admin approval
- **Profile Management**: Users can update profiles including sport, campus, and personal information
- **Session Management**: Secure login with timeout and CSRF protection
- **User Base Management**: Comprehensive user directory with filtering by sport, campus, and status
- **Multi-Factor Authentication**: Enhanced security with 2FA support via Laravel Fortify

### Super Admin Features
- **Full User Management**: Create, edit, and delete admin and student accounts
- **System Administration**: Complete control over user permissions across all roles
- **Account Management**: Direct user creation bypassing approval workflow
- **Administrative Oversight**: Access to all system functions and user records

### Activity Logging & Monitoring
- **Submission Tracking**: Monitor all document submissions with timestamps and status changes
- **Real-time Monitoring**: Track user logins, file uploads, document approvals
- **Security Logs**: Monitor failed login attempts and authentication events
- **Administrative Actions**: Record all admin decisions, approvals, and rejections
- **User Analytics**: Dashboard statistics for athletes, pending evaluations, and account approvals

### Document Management
- **Document Submission**: Students submit documents (PDF, JPG, JPEG, PNG) up to 5MB
- **Base64 Storage**: Files stored as base64 in database for SQLite compatibility
- **Approval Workflow**: Admins can approve/reject submissions with comments
- **Document Types**: Support for certificates, medals, competition proofs, and other supporting documents
- **Download/View Functionality**: Secure inline document viewing with proper MIME type handling

### Achievement Tracking
- **Point-Based Evaluation System**: Comprehensive scoring based on:
  - Level of competition (University, Regional, National, International)
  - Performance (Champion, 1st Runner-up, 2nd Runner-up, etc.)
  - Number of events participated
  - Leadership roles held
  - Sportsmanship awards
  - Community impact contributions
  - Document completeness
- **Campus Leaderboard**: Real-time ranking system displaying student standings
- **Total Points Tracking**: Cumulative score monitoring with automatic rank calculation
- **Award Recognition System**: Admins evaluate and approve achievements
- **Status Tracking**: Pending, Approved, and Rejected achievement statuses
- **Document Attachment**: Supporting documents linked to achievements

### Administrative Features
- **Dashboard**: Comprehensive admin interface with analytics and statistics
- **Athlete Management**: View, filter, and manage student athletes by sport, campus, and status
- **Evaluation System**: Review and score student submissions with point assignments
- **User Management**: Add, edit, and manage user accounts (Super Admin only)
- **Reports and Analytics**: Real-time statistics on athletes, pending evaluations, and approvals
- **Account Approvals**: Manage new account requests with document verification

### Sports & Campus Management
- **Multi-Sport Support**: 16 official sports categories:
  - Athletics, Badminton, Basketball, Cheerleading, Chess
  - Dance Sports, Esports, Football, Sepak Takraw, Softball
  - Swimming, Table Tennis, Taekwondo, Tennis, Volleyball, Wrestling
- **Multi-Campus Support**: 5 USeP campuses:
  - Tagum-Mabini, Obrero, Mintal, Guianga, Bislig
- **Student Status Tracking**: Undergraduate and Alumni status management
- **Sport-Specific Filtering**: Filter athletes by their registered sport

---

## 3. Tech Stack

- **Backend:** PHP 8.2+, Laravel 12, Laravel Fortify (authentication)
- **Frontend:** Vite, Vue 3, Inertia.js, TailwindCSS 4, TypeScript
- **UI Components:** Reka UI, Lucide Vue icons, Tailwind Merge
- **Database:** SQLite (default) / MySQL / MariaDB with base64 file storage
- **Email:** PHPMailer for transactional emails
- **Runtime:** Node.js 18+, Composer 2+
- **Code Quality:** Laravel Pint (PHP), ESLint + Prettier (JS/TS)
- **Testing:** PHPUnit, Laravel Dusk (optional)
- **Recommended Dev Environment:** Laragon on Windows

---

## 4. System Requirements

### Hardware Requirements

| Component | Minimum Requirements | Recommended Requirements |
|-----------|---------------------|---------------------------|
| **Client Machine** | Intel i5 processor, 8GB RAM, 256GB SSD, Windows 10 or Linux OS | Intel i7 or higher, 16GB RAM, 512GB SSD, Windows 11 or latest Linux OS |
| **Server Machine** | Intel Xeon processor, 16GB RAM, 1TB HDD/SSD, Windows Server 2019 or Linux-based OS | Intel Xeon multi-core, 32GB RAM, 1TB SSD, Latest Windows Server or Linux OS |
| **Backup Storage** | External hard drives or cloud storage | Automated cloud backup with redundancy (e.g., AWS S3, Google Drive Enterprise) |

### Software Requirements

| Component | Minimum Requirements | Recommended Requirements |
|-----------|---------------------|---------------------------|
| **Database Management System** | MySQL 5.7 or Microsoft SQL Server 2016 | MySQL 8.0 or Microsoft SQL Server 2019 or newer |
| **Development Environment** | VS Code, PHPStorm, or similar IDE | VS Code with PHP extensions or IntelliJ IDEA |
| **Web Server** | Apache 2.4, Nginx 1.18, or IIS 10 | Apache 2.4 or newer, Nginx latest stable, or IIS with optimized module configurations |
| **Security Software** | Basic antivirus (e.g., Windows Defender) and anti-malware | Enterprise-level endpoint protection (e.g., Bitdefender, Norton, or Malwarebytes Premium) |
| **Backup Software** | Manual or scheduled backup tools (e.g., Windows Backup, rsync) | Automated cloud-integrated backup solutions (e.g., Acronis, Veeam, or AWS Backup) |

### Network Requirements

| Component | Minimum Requirements | Recommended Requirements |
|-----------|---------------------|---------------------------|
| **Internet Connection** | Stable broadband (DSL/Fiber) with at least 10 Mbps download speed | High-speed fiber connection with 50 Mbps or higher, with redundancy/failover option |
| **Local Network** | Basic wired or wireless LAN supporting at least 100 Mbps | Gigabit Ethernet for wired connections; Wi-Fi 5/6 for wireless coverage |
| **Firewall** | Basic software firewall (e.g., Windows Firewall) | Dedicated hardware firewall (e.g., Cisco ASA, Fortinet) and enterprise-level software firewall (e.g., pfSense) |

### Other Facilities

- **User Training Facilities**: Designated room with computers, projector, and internet for hands-on training
- **Technical Support**: Helpdesk unit with ticketing system and trained IT personnel
- **Support Availability**: Peak hours support (8 AM - 5 PM weekdays) with emergency off-hours support
- **Support Channels**: Multichannel support (email, hotline, knowledge base integration)

> **Campus Restriction**: System is designed exclusively for USeP Tagum-Mabini Campus users and requires on-campus access or VPN connection.

---

## 5. Quick Start (Fresh Install)

### Step 1: Clone and Install Dependencies

```bash
# 1. Clone project
git clone <repository-url>
cd SOAPS

# 2. Install PHP dependencies
composer install

# 3. Install Node.js dependencies
npm install
```

### Step 2: Environment Configuration

```bash
# 4. Copy environment file
cp .env.example .env

# 5. Generate application key
php artisan key:generate
```

### Step 3: Database Setup (Choose SQLite or MySQL)

**Option A: SQLite (Default - Easiest for Development)**
- No additional setup needed. SQLite database file will be created automatically.

**Option B: MySQL (Recommended for Production)**

1. **Create the database in phpMyAdmin:**
   - Open http://localhost/phpmyadmin (or your MySQL admin tool)
   - Click "New" to create a database
   - Database name: `SOAPS` (or any name you prefer)
   - Click "Create"

2. **Update `.env` file with MySQL settings:**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=SOAPS
   DB_USERNAME=root
   DB_PASSWORD=
   ```

### Step 4: Create Tables and Seed Data

```bash
# 6. Run migrations to create all tables
php artisan migrate

# Or use --seed flag to create tables AND seed with default data
php artisan migrate --seed

# To reset database and re-create tables (clears all data):
php artisan migrate:fresh --seed
```

**Tables created by migrations:**
- `users` - User accounts with roles (super_admin, admin, user)
- `submissions` - Document submissions with base64 file storage
- `achievements` - Achievement records with point calculations
- `leaderboard` - Points aggregation and rankings
- `account_approvals` - Pending account registration requests
- `user_images` - Profile image storage
- `notifications` - User notification system
- `cache`, `jobs` - Laravel system tables

### Step 5: Final Setup

```bash
# 7. Create storage symlink for file uploads
php artisan storage:link

# 8. Compile assets
npm run build   # production assets
# or: npm run dev  # for development with hot reload

# 9. Start development server
php artisan serve
# Visit: http://127.0.0.1:8000
```

### Quick Troubleshooting

**Tables not showing in phpMyAdmin?**
- Make sure `DB_CONNECTION=mysql` in `.env`
- Clear config cache: `php artisan config:clear`
- Re-run migrations: `php artisan migrate:fresh --seed`

**Migration errors?**
- Check database exists in MySQL
- Verify DB credentials in `.env`
- Clear all caches: `php artisan optimize:clear`

---

## 6. Scope and Limitations

### Scope

**Primary Users:**
- **Students**: Enrolled athletes and artists participating in university-approved sports and cultural events
- **Admins**: Faculty designated to manage the Sports and Cultural Office operations

**Functions:**
- Digital document submission, validation, and archiving
- Automated evaluation for awards and recognitions based on a point system
- Search and filter functionalities for quick access to stored data
- Sports equipment borrowing and return tracking with sanction system
- Campus leaderboard and point accumulation monitoring

**Access:**
- Limited to on-campus users at USeP Tagum-Mabini Campus
- VPN access available for authorized remote connections

### Limitations

- **Exclusion of Academic Records**: The system focuses solely on sports and cultural documents and does not handle academic records or achievements
- **Restricted User Base**: Designed exclusively for USeP Tagum-Mabini students, alumni and faculty; not accessible to external users
- **Dependency on Hardware and Internet Connection**: Requires compatible desktop computers and consistent power supply to function effectively
- **Manual Inputs for Validation**: Some document validation processes may still require manual review to ensure accuracy and compliance

## 7. Target Users

### Admins (Faculty/Staff)
- Complete system administration and configuration
- Manage student accounts and approval workflows
- Record and track student achievements using point-based evaluation
- Generate reports and analytics from dashboard
- Oversee equipment borrowing and return processes
- Monitor and enforce sanction policies for late returns
- Process document submissions and maintain digital archives

### Students/Alumni
- Submit sports and cultural-related documents and applications
- Track personal achievements and participation records
- Monitor accumulated points and campus leaderboard standings
- Update profiles and manage account information
- View approval status of submitted documents
- Browse available sports equipment and supplies
- Submit equipment borrowing requests with specified return dates
- Monitor borrowing history and current equipment status
- Receive notifications for upcoming due dates and sanctions

---

## 8. System Benefits

### Tangible Benefits
- **Reduction in operational costs**: Decreased need for physical storage and printed documents, saving on paper and printing expenses
- **Time savings**: Faster document processing and retrieval for faculty and students, leading to more timely participation in events
- **Improved accuracy**: Minimized manual errors through automated validation and processing

### Intangible Benefits
- **Improved user satisfaction**: Students face less frustration with simplified submission and tracking processes
- **Improved productivity**: Faculty can focus on strategic tasks instead of administrative burdens
- **Data security**: Better protection of sensitive student information with a controlled and digital system

---

## 9. Security Features

### Information Security Mechanisms

**User Authentication:**
- **Secure Login System**: Unique usernames and passwords for both students and faculty/admins
- **Multi-Factor Authentication (MFA)**: Enhanced security during the login process
- **Session Management**: Timeout protection and session regeneration

**Access Control:**
- **Role-Based Access Control (RBAC)**: Users can only access information and functionalities relevant to their roles
- **Regular Audits**: Periodic review of user access rights to ensure compliance and security

**Data Encryption:**
- **In Transit Protection**: SSL/TLS protocols for secure data transmission
- **At Rest Protection**: AES encryption for sensitive data storage
- **Secure Connections**: All document uploads and downloads conducted over encrypted channels

**Audit Trails:**
- **Activity Logging**: Comprehensive logs of user activities within the system
- **Access Tracking**: Monitor access and modifications to sensitive data
- **Regular Reviews**: Periodic audit log analysis to identify unauthorized access or anomalies

**Data Privacy Compliance:**
- **Regulatory Compliance**: Adherence to relevant data protection regulations (e.g., GDPR, local data privacy laws)
- **Data Retention Policies**: Responsible management of personal data with defined retention and deletion policies

### Technical Security Features
- **Password Hashing**: Secure password storage using PHP's password_hash()
- **CSRF Protection**: Cross-site request forgery protection with tokens
- **Input Validation**: Comprehensive input sanitization and validation
- **File Security**: MIME type verification and secure file handling
- **SQL Injection Prevention**: Prepared statements and parameterized queries

---

## 10. Seeded Accounts

| Role | Access Method | Permissions |
|------|---------------|-------------|
| **Super Admin** | Create via `/create-admin-usep` route | Full user CRUD, can manage other admins, all system functions |
| **Admin** | Create via seeder or Super Admin | Manage users, documents, approvals, evaluations |
| **Student** | Self-register with approval | Submit documents, track achievements, view leaderboard |

> **Important:** Update all default credentials immediately in production. Use the secret route `/create-admin-usep` to create the first Super Admin account after installation.

### Role-Based Access Control (RBAC)

| Feature                 | Super Admin | Admin              | Student |
|---------                |:---------- :|:-----:              |:-------:|
| User Management (CRUD)  | ✅          | ✅ (students only) | ❌     |
| Approve/Reject Accounts | ✅          | ✅                 | ❌     |
| System Settings         | ✅          | ❌                 | ❌     |
| Create Other Admins     | ✅          | ❌                 | ❌     |
| Document Management     | ✅          | ✅                 | ❌     |
| Equipment Management    | ✅          | ✅                 | ❌     |
| View Reports/Analytics  | ✅          | ✅                 | ❌     |
| Submit Documents        | ❌          | ❌                 | ✅     |
| View Personal Records   | ✅          | ✅                 | ✅     |
| Borrow Equipment        | ❌          | ❌                 | ✅     |

---

## 11. Useful Artisan & npm Commands

| Command | Purpose |
|---------|---------|
| `php artisan migrate:fresh --seed` | Reset database and reseed (runs AdminSeeder) |
| `php artisan storage:link` | **Important:** expose `storage/app/public` via `public/storage` |
| `php artisan queue:work` | Run queued jobs for email notifications |
| `php artisan optimize:clear` | Clear all config, route, view, and cache files |
| `php artisan config:clear && php artisan cache:clear` | Clear configuration and application cache |
| `composer run dev` | Boot Laravel server, queue, and Vite concurrently |
| `composer run setup` | Full install workflow (deps + key + migrate + build) |
| `npm run dev` | Vite dev server with hot reload |
| `npm run build` | Compile production assets |
| `npm run build:ssr` | Build with SSR support |
| `npm run lint` | Run ESLint on JavaScript/TypeScript |
| `npm run format` | Run Prettier code formatting |

### Composer Scripts

- `composer run dev` ⇒ boots Laravel server, queue listener, and Vite concurrently (if configured)
- `composer run setup` ⇒ full install workflow (composer + key + migrate + npm build) (if configured)

---

## 12. Environment Tips

- **File Uploads:** uploaded files live in `storage/app/public`. Missing images usually mean `php artisan storage:link` was skipped.
- **Sessions:** configured via `config/session.php`; adjust timeout/security as needed.
- **Mail & Queues:** set `MAIL_*` + queue driver in `.env` before enabling email alerts or background jobs.
- **Database:** Default uses SQLite for easy setup. Switch to MySQL/MariaDB for production by updating `DB_CONNECTION` and related settings.
- **Logging:** check `storage/logs/laravel.log` when debugging.

---

## 13. Project Map

```
app/
├── Actions/Fortify/        # Custom Fortify authentication actions
├── Concerns/               # Validation rule traits
├── Http/
│   ├── Controllers/        # Web controllers
│   │   ├── Auth/           # Authentication controllers
│   │   │   ├── LoginController.php
│   │   │   ├── RegisterController.php
│   │   │   ├── ForgotPasswordController.php
│   │   │   └── AdminCreationController.php
│   │   ├── Settings/       # Profile, password, 2FA settings
│   │   ├── AdminController.php
│   │   ├── UserController.php
│   │   └── EmailController.php
│   ├── Middleware/         # Role-based access middleware
│   └── Requests/           # Form request validation
├── Mail/                   # Mailable classes (Approval, OTP, Notification)
├── Models/                 # Eloquent models
│   ├── User.php           # User with roles, 2FA, relations
│   ├── Submission.php     # Document submissions
│   ├── Achievement.php    # Achievement records
│   ├── Leaderboard.php    # Points aggregation
│   ├── AccountApproval.php # Registration requests
│   ├── Notification.php   # User notifications
│   └── UserImage.php      # Profile images
├── Providers/              # Service providers
└── Services/               # Business logic services

database/
├── factories/              # Model factories
├── migrations/             # Schema definitions
│   ├── 0001_01_01_000000_create_users_table.php
│   ├── 2025_01_21_000001_update_users_table.php
│   ├── 2025_01_21_000004_create_submissions_table.php
│   ├── 2025_04_06_000002_create_achievements_table.php
│   ├── 2025_04_06_000003_create_leaderboard_table.php
│   └── ... (19 total migrations)
└── seeders/                # Database seeders
    ├── DatabaseSeeder.php
    └── AdminSeeder.php

resources/
├── views/                  # Blade templates
│   ├── admin/             # Admin dashboard pages
│   ├── user/              # Student portal pages
│   ├── auth/              # Authentication pages
│   ├── emails/            # Email templates
│   ├── settings/          # User settings pages
│   ├── intro.blade.php    # Landing page
│   └── login.blade.php    # Login page
├── js/                     # Vue.js application
│   ├── components/        # Vue components + UI library
│   ├── composables/       # Shared Vue composables
│   ├── app.ts            # Main entry point
│   └── ssr.ts            # SSR entry point
└── css/                    # TailwindCSS styles

public/
├── storage/ -> ../storage/app/public (symlink)
├── image/                 # Static images (USeP logos)
├── css/                   # Compiled CSS
├── js/                    # Compiled JS
└── build/                 # Vite compiled assets (manifest.json)

routes/
├── web.php               # Main application routes
├── settings.php          # User settings routes
└── console.php           # Console commands
```

---

## 14. Testing & Quality

```bash
# Run automated tests
php artisan test

# Code formatting (if Pint is installed)
./vendor/bin/pint

# Lint JavaScript/TypeScript (if configured)
npm run lint
```

---

## 15. Common Issues & Solutions

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

## 16. Maintenance Checklist

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

## 17. Development Workflow

1. **Setup:** Follow the Quick Start guide above
2. **Development:** Use `npm run dev` for hot reload during frontend changes
3. **Backend:** Use `php artisan serve` for the Laravel development server
4. **Testing:** Run `php artisan test` before committing changes
5. **Deployment:** Use `npm run build` to compile production assets

---

## 18. License & Attribution

This project is developed for the University of Southeastern Philippines (USeP) Tagum-Mabini Campus Sports and Cultural Office by Group 6 of the 2IT program.

<div align="center">
  <sub>Maintained by the Sports and Cultural Management System development team for USeP Tagum-Mabini Campus.</sub>
</div>
