<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-8 px-4 sm:px-6 lg:px-8">
  <div class="max-w-5xl mx-auto">
    
    <!-- Header Card -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-3xl shadow-2xl p-6 sm:p-8 mb-8 transform hover:scale-[1.01] transition-transform duration-300">
      <div class="flex items-center gap-4">
        <div class="bg-white/20 backdrop-blur-sm p-4 rounded-2xl">
          <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
          </svg>
        </div>
        <div>
          <h1 class="text-3xl font-bold text-white mb-1">📋 Detail Pengaduan</h1>
          <p class="text-blue-100">Informasi lengkap tentang pengaduan yang diajukan</p>
        </div>
      </div>
    </div>

    <!-- Main Content Card -->
    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
      
      <!-- Info Grid -->
      <div class="divide-y divide-gray-100">
        
        <!-- Judul Pengaduan -->
        <div class="p-6 hover:bg-gray-50 transition-colors">
          <div class="flex flex-col sm:flex-row sm:items-start gap-4">
            <div class="sm:w-48 flex-shrink-0">
              <div class="flex items-center gap-2 text-sm font-bold text-gray-700">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                </svg>
                Judul Pengaduan
              </div>
            </div>
            <div class="flex-1">
              <p class="text-gray-900 font-semibold text-lg"><?= esc($pengaduan['nama_pengaduan']) ?></p>
            </div>
          </div>
        </div>

        <!-- Deskripsi -->
        <div class="p-6 hover:bg-gray-50 transition-colors">
          <div class="flex flex-col sm:flex-row sm:items-start gap-4">
            <div class="sm:w-48 flex-shrink-0">
              <div class="flex items-center gap-2 text-sm font-bold text-gray-700">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                </svg>
                Deskripsi
              </div>
            </div>
            <div class="flex-1">
              <p class="text-gray-700 leading-relaxed"><?= esc($pengaduan['deskripsi']) ?></p>
            </div>
          </div>
        </div>

        <!-- Lokasi -->
        <div class="p-6 hover:bg-gray-50 transition-colors">
          <div class="flex flex-col sm:flex-row sm:items-start gap-4">
            <div class="sm:w-48 flex-shrink-0">
              <div class="flex items-center gap-2 text-sm font-bold text-gray-700">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Lokasi
              </div>
            </div>
            <div class="flex-1">
              <p class="text-gray-700 font-medium"><?= esc($pengaduan['lokasi']) ?></p>
            </div>
          </div>
        </div>

        <!-- Foto Pengaduan -->
        <div class="p-6 hover:bg-gray-50 transition-colors">
          <div class="flex flex-col sm:flex-row sm:items-start gap-4">
            <div class="sm:w-48 flex-shrink-0">
              <div class="flex items-center gap-2 text-sm font-bold text-gray-700">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Foto Bukti
              </div>
            </div>
            <div class="flex-1">
              <?php if (!empty($pengaduan['foto'])): ?>
                <div class="group relative inline-block rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-shadow">
                  <img src="<?= base_url('uploads/foto_pengaduan/' . $pengaduan['foto']) ?>" 
                       alt="Foto Pengaduan" 
                       class="max-w-full h-auto max-h-96 object-cover rounded-2xl transform group-hover:scale-105 transition-transform duration-300">
                  <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                </div>
              <?php else: ?>
                <div class="bg-gray-100 border-2 border-dashed border-gray-300 rounded-2xl p-8 text-center">
                  <svg class="w-16 h-16 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                  </svg>
                  <p class="text-gray-500 font-medium">Tidak ada foto</p>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <!-- Foto Perbaikan -->
        <div class="p-6 bg-gradient-to-br from-gray-50 to-blue-50">
          <div class="flex flex-col sm:flex-row sm:items-start gap-4">
            <div class="sm:w-48 flex-shrink-0">
              <div class="flex items-center gap-2 text-sm font-bold text-gray-700">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Dokumentasi Perbaikan
              </div>
            </div>
            <div class="flex-1">
              <?php if (empty($pengaduan['foto_balasan'])): ?>
                <div class="bg-amber-50 border-2 border-amber-200 rounded-2xl p-8 text-center">
                  <svg class="w-16 h-16 mx-auto text-amber-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                  </svg>
                  <p class="text-amber-800 font-semibold">Belum ada foto balasan dari petugas</p>
                  <p class="text-amber-600 text-sm mt-1">Petugas akan mengunggah foto balasan setelah penanganan</p>
                </div>
              <?php else: ?>
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                  <div class="bg-gradient-to-r from-purple-500 to-indigo-500 p-3 text-center">
                    <div class="flex items-center justify-center gap-2 text-white font-bold">
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                      </svg>
                      📸 Foto Balasan Petugas
                    </div>
                  </div>
                  <div class="p-4">
                    <img src="<?= base_url('uploads/foto_balasan/' . $pengaduan['foto_balasan']) ?>" 
                         alt="Foto Balasan Petugas" 
                         class="w-full h-auto object-contain rounded-xl shadow-md mx-auto"
                         style="max-height: 400px;"
                         onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                    <div style="display:none;" class="bg-yellow-50 border-2 border-yellow-300 rounded-xl p-4 text-center">
                      <svg class="w-12 h-12 mx-auto text-yellow-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                      </svg>
                      <p class="text-yellow-800 font-semibold">⚠️ File foto tidak ditemukan</p>
                      <p class="text-yellow-600 text-sm">Petugas sudah upload foto balasan, tapi file fisik tidak ada di server.</p>
                    </div>
                  </div>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <!-- Status -->
        <div class="p-6 hover:bg-gray-50 transition-colors">
          <div class="flex flex-col sm:flex-row sm:items-start gap-4">
            <div class="sm:w-48 flex-shrink-0">
              <div class="flex items-center gap-2 text-sm font-bold text-gray-700">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Status
              </div>
            </div>
            <div class="flex-1">
              <?php 
                $status = strtolower($pengaduan['status']);
                $statusConfig = [
                  'diajukan' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-800', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                  'diproses' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z'],
                  'selesai' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'icon' => 'M5 13l4 4L19 7'],
                  'ditolak' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'icon' => 'M6 18L18 6M6 6l12 12']
                ];
                $config = $statusConfig[$status] ?? $statusConfig['diajukan'];
              ?>
              <div class="inline-flex items-center gap-2 <?= $config['bg'] ?> <?= $config['text'] ?> px-5 py-3 rounded-full font-bold shadow-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?= $config['icon'] ?>"/>
                </svg>
                <?= esc(ucfirst($pengaduan['status'])) ?>
              </div>
            </div>
          </div>
        </div>

        <!-- Tanggal Pengajuan -->
        <div class="p-6 hover:bg-gray-50 transition-colors">
          <div class="flex flex-col sm:flex-row sm:items-start gap-4">
            <div class="sm:w-48 flex-shrink-0">
              <div class="flex items-center gap-2 text-sm font-bold text-gray-700">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Tanggal Pengajuan
              </div>
            </div>
            <div class="flex-1">
              <div class="flex items-center gap-2">
                <div class="bg-blue-100 text-blue-700 px-4 py-2 rounded-lg font-semibold">
                  <?= date('d-m-Y', strtotime($pengaduan['tgl_pengajuan'])) ?>
                </div>
                <div class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg font-semibold">
                  <?= date('H:i', strtotime($pengaduan['tgl_pengajuan'])) ?>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Tanggal Selesai -->
        <div class="p-6 hover:bg-gray-50 transition-colors">
          <div class="flex flex-col sm:flex-row sm:items-start gap-4">
            <div class="sm:w-48 flex-shrink-0">
              <div class="flex items-center gap-2 text-sm font-bold text-gray-700">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Tanggal Selesai
              </div>
            </div>
            <div class="flex-1">
              <?php if (!empty($pengaduan['tgl_selesai'])): ?>
                <div class="flex items-center gap-2">
                  <div class="bg-green-100 text-green-700 px-4 py-2 rounded-lg font-semibold">
                    <?= date('d-m-Y', strtotime($pengaduan['tgl_selesai'])) ?>
                  </div>
                  <div class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg font-semibold">
                    <?= date('H:i', strtotime($pengaduan['tgl_selesai'])) ?>
                  </div>
                </div>
              <?php else: ?>
                <div class="inline-flex items-center gap-2 bg-gray-100 text-gray-500 px-4 py-2 rounded-lg font-medium">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                  </svg>
                  Belum selesai
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <!-- Saran Petugas -->
        <div class="p-6 hover:bg-gray-50 transition-colors">
          <div class="flex flex-col sm:flex-row sm:items-start gap-4">
            <div class="sm:w-48 flex-shrink-0">
              <div class="flex items-center gap-2 text-sm font-bold text-gray-700">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                </svg>
                Saran Petugas
              </div>
            </div>
            <div class="flex-1">
              <?php if (!empty($pengaduan['saran_petugas'])): ?>
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 border-l-4 border-blue-500 p-4 rounded-lg">
                  <p class="text-gray-700 leading-relaxed"><?= esc($pengaduan['saran_petugas']) ?></p>
                </div>
              <?php else: ?>
                <div class="inline-flex items-center gap-2 bg-gray-100 text-gray-500 px-4 py-2 rounded-lg font-medium">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                  </svg>
                  Belum ada saran
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>

      </div>
    </div>

  </div>
</div>

<?= $this->endSection() ?>
