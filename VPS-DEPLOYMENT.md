# VPS Deployment Guide - UKK Pengaduan Sarpras

## � Auto Deploy from GitHub (CI/CD)

Set up once, then every push to `main` will automatically pull on the VPS, install deps, run migrations, and refresh the app.

### 1) Configure GitHub Secrets

Add these in your repository Settings → Secrets and variables → Actions:

- `SSH_HOST` → e.g. `your.server.com`
- `SSH_USER` → SSH user on the VPS (e.g. `virael`)
- `SSH_PORT` → SSH port (e.g. `22`)
- `SSH_KEY` → Paste your private key for that user (PEM contents)
- `APP_DIR` → Absolute path to your app, e.g. `/var/www/UKK-Pengaduan-Sarpras`
- `PHP_FPM_SERVICE` (optional) → e.g. `php8.2-fpm` (only if you want the workflow to reload PHP-FPM)

The workflow file is at `.github/workflows/deploy.yml` and triggers on push to `main`.

### 2) Prepare the VPS (one time)

```bash
# Ensure the repo is already cloned on the VPS to APP_DIR
cd /var/www
git clone https://github.com/ViraElinda/UKK-Pengaduan-Sarpras.git
cd UKK-Pengaduan-Sarpras

# Prepare environment and vendor on first run
cp .env.production .env # then edit DB credentials
composer install --no-dev --optimize-autoloader
php spark key:generate
php spark migrate -n
```

Ensure your SSH user has write permissions to the project (especially `writable/`).

### 3) Deploy flow (automatic)

When you push to `main`:
1. GitHub Action connects to VPS via SSH.
2. Runs `git reset --hard origin/main`, `composer install --no-dev`.
3. Runs `php spark migrate -n`.
4. Clears cache and sets perms for `writable/`.
5. Optionally reloads PHP-FPM if `PHP_FPM_SERVICE` is provided and sudo is allowed.

You can also trigger it manually in GitHub → Actions → Deploy to VPS → Run workflow.

## �🚀 Quick Deploy (Recommended)

```bash
# 1. Clone repository
git clone https://github.com/ViraElinda/UKK-Pengaduan-Sarpras.git
cd UKK-Pengaduan-Sarpras

# 2. Run deployment script
chmod +x deploy-vps.sh
./deploy-vps.sh
```

## 📋 Manual Deployment Steps

### 1. Setup Environment
```bash
# Copy environment file
cp .env.production .env

# Edit database credentials
nano .env
```

### 2. Update .env File
```bash
# Required changes:
app.baseURL = 'https://viraelinda.my.id'
database.default.username = ci_user
database.default.password = root
```

### 3. Install Dependencies
```bash
composer install --no-dev --optimize-autoloader
```

### 4. Generate Encryption Key
```bash
php spark key:generate
```

### 5. Database Setup
```bash
# Create database (MySQL)
mysql -u root -p -e "CREATE DATABASE pengaduan_sarpras;"

# Run migrations (creates all tables + initial data)
php spark migrate
```

### 6. Set Permissions
```bash
find . -type f -exec chmod 644 {} \;
find . -type d -exec chmod 755 {} \;
chmod -R 777 writable/
```

## 🗄️ Database Tables Created

The migration will create:
- ✅ `user` - Users (admin, petugas, user)
- ✅ `lokasi` - Locations (10 default locations)  
- ✅ `items` - Items/equipment (8 default items)
- ✅ `pengaduan` - Main complaints table
- ✅ `temporary_item` - Pending approval items
- ✅ `list_lokasi` - Location-item mapping

## 👤 Default Login Credentials

**Admin Access:**
- Username: `admin`
- Password: `admin123`

⚠️ **IMPORTANT:** Change password after first login!

## 🔧 Migration Order (VPS Safe)

1. `CreateUserTable` - Creates user table
2. `CreateLokasiTable` - Creates lokasi table  
3. `CreateItemsTable` - Creates items table
4. `CreatePengaduanTable` - Creates pengaduan table
5. `CreateListLokasiTable` - Creates list_lokasi table
6. `CreateTemporaryItemTable` - Creates temporary_item table
7. `SeedInitialData` - Inserts default data
8. `AlterTemporaryItemLokasi` - Alters temporary_item (safe)
9. `AddBeforeAfterPhotosToPengaduan` - Adds foto columns
10. `AddFotoBalasanToPengaduan` - Adds foto_balasan column

## 🛡️ Security Features

- ✅ All migrations check if table/column exists (no errors on re-run)
- ✅ Production environment settings
- ✅ Password hashing for users
- ✅ Proper file permissions
- ✅ HTTPS enforcement (when SSL configured)

## 🚨 Troubleshooting

### If migration fails:
```bash
# Check migration status
php spark migrate:status

# Reset if needed (CAUTION: This drops all data!)
php spark migrate:reset
php spark migrate
```

### If database connection fails:
1. Check MySQL service: `sudo systemctl status mysql`
2. Verify database exists: `mysql -u root -p -e "SHOW DATABASES;"`
3. Check credentials in `.env` file
4. Ensure user has proper permissions

### Check logs:
```bash
tail -f writable/logs/log-$(date +%Y-%m-%d).log
```

## 🌐 Web Server Configuration

### Apache (.htaccess already included)
Point document root to `/public` directory

### Nginx
```nginx
server {
    listen 80;
    server_name viraelinda.my.id;
    root /var/www/UKK-Pengaduan-Sarpras/public;
    index index.php;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

## ✅ Post-Deployment Checklist

- [ ] Database created and migrated
- [ ] Default admin user created
- [ ] File permissions set correctly
- [ ] Web server pointing to `/public`
- [ ] SSL certificate configured (optional)
- [ ] Admin password changed
- [ ] Application accessible via browser
 - [ ] (CI/CD) GitHub Secrets configured and workflow green

## 📞 Support

If you encounter issues:
1. Check migration logs in `writable/logs/`
2. Verify database connection
3. Check file permissions
4. Review web server error logs