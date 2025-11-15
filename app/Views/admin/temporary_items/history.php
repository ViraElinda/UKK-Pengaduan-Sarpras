<?= $this->extend('layout/admin') ?>

<?= $this->section('title') ?>
Riwayat Temporary Items
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="min-h-screen bg-ui-page py-8 px-4 sm:px-6 lg:px-8">
  <div class="max-w-7xl mx-auto">
    
    <!-- Header with Back Button -->
    <div class="flex items-center justify-between mb-6">
      <div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">
          📜 Riwayat Temporary Items
        </h1>
        <p class="text-gray-600 font-medium">Daftar item yang sudah disetujui atau ditolak</p>
      </div>
      <a href="<?= base_url('admin/temporary_items') ?>" class="btn-ui px-6 py-3">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        Lihat Pending
      </a>
    </div>

    <!-- Table Card -->
    <div class="bg-white/90 backdrop-blur-md rounded-2xl shadow-2xl overflow-hidden border border-white/30">
      <?php if(empty($temporaryItems)): ?>
        <!-- Empty State -->
        <div class="p-16 text-center">
          <div class="w-24 h-24 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
          </div>
          <h3 class="text-2xl font-bold text-gray-800 mb-2">Tidak Ada Riwayat</h3>
          <p class="text-gray-600">Belum ada item yang diproses</p>
        </div>
      <?php else: ?>
        <div class="overflow-x-auto">
          <table class="min-w-full">
            <thead class="bg-ui-header text-white">
              <tr>
                <th class="px-6 py-4 text-left font-bold text-sm uppercase tracking-wider">ID</th>
                <th class="px-6 py-4 text-left font-bold text-sm uppercase tracking-wider">Nama Barang</th>
                <th class="px-6 py-4 text-left font-bold text-sm uppercase tracking-wider">Lokasi</th>
                <th class="px-6 py-4 text-center font-bold text-sm uppercase tracking-wider">Status</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-indigo-100">
              <?php foreach($temporaryItems as $item): ?>
              <tr class="hover:bg-indigo-50/50 transition-all">
                <td class="px-6 py-4 text-gray-700 font-semibold"><?= esc($item['id_temporary']); ?></td>
                <td class="px-6 py-4 text-gray-700 font-medium"><?= esc($item['nama_barang_baru']); ?></td>
                <td class="px-6 py-4 text-gray-700 font-medium"><?= esc($item['lokasi_barang_baru']); ?></td>
                <td class="px-6 py-4 text-center">
                  <?php 
                    $status = strtolower($item['status']);
                    $badgeClass = $status === 'approved' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700';
                    $text = $status === 'approved' ? 'Disetujui' : 'Ditolak';
                  ?>
                  <span class="px-4 py-2 text-xs font-bold rounded-full shadow-md <?= $badgeClass ?>">
                    <?= $text ?>
                  </span>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>

  </div>
</div>

<script src="https://unpkg.com/lucide@latest"></script>
<script>
  lucide.createIcons();
</script>

<?= $this->endSection() ?>
