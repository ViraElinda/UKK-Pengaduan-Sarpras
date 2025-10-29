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
 <?= view('navbar/petugas') ?>
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
