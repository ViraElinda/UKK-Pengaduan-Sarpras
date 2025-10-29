<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Beranda - Pengaduan Sarpras</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
</head>
<body class="landing-body">
    <div class="landing-overlay"></div>

    <div class="landing-container">
        <div class="landing-content">
            <h1 class="landing-title">Sistem Pengaduan<br><span>Sarana dan Prasarana</span></h1>
            <p class="landing-desc">
                Sampaikan keluhan atau masukan terkait fasilitas sekolah dengan mudah dan cepat.
            </p>
            <div class="landing-buttons">
                <a href="<?= base_url('auth/login') ?>" class="landing-btn landing-login">Login</a>
                <a href="<?= base_url('auth/register') ?>" class="landing-btn landing-register">Register</a>
            </div>
        </div>
    </div>
</body>
</html>
