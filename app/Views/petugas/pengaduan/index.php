<?= $this->extend('layout/petugas') ?>

<?= $this->section('title') ?>
Manajemen Pengaduan - Petugas
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="min-h-screen bg-ui-page py-8 px-4 sm:px-6 lg:px-8">
  <div class="max-w-7xl mx-auto">
    
    <!-- Header -->
    <div class="mb-6">
      <h1 class="text-3xl font-bold text-gray-900 mb-2">
        📋 Kelola Semua Pengaduan
      </h1>
      <p class="text-gray-600 font-medium">Petugas dapat mengelola dan mengubah status semua pengaduan sarana prasarana</p>
    </div>

    <!-- Table Card -->
    <div class="bg-white/90 backdrop-blur-md rounded-2xl shadow-2xl overflow-hidden border border-white/30">
      <div class="overflow-x-auto">
        <table class="min-w-full">
          <thead class="bg-ui-header text-white">
            <tr>
              <th class="px-6 py-4 text-center font-bold text-sm uppercase tracking-wider">No</th>
              <th class="px-6 py-4 text-left font-bold text-sm uppercase tracking-wider">Nama Aduan</th>
              <th class="px-6 py-4 text-left font-bold text-sm uppercase tracking-wider">Pelapor</th>
              <th class="px-6 py-4 text-left font-bold text-sm uppercase tracking-wider">Lokasi</th>
              <th class="px-6 py-4 text-center font-bold text-sm uppercase tracking-wider">Tanggal</th>
              <th class="px-6 py-4 text-center font-bold text-sm uppercase tracking-wider">Status</th>
              <th class="px-6 py-4 text-center font-bold text-sm uppercase tracking-wider">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100">
            <?php if (!empty($pengaduan)): ?>
              <?php $no = 1; foreach ($pengaduan as $p) : ?>
              <tr class="hover:bg-blue-50/50 transition-all">
                <td class="px-6 py-4 text-center text-gray-700 font-semibold" data-label="No"><?= $no++ ?></td>
                <td class="px-6 py-4 text-gray-700 font-medium" data-label="Nama Aduan"><?= esc($p['nama_pengaduan']) ?></td>
                <td class="px-6 py-4 text-gray-700 font-medium" data-label="Pelapor"><?= esc($p['nama_pengguna'] ?? '-') ?></td>
                <td class="px-6 py-4 text-gray-700 font-medium" data-label="Lokasi"><?= esc($p['nama_lokasi'] ?? '-') ?></td>
                <td class="px-6 py-4 text-center text-gray-600" data-label="Tanggal"><?= !empty($p['tgl_pengajuan']) ? date('d/m/Y', strtotime($p['tgl_pengajuan'])) : '-' ?></td>
                <td class="px-6 py-4 text-center" data-label="Status">
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
                <td class="px-6 py-4 align-middle">
                  <div class="flex gap-2 justify-center items-center whitespace-nowrap">
                    <?php 
                      $statusLower = strtolower($p['status']);
                      $isSelesai = ($statusLower === 'selesai');
                    ?>
                    <?php if ($isSelesai): ?>
                      <a href="<?= base_url('petugas/pengaduan/detail/'.$p['id_pengaduan']) ?>" class="inline-flex items-center justify-center w-9 h-9 bg-white border border-gray-200 text-gray-700 rounded-xl font-semibold text-sm" title="Lihat" aria-label="Lihat pengaduan">
                        <i data-lucide="eye" class="w-4 h-4"></i>
                      </a>
                    <?php else: ?>
                      <a href="<?= base_url('petugas/pengaduan/edit/'.$p['id_pengaduan']) ?>" class="btn-ui inline-flex items-center justify-center w-9 h-9 text-sm" title="Kelola" aria-label="Kelola pengaduan">
                        <i data-lucide="edit-2" class="w-4 h-4"></i>
                      </a>
                      <a href="<?= base_url('petugas/pengaduan/detail/'.$p['id_pengaduan']) ?>" class="inline-flex items-center justify-center w-9 h-9 bg-white border border-gray-200 text-gray-700 rounded-xl font-semibold text-sm" title="Lihat" aria-label="Lihat pengaduan">
                        <i data-lucide="eye" class="w-4 h-4"></i>
                      </a>
                    <?php endif; ?>
                  </div>
                </td>
              </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="7" class="px-6 py-12 text-center">
                  <div class="flex flex-col items-center justify-center">
                    <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-gray-500 text-lg font-medium">Belum ada pengaduan</p>
                  </div>
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
  
  <?php if(session()->getFlashdata('success')): ?>
    showSuccessPopup("<?= session()->getFlashdata('success'); ?>");
  <?php endif; ?>

  function showSuccessPopup(message) {
    const popup = document.createElement('div');
    popup.className = 'fixed top-4 right-4 bg-white rounded-xl shadow-2xl p-4 z-50 flex items-center gap-3 animate-bounce';
    popup.innerHTML = `
      <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
      </svg>
      <span class="text-gray-800 font-bold">${message}</span>
    `;
    document.body.appendChild(popup);
    setTimeout(() => popup.remove(), 3000);
  }
</script>

<?= $this->endSection() ?>
