# FIX PERMISSION ERROR DI HOSTING

## Error yang Terjadi
```
CacheException: Cache unable to write to "/var/www/UKK-Pengaduan-Sarpras/writable/cache/"
```

## Penyebab
Folder `writable` dan subfolder-nya tidak memiliki permission yang benar di server hosting.

## Solusi

### Opsi 1: Via SSH (Paling Mudah)
Jika Anda punya akses SSH ke server hosting:

```bash
# Masuk ke directory project
cd /var/www/UKK-Pengaduan-Sarpras

# Set permissions untuk writable directory
chmod -R 777 writable
chmod -R 777 writable/cache
chmod -R 777 writable/logs
chmod -R 777 writable/session
chmod -R 777 writable/uploads

# Atau gunakan script yang sudah disediakan
chmod +x fix_permissions.sh
./fix_permissions.sh
```

### Opsi 2: Via Browser (Tanpa SSH)
1. Upload file `fix_permissions_web.php` ke root directory hosting
2. Akses via browser: `http://yourdomain.com/fix_permissions_web.php?pass=pengaduan2024`
3. Script akan otomatis membuat folder dan set permission
4. **PENTING:** Hapus file `fix_permissions_web.php` setelah selesai!

### Opsi 3: Via cPanel File Manager
1. Login ke cPanel
2. Buka File Manager
3. Navigate ke folder `writable`
4. Klik kanan > Change Permissions
5. Set permission ke **777** (atau 0777)
6. Centang "Recurse into subdirectories"
7. Apply

### Opsi 4: Via FTP (FileZilla)
1. Connect ke server via FTP
2. Navigate ke folder `writable`
3. Klik kanan > File Permissions
4. Set Numeric value: **777**
5. Centang "Recurse into subdirectories" dan "Apply to directories only"
6. OK

## Struktur Folder yang Harus Writable
```
writable/
├── cache/          (777)
├── logs/           (777)
├── session/        (777)
└── uploads/        (777)

public/uploads/
├── foto_pengaduan/ (777)
└── user/           (777)
```

## Verifikasi
Setelah set permission, cek apakah website sudah bisa diakses:
- Akses homepage: http://yourdomain.com
- Coba login
- Coba buat pengaduan

## Jika Masih Error
Hubungi hosting support dan minta mereka:
1. Set folder `writable` dan semua subfolder ke permission 777
2. Set owner folder ke user web server (www-data atau apache)
3. Pastikan PHP memiliki akses write

## Notes
- Permission 777 = Read, Write, Execute untuk semua user
- Ini diperlukan agar PHP bisa menulis cache, logs, session, dan uploads
- Folder `writable` memang harus writable oleh web server

## Kontak Hosting Support
Jika tetap tidak bisa, kirim pesan ini ke hosting support:

```
Hi, saya perlu bantuan untuk set permission folder di aplikasi CodeIgniter 4 saya.

Path: /var/www/UKK-Pengaduan-Sarpras/writable

Mohon bantuannya untuk:
1. Set permission folder 'writable' dan semua subfolder ke 777 (rwxrwxrwx)
2. Set owner ke user web server (www-data atau apache)
3. Pastikan PHP bisa write ke folder tersebut

Error yang saya dapat:
"Cache unable to write to /var/www/UKK-Pengaduan-Sarpras/writable/cache/"

Terima kasih!
```
