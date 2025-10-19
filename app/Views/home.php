<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Beranda - Pengaduan Sarpras</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
</head>
<body>

    <header class="navbar">
        <div class="logo">
            <img src="<?= base_url('bg.jpeg') ?>" alt="Logo Web" style="height:40px; width:auto; vertical-align: middle;" />
        </div>
        <nav class="nav-links">
            <a href="#tentang">Tentang Web</a>
            <a href="<?= base_url('auth/login') ?>">Login</a>
            <a href="<?= base_url('auth/register') ?>">Registrasi</a>
        </nav>
        <!-- Kalau mau tombol grup bisa pakai <div class="btn-group"> jika dibutuhkan -->
    </header>

    <main>
        <h1>Start your<br> transformation journey <span class="highlight-blue">Today!</span></h1>
        <p>Per leo gravida augue id rhoncus faucibus semper adipiscing. 
           Porttitor nec porta ligula suscipit litora. Orci habitant ridiculus aenean commodo 
           curae pulvinar dictumst nunc senectus.</p>
        <button class="btn-primary">Discover More</button>
    </main>

</body>
</html>
