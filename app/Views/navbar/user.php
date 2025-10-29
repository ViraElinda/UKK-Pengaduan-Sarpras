<?php
$session = session();
$user = $session->get('user') ?? [];   // pastikan data aman

$username = $user['username'] ?? 'U';
$foto = $user['foto'] ?? null;
$inisial = strtoupper(substr($username, 0, 1));
?>

<nav class="navbar">
  <div class="nav-left">
    <h1>Pengaduan</h1>
  </div>

  <div class="nav-right">

    <a href="<?= base_url('user') ?>" class="nav-item <?= (uri_string() == 'user') ? 'active' : '' ?>">
      Aduan
    </a>

    <a href="<?= base_url('user/riwayat') ?>" class="nav-item <?= (uri_string() == 'user/riwayat') ? 'active' : '' ?>">
      Riwayat
    </a>  

    <!-- AVATAR -->
    <a href="<?= base_url('user/profile') ?>" class="nav-avatar">
      <?php if (!empty($foto)): ?>
        <img src="<?= base_url('uploads/foto_user/' . $foto) ?>" alt="profile">
      <?php else: ?>
        <div class="avatar-text"><?= $inisial ?></div>
      <?php endif; ?>
    </a>

    <!-- Logout -->
    <form action="<?= base_url('auth/logout') ?>" method="post" style="display:inline">
      <?= csrf_field() ?>
      <button type="submit" class="logout-btn"
        style="background:none;border:0;padding:0;font:inherit;cursor:pointer">
        Logout
      </button>
    </form>

  </div>
</nav>
