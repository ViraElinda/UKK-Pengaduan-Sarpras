# 🔒 Logika Lock Status Pengaduan

## Deskripsi
Implementasi logika penguncian status pengaduan untuk mencegah perubahan yang tidak diinginkan setelah status tertentu tercapai.

## Aturan Bisnis

### 1. Penguncian oleh Petugas (Sudah Diproses)
**Kondisi:** Jika petugas sudah MEMPROSES pengaduan (status: `Diproses`, `Disetujui`, `Ditolak`, atau `Selesai`)

**Dampak:**
- ❌ **Admin TIDAK bisa** mengubah status pengaduan lagi
- ✅ **Petugas masih bisa** mengubah status (kecuali sudah Selesai)

**Implementasi:**
- Controller: `Admin\PengaduanController::edit()` dan `update()`
- Validasi: Cek role === 'admin' dan status IN ('diproses', 'disetujui', 'ditolak', 'selesai')
- View: Tombol "Edit" jadi abu-abu (disabled) di `admin/pengaduan/index.php`

### 2. Penguncian Status Selesai
**Kondisi:** Jika status pengaduan sudah `Selesai`

**Dampak:**
- ❌ **Admin TIDAK bisa** mengubah apapun
- ❌ **Petugas TIDAK bisa** mengubah apapun
- ❌ **Status final**, tidak bisa dikembalikan

**Implementasi:**
- Controller: 
  - `Admin\PengaduanController::edit()` dan `update()`
  - `Petugas\PengaduanController::edit()` dan `update()`
- Validasi: Cek status === 'selesai' untuk semua role
- View: Tombol "Edit/Kelola" jadi abu-abu (disabled) di kedua view index

## Flow Status Pengaduan

```
Diajukan (User) ← Admin bisa edit
    ↓
┌───────────────────────────────┐
│   Petugas Memproses           │
├───────────────────────────────┤
│ Diproses                      │ ← Admin TIDAK bisa ubah
│ Disetujui                     │ ← Admin TIDAK bisa ubah
│ Ditolak                       │ ← Admin TIDAK bisa ubah
└───────────────────────────────┘
    ↓
Selesai ← 🔒 LOCKED (Admin & Petugas tidak bisa ubah)
```

## File yang Dimodifikasi

### Controllers
1. **`app/Controllers/Admin/PengaduanController.php`**
   - Method `edit()`: Tambah validasi redirect jika locked
   - Method `update()`: Tambah validasi sebelum update

2. **`app/Controllers/Petugas/PengaduanController.php`**
   - Method `edit()`: Tambah validasi status Selesai
   - Method `update()`: Tambah validasi status Selesai

### Views
1. **`app/Views/admin/pengaduan/index.php`**
   - Tombol Edit → Disable jika status Disetujui/Ditolak/Selesai
   - Tooltip menjelaskan alasan lock

2. **`app/Views/petugas/pengaduan/index.php`**
   - Tombol Kelola → Abu-abu (disabled) jika status Selesai
   - TIDAK ADA tombol Hapus untuk petugas

## Pesan Error

### Admin mencoba edit status yang sudah diproses petugas:
```
❌ Pengaduan sudah diproses oleh petugas. Admin tidak bisa mengubah status lagi.
```

### Admin/Petugas mencoba edit status Selesai:
```
❌ Pengaduan sudah selesai dan tidak bisa diubah lagi.
```

## Testing Checklist

- [ ] Admin tidak bisa edit pengaduan dengan status Diproses
- [ ] Admin tidak bisa edit pengaduan dengan status Disetujui
- [ ] Admin tidak bisa edit pengaduan dengan status Ditolak
- [ ] Admin tidak bisa edit pengaduan dengan status Selesai
- [ ] Petugas masih bisa edit pengaduan dengan status Diproses/Disetujui
- [ ] Petugas tidak bisa edit pengaduan dengan status Selesai
- [ ] Tombol Edit/Kelola jadi abu-abu (disabled) sesuai kondisi
- [ ] Tidak ada tombol Hapus di halaman petugas
- [ ] Redirect dengan pesan error yang sesuai

## Catatan Penting

⚠️ **Hati-hati:** Jika ada data dengan status Selesai, data tersebut tidak bisa diubah lagi melalui interface. Jika perlu mengubah, harus melalui database langsung.

💡 **Best Practice:** Pastikan petugas dan admin memahami bahwa:
- Begitu petugas memproses (ubah status jadi Diproses/Disetujui/Ditolak), admin tidak bisa ubah lagi
- Status Selesai adalah status final yang tidak bisa diubah siapapun
- Petugas tidak punya akses tombol Hapus (hanya Admin)

---
**Tanggal Implementasi:** 2024-11-11
**Versi:** 1.0
