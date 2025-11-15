# VPS Deployment Guide - UKK Pengaduan Sarpras

## 🚀 Quick Deploy (Recommended)

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

## 📞 Support

If you encounter issues:
1. Check migration logs in `writable/logs/`
2. Verify database connection
3. Check file permissions
4. Review web server error logs