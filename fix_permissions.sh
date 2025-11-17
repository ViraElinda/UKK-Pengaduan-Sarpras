#!/bin/bash

# Script untuk fix permissions di server hosting
echo "=== FIX PERMISSIONS SCRIPT ==="
echo ""

# Set ownership (ganti 'username' dengan user hosting Anda)
# chown -R username:username /var/www/UKK-Pengaduan-Sarpras

# Set permissions untuk writable directory
echo "Setting permissions for writable directory..."
chmod -R 755 /var/www/UKK-Pengaduan-Sarpras/writable
chmod -R 777 /var/www/UKK-Pengaduan-Sarpras/writable/cache
chmod -R 777 /var/www/UKK-Pengaduan-Sarpras/writable/logs
chmod -R 777 /var/www/UKK-Pengaduan-Sarpras/writable/session
chmod -R 777 /var/www/UKK-Pengaduan-Sarpras/writable/uploads

# Create directories if not exist
echo "Creating directories if not exist..."
mkdir -p /var/www/UKK-Pengaduan-Sarpras/writable/cache
mkdir -p /var/www/UKK-Pengaduan-Sarpras/writable/logs
mkdir -p /var/www/UKK-Pengaduan-Sarpras/writable/session
mkdir -p /var/www/UKK-Pengaduan-Sarpras/writable/uploads

# Set permissions again after creating
chmod -R 777 /var/www/UKK-Pengaduan-Sarpras/writable/cache
chmod -R 777 /var/www/UKK-Pengaduan-Sarpras/writable/logs
chmod -R 777 /var/www/UKK-Pengaduan-Sarpras/writable/session
chmod -R 777 /var/www/UKK-Pengaduan-Sarpras/writable/uploads

echo ""
echo "✅ Permissions fixed!"
echo ""
echo "Jalankan command ini di server hosting Anda via SSH:"
echo "chmod +x fix_permissions.sh"
echo "./fix_permissions.sh"
