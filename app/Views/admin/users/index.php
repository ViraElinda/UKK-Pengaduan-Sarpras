<?= $this->extend('layout/admin') ?>

<?= $this->section('title') ?>
Manajemen User
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="min-h-screen bg-ui-page py-8 px-4 sm:px-6 lg:px-8">
  <div class="max-w-7xl mx-auto">
    
    <!-- Header -->
    <div class="mb-6">
      <h1 class="text-3xl font-bold text-gray-900 mb-2">
        👥 Manajemen User
      </h1>
      <p class="text-gray-600 font-medium">Kelola data pengguna sistem</p>
    </div>

    <!-- Action Button -->
    <div class="mb-6 flex justify-end">
      <a href="<?= base_url('admin/users/create'); ?>" class="btn-ui px-6 py-3">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
        </svg>
        Tambah User
      </a>
    </div>

    <!-- Table Card -->
    <div class="bg-white/90 backdrop-blur-md rounded-2xl shadow-2xl overflow-hidden border border-white/30">
      <div class="overflow-x-auto">
        <table class="min-w-full">
          <thead class="bg-ui-header text-white">
            <tr>
              <th class="px-6 py-4 text-left font-bold text-sm uppercase tracking-wider">ID</th>
              <th class="px-6 py-4 text-left font-bold text-sm uppercase tracking-wider">Username</th>
              <th class="px-6 py-4 text-left font-bold text-sm uppercase tracking-wider">Nama</th>
              <th class="px-6 py-4 text-left font-bold text-sm uppercase tracking-wider">Role</th>
              <th class="px-6 py-4 text-center font-bold text-sm uppercase tracking-wider">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-indigo-100">
            <?php foreach($users as $u): ?>
            <tr class="hover:bg-indigo-50/50 transition-all">
              <td class="px-6 py-4 text-gray-700 font-semibold"><?= esc($u['id_user']); ?></td>
              <td class="px-6 py-4 text-gray-700 font-medium"><?= esc($u['username']); ?></td>
              <td class="px-6 py-4 text-gray-700 font-medium"><?= esc($u['nama_pengguna']); ?></td>
              <td class="px-6 py-4">
                <span class="px-4 py-2 rounded-full text-xs font-bold shadow-md
                  <?= strtolower($u['role']) == 'admin' ? 'bg-red-100 text-red-700 font-bold' : '' ?>
                  <?= strtolower($u['role']) == 'user' ? 'bg-blue-100 text-blue-700 font-bold' : '' ?>
                "><?= esc($u['role']) ?></span>
              </td>
              <td class="px-6 py-4">
                <div class="flex gap-2 justify-center">
                  <a href="<?= base_url('admin/users/edit/'.$u['id_user']); ?>" class="btn-ui px-4 py-2">Edit</a>
                  <button onclick="confirmDelete(<?= $u['id_user'] ?>, '<?= esc($u['username']) ?>')" class="btn-danger-ui px-4 py-2">Hapus</button>
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

  function confirmDelete(id, username) {
    Swal.fire({
      title: 'Hapus User?',
      html: `Apakah Anda yakin ingin menghapus user:<br><strong>${username}</strong>?`,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#ef4444',
      cancelButtonColor: '#6b7280',
      confirmButtonText: 'Ya, Hapus!',
      cancelButtonText: 'Batal',
      reverseButtons: true
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = '<?= base_url('admin/users/delete/') ?>' + id;
      }
    });
  }
</script>
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
