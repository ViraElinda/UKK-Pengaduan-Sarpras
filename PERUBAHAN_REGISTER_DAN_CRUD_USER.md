# Dokumentasi Perubahan: Register & CRUD User

## 📋 Ringkasan Perubahan

Sistem telah diupdate dengan fitur berikut:

### 1. **Register Auto Role User** ✅
- User yang mendaftar melalui halaman register akan **otomatis mendapatkan role "user"**
- Tidak perlu memilih role saat register
- Role lain (admin, petugas) hanya bisa dibuat melalui CRUD Admin

### 2. **CRUD User dengan Role Admin, Petugas, dan User** ✅
- Admin dapat menambah user baru dengan memilih role:
  - 👨‍💼 **Admin**
  - 🔧 **Petugas**
  - 👤 **User**
- Pilihan role guru dan siswa telah dihapus
- Berlaku untuk form Create dan Edit User

---

## 🔧 File yang Dimodifikasi

### 1. **RegisterController.php**
📁 `app/Controllers/Auth/RegisterController.php`

**Perubahan:**
- Menghapus parameter role dari form
- Auto set `$role = 'user'` untuk semua registrasi
- Menghapus logika insert ke tabel petugas (hanya untuk user biasa)
- Validasi lebih sederhana

**Kode Utama:**
```php
public function register()
{
    $userModel = new UserModel();

    $nama_pengguna = $this->request->getPost('nama_pengguna');
    $username      = $this->request->getPost('username');
    $password      = $this->request->getPost('password');
    
    // Auto set role sebagai 'user' untuk registrasi public
    $role = 'user';

    // Validasi field
    if (!$nama_pengguna || !$username || !$password) {
        return redirect()->back()->withInput()->with('error', 'Semua field wajib diisi.');
    }

    if (strlen($password) < 6) {
        return redirect()->back()->withInput()->with('error', 'Password minimal 6 karakter.');
    }

    // Cek username sudah digunakan
    if ($userModel->where('username', $username)->first()) {
        return redirect()->back()->withInput()->with('error', 'Username sudah digunakan.');
    }

    // Insert ke tabel user dengan role 'user'
    $userModel->insert([
        'nama_pengguna' => $nama_pengguna,
        'username'      => $username,
        'password'      => password_hash($password, PASSWORD_DEFAULT),
        'role'          => $role,
        'created_at'    => date('Y-m-d H:i:s'),
    ]);

    return redirect()->to('/auth/login')
                     ->with('success', 'Berhasil daftar! Silakan login sebagai User.');
}
```

---

### 2. **create.php (Admin Users)**
📁 `app/Views/admin/users/create.php`

**Perubahan:**
- Dropdown role diupdate menjadi 3 pilihan:
  - Admin
  - Petugas
  - User
- Menghapus opsi Guru dan Siswa

**Kode Utama:**
```php
<select 
  name="role" 
  required
  class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all bg-white"
>
  <option value="" disabled selected>Pilih Role</option>
  <option value="admin">👨‍💼 Admin</option>
  <option value="petugas">🔧 Petugas</option>
  <option value="user">👤 User</option>
</select>
```

---

### 3. **edit.php (Admin Users)**
📁 `app/Views/admin/users/edit.php`

**Perubahan:**
- Dropdown role diupdate menjadi 3 pilihan yang sama
- Auto select role saat ini (admin/petugas/user)

**Kode Utama:**
```php
<select id="role" name="role"
        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all font-medium" required>
  <option value="admin" <?= $user['role']=='admin'?'selected':''; ?>>👨‍💼 Admin</option>
  <option value="petugas" <?= $user['role']=='petugas'?'selected':''; ?>>🔧 Petugas</option>
  <option value="user" <?= $user['role']=='user'?'selected':''; ?>>👤 User</option>
</select>
```

---

## 🎯 Cara Kerja Sistem

### **Untuk User Biasa (Registrasi Publik)**
1. Buka halaman `/auth/register`
2. Isi form:
   - Nama Lengkap
   - Username
   - Password (minimal 6 karakter)
3. Klik **"Daftar Sekarang"**
4. Sistem otomatis set role = **"user"**
5. Data tersimpan di database dengan role user
6. Redirect ke halaman login
7. Login dan masuk ke User Dashboard

### **Untuk Admin (Menambah User dari Admin Panel)**
1. Login sebagai Admin
2. Buka menu **Users** → **Tambah User**
3. Isi form:
   - Username
   - Password
   - Nama Lengkap
   - **Pilih Role** (Admin / Petugas / User)
4. Klik **"Simpan"**
5. User baru tersimpan dengan role yang dipilih

---

## 🗄️ Struktur Database

Tabel `user`:
```sql
CREATE TABLE `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_pengguna` varchar(100) NOT NULL,
  `role` enum('admin','petugas','user') NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_user`)
);
```

**Role yang Valid:**
- `admin` - Full access ke semua fitur
- `petugas` - Akses terbatas untuk mengelola pengaduan
- `user` - User biasa yang bisa membuat pengaduan

---

## 🔐 Flow Autentikasi

### **Login**
```
LoginController::login()
  ↓
Cek username & password
  ↓
Load role dari database
  ↓
Set session dengan role
  ↓
Redirect based on role:
  - admin → /admin/dashboard
  - petugas → /petugas/dashboard
  - user → /user/dashboard
```

### **Register**
```
RegisterController::register()
  ↓
Validasi input (nama, username, password)
  ↓
Auto set role = 'user'
  ↓
Hash password
  ↓
Insert ke database
  ↓
Redirect ke login page
```

---

## ✅ Checklist Testing

### **Test Registrasi User Baru**
- [ ] Buka `/auth/register`
- [ ] Isi form dengan data valid
- [ ] Submit form
- [ ] Cek database: role harus **'user'**
- [ ] Login dengan akun baru
- [ ] Harus masuk ke `/user/dashboard`

### **Test CRUD User di Admin**
- [ ] Login sebagai admin
- [ ] Buka `/admin/users`
- [ ] Klik "Tambah User"
- [ ] Pilih role **Admin** → Submit → Cek database
- [ ] Pilih role **Petugas** → Submit → Cek database
- [ ] Pilih role **User** → Submit → Cek database
- [ ] Edit user → Ubah role → Cek perubahan di database
- [ ] Delete user → Cek terhapus dari database

---

## 🚀 URL Routes

| Method | URL | Deskripsi | Role Required |
|--------|-----|-----------|---------------|
| GET | `/auth/register` | Form registrasi | Public |
| POST | `/auth/register` | Proses registrasi (auto role user) | Public |
| GET | `/admin/users` | List semua user | Admin |
| GET | `/admin/users/create` | Form tambah user | Admin |
| POST | `/admin/users/store` | Simpan user baru | Admin |
| GET | `/admin/users/edit/{id}` | Form edit user | Admin |
| POST | `/admin/users/update/{id}` | Update user | Admin |
| GET | `/admin/users/delete/{id}` | Hapus user | Admin |

---

## 📝 Catatan Penting

1. **Password Hashing**: Semua password di-hash menggunakan `password_hash()` dengan algoritma default (bcrypt)
2. **Session Management**: Role disimpan dalam session setelah login
3. **Role Filter**: Route group menggunakan middleware `role:admin`, `role:petugas`, `role:user`
4. **Validation**: Username harus unik di seluruh sistem
5. **User yang Register**: Tidak bisa memilih role, otomatis jadi 'user'
6. **Admin Panel**: Admin bisa create user dengan role apapun (admin/petugas/user)

---

## 🐛 Troubleshooting

### **Masalah: User yang register tidak bisa login**
- Cek database apakah role = 'user'
- Pastikan password ter-hash dengan benar
- Cek filter route untuk role user

### **Masalah: Dropdown role tidak muncul di form admin**
- Clear browser cache
- Cek file `app/Views/admin/users/create.php` dan `edit.php`
- Pastikan tag `<select name="role">` ada

### **Masalah: Redirect error setelah login**
- Cek `LoginController::login()` untuk switch case role
- Pastikan route untuk setiap role sudah didefinisikan
- Cek `Routes.php` untuk route group user, admin, petugas

---

## 📞 Support

Jika ada pertanyaan atau masalah, hubungi developer atau cek dokumentasi CodeIgniter 4.

---

**Update Terakhir:** 8 November 2025
**Version:** 1.0.0
