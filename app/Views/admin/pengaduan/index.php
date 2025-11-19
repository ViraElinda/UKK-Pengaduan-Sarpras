<?= $this->extend('layout/admin') ?>

<?= $this->section('title') ?>
Manajemen Aduan
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="min-h-screen bg-ui-page py-8 px-4 sm:px-6 lg:px-8">
  <div class="max-w-7xl mx-auto">
    
    <!-- Header -->
    <div class="mb-6">
      <h1 class="text-3xl font-bold text-gray-900 mb-2">
        📋 Manajemen Aduan
      </h1>
      <p class="text-gray-600 font-medium">Kelola data pengaduan sarana & prasarana</p>
    </div>

    <!-- Action Button -->
    <div class="mb-6 flex justify-end">
      <a href="<?= base_url('admin/pengaduan/create') ?>" class="btn-ui px-6 py-3">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
        </svg>
        Tambah Pengaduan
      </a>
    </div>

    <!-- Table Card -->
    <div class="bg-white/90 backdrop-blur-md rounded-2xl shadow-2xl overflow-hidden border border-white/30">
      <div class="overflow-x-auto">
        <table class="min-w-full">
          <thead class="bg-ui-header text-white">
            <tr>
              <th class="px-6 py-4 text-center font-bold text-sm uppercase tracking-wider">No</th>
              <th class="px-6 py-4 text-left font-bold text-sm uppercase tracking-wider">Nama</th>
              <th class="px-6 py-4 text-left font-bold text-sm uppercase tracking-wider">Nama User</th>
              <th class="px-6 py-4 text-left font-bold text-sm uppercase tracking-wider">Lokasi</th>
              <th class="px-6 py-4 text-center font-bold text-sm uppercase tracking-wider">Tgl</th>
              <th class="px-6 py-4 text-center font-bold text-sm uppercase tracking-wider">Status</th>
              <th class="px-6 py-4 text-center font-bold text-sm uppercase tracking-wider">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100">
            <?php $no = 1; foreach ($pengaduan as $p) : ?>
            <tr class="hover:bg-blue-50/50 transition-all">
              <td data-label="No" class="px-6 py-4 text-center text-gray-700 font-semibold"><?= $no++ ?></td>
              <td data-label="Nama" class="px-6 py-4 text-gray-700 font-medium"><?= esc($p['nama_pengaduan']) ?></td>
              <td data-label="Nama User" class="px-6 py-4 text-gray-700 font-medium"><?= esc($p['nama_user'] ?? '-') ?></td>
              <td data-label="Lokasi" class="px-6 py-4 text-gray-700 font-medium"><?= esc($p['lokasi']) ?></td>
              <td data-label="Tanggal" class="px-6 py-4 text-center text-gray-600"><?= !empty($p['tgl_pengajuan']) ? date('d/m/Y', strtotime($p['tgl_pengajuan'])) : '-' ?></td>
              <td data-label="Status" class="px-6 py-4 text-center">
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
              
              <td data-label="Aksi" class="px-6 py-4 align-middle">
                <div class="flex gap-2 justify-center items-center whitespace-nowrap">
                  <?php 
                    $statusLower = strtolower($p['status']);
                    // Admin tidak bisa edit jika petugas sudah memproses (Diproses, Disetujui, Ditolak, Selesai)
                    $isLocked = in_array($statusLower, ['diproses', 'disetujui', 'ditolak', 'selesai']);
                  ?>
                  <?php if ($isLocked): ?>
                    <a href="<?= base_url('admin/pengaduan/detail/'.$p['id_pengaduan']) ?>" class="inline-flex items-center justify-center w-9 h-9 bg-white border border-gray-200 text-gray-700 rounded-xl font-semibold text-sm" title="Lihat" aria-label="Lihat pengaduan">
                      <i data-lucide="eye" class="w-4 h-4"></i>
                    </a>
                  <?php else: ?>
                    <a href="<?= base_url('admin/pengaduan/edit/'.$p['id_pengaduan']) ?>" class="btn-ui inline-flex items-center justify-center w-9 h-9" title="Edit" aria-label="Edit pengaduan">
                      <i data-lucide="edit-2" class="w-4 h-4"></i>
                    </a>
                    <a href="<?= base_url('admin/pengaduan/detail/'.$p['id_pengaduan']) ?>" class="inline-flex items-center justify-center w-9 h-9 bg-white border border-gray-200 text-gray-700 rounded-xl font-semibold text-sm" title="Lihat" aria-label="Lihat pengaduan">
                      <i data-lucide="eye" class="w-4 h-4"></i>
                    </a>
                  <?php endif; ?>
                  <button onclick="confirmDelete(<?= $p['id_pengaduan'] ?>, '<?= esc($p['nama_pengaduan']) ?>')" class="inline-flex items-center justify-center w-9 h-9 btn-danger-ui" title="Hapus" aria-label="Hapus pengaduan">
                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                  </button>
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

  <?php if(session()->getFlashdata('error')): ?>
    Swal.fire({
      icon: 'error',
      title: 'Gagal!',
      text: "<?= session()->getFlashdata('error'); ?>",
      timer: 3000,
      showConfirmButton: false,
      toast: true,
      position: 'top-end'
    });
  <?php endif; ?>

  function confirmDelete(id, nama) {
    Swal.fire({
      title: 'Hapus Pengaduan?',
      html: `Apakah Anda yakin ingin menghapus pengaduan:<br><strong>${nama}</strong>?`,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#ef4444',
      cancelButtonColor: '#6b7280',
      confirmButtonText: 'Ya, Hapus!',
      cancelButtonText: 'Batal',
      reverseButtons: true
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = '<?= base_url('admin/pengaduan/delete/') ?>' + id;
      }
    });
  }
</script>

<?= $this->endSection() ?>
