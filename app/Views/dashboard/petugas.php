<?= $this->extend('layout/petugas') ?>

<?= $this->section('title') ?>
Dashboard Petugas
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="min-h-screen bg-ui-page py-8 px-4 sm:px-6 lg:px-8">
  <div class="max-w-7xl mx-auto">
    
    <!-- Header -->
    <div class="mb-8">
      <h1 class="text-4xl font-bold text-gray-900 mb-2">
        👷 Dashboard Petugas
      </h1>
      <p class="text-gray-600 text-lg">Selamat datang, <strong><?= esc($username) ?></strong>! Kelola semua pengaduan sarana prasarana.</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
      
      <!-- Total Semua Aduan -->
      <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-2xl p-6 text-white transform hover:scale-105 transition-all">
        <div class="flex items-center justify-between mb-4">
          <div class="bg-white/20 p-3 rounded-xl backdrop-blur-sm">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
          </div>
        </div>
        <h3 class="text-3xl font-bold mb-1"><?= $total_aduan ?></h3>
        <p class="text-blue-100 font-medium">Total Aduan</p>
      </div>

      <!-- Diajukan -->
      <div class="bg-gradient-to-br from-gray-500 to-gray-600 rounded-2xl shadow-2xl p-6 text-white transform hover:scale-105 transition-all">
        <div class="flex items-center justify-between mb-4">
          <div class="bg-white/20 p-3 rounded-xl backdrop-blur-sm">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
          </div>
        </div>
        <h3 class="text-3xl font-bold mb-1"><?= $total_diajukan ?></h3>
        <p class="text-gray-100 font-medium">Diajukan</p>
      </div>

      <!-- Disetujui -->
      <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-2xl shadow-2xl p-6 text-white transform hover:scale-105 transition-all">
        <div class="flex items-center justify-between mb-4">
          <div class="bg-white/20 p-3 rounded-xl backdrop-blur-sm">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
          </div>
        </div>
        <h3 class="text-3xl font-bold mb-1"><?= $total_disetujui ?></h3>
        <p class="text-indigo-100 font-medium">Disetujui</p>
      </div>

      <!-- Diproses -->
      <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl shadow-2xl p-6 text-white transform hover:scale-105 transition-all">
        <div class="flex items-center justify-between mb-4">
          <div class="bg-white/20 p-3 rounded-xl backdrop-blur-sm">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
          </div>
        </div>
        <h3 class="text-3xl font-bold mb-1"><?= $total_diproses ?></h3>
        <p class="text-orange-100 font-medium">Diproses</p>
      </div>

      <!-- Selesai -->
      <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-2xl p-6 text-white transform hover:scale-105 transition-all">
        <div class="flex items-center justify-between mb-4">
          <div class="bg-white/20 p-3 rounded-xl backdrop-blur-sm">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
          </div>
        </div>
        <h3 class="text-3xl font-bold mb-1"><?= $total_selesai ?></h3>
        <p class="text-green-100 font-medium">Selesai</p>
      </div>

      <!-- Ditolak -->
      <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-2xl shadow-2xl p-6 text-white transform hover:scale-105 transition-all">
        <div class="flex items-center justify-between mb-4">
          <div class="bg-white/20 p-3 rounded-xl backdrop-blur-sm">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
          </div>
        </div>
        <h3 class="text-3xl font-bold mb-1"><?= $total_ditolak ?></h3>
        <p class="text-red-100 font-medium">Ditolak</p>
      </div>

    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
      <a href="<?= base_url('petugas/pengaduan') ?>" class="bg-white/90 backdrop-blur-md rounded-2xl shadow-xl p-6 hover:shadow-2xl transform hover:scale-105 transition-all border border-white/30">
        <div class="flex items-center gap-4">
          <div class="bg-blue-100 p-4 rounded-xl">
            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
          </div>
          <div>
            <h3 class="text-xl font-bold text-gray-900 mb-1">Kelola Pengaduan</h3>
            <p class="text-gray-600">Lihat dan ubah status pengaduan</p>
          </div>
        </div>
      </a>

      <a href="<?= base_url('auth/logout') ?>" class="bg-white/90 backdrop-blur-md rounded-2xl shadow-xl p-6 hover:shadow-2xl transform hover:scale-105 transition-all border border-white/30">
        <div class="flex items-center gap-4">
          <div class="bg-red-100 p-4 rounded-xl">
            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
            </svg>
          </div>
          <div>
            <h3 class="text-xl font-bold text-gray-900 mb-1">Logout</h3>
            <p class="text-gray-600">Keluar dari sistem</p>
          </div>
        </div>
      </a>
    </div>

    <!-- Recent Complaints -->
    <div class="bg-white/90 backdrop-blur-md rounded-2xl shadow-2xl overflow-hidden border border-white/30">
      <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
        <h2 class="text-2xl font-bold text-white flex items-center gap-2">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
          Pengaduan Terbaru
        </h2>
      </div>
      
      <div class="overflow-x-auto">
        <table class="min-w-full">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-4 text-left font-bold text-sm uppercase tracking-wider text-gray-700">Nama Pengaduan</th>
              <th class="px-6 py-4 text-left font-bold text-sm uppercase tracking-wider text-gray-700">Pelapor</th>
              <th class="px-6 py-4 text-center font-bold text-sm uppercase tracking-wider text-gray-700">Lokasi</th>
              <th class="px-6 py-4 text-center font-bold text-sm uppercase tracking-wider text-gray-700">Tanggal</th>
              <th class="px-6 py-4 text-center font-bold text-sm uppercase tracking-wider text-gray-700">Status</th>
              <th class="px-6 py-4 text-center font-bold text-sm uppercase tracking-wider text-gray-700">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100">
            <?php if (!empty($pengaduan_terbaru)): ?>
              <?php foreach ($pengaduan_terbaru as $p): ?>
              <tr class="hover:bg-blue-50/50 transition-all">
                <td class="px-6 py-4 text-gray-700 font-medium"><?= esc($p['nama_pengaduan']) ?></td>
                <td class="px-6 py-4 text-gray-600"><?= esc($p['nama_pengguna'] ?? '-') ?></td>
                <td class="px-6 py-4 text-center text-gray-600"><?= esc($p['lokasi']) ?></td>
                <td class="px-6 py-4 text-center text-gray-600"><?= date('d/m/Y', strtotime($p['tgl_pengajuan'])) ?></td>
                <td class="px-6 py-4 text-center">
                  <?php 
                    $status = strtolower($p['status']);
                    $statusClasses = [
                      'diajukan'  => 'badge-status-diajukan',
                      'disetujui' => 'badge-status-disetujui',
                      'diproses'  => 'badge-status-diproses',
                      'selesai'   => 'badge-status-selesai',
                      'ditolak'   => 'badge-status-ditolak',
                    ];
                    $badgeClass = $statusClasses[$status] ?? 'badge-ui';
                  ?>
                  <span class="text-xs <?= $badgeClass ?>">
                    <?= esc(ucfirst($p['status'])) ?>
                  </span>
                </td>
                <td class="px-6 py-4 text-center">
                  <a href="<?= base_url('petugas/pengaduan/edit/'.$p['id_pengaduan']) ?>" class="btn-ui px-4 py-2 text-sm">
                    Ubah Status
                  </a>
                </td>
              </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                  <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                  </svg>
                  <p class="text-lg font-medium">Belum ada pengaduan</p>
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>

<script src="https://unpkg.com/lucide@latest"></script>
<script>
  lucide.createIcons();
</script>

<?= $this->endSection() ?>
