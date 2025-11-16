#!/bin/bash
# Deployment script executed by the webhook.
# PENTING: Script ini akan dijalankan oleh user web server (misal: www-data).
# Pastikan user tersebut punya izin yang cukup.

# Pindah ke direktori aplikasi
# Menggunakan `dirname "$0"` agar path selalu benar relatif terhadap script ini.
cd "$(dirname "$0")" || exit

echo "==> [1/5] Memastikan di branch 'main'..."
git checkout main

echo "==> [2/5] Membersihkan file lokal yang tidak terlacak (opsional, hati-hati)..."
# git clean -fd

echo "==> [3/5] Menarik perubahan terbaru dari origin/main..."
# Reset --hard untuk menimpa semua perubahan lokal.
git fetch --all
git reset --hard origin/main

echo "==> [4/5] Install dependensi Composer..."
# Gunakan composer.phar jika composer tidak ada di PATH global
if command -v composer >/dev/null 2>&1; then
  composer install --no-dev --prefer-dist --no-interaction --optimize-autoloader
else
  php composer.phar install --no-dev --prefer-dist --no-interaction --optimize-autoloader
fi

echo "==> [5/5] Menjalankan migrasi database..."
# Menjalankan migrasi untuk semua namespace, tidak perlu konfirmasi (aman untuk CI/CD)
php spark migrate --all

echo "✅ Proses deploy selesai."
