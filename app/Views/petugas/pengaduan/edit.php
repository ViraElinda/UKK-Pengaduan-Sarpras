<?= $this->extend('layout/petugas') ?>

<?= $this->section('title') ?>
Ubah Status Pengaduan
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="min-h-screen bg-ui-page py-8 px-4 sm:px-6 lg:px-8">
  <div class="max-w-4xl mx-auto">
    
    <!-- Header -->
    <div class="mb-6">
      <h1 class="text-3xl font-bold text-gray-900 mb-2">
        🔧 Kelola Pengaduan
      </h1>
      <p class="text-gray-600 font-medium">Ubah status, tambahkan saran, atau tolak pengaduan dengan alasan</p>
    </div>

    <!-- Error Message -->
    <?php if(session()->getFlashdata('error')): ?>
      <div class="bg-red-50 text-red-700 p-4 rounded-xl mb-6 font-bold shadow-lg">
        ⚠️ <?= session()->getFlashdata('error') ?>
      </div>
    <?php endif; ?>

    <!-- Form Card -->
    <div class="bg-white/90 backdrop-blur-md rounded-2xl shadow-2xl p-8 border border-white/30">
      
      <!-- Info Pengaduan -->
      <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mb-6">
        <h3 class="text-lg font-bold text-gray-700 mb-4 flex items-center gap-2">
          <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
          </svg>
          Informasi Pengaduan
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700">
          <div>
            <p class="text-sm text-gray-500 mb-1">Nama Pengaduan</p>
            <p class="font-bold text-gray-800"><?= esc($pengaduan['nama_pengaduan']); ?></p>
          </div>
          <div>
            <p class="text-sm text-gray-500 mb-1">Status Saat Ini</p>
            <p class="font-bold">
              <?php 
                $status = strtolower($pengaduan['status']);
                $statusClasses = [
                  'diajukan'  => 'badge-status-diajukan',
                  'disetujui' => 'badge-status-disetujui',
                  'diproses'  => 'badge-status-diproses',
                  'selesai'   => 'badge-status-selesai',
                  'ditolak'   => 'badge-status-ditolak',
                ];
                $badgeClass = $statusClasses[$status] ?? 'badge-ui';
              ?>
              <span class="<?= $badgeClass ?>">
                <?= esc(ucfirst($pengaduan['status'])) ?>
              </span>
            </p>
          </div>
          <div class="md:col-span-2">
            <p class="text-sm text-gray-500 mb-1">Deskripsi</p>
            <p class="font-medium text-gray-800"><?= esc($pengaduan['deskripsi']); ?></p>
          </div>
        </div>
      </div>

      <form action="<?= base_url('petugas/pengaduan/update/'.$pengaduan['id_pengaduan']); ?>" method="post" enctype="multipart/form-data" class="space-y-6">
        <?= csrf_field() ?>

        <!-- Status -->
        <div class="bg-gray-50 rounded-xl p-5 border-2 border-gray-200">
          <label for="status" class="block text-gray-700 font-bold mb-3 text-sm flex items-center gap-2">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            Ubah Status Pengaduan
          </label>
          <select id="status" name="status" onchange="toggleAlasan()"
                  class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all font-bold bg-white">
            <option value="Diajukan" <?= $pengaduan['status']=='Diajukan'?'selected':'' ?>>📝 Diajukan</option>
            <option value="Disetujui" <?= $pengaduan['status']=='Disetujui'?'selected':'' ?>>👍 Disetujui</option>
            <option value="Diproses" <?= $pengaduan['status']=='Diproses'?'selected':'' ?>>⚙️ Diproses</option>
            <option value="Selesai" <?= $pengaduan['status']=='Selesai'?'selected':'' ?>>✅ Selesai</option>
            <option value="Ditolak" <?= $pengaduan['status']=='Ditolak'?'selected':'' ?>>❌ Ditolak</option>
          </select>
        </div>

        <!-- Alasan Penolakan (conditional) -->
        <div id="alasan" class="bg-red-50 rounded-xl p-5 border-2 border-red-200" style="display: <?= $pengaduan['status']=='Ditolak'?'block':'none' ?>;">
          <label for="alasan_penolakan" class="block text-gray-700 font-bold mb-3 text-sm flex items-center gap-2">
            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            Alasan Penolakan (Wajib jika status Ditolak)
          </label>
          <textarea id="alasan_penolakan" name="alasan_penolakan" rows="3" placeholder="Jelaskan mengapa pengaduan ini ditolak..."
                    class="w-full px-4 py-3 border-2 border-red-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all font-medium bg-white"><?= esc($pengaduan['alasan_penolakan'] ?? ''); ?></textarea>
        </div>

        <!-- Saran Petugas -->
        <div class="bg-green-50 rounded-xl p-5 border-2 border-green-200">
          <label for="saran_petugas" class="block text-gray-700 font-bold mb-3 text-sm flex items-center gap-2">
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Saran Petugas (Opsional)
          </label>
          <textarea id="saran_petugas" name="saran_petugas" rows="4" placeholder="Berikan saran, catatan, atau rekomendasi untuk pengaduan ini..."
                    class="w-full px-4 py-3 border-2 border-green-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all font-medium bg-white"><?= esc($pengaduan['saran_petugas'] ?? ''); ?></textarea>
          <p class="text-xs text-gray-500 mt-2">💡 Tip: Berikan saran yang membantu untuk mempercepat penyelesaian pengaduan</p>
        </div>

        <!-- Foto Balasan -->
        <div class="bg-purple-50 rounded-xl p-5 border-2 border-purple-200">
          <label for="foto_balasan" class="block text-gray-700 font-bold mb-3 text-sm flex items-center gap-2">
            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            Upload Foto Balasan (Opsional)
          </label>
          <input type="file" id="foto_balasan" name="foto_balasan" accept="image/*"
                 class="w-full px-4 py-3 border-2 border-purple-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all font-medium bg-white" />
          <p class="text-xs text-gray-500 mt-2">💡 Upload foto bukti penanganan atau hasil perbaikan (Max 5MB)</p>
          
          <?php if (!empty($pengaduan['foto_balasan'])): ?>
            <div class="mt-4 p-3 bg-white rounded-lg border border-purple-200">
              <span class="text-sm text-gray-600 font-medium">Foto Balasan Saat Ini:</span>
              <div class="mt-2">
                <img src="<?= base_url('uploads/foto_balasan/' . $pengaduan['foto_balasan']) ?>" alt="Foto Balasan" class="rounded-xl shadow-lg max-h-64 mx-auto">
              </div>
            </div>
          <?php endif; ?>
        </div>

        <!-- Submit Button -->
        <div class="flex gap-4 pt-4">
          <button type="submit"
                                    class="flex-1 btn-ui py-3.5">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
            </svg>
            <span>Simpan Perubahan</span>
          </button>
          <a href="<?= base_url('petugas/pengaduan') ?>"
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
  
  function toggleAlasan() {
    const alasanDiv = document.getElementById('alasan');
    const status = document.getElementById('status').value;
    alasanDiv.style.display = status === 'Ditolak' ? 'block' : 'none';
  }
</script>

<?= $this->endSection() ?>
