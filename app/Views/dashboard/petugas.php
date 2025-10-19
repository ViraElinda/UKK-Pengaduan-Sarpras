<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard User - Lapor</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body>

    <nav class="navbar">
        <div class="logo" tabindex="0" role="button" aria-label="Lapor Home">LAPOR!</div>

        <div class="nav-links" id="nav-links">
            <a href="#" class="active" tabindex="0">Beranda</a>
            <a href="#" tabindex="0">Statistik</a>
            <a href="#" tabindex="0">Tentang</a>
            <a href="/profile" tabindex="0">Profil</a>
        </div>

        <div class="btn-group">
            <button class="btn" tabindex="0">Logout</button>
        </div>

        <div class="menu-toggle" id="menu-toggle" aria-label="Toggle menu" role="button" tabindex="0">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </nav>

    <main>
        <h1>Selamat datang, Siswa!</h1>
        <p>Layanan Aspirasi dan Pengaduan Online Rakyat</p>

        <button class="btn-primary" tabindex="0">Buat Pengaduan Baru</button>
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
