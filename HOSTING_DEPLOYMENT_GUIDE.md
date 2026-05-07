# GBASE CMS - Hostinger Shared Hosting Deployment Guide

## Prerequisites
- Hostinger Premium Website Hosting Account
- SSH Access enabled
- Server IP Address
- FTP/SSH credentials
- Temporary Domain created

---

## PHASE 1: SERVER SETUP & SSH ACCESS

### Step 1: Connect to Server via SSH

```bash
# Replace with your actual Hostinger credentials
ssh username@your_server_ip
# Enter password when prompted
```

**Finding your credentials:**
- Login to Hostinger Control Panel
- Go to: Hosting → Select Your Package → SSH Access
- Copy the SSH credentials provided

---

## PHASE 2: PREPARE DIRECTORY STRUCTURE

### Step 2: Navigate to Public HTML & Create Project Directory

```bash
# Go to public HTML directory
cd ~/public_html

# Check current directory
pwd

# List existing files
ls -la

# Create a directory for your domain (replace with your actual domain)
mkdir -p gbase-cms
cd gbase-cms
```

### Step 3: Verify PHP & Composer

```bash
# Check PHP version (Should be 8.0+)
php -v

# Check if Composer is installed
composer --version

# If Composer not found, install it
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
chmod +x /usr/local/bin/composer
```

---

## PHASE 3: UPLOAD & EXTRACT PROJECT

### Step 4: Upload Your Code

**Option A: Using Git (Recommended)**

```bash
# From your server, clone your repository
git clone https://github.com/harsha2122/GBASE.git .
# Or if you want to clone the specific branch
git clone -b claude/build-laravel-cms-HGlgZ https://github.com/harsha2122/GBASE.git .

# Navigate to project root
cd ~/public_html/gbase-cms
```

**Option B: Using SCP (if uploading from local machine)**

```bash
# From your LOCAL computer (not server), upload the entire project
scp -r /path/to/local/GBASE username@your_server_ip:~/public_html/gbase-cms/
```

**Option C: Using FTP**
- Use FileZilla or WinSCP
- Connect to your server
- Upload to `public_html/gbase-cms/`

---

## PHASE 4: LARAVEL SETUP

### Step 5: Install Dependencies

```bash
# Ensure you're in project root
cd ~/public_html/gbase-cms

# Install PHP dependencies
composer install --no-dev --optimize-autoloader

# This will take 2-5 minutes. Wait for completion.
```

### Step 6: Create & Configure .env File

```bash
# Copy the example env file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### Step 7: Edit .env Configuration

```bash
# Edit the .env file with your settings
nano .env
```

**Update these values in .env:**

```env
APP_NAME="GBASE CMS"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-temporary-domain.com

# Database Configuration (Hostinger usually provides this)
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_db_username
DB_PASSWORD=your_db_password

# Mail Configuration - Choose ONE option below

# Option 1: Gmail SMTP (Recommended)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="GBASE Technologies"

# Option 2: Hostinger Mail (if you have email hosting)
MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=465
MAIL_USERNAME=your-email@yourdomain.com
MAIL_PASSWORD=your-email-password
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=your-email@yourdomain.com
MAIL_FROM_NAME="GBASE Technologies"

# Session & Cache
SESSION_DRIVER=database
CACHE_STORE=database
```

**To save and exit nano:**
```
Ctrl + X
Y (yes)
Enter (confirm)
```

### Step 8: Create Database

**Using Hostinger Control Panel:**
1. Login to Hostinger
2. Go to: Databases → MySQL Databases
3. Create new database
4. Create database user with all privileges
5. Copy credentials and paste in .env file

**OR Using SSH (if MySQL CLI available):**

```bash
# Login to MySQL
mysql -u root -p
# Enter root password when prompted

# Create database
CREATE DATABASE gbase_cms;

# Create user
CREATE USER 'gbase_user'@'localhost' IDENTIFIED BY 'strong_password';

# Grant privileges
GRANT ALL PRIVILEGES ON gbase_cms.* TO 'gbase_user'@'localhost';

# Flush privileges
FLUSH PRIVILEGES;

# Exit MySQL
EXIT;
```

---

## PHASE 5: DATABASE & MIGRATIONS

### Step 9: Run Migrations & Seed Data

```bash
# From project root directory
cd ~/public_html/gbase-cms

# Run all migrations
php artisan migrate --force

# Seed initial data (pages, machines, cards, etc.)
php artisan db:seed --force

# Verify database was populated
php artisan tinker
# Inside tinker, run:
# \App\Models\Page::count()
# exit
```

### Step 10: Create Storage Symlink

```bash
# Create symlink for file uploads
php artisan storage:link

# Verify public/storage folder was created
ls -l public/storage
```

---

## PHASE 6: FILE PERMISSIONS

### Step 11: Set Proper Permissions

```bash
# Navigate to project root
cd ~/public_html/gbase-cms

# Set ownership (replace 'nobody' with your Hostinger username if different)
chown -R nobody:nobody .

# Set directory permissions (755 = read+execute for all)
find . -type d -exec chmod 755 {} \;

# Set file permissions (644 = read for all, write for owner)
find . -type f -exec chmod 644 {} \;

# Make artisan executable
chmod +x artisan

# Set storage & bootstrap writable (777 = full permissions)
chmod -R 777 storage/
chmod -R 777 bootstrap/cache/
chmod -R 777 public/storage/

# Verify permissions
ls -la | head -20
```

---

## PHASE 7: CONFIGURE TEMPORARY DOMAIN

### Step 12: Point Domain to Project Public Folder

**Via Hostinger Control Panel:**

1. Go to: Domains → Your Temporary Domain
2. Click "Manage"
3. Find "Document Root" or "Public Root"
4. Change from `/public_html` to `/public_html/gbase-cms/public`
5. Save changes

**OR Via .htaccess (if you can't change document root):**

Create `/public_html/gbase-cms/.htaccess`:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine on
    RewriteCond %{REQUEST_URI} !^public
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

### Step 13: Test Domain Access

```bash
# From your LOCAL computer (not SSH), test the domain
curl https://your-temporary-domain.com

# Should return HTML. If you get error, check:
# 1. Document root is pointing to /public folder
# 2. File permissions are correct (777 for storage)
# 3. Database credentials in .env are correct
```

---

## PHASE 8: VERIFY EVERYTHING

### Step 14: Test Application

```bash
# Check if Laravel can write to storage
touch ~/public_html/gbase-cms/storage/logs/laravel.log
ls -la ~/public_html/gbase-cms/storage/logs/laravel.log

# Check database connection
php artisan tinker
# Type: \DB::connection()->getPDO();
# Should show database connection info
# Type: exit

# Test cache
php artisan cache:clear

# Test routes
php artisan route:list | head -20
```

### Step 15: Access Admin Panel

Open in browser:
```
https://your-temporary-domain.com/admin/login
```

**Login with:**
- Email: `admin@gbase.co.in`
- Password: `password`

**CHANGE THIS PASSWORD IMMEDIATELY AFTER LOGIN!**

---

## PHASE 9: CONFIGURE SSL CERTIFICATE

### Step 16: Enable HTTPS

**Hostinger usually provides FREE SSL:**

1. Go to Hostinger Control Panel
2. Navigate to: Security → SSL Certificates
3. Install Let's Encrypt (Free) certificate
4. Wait 10-15 minutes for activation
5. Update APP_URL in .env to use `https://`

```bash
# Edit .env
nano .env
# Change: APP_URL=https://your-temporary-domain.com
```

---

## PHASE 10: PRODUCTION OPTIMIZATION

### Step 17: Optimize for Production

```bash
# Clear and cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optimize autoloader
composer dump-autoload --optimize --no-dev

# Clear all caches
php artisan cache:clear
php artisan view:clear
```

### Step 18: Set Up Cron Job for Laravel Schedule

Hostinger Control Panel → Cron Jobs → Add New:

```
Command: /usr/bin/php /home/username/public_html/gbase-cms/artisan schedule:run
Interval: Every Minute (or every 5 minutes)
```

---

## TROUBLESHOOTING COMMANDS

If you encounter issues, run these diagnostics:

```bash
# Check Laravel logs
tail -f ~/public_html/gbase-cms/storage/logs/laravel.log

# Clear all caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Rebuild cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Check database connection
php artisan tinker
# \DB::connection()->getPDO();

# Verify permissions
ls -la ~/public_html/gbase-cms/storage/
ls -la ~/public_html/gbase-cms/bootstrap/cache/

# Reset database (WARNING: deletes all data)
php artisan migrate:fresh --seed --force
```

---

## COMMON ISSUES & SOLUTIONS

### Issue 1: "The application could not run because .env was not found"
```bash
# Solution: Ensure .env file exists
ls -la ~/public_html/gbase-cms/.env

# If missing, create it
cp ~/public_html/gbase-cms/.env.example ~/public_html/gbase-cms/.env
php artisan key:generate
```

### Issue 2: "500 Internal Server Error"
```bash
# Check error logs
tail -50 ~/public_html/gbase-cms/storage/logs/laravel.log

# Fix storage permissions
chmod -R 777 ~/public_html/gbase-cms/storage/
chmod -R 777 ~/public_html/gbase-cms/bootstrap/cache/
```

### Issue 3: "Database connection refused"
```bash
# Verify .env database credentials
grep DB_ ~/public_html/gbase-cms/.env

# Test connection
php artisan tinker
# \DB::connection()->getPDO();
```

### Issue 4: "Class 'PDO' not found"
```bash
# Check PHP extensions
php -m | grep -i pdo

# Contact Hostinger support to enable PDO extension
```

### Issue 5: "Composer version 2 not compatible"
```bash
# Use Composer v1
composer self-update --1
composer install --no-dev --optimize-autoloader
```

---

## FINAL SECURITY CHECKLIST

```bash
# 1. Change admin password
# Login to /admin/login and change password from settings

# 2. Update APP_DEBUG to false
nano .env
# Change: APP_DEBUG=false

# 3. Set APP_ENV to production
# Change: APP_ENV=production

# 4. Verify file permissions
chmod -R 755 ~/public_html/gbase-cms
chmod -R 777 ~/public_html/gbase-cms/storage/
chmod -R 777 ~/public_html/gbase-cms/bootstrap/cache/

# 5. Enable HTTPS (check Step 16)

# 6. Configure email properly (check .env MAIL settings)

# 7. Test contact form sends emails
# Go to /contact and submit test form
```

---

## USEFUL COMMANDS REFERENCE

```bash
# Navigation
cd ~/public_html/gbase-cms          # Go to project
pwd                                  # Show current path

# File operations
nano .env                            # Edit .env file
cat .env | grep DB_                 # View database settings
ls -la                               # List files with permissions

# Laravel commands
php artisan migrate                  # Run migrations
php artisan db:seed                  # Seed database
php artisan tinker                   # Laravel REPL
php artisan cache:clear              # Clear cache
php artisan storage:link             # Create storage symlink

# Permissions
chmod 777 storage/                   # Make writable
chown -R nobody:nobody .             # Change ownership

# System info
php -v                               # PHP version
mysql -V                             # MySQL version
composer --version                   # Composer version

# Logs
tail -f storage/logs/laravel.log     # View real-time logs
tail -50 storage/logs/laravel.log    # Last 50 lines

# Restart services
# (Usually not needed on shared hosting, but ask Hostinger support)
```

---

## NEXT STEPS AFTER DEPLOYMENT

1. ✅ Test all pages work: `https://your-domain.com/`
2. ✅ Test admin panel: `https://your-domain.com/admin/login`
3. ✅ Edit a page from admin and verify changes
4. ✅ Submit contact form and check database
5. ✅ Test email (if configured): Submit contact form
6. ✅ Add your real domain and repeat all tests
7. ✅ Configure SSL for main domain
8. ✅ Set up regular backups

---

## SUPPORT & DOCUMENTATION

- Laravel Docs: https://laravel.com/docs
- Hostinger Docs: https://support.hostinger.com
- Contact Hostinger support for: Database setup, SSH access, SSL issues

---

**READY TO DEPLOY? Reply with your:**
1. Server IP address
2. SSH username
3. Temporary domain name
4. Database credentials (if already created)

I'll then provide personalized commands for YOUR specific setup!
