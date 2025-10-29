 <!-- NAVBAR -->
  <nav class="navbar">
    <div class="nav-left">
      <h1>Pengaduan <span>Admin</span></h1>
    </div>
    <div class="nav-right">
  <a href="<?= base_url('admin/pengaduan') ?>" class="nav-item <?= (uri_string() == 'admin/pengaduan') ? 'active' : '' ?>">Manajemen Aduan</a>
  <a href="<?= base_url('admin/users') ?>" class="nav-item <?= (uri_string() == 'admin/users') ? 'active' : '' ?>">Manajemen User</a>
  <a href="<?= base_url('admin/items') ?>" class="nav-item <?= (uri_string() == 'admin/items') ? 'active' : '' ?>">Manajemen Items</a>
  <a href="<?= base_url('admin/laporan') ?>" class="nav-item <?= (uri_string() == 'admin/laporan') ? 'active' : '' ?>">Generate Laporan</a>
  <form action="<?= base_url('auth/logout') ?>" method="post" style="display:inline">
    <?php if (function_exists('csrf_field')): ?>
      <?= csrf_field() ?>
    <?php endif ?>
    <button type="submit" class="logout-btn" style="background:none;border:0;padding:0;font:inherit;cursor:pointer">Logout</button>
  </form>
</div>  
  </nav>