# 🔐 Panduan Sistem Autentikasi

## Overview
Sistem autentikasi ini menggunakan 3 filter utama untuk melindungi semua halaman:

### 1. **GuestFilter** (`app/Filters/GuestFilter.php`)
- **Tujuan**: Mencegah user yang SUDAH LOGIN akses halaman login/register
- **Diterapkan pada**: Routes `auth/*` (login, register)
- **Fungsi**:
  - Jika user sudah login → redirect ke dashboard sesuai role
  - Jika belum login → boleh akses halaman login/register

### 2. **RoleFilter** (`app/Filters/RoleFilter.php`)
- **Tujuan**: Memastikan hanya role tertentu yang bisa akses halaman tertentu
- **Diterapkan pada**: Routes `admin/*`, `petugas/*`, `user/*`
- **Fungsi**:
  - Cek apakah user sudah login
  - Cek apakah role user sesuai dengan route yang diakses
  - Jika tidak sesuai → redirect ke `/unauthorized`
  - **PENTING**: Menambahkan header no-cache di `after()` untuk mencegah browser back

### 3. **AuthFilter** (`app/Filters/AuthFilter.php`)
- **Tujuan**: Memastikan user sudah login
- **Diterapkan pada**: Routes yang butuh autentikasi (logout, dll)
- **Fungsi**:
  - Cek apakah user sudah login
  - Jika belum → redirect ke login
  - **PENTING**: Menambahkan header no-cache di `after()` untuk mencegah browser back

---

## 🛡️ Fitur Keamanan

### ✅ Prevent Browser Back After Logout
Semua filter dan BaseController menambahkan header HTTP berikut:
```php
Cache-Control: no-store, no-cache, must-revalidate, max-age=0
Pragma: no-cache
Expires: Sat, 01 Jan 2000 00:00:00 GMT
```

Ini memastikan:
- ❌ User tidak bisa tekan tombol Back setelah logout
- ❌ Browser tidak menyimpan cache halaman authenticated
- ❌ User tidak bisa akses halaman lama dengan history

### ✅ Role-Based Access Control (RBAC)
Setiap role hanya bisa akses halaman yang sesuai:
- **Admin**: `/admin/*`
- **Petugas**: `/petugas/*`
- **User**: `/user/*`

### ✅ Session Management
- Session otomatis di-destroy saat logout
- Session di-validasi di setiap request
- Role di-validasi di setiap request

---

## 📋 Implementasi di Routes

### Routes dengan GuestFilter (Login/Register)
```php
$routes->group('auth', ['filter' => 'guest'], function ($routes) {
    $routes->get('register', 'Auth\RegisterController::index');
    $routes->post('register', 'Auth\RegisterController::register');
    $routes->get('login', 'Auth\LoginController::index');
    $routes->post('login', 'Auth\LoginController::login');
});
```

### Routes dengan RoleFilter (Admin)
```php
$routes->group('admin', ['filter' => 'role:admin'], function ($routes) {
    $routes->get('dashboard', 'DashboardController::admin');
    $routes->get('users', 'Admin\UserController::index');
    // ... semua routes admin
});
```

### Routes dengan RoleFilter (Petugas)
```php
$routes->group('petugas', ['filter' => 'role:petugas'], function ($routes) {
    $routes->get('dashboard', 'DashboardController::petugas');
    $routes->get('pengaduan', 'Petugas\PengaduanController::index');
    // ... semua routes petugas
});
```

### Routes dengan RoleFilter (User)
```php
$routes->group('user', ['filter' => 'role:user'], function ($routes) {
    $routes->get('dashboard', 'DashboardController::user');
    $routes->get('index', 'User\PengaduanController::index');
    // ... semua routes user
});
```

### Routes dengan AuthFilter (Logout)
```php
$routes->post('auth/logout', 'Auth\LoginController::logout', ['filter' => 'auth']);
$routes->get('auth/logout', 'Auth\LoginController::logout', ['filter' => 'auth']);
```

---

## 🧪 Testing Autentikasi

### Test 1: Tidak Bisa Akses Login/Register Setelah Login
1. Login sebagai user (role apapun)
2. Coba akses `/auth/login` atau `/auth/register`
3. ✅ Harus otomatis redirect ke dashboard sesuai role

### Test 2: Tidak Bisa Akses Halaman Lain Tanpa Login
1. Logout atau buka browser baru (incognito)
2. Coba akses `/admin/dashboard` atau `/user/dashboard`
3. ✅ Harus redirect ke `/auth/login`

### Test 3: Tidak Bisa Akses Halaman Role Lain
1. Login sebagai **user**
2. Coba akses `/admin/dashboard`
3. ✅ Harus redirect ke `/unauthorized`

### Test 4: Tidak Bisa Back Setelah Logout
1. Login sebagai user
2. Akses halaman dashboard
3. Klik Logout
4. Tekan tombol **Back** di browser
5. ✅ Harus redirect ke login atau tidak bisa akses halaman (no-cache bekerja)

### Test 5: Session Expired
1. Login sebagai user
2. Hapus cookie/session manual dari browser DevTools
3. Refresh halaman
4. ✅ Harus redirect ke login

---

## 🚨 PENTING - Jangan Dihapus!

### File Yang Tidak Boleh Diubah:
1. ✅ `app/Filters/RoleFilter.php` - Inti RBAC
2. ✅ `app/Filters/GuestFilter.php` - Prevent double login
3. ✅ `app/Filters/AuthFilter.php` - Basic auth check
4. ✅ `app/Config/Filters.php` - Filter registration
5. ✅ `app/Config/Routes.php` - Filter aplikasi
6. ✅ `app/Controllers/BaseController.php` - No-cache header

### Method Penting di LoginController:
```php
public function logout()
{
    // Destroy session
    session()->destroy();
    
    // Prevent caching
    $this->response->setHeader('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
    $this->response->setHeader('Pragma', 'no-cache');
    $this->response->setHeader('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
    
    return redirect()->to('/auth/login');
}
```

---

## 🎯 Kesimpulan

Sistem autentikasi sudah **LENGKAP** dan **AMAN** dengan fitur:
- ✅ Role-Based Access Control (RBAC)
- ✅ Session Management
- ✅ Prevent Browser Back After Logout
- ✅ Prevent Double Login
- ✅ Protect All Routes
- ✅ No-Cache Headers

**JANGAN HAPUS ATAU UBAH** filter dan konfigurasi autentikasi!
