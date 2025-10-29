<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <script src="https://unpkg.com/lucide@latest"></script>
  <link rel="stylesheet" href="<?= base_url('css/style.css'); ?>">
</head>
<body>
 <?= view('navbar/admin') ?>
  <!-- MAIN CONTENT -->
  <main class="dashboard-main">
    <div class="welcome-box">
      <h2>Selamat Datang, <span><?= $username ?></span> 👋</h2>
    </div>

    <div class="stats-container">
      <div class="stat-card">
        <i data-lucide="message-square"></i>
        <h3><?= $total_aduan ?></h3>
        <p>Total Aduan</p>
      </div>
      <div class="stat-card">
        <i data-lucide="users"></i>
        <h3><?= $total_user ?></h3>
        <p>Total Pengguna</p>
      </div>
      <div class="stat-card">
        <i data-lucide="package"></i>
        <h3><?= $total_item ?></h3>
        <p>Total Barang (Sarpras)</p>
      </div>
    </div>
  </main>

  <script>
    lucide.createIcons();

    // Efek klik jembluk
    document.querySelectorAll('.nav-item').forEach(link => {
      link.addEventListener('click', (e) => {
        document.querySelectorAll('.nav-item').forEach(l => l.classList.remove('active', 'clicked'));
        e.currentTarget.classList.add('active', 'clicked');
        setTimeout(() => e.currentTarget.classList.remove('clicked'), 250);
      });
    });
  </script>
</body>
</html>
