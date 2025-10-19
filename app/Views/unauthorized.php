<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>403 - Akses Ditolak</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
    <style>
        .unauthorized-container {
            text-align: center;
            margin-top: 100px;
            font-family: 'Poppins', sans-serif;
        }

        .unauthorized-container h1 {
            color: #dc3545;
            font-size: 40px;
            margin-bottom: 10px;
        }

        .unauthorized-container p {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .unauthorized-container a {
            text-decoration: underline;
            color: #007bff;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="unauthorized-container">
        <h1>403 - Akses Ditolak</h1>
        <p>Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.</p>
        <a href="<?= base_url('/') ?>">Kembali ke Beranda</a>
    </div>
</body>
</html>