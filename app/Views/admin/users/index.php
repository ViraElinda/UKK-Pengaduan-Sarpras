<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Manajemen User</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css'); ?>" />
</head>
<body class="user-admin-body">

    <div class="user-admin-container">
        <h2 class="user-admin-title">Daftar User</h2>
        <a href="<?= base_url('admin/users/create'); ?>" class="user-admin-btn">Tambah User</a>

        <?php if(session()->getFlashdata('success')): ?>
            <p class="user-admin-success"><?= session()->getFlashdata('success') ?></p>
        <?php endif; ?>

        <table class="user-admin-table">
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
                    <td><?= $u['id_user']; ?></td>
                    <td><?= $u['username']; ?></td>
                    <td><?= $u['nama_pengguna']; ?></td>
                    <td><?= $u['role']; ?></td>
                    <td>
                        <a href="<?= base_url('admin/users/edit/'.$u['id_user']); ?>" class="user-admin-btn-edit">Edit</a>
                        <a href="<?= base_url('admin/users/delete/'.$u['id_user']); ?>" onclick="return confirm('Yakin hapus user ini?')" class="user-admin-btn-delete">Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</body>
</html>
