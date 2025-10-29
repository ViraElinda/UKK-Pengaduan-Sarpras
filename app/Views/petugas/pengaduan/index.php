<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Pengaduan (Petugas)</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css'); ?>">
</head>
<body class="user-admin-body">

<div class="user-admin-container">
    <h2 class="user-admin-title">Daftar Pengaduan</h2>
    <a href="<?= base_url('petugas/pengaduan/create'); ?>" class="user-admin-btn">Tambah Pengaduan</a>

    <?php if(session()->getFlashdata('success')): ?>
        <p class="user-admin-success"><?= session()->getFlashdata('success') ?></p>
    <?php endif; ?>

    <table class="user-admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Pengaduan</th>
                <th>Deskripsi</th>
                <th>Lokasi</th>
                <th>Foto</th>
                <th>Status</th>
                <th>User Pelapor</th>
                <th>ID Item</th>
                <th>Tgl Pengajuan</th>
                <th>Tgl Selesai</th>
                <th>Saran Petugas</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($pengaduan as $p): ?>
            <tr>
                <td><?= $p['id_pengaduan']; ?></td>
                <td><?= esc($p['nama_pengaduan']); ?></td>
                <td><?= esc($p['deskripsi']); ?></td>
                <td><?= esc($p['lokasi']); ?></td>
                <td>
                    <?php if(!empty($p['foto'])): ?>
                        <img src="<?= base_url('uploads/foto_pengaduan/'.$p['foto']); ?>" width="80">
                    <?php else: ?>
                        <em>-</em>
                    <?php endif; ?>
                </td>
                <td><?= esc($p['status']); ?></td>
                <td><?= esc($p['nama_pengguna'] ?? '-'); ?></td>
                <td><?= esc($p['id_item'] ?? '-'); ?></td>
                <td><?= esc($p['tgl_pengajuan']); ?></td>
                <td><?= esc($p['tgl_selesai'] ?? '-'); ?></td>
                <td><?= !empty($p['saran_petugas']) ? esc($p['saran_petugas']) : '<em>-</em>'; ?></td>
                <td>
                    <a href="<?= base_url('petugas/pengaduan/edit/'.$p['id_pengaduan']); ?>" class="user-admin-btn-edit">Edit</a>
                    <a href="<?= base_url('petugas/pengaduan/delete/'.$p['id_pengaduan']); ?>" onclick="return confirm('Yakin hapus pengaduan ini?')" class="user-admin-btn-delete">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
