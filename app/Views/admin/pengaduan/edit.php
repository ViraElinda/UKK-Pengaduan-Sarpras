<?= $this->extend('layout/admin') ?>

<?= $this->section('title') ?>
Edit Pengaduan
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="min-h-screen bg-ui-page py-8 px-4 sm:px-6 lg:px-8">
  <div class="max-w-4xl mx-auto">
    
    <!-- Header -->
    <div class="mb-6">
      <h1 class="text-3xl font-bold text-gray-900 mb-2">
        ✏️ Edit Pengaduan
      </h1>
      <p class="text-gray-600 font-medium">Perbarui data pengaduan</p>
    </div>

    <!-- Form Card -->
    <div class="bg-white/90 backdrop-blur-md rounded-2xl shadow-2xl p-8 border border-white/30">
      <?php
        $tglSelesaiValue = '';
        if (!empty($pengaduan['tgl_selesai'])) {
            $tglSelesaiValue = date('Y-m-d\TH:i', strtotime($pengaduan['tgl_selesai']));
        }   
      ?>

      <form action="<?= base_url('admin/pengaduan/update/'.$pengaduan['id_pengaduan']); ?>" method="post" enctype="multipart/form-data" class="space-y-6">
        
        <!-- Nama Pengaduan -->
        <div>
          <label for="nama_pengaduan" class="block text-gray-700 font-bold mb-2 text-sm">Nama Pengaduan</label>
          <input type="text" id="nama_pengaduan" name="nama_pengaduan" value="<?= esc($pengaduan['nama_pengaduan']); ?>" placeholder="Masukkan nama pengaduan"
                 class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all font-medium" required>
        </div>

        <!-- Deskripsi -->
        <div>
          <label for="deskripsi" class="block text-gray-700 font-bold mb-2 text-sm">Deskripsi</label>
          <textarea id="deskripsi" name="deskripsi" rows="4" placeholder="Masukkan deskripsi pengaduan"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all font-medium" required><?= esc($pengaduan['deskripsi']); ?></textarea>
        </div>

        <!-- Lokasi -->
        <div>
          <label for="id_lokasi" class="block text-gray-700 font-bold mb-2 text-sm">Lokasi Kejadian</label>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <!-- Dropdown Lokasi (opsional) -->
            <select id="id_lokasi" name="id_lokasi"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all font-medium">
              <option value="">-- Pilih dari daftar --</option>
              <?php if (!empty($lokasi)): ?>
                <?php foreach ($lokasi as $l): ?>
                  <option value="<?= esc($l['id_lokasi']) ?>" <?= (isset($pengaduan['id_lokasi']) && (int)$pengaduan['id_lokasi'] === (int)$l['id_lokasi']) ? 'selected' : '' ?>>
                    <?= esc($l['nama_lokasi']) ?>
                  </option>
                <?php endforeach; ?>
              <?php endif; ?>
            </select>

            <!-- Input teks lokasi (fallback / custom) -->
            <input type="text" id="lokasi" name="lokasi" value="<?= esc($pengaduan['lokasi'] ?? ''); ?>" placeholder="Atau isi manual: contoh Ruang Kelas 12 IPA 1"
                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all font-medium">
          </div>
          <p class="text-xs text-gray-500 mt-1">Pilih dari daftar, atau isi manual jika belum ada di daftar.</p>
        </div>

        <!-- Status -->
        <div>
          <label for="status" class="block text-gray-700 font-bold mb-2 text-sm">Status</label>
          <select id="status" name="status"
                  class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all font-medium" required>
            <option value="Ditolak" <?= $pengaduan['status']=='Ditolak'?'selected':''; ?>>Ditolak</option>
            <option value="Diajukan" <?= $pengaduan['status']=='Diajukan'?'selected':''; ?>>Diajukan</option>
            <option value="Disetujui" <?= $pengaduan['status']=='Disetujui'?'selected':''; ?>>Disetujui</option>
          </select>
        </div>

        <!-- User -->
        <div>
          <label for="id_user" class="block text-gray-700 font-bold mb-2 text-sm">User Pengadu</label>
          <select name="id_user" id="id_user"
                  class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all font-medium" required>
            <option value="">-- Pilih User --</option>
            <?php foreach ($users as $user): ?>
              <option value="<?= esc($user['id_user']) ?>" <?= $user['id_user'] == $pengaduan['id_user'] ? 'selected' : '' ?>>
                <?= esc($user['nama_pengguna']) ?> (ID: <?= esc($user['id_user']) ?>)
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- ID Item -->
        <div>
          <label for="id_item" class="block text-gray-700 font-bold mb-2 text-sm">ID Item (opsional)</label>
          <input type="number" id="id_item" name="id_item" value="<?= esc($pengaduan['id_item'] ?? ''); ?>" placeholder="Kosongkan jika tidak terkait item"
                 class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all font-medium">
        </div>

        <!-- Tanggal Selesai -->
        <div>
          <label for="tgl_selesai" class="block text-gray-700 font-bold mb-2 text-sm">Tanggal Selesai (opsional)</label>
          <input type="datetime-local" id="tgl_selesai" name="tgl_selesai" value="<?= $tglSelesaiValue; ?>"
                 class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all font-medium">
        </div>

        <!-- Alasan Penolakan (hanya muncul jika status Ditolak) -->
        <div id="alasanPenolakanDiv" style="display: none;">
          <label for="alasan_penolakan" class="block text-gray-700 font-bold mb-2 text-sm">Alasan Penolakan</label>
          <textarea id="alasan_penolakan" name="alasan_penolakan" rows="3" placeholder="Jelaskan alasan penolakan pengaduan"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all font-medium"><?= esc($pengaduan['alasan_penolakan'] ?? ''); ?></textarea>
        </div>

        <!-- Submit Button -->
        <div class="flex gap-4 pt-4">
    <button type="submit"
      class="flex-1 btn-ui flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
            </svg>
            <span>Update Pengaduan</span>
          </button>
          <a href="<?= base_url('admin/pengaduan') ?>"
             class="px-8 py-3.5 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold rounded-xl transition-all">
            Batal
          </a>
        </div>
      </form>
    </div>

  </div>
</div>

<script src="https://unpkg.com/lucide@latest"></script>
<script>
  lucide.createIcons();
  // Sync: saat memilih dari dropdown, otomatis isi input teks lokasi
  const sel = document.getElementById('id_lokasi');
  const inp = document.getElementById('lokasi');
  if (sel && inp) {
    sel.addEventListener('change', function() {
      const opt = sel.options[sel.selectedIndex];
      if (sel.value) {
        inp.value = opt.text.trim();
      }
    });
  }

  // Toggle alasan penolakan berdasarkan status
  const statusSelect = document.getElementById('status');
  const alasanDiv = document.getElementById('alasanPenolakanDiv');
  const alasanTextarea = document.getElementById('alasan_penolakan');

  function toggleAlasanPenolakan() {
    if (statusSelect.value === 'Ditolak') {
      alasanDiv.style.display = 'block';
      alasanTextarea.setAttribute('required', 'required');
    } else {
      alasanDiv.style.display = 'none';
      alasanTextarea.removeAttribute('required');
    }
  }

  statusSelect.addEventListener('change', toggleAlasanPenolakan);
  // Jalankan saat load halaman
  toggleAlasanPenolakan();
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
