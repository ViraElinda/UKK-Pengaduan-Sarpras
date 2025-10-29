<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Manajemen User
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<link rel="stylesheet" href="<?= base_url('css/style.css'); ?>">

<div class="adminusers-container">
    <div class="adminusers-header">
        <a href="<?= base_url('dashboard/admin') ?>" class="adminusers-btn-back">← Kembali ke Dashboard</a>
        <h2 class="adminusers-title">Daftar User</h2>
        <a href="<?= base_url('admin/users/create'); ?>" class="adminusers-btn">Tambah User</a>
    </div>

    <table class="adminusers-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Nama</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($users as $u): ?>
            <tr>
                <td><?= esc($u['id_user']); ?></td>
                <td><?= esc($u['username']); ?></td>
                <td><?= esc($u['nama_pengguna']); ?></td>
                <td><?= esc($u['role']); ?></td>
                <td>
                    <a href="<?= base_url('admin/users/edit/'.$u['id_user']); ?>" class="adminusers-btn-edit">Edit</a>
                    <a href="<?= base_url('admin/users/delete/'.$u['id_user']); ?>" onclick="return confirm('Yakin hapus user ini?')" class="adminusers-btn-delete">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

   <script>
function showLoadingSuccessPopup(message = "Berhasil!") {
    const popup = document.createElement('div');
    popup.classList.add('popup-loading-success');
    popup.innerHTML = `
        <div class="loader"></div>
        <svg class="checkmark" viewBox="0 0 24 24">
            <polyline points="20 6 9 17 4 12"/>
        </svg>
        <span>${message}</span>
    `;
    document.body.appendChild(popup);

    // Ganti loader dengan centang setelah 1.5 detik
    setTimeout(() => {
        const loader = popup.querySelector('.loader');
        const check = popup.querySelector('.checkmark');
        loader.style.display = 'none';
        check.style.display = 'block';
    }, 1500);

    // Hapus popup setelah 3 detik
    setTimeout(() => {
        popup.remove();
    }, 3000);
}
</script>
<?= $this->endSection() ?>
