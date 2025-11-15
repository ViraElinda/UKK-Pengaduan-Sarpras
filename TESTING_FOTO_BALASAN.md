# 🔍 Testing Foto Balasan Petugas

## Status Data:
✅ Kolom `foto_balasan` sudah ada di database
✅ Data test sudah diisi:
   - Pengaduan ID: **160**
   - User: **yeni** (id_user: 55)
   - Foto balasan: **test_balasan_1762588434.jpg**
   - Saran: "Perbaikan sudah selesai dilakukan"

## Cara Testing di Browser:

### 1. Akses halaman test:
```
http://localhost/pengaduan4/pengaduan4/public/test_foto_balasan.php
```
Halaman ini akan menampilkan:
- ✅ Data ditemukan atau tidak
- ✅ Apakah foto_balasan ada
- ✅ Nilai empty() check

### 2. Login sebagai User:
1. Buka: `http://localhost/pengaduan4/pengaduan4/public/`
2. Login dengan:
   - Username: `yeni`
   - Password: (sesuai database)

### 3. Lihat Detail Pengaduan:
1. Klik menu **"Riwayat"**
2. Cari pengaduan: **kjsjkasjksjkjsjsj**
3. Klik **"Lihat Detail"**
4. Scroll ke bagian **"Dokumentasi Perbaikan"**

### 4. Yang Seharusnya Muncul:
- 🟣 Card dengan header ungu/indigo: **"Foto Balasan Petugas"**
- 📷 Gambar (akan error karena file dummy, tapi struktur HTML sudah ada)
- Atau debug info (jika mode development)

### 5. Jika Masih Belum Muncul:
Lihat debug info di atas card yang menampilkan:
- `foto_balasan = 'test_balasan_1762588434.jpg'`
- `empty = NO`

## Troubleshooting:

### Jika muncul "Belum ada foto balasan":
Berarti `empty($pengaduan['foto_balasan'])` = TRUE

**Solusi:**
1. Cek query di controller tidak filter foto_balasan
2. Pastikan SELECT mengambil semua kolom: `pengaduan.*`
3. Clear cache CodeIgniter jika ada

### Jika muncul debug tapi foto tidak muncul:
File memang tidak ada (normal untuk dummy data)

**Solusi untuk upload foto asli:**
1. Login sebagai **petugas**
2. Kelola pengaduan ID 160
3. Upload foto balasan yang asli
4. Kemudian cek lagi sebagai user yeni

## Script Helper:

Cek data di database:
```bash
php check_foto_balasan.php
```

Upload foto asli (sebagai petugas):
1. Login petugas
2. Kelola Pengaduan → ID 160
3. Upload foto di bagian "Upload Foto Balasan"
4. Save

## Expected Result:
✅ Card ungu dengan "Foto Balasan Petugas" muncul
✅ Image (atau error jika file tidak ada)
✅ Debug info menunjukkan empty = NO
