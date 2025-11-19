<?= $this->extend('layout/admin') ?>

<?= $this->section('title') ?>
Buat Pengaduan Baru
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="min-h-screen bg-ui-page py-8 px-4 sm:px-6 lg:px-8">
  <div class="max-w-4xl mx-auto">
    
    <!-- Header -->
    <div class="mb-6">
      <h1 class="text-3xl font-bold text-gray-900 mb-2">
        📝 Buat Pengaduan Baru
      </h1>
      <p class="text-gray-600 font-medium">Tambahkan pengaduan baru ke sistem</p>
    </div>

    <!-- Success/Error Messages -->
    <?php if(session()->getFlashdata('success')): ?>
      <div class="bg-green-50 border border-green-200 text-green-700 px-5 py-4 rounded-xl mb-6 flex items-center gap-3 shadow-lg">
        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <span class="font-medium"><?= session()->getFlashdata('success') ?></span>
      </div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>
      <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-xl mb-6 flex items-center gap-3 shadow-lg">
        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <span class="font-medium"><?= session()->getFlashdata('error') ?></span>
      </div>
    <?php endif; ?>

    <!-- Form Card -->
    <div class="bg-white/90 backdrop-blur-md rounded-2xl shadow-2xl p-8 border border-white/30">
      <form action="<?= base_url('admin/pengaduan/store') ?>" method="post" enctype="multipart/form-data" class="space-y-6">
        
        <!-- Nama Pengaduan -->
        <div>
          <label class="block text-sm font-bold text-gray-700 mb-2">
            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Nama Pengaduan <span class="text-red-500">*</span>
          </label>
          <input 
            type="text" 
            name="nama_pengaduan" 
            placeholder="Contoh: Kerusakan Kursi Kelas X-1" 
            required
            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
          >
        </div>

        <!-- Deskripsi -->
        <div>
          <label class="block text-sm font-bold text-gray-700 mb-2">
            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
            </svg>
            Deskripsi <span class="text-red-500">*</span>
          </label>
          <textarea 
            name="deskripsi" 
            placeholder="Jelaskan detail masalah..." 
            rows="4"
            required
            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
          ></textarea>
        </div>

        <!-- Lokasi -->
        <div>
          <label class="block text-sm font-bold text-gray-700 mb-2">
            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Lokasi Kejadian <span class="text-red-500">*</span>
          </label>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <div>
              <select name="id_lokasi" id="id_lokasi" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all bg-white">
                <option value="">-- Pilih Lokasi --</option>
                <?php if (!empty($lokasi)): ?>
                  <?php foreach ($lokasi as $l): ?>
                    <option value="<?= esc($l['id_lokasi']) ?>"><?= esc($l['nama_lokasi']) ?></option>
                  <?php endforeach; ?>
                <?php endif; ?>
              </select>
            </div>
            <div>
              <input 
                type="text" 
                name="lokasi" 
                id="lokasi_text"
                placeholder="Opsional: tulis lokasi jika tidak ada di daftar"
                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
              >
            </div>
          </div>
        </div>

        <!-- Foto -->
        <div>
          <label class="block text-sm font-bold text-gray-700 mb-2">
            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            Foto Bukti
          </label>
          <input 
            type="file" 
            name="foto" 
            accept="image/*"
            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
          >
          <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, WEBP (Max: 4MB)</p>
        </div>

        <!-- Status -->
        <div>
          <label class="block text-sm font-bold text-gray-700 mb-2">
            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Status <span class="text-red-500">*</span>
          </label>
          <select 
            name="status" 
            required
            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all bg-white"
          >
            <option value="Diajukan">📋 Diajukan</option>
            <option value="Diproses">⚙️ Diproses</option>
            <option value="Selesai">✅ Selesai</option>
          </select>
        </div>

        <input type="hidden" name="id_user" value="<?= session()->get('id_user') ?>">

        <!-- Optional Fields Section -->
        <div class="border-t pt-6">
          <h3 class="text-lg font-bold text-gray-700 mb-4">📎 Informasi Tambahan (Opsional)</h3>
          
          <div class="space-y-6">
            <!-- ID Petugas -->
            <div>
              <label class="block text-sm font-bold text-gray-700 mb-2">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                ID Petugas
              </label>
              <input 
                type="number" 
                name="id_petugas" 
                placeholder="Masukkan ID Petugas"
                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
              >
            </div>

            <!-- Item selection (filtered by Lokasi) -->
                <div>
                  <label class="block text-sm font-bold text-gray-700 mb-2">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                    Item (pilih berdasarkan lokasi)
                  </label>
                  <select name="id_item" id="id_item" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all bg-white">
                    <option value="">-- Pilih Item --</option>
                    <!-- Options will be loaded by JS when lokasi selected -->
                  </select>
                  <p class="text-xs text-gray-500 mt-1">Jika item tidak ada, isi kolom "Item Baru" di bawah.</p>
                </div>

                <!-- Item Baru (manual) -->
                <div>
                  <label class="block text-sm font-bold text-gray-700 mb-2">Item Baru (opsional)</label>
                  <input type="text" name="item_baru" id="item_baru" placeholder="Masukkan nama item baru jika tidak ditemukan" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                </div>

            <!-- Tanggal Selesai -->
            <div>
              <label class="block text-sm font-bold text-gray-700 mb-2">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Tanggal Selesai
              </label>
              <input 
                type="datetime-local" 
                name="tgl_selesai"
                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
              >
            </div>

            <!-- Alasan Penolakan (hanya muncul jika status Ditolak) -->
            <div id="alasanPenolakanDiv" style="display: none;">
              <label class="block text-sm font-bold text-gray-700 mb-2">
                <svg class="w-4 h-4 inline mr-1 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Alasan Penolakan
              </label>
              <textarea 
                id="alasan_penolakan"
                name="alasan_penolakan" 
                placeholder="Jelaskan alasan penolakan pengaduan..." 
                rows="3"
                class="w-full px-4 py-3 border border-red-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all"
              ></textarea>
            </div>
          </div>
        </div>

  <!-- Action Buttons -->
        <div class="flex gap-3 pt-4">
          <button 
            type="submit" 
            class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-6 py-3 rounded-xl font-bold shadow-lg hover:shadow-xl transition-all flex items-center justify-center gap-2"
          >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
            </svg>
            Kirim Pengaduan
          </button>
          <a 
            href="<?= base_url('admin/pengaduan') ?>" 
            class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-xl font-bold shadow-lg hover:shadow-xl transition-all flex items-center justify-center gap-2"
          >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            Batal
          </a>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  // Toggle alasan penolakan berdasarkan status
  const statusSelect = document.getElementById('status');
  const alasanDiv = document.getElementById('alasanPenolakanDiv');
  const alasanTextarea = document.getElementById('alasan_penolakan');

  // Load items when lokasi changes (AJAX)
  const lokasiSelect = document.getElementById('id_lokasi');
  const itemSelect = document.getElementById('id_item');

  async function loadItemsForLokasi(lokasiId) {
    if (!lokasiId) {
      itemSelect.innerHTML = '<option value="">-- Pilih Item --</option>';
      return;
    }

    try {
      const res = await fetch('<?= base_url('user/pengaduan/getItems/') ?>' + lokasiId, { credentials: 'include' });
      if (!res.ok) throw new Error('Network error');
      const items = await res.json();

      itemSelect.innerHTML = '<option value="">-- Pilih Item --</option>';
      items.forEach(i => {
        const opt = document.createElement('option');
        opt.value = i.id_item;
        opt.textContent = i.nama_item;
        itemSelect.appendChild(opt);
      });
    } catch (err) {
      console.error('Gagal memuat item:', err);
    }
  }

  if (lokasiSelect) {
    lokasiSelect.addEventListener('change', function() {
      loadItemsForLokasi(this.value);
    });
    // load initially if selected
    if (lokasiSelect.value) loadItemsForLokasi(lokasiSelect.value);
  }

  // If admin types a custom lokasi text, clear lokasiSelect and reset items
  const lokasiTextInput = document.getElementById('lokasi_text');
  if (lokasiTextInput) {
    lokasiTextInput.addEventListener('input', function() {
      if (this.value.trim() !== '') {
        // clear select and items so admin knows items are not filtered by a selected lokasi
        if (lokasiSelect) lokasiSelect.value = '';
        if (itemSelect) itemSelect.innerHTML = '<option value="">-- Pilih Item --</option>';
      }
    });
  }

  // If admin types an item_baru, clear id_item selection
  const itemBaruInput = document.getElementById('item_baru');
  if (itemBaruInput) {
    itemBaruInput.addEventListener('input', function() {
      if (this.value.trim() !== '' && itemSelect) {
        itemSelect.value = '';
      }
    });
  }

  function toggleAlasanPenolakan() {
    if (statusSelect && statusSelect.value === 'Ditolak') {
      alasanDiv.style.display = 'block';
      alasanTextarea.setAttribute('required', 'required');
    } else {
      alasanDiv.style.display = 'none';
      alasanTextarea.removeAttribute('required');
    }
  }

  if (statusSelect) {
    statusSelect.addEventListener('change', toggleAlasanPenolakan);
    // Jalankan saat load halaman
    toggleAlasanPenolakan();
  }
</script>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  // Show error popup if there's an error message
  <?php if(session()->getFlashdata('error')): ?>
    Swal.fire({
      icon: 'error',
      title: 'Gagal!',
      text: "<?= session()->getFlashdata('error'); ?>",
      confirmButtonColor: '#ef4444',
      confirmButtonText: 'OK'
    });
  <?php endif; ?>

  // Show success popup if there's a success message
  <?php if(session()->getFlashdata('success')): ?>
    Swal.fire({
      icon: 'success',
      title: 'Berhasil!',
      text: "<?= session()->getFlashdata('success'); ?>",
      timer: 3000,
      showConfirmButton: false,
      toast: true,
      position: 'top-end'
    });
  <?php endif; ?>
</script>

<?= $this->endSection() ?>  