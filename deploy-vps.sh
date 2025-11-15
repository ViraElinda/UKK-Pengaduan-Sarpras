#!/bin/bash

#################################################################
# VPS Deployment Script untuk UKK Pengaduan Sarpras
# Jalankan script ini di server VPS setelah git clone
#################################################################

echo "🚀 Starting VPS Deployment..."
echo "==============================="

# 1. Install dependencies
echo "📦 Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader

# 2. Setup environment
echo "⚙️  Setting up environment..."
if [ ! -f .env ]; then
    cp .env.production .env
    echo "✅ Copied .env.production to .env"
    echo "⚠️  IMPORTANT: Edit .env file with your database credentials!"
else
    echo "✅ .env file already exists"
fi

# 3. Generate encryption key if not set
echo "🔐 Checking encryption key..."
if ! grep -q "encryption.key = [a-zA-Z0-9]" .env; then
    php spark key:generate
    echo "✅ Generated new encryption key"
else
    echo "✅ Encryption key already set"
fi

# 4. Set proper permissions
echo "🔒 Setting file permissions..."
find . -type f -exec chmod 644 {} \;
find . -type d -exec chmod 755 {} \;
chmod -R 777 writable/
echo "✅ File permissions set"

# 5. Create database (user needs to create manually)
echo "🗄️  Database setup..."
echo "⚠️  Make sure you have:"
echo "   - Created MySQL database: pengaduan_sarpras"
echo "   - Updated database credentials in .env file"

# 6. Run migrations
echo "📊 Running database migrations..."
read -p "Run migrations now? (y/n): " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    php spark migrate
    echo "✅ Migrations completed"
else
    echo "⚠️  Remember to run: php spark migrate"
fi

# 7. Clear caches
echo "🧹 Clearing caches..."
php spark cache:clear
echo "✅ Caches cleared"

echo ""
echo "🎉 Deployment completed!"
echo "==============================="
echo "✅ Next steps:"
echo "1. Edit .env file with your database credentials"
echo "2. Create database: pengaduan_sarpras"
echo "3. Run: php spark migrate (if not done above)"
echo "4. Configure web server to point to /public directory"
echo "5. Test the application"
echo ""
echo "📝 Default login credentials:"
echo "   Admin: admin@admin.com / admin123"
echo "   (Change after first login)"