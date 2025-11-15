<?= $this->extend('layout/admin') ?>

<?= $this->section('title') ?>
Manajemen Sarpras
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="min-h-screen bg-ui-page py-8 px-4 sm:px-6 lg:px-8">
  <div class="max-w-7xl mx-auto">
    
    <!-- Header -->
    <div class="mb-6">
      <h1 class="text-3xl font-bold text-gray-900 mb-2">
        📦 Manajemen Sarpras
      </h1>
      <p class="text-gray-600 font-medium">Kelola data sarana & prasarana</p>
    </div>

    <!-- Action Button -->
    <div class="mb-6 flex justify-end">
      <a href="<?= base_url('admin/items/create'); ?>" class="btn-ui px-6 py-3">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
        </svg>
        Tambah Item
      </a>
    </div>

    <!-- Success Message -->
    <?php if(session()->getFlashdata('success')): ?>
      <div class="bg-green-50 text-green-700 p-4 mb-6 rounded-xl shadow-lg flex items-center gap-3">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
        </svg>
        <p class="font-bold"><?= session()->getFlashdata('success') ?></p>
      </div>
    <?php endif; ?>

    <!-- Table Card -->
    <div class="bg-white/90 backdrop-blur-md rounded-2xl shadow-2xl overflow-hidden border border-white/30">
      <div class="overflow-x-auto">
        <table class="min-w-full">
          <thead class="bg-ui-header text-white">
            <tr>
              <th class="px-6 py-4 text-center font-bold text-sm uppercase tracking-wider">ID</th>
              <th class="px-6 py-4 text-left font-bold text-sm uppercase tracking-wider">Nama Item</th>
              <th class="px-6 py-4 text-left font-bold text-sm uppercase tracking-wider">Tersedia di Lokasi</th>
              <th class="px-6 py-4 text-left font-bold text-sm uppercase tracking-wider">Deskripsi</th>
              <th class="px-6 py-4 text-center font-bold text-sm uppercase tracking-wider">Foto</th>
              <th class="px-6 py-4 text-center font-bold text-sm uppercase tracking-wider">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100">
            <?php if(empty($items)): ?>
            <tr>
              <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                <div class="flex flex-col items-center gap-3">
                  <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                  </svg>
                  <p class="font-semibold text-lg">Belum ada item sarpras</p>
                  <p class="text-sm">Klik tombol "Tambah Item" untuk menambahkan</p>
                </div>
              </td>
            </tr>
            <?php else: ?>
              <?php foreach($items as $item): ?>
              <tr class="hover:bg-blue-50/50 transition-all">
                <td class="px-6 py-4 text-center text-gray-700 font-semibold"><?= $item['id_item']; ?></td>
                <td class="px-6 py-4 text-gray-700 font-medium"><?= esc($item['nama_item']); ?></td>
                <td class="px-6 py-4">
                  <?php if(!empty($item['lokasi_list'])): ?>
                    <div class="flex flex-wrap gap-1">
                      <?php 
                      $lokasi_array = explode(', ', $item['lokasi_list']);
                      foreach($lokasi_array as $lok): 
                      ?>
                        <span class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-semibold bg-blue-100 text-blue-700">
                          📍 <?= esc($lok); ?>
                        </span>
                      <?php endforeach; ?>
                    </div>
                  <?php else: ?>
                    <span class="text-gray-400 italic text-sm">Tidak ada lokasi</span>
                  <?php endif; ?>
                </td>
                <td class="px-6 py-4 text-gray-600 text-sm"><?= esc(substr($item['deskripsi'], 0, 80)) . (strlen($item['deskripsi']) > 80 ? '...' : ''); ?></td>
                <td class="px-6 py-4 text-center">
                  <?php if ($item['foto']): ?>
                    <img src="<?= base_url('uploads/foto_items/' . $item['foto']); ?>" alt="<?= esc($item['nama_item']); ?>" class="w-16 h-16 object-cover rounded-xl shadow-lg mx-auto hover:scale-110 transition-transform cursor-pointer">
                  <?php else: ?>
                    <div class="w-16 h-16 bg-gray-200 rounded-xl flex items-center justify-center mx-auto">
                      <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                      </svg>
                    </div>
                  <?php endif; ?>
                </td>
                <td class="px-6 py-4">
                  <div class="flex gap-2 justify-center">
                    <a href="<?= base_url('admin/items/edit/'.$item['id_item']); ?>" class="btn-ui px-4 py-2 text-sm">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                      </svg>
                      Edit
                    </a>
                    <button onclick="confirmDelete(<?= $item['id_item'] ?>, '<?= esc($item['nama_item']) ?>')" class="btn-danger-ui px-4 py-2 text-sm">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                      </svg>
                      Hapus
                    </button>
                  </div>
                </td>
              </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
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

  function confirmDelete(id, namaItem) {
    Swal.fire({
      title: 'Hapus Item?',
      html: `Apakah Anda yakin ingin menghapus item:<br><strong>${namaItem}</strong>?<br><small class="text-red-600">Data akan dihapus permanen!</small>`,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#ef4444',
      cancelButtonColor: '#6b7280',
      confirmButtonText: 'Ya, Hapus!',
      cancelButtonText: 'Batal',
      reverseButtons: true
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = '<?= base_url('admin/items/delete/') ?>' + id;
      }
    });
  }
</script>

<?= $this->endSection() ?>
