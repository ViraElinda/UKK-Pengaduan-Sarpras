<?= $this->extend('layout/admin') ?>

<?= $this->section('title') ?>
Generate Laporan
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="min-h-screen bg-blue-600 py-8 px-4 sm:px-6 lg:px-8">
  <div class="max-w-7xl mx-auto">
    
    <!-- Header -->
    <div class="mb-6">
      <h1 class="text-3xl font-bold text-gray-900 mb-2">
        📊 Laporan Pengaduan
      </h1>
      <p class="text-gray-600 font-medium">Generate laporan berdasarkan periode</p>
    </div>

    <!-- Error Message -->
    <?php if(session()->getFlashdata('error')): ?>
      <div class="bg-red-50 text-red-700 p-4 mb-6 rounded-xl shadow flex items-center gap-3 border border-red-200">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <p class="font-bold"><?= session()->getFlashdata('error') ?></p>
      </div>
    <?php endif; ?>

    <!-- Form Card -->
    <div class="bg-white/90 backdrop-blur-md rounded-2xl shadow-2xl p-8 mb-6 border border-white/30">
      <form action="<?= base_url('admin/laporan/preview') ?>" method="post" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label for="tgl_mulai" class="block text-blue-600 font-bold mb-2 text-sm">Tanggal Mulai</label>
            <input type="date" id="tgl_mulai" name="tgl_mulai" required 
              class="w-full px-4 py-3 rounded-xl border-2 border-blue-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all font-medium">
          </div>
          <div>
            <label for="tgl_selesai" class="block text-blue-600 font-bold mb-2 text-sm">Tanggal Selesai</label>
            <input type="date" id="tgl_selesai" name="tgl_selesai" required 
              class="w-full px-4 py-3 rounded-xl border-2 border-blue-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all font-medium">
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div>
            <label for="petugas" class="block text-blue-600 font-bold mb-2 text-sm">Filter Petugas</label>
            <select id="petugas" name="petugas" class="w-full px-4 py-3 rounded-xl border-2 border-blue-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all font-medium">
              <option value="">Semua Petugas</option>
              <?php if (!empty($petugasList)): foreach ($petugasList as $pt): ?>
                <?php $label = esc($pt['nama_petugas'] ?? ($pt['nama'] ?? '')); ?>
                <?php if (!empty($pt['username'])) $label .= ' (' . esc($pt['username']) . ')'; ?>
                <option value="<?= esc($pt['id_petugas']) ?>"><?= $label ?></option>
              <?php endforeach; endif; ?>
            </select>
          </div>
          <div>
            <label for="lokasi" class="block text-blue-600 font-bold mb-2 text-sm">Filter Lokasi</label>
            <select id="lokasi" name="lokasi" class="w-full px-4 py-3 rounded-xl border-2 border-blue-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all font-medium">
              <option value="">Semua Lokasi</option>
              <?php if (!empty($lokasiList)): foreach ($lokasiList as $lk): ?>
                <option value="<?= esc($lk['id_lokasi']) ?>"><?= esc($lk['nama_lokasi']) ?></option>
              <?php endforeach; endif; ?>
            </select>
          </div>
          <div>
            <label for="status" class="block text-blue-600 font-bold mb-2 text-sm">Filter Status</label>
            <select id="status" name="status" class="w-full px-4 py-3 rounded-xl border-2 border-blue-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all font-medium">
              <option value="">Semua Status</option>
              <?php if (!empty($statusList)): foreach ($statusList as $k => $lbl): if ($k === '') continue; ?>
                <option value="<?= esc($k) ?>" <?= (isset($filterStatus) && $filterStatus === $k) ? 'selected' : '' ?>><?= esc($lbl) ?></option>
              <?php endforeach; endif; ?>
            </select>
          </div>
        </div>
        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-4 rounded-xl shadow-lg hover:shadow-xl transition-all flex items-center justify-center gap-2">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
          </svg>
          Tampilkan Laporan
        </button>
      </form>
    </div>

    <!-- Info & Table -->
    <?php $count = isset($pengaduan) ? count($pengaduan) : 0; ?>
    <div class="bg-white/90 backdrop-blur-md rounded-2xl shadow-2xl overflow-hidden border border-white/30">
      <div class="bg-blue-600 text-white px-6 py-4">
        <h3 class="font-bold text-lg">Data Pengaduan: <span class="text-yellow-300"><?= $count ?></span> pengaduan ditemukan</h3>
      </div>
      <div class="overflow-x-auto">
        <table class="min-w-full">
          <thead class="bg-blue-600 text-white">
            <tr>
              <th class="px-4 py-3 text-left font-bold text-xs uppercase">ID</th>
              <th class="px-4 py-3 text-left font-bold text-xs uppercase">Nama Pengaduan</th>
              <th class="px-4 py-3 text-left font-bold text-xs uppercase">Deskripsi</th>
              <th class="px-4 py-3 text-left font-bold text-xs uppercase">Lokasi</th>
              <th class="px-4 py-3 text-center font-bold text-xs uppercase">Foto</th>
              <th class="px-4 py-3 text-center font-bold text-xs uppercase">Status</th>
              <th class="px-4 py-3 text-left font-bold text-xs uppercase">Petugas</th>
              <th class="px-4 py-3 text-left font-bold text-xs uppercase">Item</th>
              <th class="px-4 py-3 text-left font-bold text-xs uppercase">Tgl Pengajuan</th>
              <th class="px-4 py-3 text-left font-bold text-xs uppercase">Tgl Selesai</th>
              <th class="px-4 py-3 text-left font-bold text-xs uppercase">Saran Petugas</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100">
            <?php if(!empty($pengaduan)): ?>
              <?php foreach($pengaduan as $p): ?>
              <tr class="hover:bg-blue-50/50 transition-all">
                <td class="px-4 py-3 text-gray-700 font-semibold text-sm"><?= $p['id_pengaduan']; ?></td>
                <td class="px-4 py-3 text-gray-700 font-medium text-sm"><?= esc($p['nama_pengaduan']); ?></td>
                <td class="px-4 py-3 text-gray-600 text-sm"><?= esc($p['deskripsi']); ?></td>
                <td class="px-4 py-3 text-gray-600 text-sm"><?= esc($p['lokasi']); ?></td>
                <td class="px-4 py-3 text-center">
                  <?php if(!empty($p['foto'])): ?>
                    <?php
                      // Prefer storing photos under uploads/foto_pengaduan/<filename>
                      $fotoFile = 'foto_pengaduan/' . $p['foto'];
                      $fotoUrl = base_url('uploads/' . rawurlencode($fotoFile));
                    ?>
                    <img src="<?= esc($fotoUrl) ?>" alt="Foto" class="w-12 h-12 object-cover rounded-lg shadow-md mx-auto">
                  <?php else: ?>
                    <span class="text-gray-400 italic text-sm">-</span>
                  <?php endif; ?>
                </td>
                <td class="px-4 py-3 text-center">
                  <?php 
                    $status = strtolower($p['status']);
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
                    <?= esc(ucfirst($p['status'])) ?>
                  </span>
                </td>
                <td class="px-4 py-3 text-gray-600 text-sm"><?= esc($p['id_petugas'] ?? '-'); ?></td>
                <td class="px-4 py-3 text-gray-600 text-sm"><?= esc($p['id_item'] ?? '-'); ?></td>
                <td class="px-4 py-3 text-gray-600 text-sm"><?= esc($p['tgl_pengajuan']); ?></td>
                <td class="px-4 py-3 text-gray-600 text-sm"><?= esc($p['tgl_selesai'] ?? '-'); ?></td>
                <td class="px-4 py-3 text-gray-600 text-sm"><?= !empty($p['saran_petugas']) ? esc($p['saran_petugas']) : '<em class="text-gray-400">-</em>'; ?></td>
              </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="11" class="px-4 py-8 text-center text-gray-400 italic">Tidak ada pengaduan ditemukan.</td>
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
