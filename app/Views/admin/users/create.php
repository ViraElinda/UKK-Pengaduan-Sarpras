<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah User</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css'); ?>">
</head>
<body class="user-admin-body">

    <div class="user-admin-container">
        <h2 class="user-admin-title">Tambah User Baru</h2>

        <form action="<?= base_url('admin/users/store'); ?>" method="post" class="user-admin-form">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="text" name="nama_pengguna" placeholder="Nama Lengkap" required>
            
            <select name="role" required>
                <option value="" disabled selected>Pilih Role</option>
                <option value="admin">Admin</option>
                <option value="petugas">Petugas</option>
                <option value="guru">Guru</option>
                <option value="siswa">Siswa</option>
            </select>

            <button type="submit" class="user-admin-btn">Simpan</button>
        </form>
    </div>

</body>
</html>