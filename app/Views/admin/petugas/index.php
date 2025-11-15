<?= $this->extend('layout/admin') ?>

<?= $this->section('title') ?>
Manajemen Petugas
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="min-h-screen bg-ui-page py-8 px-4 sm:px-6 lg:px-8">
  <div class="max-w-7xl mx-auto">
    <div class="mb-6">
      <h1 class="text-3xl font-bold text-gray-900 mb-2">👷 Manajemen Petugas</h1>
      <p class="text-gray-600 font-medium">Kelola data petugas yang menangani pengaduan</p>
    </div>

    <div class="mb-6 flex justify-end">
      <a href="<?= base_url('admin/petugas/create'); ?>" class="btn-ui px-6 py-3">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
        </svg>
        Tambah Petugas
      </a>
    </div>

    <div class="bg-white/90 backdrop-blur-md rounded-2xl shadow-2xl overflow-hidden border border-white/30">
      <div class="overflow-x-auto">
        <table class="min-w-full">
          <thead class="bg-ui-header text-white">
            <tr>
              <th class="px-6 py-4 text-left font-bold text-sm uppercase tracking-wider">ID</th>
              <th class="px-6 py-4 text-left font-bold text-sm uppercase tracking-wider">Username</th>
              <th class="px-6 py-4 text-left font-bold text-sm uppercase tracking-wider">Nama Petugas</th>
              <th class="px-6 py-4 text-center font-bold text-sm uppercase tracking-wider">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-indigo-100">
            <?php foreach($petugas as $p): ?>
            <tr class="hover:bg-indigo-50/50 transition-all">
              <td class="px-6 py-4 text-gray-700 font-semibold"><?= esc($p['id_petugas']) ?></td>
              <td class="px-6 py-4 text-gray-700 font-medium"><?= esc($p['username'] ?? '-') ?></td>
              <td class="px-6 py-4 text-gray-700 font-medium"><?= esc($p['nama']) ?></td>
              <td class="px-6 py-4">
                <div class="flex gap-2 justify-center">
                  <a href="<?= base_url('admin/petugas/edit/'.$p['id_petugas']); ?>" class="btn-ui px-4 py-2">Edit</a>
                  <button onclick="confirmDelete(<?= $p['id_petugas'] ?>, '<?= esc($p['nama']) ?>')" class="btn-danger-ui px-4 py-2">Hapus</button>
                </div>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  <?php if(session()->getFlashdata('success')): ?>
    Swal.fire({ icon: 'success', title: 'Berhasil', text: "<?= session()->getFlashdata('success'); ?>", timer: 2500, toast: true, position: 'top-end', showConfirmButton: false });
  <?php endif; ?>

  function confirmDelete(id, name) {
    Swal.fire({
      title: 'Hapus Petugas?',
      html: `Apakah Anda yakin ingin menghapus petugas:<br><strong>${name}</strong>?`,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#ef4444',
      cancelButtonColor: '#6b7280',
      confirmButtonText: 'Ya, Hapus!',
      cancelButtonText: 'Batal',
      reverseButtons: true
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = '<?= base_url('admin/petugas/delete/') ?>' + id;
      }
    });
  }
</script>

<?= $this->endSection() ?>
