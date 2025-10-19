<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard Admin - Lapor</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body>

    <nav class="navbar">
        <div class="logo" tabindex="0" role="button" aria-label="Lapor Home">LAPOR!</div>

        <div class="nav-links" id="nav-links">
    <a href="<?= base_url('admin/users'); ?>" tabindex="0">Manajemen User</a>
    <a href="<?= base_url('admin/pengaduan'); ?>" tabindex="0">Manajemen Aduan</a>
    <a href="<?= base_url('admin/items'); ?>" tabindex="0">Manajemen Items</a>
    <a href="<?= base_url('admin/laporan'); ?>" tabindex="0">Generate Laporan</a>
</div>


        <div class="btn-group">
            <form action="/auth/logout" method="POST">
                <button class="btn" tabindex="0" type="submit">Logout</button>
            </form>
        </div>

        <div class="menu-toggle" id="menu-toggle" aria-label="Toggle menu" role="button" tabindex="0">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </nav>

    <main>
        <h1>Selamat datang, Admin!</h1>
        <p>Layanan Aspirasi dan Pengaduan Online Rakyat</p>

        <a href="<?= base_url('admin/index') ?>" tabindex="0" class="btn-primary">Kelola Pengaduan</a>
    </main>

    <script>
        // Toggle menu mobile
        const menuToggle = document.getElementById('menu-toggle');
        const navLinks = document.getElementById('nav-links');

        function toggleMenu() {
            navLinks.classList.toggle('active');
        }
        menuToggle.addEventListener('click', toggleMenu);
        menuToggle.addEventListener('keypress', function(e){
            if(e.key === 'Enter' || e.key === ' ') {
                toggleMenu();
            }
        });
    </script>

</body>
</html>
