<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard - Pengaduan Sarpras</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>

<body>
   <?= view('navbar/user') ?>
  <div class="content">
      <div class="siswa-hero">
        <div class="siswa-hero-card">
          <h2>Hai, <?= esc($username); ?> 👋</h2>
          <p class="muted">Selamat datang di dashboard. Di sini kamu bisa mengajukan aduan sarpras, melihat riwayat, dan memperbarui profil.</p>

          <div class="siswa-cta">
            <a href="<?= base_url('user') ?>" class="cta-btn">+ Ajukan Aduan</a>
          </div>

          <!-- stats removed per user request -->
        </div>
      </div>
    </div>
</body>
</html>
