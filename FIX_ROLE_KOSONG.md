# 🔧 FIX: Masalah Role Kosong saat Register

## 🐛 Masalah yang Ditemukan

### Problem:
1. User yang register tidak bisa login
2. Kolom `role` di database **KOSONG** (NULL)
3. Error terjadi karena kolom `role` adalah **ENUM** yang tidak memiliki nilai `'user'`

### Penyebab:
Kolom `role` di tabel `user` didefinisikan sebagai:
```sql
ENUM('admin', 'petugas', 'guru', 'siswa')
```

Tidak ada nilai `'user'` di dalam ENUM, sehingga ketika RegisterController mencoba insert dengan `role = 'user'`, MySQL menolak dan set kolom menjadi **kosong/NULL**.

---

## ✅ Solusi yang Diterapkan

### 1. ALTER TABLE - Tambah 'user' ke ENUM

**SQL Command:**
```sql
ALTER TABLE user 
MODIFY COLUMN role ENUM('admin', 'petugas', 'user', 'guru', 'siswa') NOT NULL;
```

**Hasil:**
- ✅ ENUM sekarang mendukung: `admin`, `petugas`, `user`, `guru`, `siswa`
- ✅ Kolom `role` tetap NOT NULL

### 2. Update User yang Role-nya Kosong

**SQL Command:**
```sql
UPDATE user 
SET role = 'user' 
WHERE role IS NULL OR role = '';
```

**Hasil:**
- ✅ User "mita" (dan user lain yang role kosong) sudah di-set menjadi `user`
- ✅ Sekarang bisa login dengan normal

---

## 📝 File yang Sudah Dibuat

### 1. **add_user_to_enum.php**
Script untuk:
- ALTER TABLE tambah 'user' ke ENUM
- Update user yang role kosong
- Menampilkan daftar user setelah fix

**Cara Jalankan:**
```bash
php add_user_to_enum.php
```

### 2. **check_role_column.php**
Script untuk cek struktur kolom role dan user yang bermasalah.

### 3. **fix_empty_role.php**
Script backup untuk update role (jika diperlukan lagi).

---

## 🧪 Testing Setelah Fix

### Test 1: Login User yang Sudah Ada
1. **Username:** mita
2. **Password:** (password yang digunakan saat register)
3. **Expected:** ✅ Berhasil login → redirect ke `/user/dashboard`

### Test 2: Register User Baru
1. Buka `/auth/register`
2. Isi form:
   - Nama: Test User Baru
   - Username: testuserbaru
   - Password: test123456
3. Submit
4. Login dengan akun baru
5. **Expected:** ✅ Role = 'user' di database, bisa login normal

### Test 3: Admin Create User dengan Role User
1. Login sebagai admin
2. Buka `/admin/users/create`
3. Pilih Role: **👤 User**
4. Submit
5. **Expected:** ✅ User tersimpan dengan role = 'user'

---

## 🗄️ Struktur Database Setelah Fix

### Tabel: `user`

```sql
CREATE TABLE `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_pengguna` varchar(100) NOT NULL,
  `role` enum('admin','petugas','user','guru','siswa') NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_user`)
);
```

**Role yang Valid:**
- ✅ `admin` - Administrator full access
- ✅ `petugas` - Petugas pengelola pengaduan
- ✅ `user` - User biasa (dari register) ⭐ **BARU DITAMBAHKAN**
- ✅ `guru` - Guru (jika diperlukan)
- ✅ `siswa` - Siswa (jika diperlukan)

---

## 📊 Data User Setelah Fix

| ID | Username | Nama Pengguna | Role |
|----|----------|---------------|------|
| 16 | fera | feri | siswa |
| 43 | admini | admini | admin |
| 49 | petugas4 | petugas4 | petugas |
| 50 | vira | vira | siswa |
| 51 | nisha | nisha | siswa |
| 52 | vina | vina | siswa |
| 54 | mita | mita | **user** ✅ (FIXED) |

---

## 🔄 Alur Register yang Benar

### Sebelum Fix:
```
User Register
  ↓
Controller set role = 'user'
  ↓
MySQL INSERT dengan role = 'user'
  ↓
❌ ERROR: 'user' tidak ada di ENUM
  ↓
Role di database = NULL (kosong)
  ↓
❌ Tidak bisa login
```

### Setelah Fix:
```
User Register
  ↓
Controller set role = 'user'
  ↓
MySQL INSERT dengan role = 'user'
  ↓
✅ BERHASIL: 'user' ada di ENUM
  ↓
Role di database = 'user'
  ↓
✅ Bisa login normal
```

---

## 🚨 Catatan Penting

### 1. Backup Database
Sebelum menjalankan ALTER TABLE di production, selalu backup database:
```bash
mysqldump -u root -p pengaduan_sarpras > backup_before_alter.sql
```

### 2. Impact ke Code Existing
- ✅ Tidak ada perubahan kode aplikasi yang diperlukan
- ✅ RegisterController sudah benar (set role = 'user')
- ✅ View admin sudah benar (dropdown Admin, Petugas, User)
- ✅ LoginController sudah support redirect untuk role 'user'

### 3. Role Guru dan Siswa
Meskipun `guru` dan `siswa` masih ada di ENUM, di form admin (create/edit) kita hanya tampilkan 3 pilihan:
- Admin
- Petugas
- User

Jika nanti tidak perlu guru/siswa, bisa dihapus dari ENUM dengan ALTER TABLE lagi.

---

## 🎯 Kesimpulan

### Masalah Root Cause:
Database ENUM tidak memiliki nilai `'user'` → Insert gagal → Role jadi NULL

### Solusi:
1. ✅ ALTER TABLE tambah `'user'` ke ENUM
2. ✅ Update user existing yang role kosong
3. ✅ Test register user baru
4. ✅ Test login dengan role user

### Status:
🟢 **SELESAI & TESTED**

User sekarang bisa:
- ✅ Register dengan auto role = 'user'
- ✅ Login berhasil dengan role user
- ✅ Redirect ke `/user/dashboard`

Admin bisa:
- ✅ Create user dengan role Admin/Petugas/User
- ✅ Edit user dan ubah role

---

**Fix Date:** 8 November 2025  
**Fixed By:** Developer Team  
**Status:** ✅ RESOLVED
