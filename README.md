# Nigeria High Commission Nairobi, Kenya — Master Web Portal & Consular App

An authoritative, secure web portal and consular management web application for the **High Commission of the Federal Republic of Nigeria, Nairobi, Kenya**.

---

## 1. System Architecture & Tech Stack
- **Core Environment:** Plain PHP 8.x (Custom MVC Architecture: Router, Controllers, Models, Services, Middleware).
- **Database Engine:** MySQL 8.0 / MariaDB 10.4+ (`utf8mb4_unicode_ci` charset, InnoDB storage engine) running on port `3308`.
- **Frontend Framework:** Bootstrap 5.3.3, Vanilla JavaScript, Bootstrap Icons 1.11.3 (Zero emoji policy, strictly compliant typography and HSL HUE green brand tokens).
- **Security Baseline:** Dynamic MySQL RBAC, OWASP ASVS baseline HTTP security headers, BCrypt password hashing, CSRF tokens, anti-abuse rate limiting, server-side HTML sanitizer, and CSV formula injection protection.

---

## 2. Directory Structure
```
KenyaHighCommission/
├── config/
│   ├── app.php                # Application config & OWASP security headers
│   └── database.php           # PDO MySQL connection settings (Port 3308)
├── cron/
│   └── process_outbox.php     # CLI / cPanel cron worker for email outbox queue
├── database/
│   ├── schema.sql             # Full DDL for all 24 database tables
│   ├── seed.sql               # Synthetic demonstration seed dataset
│   ├── seed_rbac.php          # 12 Roles & 13 Permissions dynamic seeder
│   ├── install.php            # Automated database installer
│   ├── test_runner.php        # Master unit & integration test runner
│   ├── test_rbac_and_files.php# RBAC & File security test suite
│   └── test_notifications_and_search.php # Outbox & Security test suite
├── public/
│   ├── index.php              # Front controller entry point
│   ├── robots.txt             # Search engine crawling rules
│   └── assets/                # CSS, JS, Images, Coat of Arms branding
├── storage/
│   ├── uploads/               # Private applicant document files (outside webroot)
│   └── logs/                  # System outbox & audit logs
├── src/
│   ├── autoload.php           # PSR-4 Autoloader (App\ namespace)
│   ├── Controllers/           # Admin, Citizen, Consular, File, Health controllers
│   ├── Core/                  # Auth, Controller, Database, Helper, Request, Router
│   ├── Models/                # Database data access objects
│   └── Services/              # ExportService, NotificationService
└── views/
    ├── admin/                 # Staff workspace & CMS administration templates
    ├── consular/              # Passport, Visa, ETC, Legalization guidance views
    ├── diaspora/              # Registration hub & emergency distress views
    ├── info/                  # Search, Fees, Notices, Privacy, Terms, FAQ
    ├── layouts/               # Header (Strict 2-Row limit), Footer (4-Column)
    ├── nigeria/               # 36 States Interactive Map & Tourism
    ├── portal/                # Citizen dashboard, requests, PDF receipt
    └── trade/                 # Trade matchmaking & investment portal
```

---

## 3. Installation & Local Development Setup (Windows XAMPP)

1. **Clone / Place Source Code:**
   Place the project directory at `C:\xampp\htdocs\KenyaHighCommission`.

2. **Database Installation:**
   Ensure XAMPP MySQL is running (configured for port `3308`).
   Execute the installer script via terminal:
   ```bash
   C:\xampp\php\php.exe database/install.php
   C:\xampp\php\php.exe database/seed_rbac.php
   ```

3. **Asset Junction Link Creation (Subdirectory Compatibility):**
   Run Command Prompt as Administrator to link `public/assets` to root `assets`:
   ```cmd
   mklink /J "C:\xampp\htdocs\KenyaHighCommission\assets" "C:\xampp\htdocs\KenyaHighCommission\public\assets"
   ```

4. **Accessing Local Portal:**
   - **Public Website:** `http://localhost:8080/KenyaHighCommission/`
   - **Staff Workspace:** `http://localhost:8080/KenyaHighCommission/admin/login`
   - **Citizen Portal:** `http://localhost:8080/KenyaHighCommission/portal/login`

---

## 4. Default Seed Accounts (Password: `Password123!`)
- **System Administrator:** `admin@nigeriankenya.or.ke`
- **Consular Officer:** `officer@nigeriankenya.or.ke`
- **Content Editor:** `editor@nigeriankenya.or.ke`
- **Demo Citizen (Tunde):** `tunde.demo@example.com`
- **Demo Citizen (Amina):** `amina.demo@example.com`

---

## 5. Background Outbox Worker & Cron Setup
To process queued notifications, configure a cron job to execute every 5 minutes:
```bash
*/5 * * * * /usr/bin/php /path/to/KenyaHighCommission/cron/process_outbox.php >/dev/null 2>&1
```

---

## 6. Linux / Production Apache Server Deployment
1. Set Apache document root to `/var/www/html/KenyaHighCommission/public`.
2. Enable `mod_rewrite` and `AllowOverride All`.
3. Set file permissions: `storage/` directory must be writable (`755` or `775`).
4. Ensure `.env` and `storage/uploads/` remain inaccessible directly via HTTP.
