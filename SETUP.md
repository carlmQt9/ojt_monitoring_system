# OJT Monitoring System - Setup Guide

## System Configuration Fixed ✓

The following issues have been resolved:

### 1. **Environment Configuration**
- ✓ Updated `APP_NAME` to "OJT Monitoring System"
- ✓ Updated `APP_URL` to `http://localhost/ojt-monitoring-system`
- ✓ Configured database connection (SQLite)
- ✓ Set up mail configuration

### 2. **Application Configuration**
- ✓ Updated `config/app.php` with correct application name
- ✓ Configured all necessary services (database, session, cache, queue)

### 3. **Frontend Setup**
- ✓ Created modern landing page with responsive design
- ✓ Configured Vite with Tailwind CSS
- ✓ Set up all asset compilation

### 4. **Storage & Links**
- ✓ Created symbolic link for storage: `public/storage`

## To Run the Application

### Step 1: Install PHP Dependencies
```bash
composer install
```

### Step 2: Install JavaScript Dependencies
Make sure you have Node.js installed, then run:
```bash
npm install
```

### Step 3: Generate Application Key
```bash
php artisan key:generate
```
(Already done, but can be rerun if needed)

### Step 4: Run Migrations (if needed)
```bash
php artisan migrate
```

### Step 5: Start Development Servers

**Terminal 1 - Laravel Development Server:**
```bash
php artisan serve --host=localhost --port=8000
```

**Terminal 2 - Vite Development Server (for asset compilation):**
```bash
npm run dev
```

Then visit: `http://localhost:8000/ojt-monitoring-system`

## Or for Quick Testing

If you're using XAMPP, simply:
1. Start Apache and MySQL
2. Access: `http://localhost/ojt-monitoring-system`

## Project Structure

```
ojt-monitoring-system/
├── app/                 # Application logic
├── config/              # Configuration files
├── database/            # Migrations and seeders
├── public/              # Public assets
├── resources/
│   ├── css/            # Stylesheets
│   ├── js/             # JavaScript files
│   └── views/          # Blade templates
├── routes/             # Application routes
└── storage/            # Uploaded files and logs
```

## Key Files Modified

- `.env` - Environment configuration
- `config/app.php` - Application settings
- `routes/web.php` - Added landing page route
- `resources/views/landing.blade.php` - Created new landing page

## Features Implemented

- ✓ Professional landing page with animations
- ✓ Responsive design (mobile, tablet, desktop)
- ✓ Feature showcase section
- ✓ Call-to-action sections
- ✓ Navigation with login/register
- ✓ Footer with links
- ✓ Tailwind CSS styling
- ✓ Modern gradient and blur effects

## Next Steps

1. **Create Dashboard** - Create a dashboard view for authenticated users
2. **Build Authentication** - Set up login/registration pages
3. **Create Database Models** - Define trainee, mentor, and admin models
4. **API Endpoints** - Create REST API for data management
5. **Admin Panel** - Build admin panel for system management

## Troubleshooting

**Problem: Assets not loading (CSS/JS)**
- Make sure Vite dev server is running: `npm run dev`
- Clear cache: `php artisan cache:clear`

**Problem: "Route 'login' not defined"**
- Need to set up authentication first

**Problem: Database errors**
- Check SQLite database file exists: `database/database.sqlite`
- Run: `php artisan migrate`

## Development Commands

```bash
# Create a new model
php artisan make:model ModelName

# Create a controller
php artisan make:controller ControllerName

# Create a migration
php artisan make:migration create_table_name

# Clear all caches
php artisan cache:clear

# Build assets for production
npm run build
```

---

**Application Name:** OJT Monitoring System  
**Framework:** Laravel 11 with Vite  
**CSS Framework:** Tailwind CSS 4.0  
**Version:** 1.0.0
