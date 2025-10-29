<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Pengaduan Sarpras</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
<body class="login-body">
    <div class="login-container">
        <div class="login-form">
            <h2>Register</h2>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="login-alert"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <form action="<?= base_url('/auth/register') ?>" method="post">
                <input type="text" name="nama_pengguna" placeholder="Nama Pengguna" required>
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required minlength="6">

                <select name="role" required>
                    <option value="">-- Pilih Role --</option>
                    <option value="admin">Admin</option>
                    <option value="guru">Guru</option>
                    <option value="siswa">Siswa</option>
                    <option value="petugas">Petugas</option>
                    <option value="user" selected>User</option>
                </select>

                <button type="submit">Daftar</button>
            </form>

            <p class="login-register-text">
                Sudah punya akun?
                <a href="<?= base_url('auth/login') ?>" class="login-register-link">Login Sekarang</a>
            </p>
        </div>
    </div>
</body>
</html>
