<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Pengaduan Sarpras</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
<body class="login-body">
    <div class="login-container">
        <div class="login-form">
            <h2>Login</h2>

            <?php if(session()->getFlashdata('error')): ?>
                <div class="login-alert">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('/auth/login') ?>" method="post">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Masuk</button>
            </form>

            <p class="login-register-text">
                Belum punya akun?
                <a href="<?= base_url('auth/register') ?>" class="login-register-link">Daftar Sekarang</a>
            </p>
        </div>
    </div>
</body>
</html>
