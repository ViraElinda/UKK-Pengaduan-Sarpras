<?= $this->extend('layout/admin') ?>

<?= $this->section('title') ?>
Temporary Items - Pending Approval
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="min-h-screen bg-ui-page py-8 px-4 sm:px-6 lg:px-8">
  <div class="max-w-7xl mx-auto">
    
    <!-- Header with Back Button -->
    <div class="flex items-center justify-between mb-6">
      <div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">
          🔔 Temporary Items - Pending Approval
        </h1>
        <p class="text-gray-600 font-medium">Kelola item yang menunggu persetujuan</p>
      </div>
      <a href="<?= base_url('admin/temporary_items/history') ?>" class="btn-ui px-5 py-3">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        Riwayat
      </a>
    </div>

    <!-- Success/Error Messages -->
    <?php if(session()->getFlashdata('success')): ?>
      <div class="bg-green-50 text-green-700 p-4 mb-6 rounded-xl shadow-lg flex items-center gap-3">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
        </svg>
        <p class="font-bold"><?= session()->getFlashdata('success') ?></p>
      </div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>
      <div class="bg-red-50 text-red-700 p-4 mb-6 rounded-xl shadow-lg flex items-center gap-3">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <p class="font-bold"><?= session()->getFlashdata('error') ?></p>
      </div>
    <?php endif; ?>

    <!-- Table Card -->
    <div class="bg-white/90 backdrop-blur-md rounded-2xl shadow-2xl overflow-hidden border border-white/30">
      <?php if(empty($temporaryItems)): ?>
        <!-- Empty State -->
        <div class="p-16 text-center">
          <div class="w-24 h-24 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
          </div>
          <h3 class="text-2xl font-bold text-gray-800 mb-2">Tidak Ada Item Pending</h3>
          <p class="text-gray-600">Semua temporary items sudah diproses</p>
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
                <th class="px-6 py-4 text-center font-bold text-sm uppercase tracking-wider">Aksi</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-indigo-100">
              <?php foreach($temporaryItems as $item): ?>
              <tr class="hover:bg-indigo-50/50 transition-all">
                <td class="px-6 py-4 text-gray-700 font-semibold"><?= esc($item['id_temporary']); ?></td>
                <td class="px-6 py-4 text-gray-700 font-medium"><?= esc($item['nama_barang_baru']); ?></td>
                <td class="px-6 py-4 text-gray-700 font-medium"><?= esc($item['lokasi_barang_baru']); ?></td>
                <td class="px-6 py-4 text-center">
                  <span class="px-4 py-2 bg-yellow-100 text-yellow-700 text-xs font-bold rounded-full shadow-md">
                    <?= esc($item['status']) ?>
                  </span>
                </td>
                <td class="px-6 py-4">
                  <div class="flex gap-2 justify-center">
                    <!-- Approve Button -->
              <button onclick="confirmApprove(<?= $item['id_temporary'] ?>, '<?= esc($item['nama_barang_baru'] ?? $item['nama_item'] ?? '', 'js') ?>')" 
                class="group bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg font-bold shadow-md hover:shadow-lg transition-all flex items-center gap-2">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                      </svg>
                      <span>Setujui</span>
                    </button>

                    <!-- Reject Button -->
              <button onclick="confirmReject(<?= $item['id_temporary'] ?>, '<?= esc($item['nama_barang_baru'] ?? $item['nama_item'] ?? '', 'js') ?>')" 
                class="group bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-lg font-bold shadow-md hover:shadow-lg transition-all flex items-center gap-2">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                      </svg>
                      <span>Tolak</span>
                    </button>
                  </div>
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

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/lucide@latest"></script>
<script>
  lucide.createIcons();

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

  function confirmApprove(id, namaItem) {
    Swal.fire({
      title: 'Setujui Item?',
      html: `Apakah Anda yakin ingin menyetujui item:<br><strong>${namaItem}</strong><br>untuk dipindahkan ke daftar items?`,
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#16a34a',
      cancelButtonColor: '#6b7280',
      confirmButtonText: 'Ya, Setujui!',
      cancelButtonText: 'Batal',
      reverseButtons: true
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = '<?= base_url('admin/temporary_items/approve/') ?>' + id;
      }
    });
  }

  function confirmReject(id, namaItem) {
    Swal.fire({
      title: 'Tolak Item?',
      html: `Apakah Anda yakin ingin menolak item:<br><strong>${namaItem}</strong>?`,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#ef4444',
      cancelButtonColor: '#6b7280',
      confirmButtonText: 'Ya, Tolak!',
      cancelButtonText: 'Batal',
      reverseButtons: true
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = '<?= base_url('admin/temporary_items/reject/') ?>' + id;
      }
    });
  }
</script>

<?= $this->endSection() ?>
