# Popup Validation untuk Duplikasi Lokasi & Item

## Perubahan yang Dibuat

### 1. **Admin - Create Pengaduan** (`app/Views/admin/pengaduan/create.php`)
✅ Menambahkan SweetAlert2 popup untuk error duplikasi
- Popup error dengan icon merah saat lokasi & item sama sudah aktif
- Popup success toast untuk berhasil simpan

### 2. **Admin - Edit Pengaduan** (`app/Views/admin/pengaduan/edit.php`)
✅ Menambahkan SweetAlert2 popup untuk error duplikasi
- Popup error dengan icon merah saat lokasi & item sama sudah aktif
- Popup success toast untuk berhasil update

### 3. **User - Form Pengaduan** (`app/Views/user/pengaduan_form.php`)
✅ Menambahkan SweetAlert2 popup untuk error duplikasi
- Popup error dengan footer hint: "Silakan pilih lokasi atau item yang berbeda"
- User-friendly message

## Cara Kerja

Ketika user atau admin mencoba submit pengaduan dengan lokasi & item yang sama (dan masih aktif/belum selesai):

1. **Controller** (`PengaduanController::store()`) melakukan pengecekan:
   ```php
   if ($idLokasi && $idItem) {
       $existingComplaint = $this->pengaduanModel
           ->where('id_lokasi', $idLokasi)
           ->where('id_item', $idItem)
           ->where('status !=', 'Selesai')
           ->first();
       
       if ($existingComplaint) {
           return redirect()->back()
               ->withInput()
               ->with('error', 'Pengaduan untuk lokasi & item ini masih aktif...');
       }
   }
   ```

2. **View** menampilkan popup SweetAlert2:
   ```javascript
   Swal.fire({
     icon: 'error',
     title: 'Gagal!',
     text: "Pengaduan untuk lokasi & item ini masih aktif...",
     confirmButtonColor: '#ef4444'
   });
   ```

## Hasil

✅ Popup modern dan professional menggantikan alert/banner biasa
✅ User langsung tahu masalahnya dengan visual yang jelas
✅ Form data tetap tersimpan (withInput) sehingga user tidak perlu isi ulang
✅ Konsisten dengan popup delete yang sudah ada

## Contoh Tampilan

**Error Popup:**
- 🔴 Icon error merah
- Title: "Gagal!" atau "Oops..."
- Message: Error dari controller
- Button: "OK" atau "Mengerti"
- Footer hint (khusus user): "Silakan pilih lokasi atau item yang berbeda"

**Success Popup:**
- ✅ Toast notification di pojok kanan atas
- Auto-dismiss dalam 3 detik
- Tidak menghalangi user interaction
