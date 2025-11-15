<?= $this->extend('layout/admin') ?>

<?= $this->section('title') ?>
Preview Laporan
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="min-h-screen bg-ui-page py-8 px-4 sm:px-6 lg:px-8">
  <div class="max-w-7xl mx-auto">

    <!-- Header & Actions -->
    <div class="flex items-center justify-between mb-6">
      <div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">
          🧾 Preview Laporan
        </h1>
        <p class="text-gray-600 font-medium">Periode: <span class="text-blue-600 font-bold"><?= esc($tgl_mulai) ?> → <?= esc($tgl_selesai) ?></span></p>
      </div>
      <div class="flex items-center gap-3">
        <?php
          $query = [];
          if (!empty($filterPetugas)) $query['petugas'] = $filterPetugas;
          if (!empty($filterLokasi)) $query['lokasi'] = $filterLokasi;
          if (!empty($filterStatus)) $query['status'] = $filterStatus;
          $queryString = http_build_query($query);
          $downloadUrl = base_url('admin/laporan/cetak/' . rawurlencode($tgl_mulai) . '/' . rawurlencode($tgl_selesai));
          if (!empty($queryString)) $downloadUrl .= '?' . $queryString;
        ?>
        <a href="<?= esc($downloadUrl) ?>" class="bg-red-600 hover:bg-red-700 text-white px-5 py-3 rounded-xl font-bold shadow-lg hover:shadow-xl transition-all flex items-center gap-2 animate-pulse">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
          </svg>
          Download PDF
        </a>
      </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white/90 backdrop-blur-md rounded-2xl shadow-2xl overflow-hidden border border-white/30">
      <div class="overflow-x-auto">
        <table class="min-w-full">
          <thead class="bg-blue-600 text-white">
            <tr>
              <th class="px-6 py-4 text-left font-bold text-sm uppercase tracking-wider">ID</th>
              <th class="px-6 py-4 text-left font-bold text-sm uppercase tracking-wider">Nama Pengaduan</th>
              <th class="px-6 py-4 text-center font-bold text-sm uppercase tracking-wider">Foto</th>
              <th class="px-6 py-4 text-left font-bold text-sm uppercase tracking-wider">Tgl Pengajuan</th>
              <th class="px-6 py-4 text-center font-bold text-sm uppercase tracking-wider">Status</th>
              <th class="px-6 py-4 text-left font-bold text-sm uppercase tracking-wider">ID User</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100">
            <?php foreach ($laporan as $row): ?>
            <tr class="hover:bg-blue-50/50 transition-all">
              <td class="px-6 py-4 text-gray-700 font-semibold"><?= esc($row['id_pengaduan']); ?></td>
              <td class="px-6 py-4 text-gray-700 font-medium"><?= esc($row['nama_pengaduan']); ?></td>
              <td class="px-6 py-4 text-center">
                <?php if(!empty($row['foto'])): ?>
                  <?php $fotoFile = 'foto_pengaduan/' . $row['foto']; $fotoUrl = base_url('uploads/' . rawurlencode($fotoFile)); ?>
                  <img src="<?= esc($fotoUrl) ?>" alt="Foto" class="w-12 h-12 object-cover rounded-lg shadow-md mx-auto">
                <?php else: ?>
                  <span class="text-gray-400 italic text-sm">-</span>
                <?php endif; ?>
              </td>
              <td class="px-6 py-4 text-gray-600"><?= esc($row['tgl_pengajuan']); ?></td>
              <td class="px-6 py-4 text-center">
                <?php 
                  $status = strtolower($row['status']);
                  $statusClasses = [
                    'diajukan'  => 'badge-status-diajukan',
                    'diproses'  => 'badge-status-diproses',
                    'selesai'   => 'badge-status-selesai',
                    'disetujui' => 'badge-status-selesai',
                    'ditolak'   => 'badge-status-ditolak',
                  ];
                  $badgeClass = $statusClasses[$status] ?? 'badge-ui';
                ?>
                <span class="text-xs <?= $badgeClass ?>">
                  <?= esc(ucfirst($row['status'])) ?>
                </span>
              </td>
              <td class="px-6 py-4 text-gray-600"><?= esc($row['id_user']); ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>
<?= $this->endSection() ?>
