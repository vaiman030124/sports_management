# H2O Sports Booking System - Project Documentation

## Table of Contents
1. [System Requirements](#system-requirements)
2. [Installation Guide](#installation-guide)
3. [Configuration](#configuration)
4. [Database Setup](#database-setup)
5. [Admin User Creation](#admin-user-creation)
6. [Project Structure](#project-structure)
7. [Development Workflow](#development-workflow)
8. [Troubleshooting](#troubleshooting)

## System Requirements
- PHP 8.1 or higher
- Composer 2.0 or higher
- MySQL 5.7+ or MariaDB 10.3+
- Node.js 16.x or higher
- NPM 8.x or higher
- Laragon/WAMP/XAMPP (for Windows) or native PHP/MySQL (Linux/Mac)

## Installation Guide

### 1. Clone the Repository
```bash
git clone [repository-url]
cd H2O_Sport_Booking_Latest
```

### 2. Install PHP Dependencies
```bash
composer install
```

### 3. Install JavaScript Dependencies
```bash
npm install
npm run dev
```

### 4. Environment Configuration
```bash
cp .env.example .env
php artisan key:generate
```

## Configuration

### Database Configuration
Edit `.env` file:
```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=h2o_sports
DB_USERNAME=root
DB_PASSWORD=
```

### Mail Configuration (Optional)
```ini
MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@h2osports.com"
MAIL_FROM_NAME="H2O Sports"
```

## Database Setup

### 1. Run Migrations
```bash
php artisan migrate
```

### 2. Seed Initial Data
```bash
php artisan db:seed
```

## Admin User Creation

### Option 1: Using Artisan Command
```bash
php artisan admin:create-user
```
Follow the prompts to enter admin credentials.

### Option 2: Manual Creation
1. Visit `/admin/login`
2. Click "Register" (if enabled)
3. Fill in admin details
4. Assign admin role manually in database if needed

## Project Structure

```
app/
├── Console/
│   └── Commands/
│       └── CreateAdminUser.php
├── Http/
│   ├── Controllers/
│   │   └── Admin/
│   │       ├── Auth/
│   │       ├── BookingController.php
│   │       ├── CourtController.php
│   │       ├── MembershipController.php
│   │       ├── SportController.php
│   │       ├── TrainerController.php
│   │       └── VenueController.php
│   └── Middleware/
config/
database/
├── migrations/
│   ├── 2025_04_12_093108_create_users_table.php
│   ├── 2025_04_12_093210_create_admin_users_table.php
│   ├── 2025_04_12_093218_create_venues_table.php
│   └── ...other migrations
public/
resources/
├── views/
│   └── admin/
│       ├── auth/
│       ├── bookings/
│       ├── courts/
│       ├── layout.blade.php
│       ├── partials/
│       ├── sports/
│       ├── trainers/
│       └── venues/
routes/
├── admin.php
└── web.php
```

## Development Workflow

1. Create new feature branch:
```bash
git checkout -b feature/your-feature-name
```

2. Run development server:
```bash
php artisan serve
```

3. For admin development:
```bash
php artisan serve --port=8001
```

4. Compile assets:
```bash
npm run dev
# or for production
npm run build
```

## Troubleshooting

### Common Issues

1. **Permission Denied Errors**
```bash
chmod -R 775 storage bootstrap/cache
```

2. **Class Not Found Errors**
```bash
composer dump-autoload
```

3. **Migration Errors**
```bash
php artisan migrate:fresh
php artisan db:seed
```

4. **Admin Login Issues**
- Verify admin user exists in `admin_users` table
- Check password hashing
- Verify admin middleware is properly set

If no users created then creat the new user using the following command:
php artisan admin:create-user

Credential -
admin@example.com
password123

### Support
For additional help, contact: [your-support-email]
