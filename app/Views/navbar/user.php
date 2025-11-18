<?php
$session = session();

// Ambil dari session langsung, bukan dari array user
$username = $session->get('username') ?? $session->get('nama_pengguna') ?? 'User';
$foto = $session->get('foto') ?? null;
$role = $session->get('role') ?? 'user';
$inisial = strtoupper(substr($username, 0, 1));
?>

<!-- NAVBAR MODERN GRADIENT TAILWIND USER -->
<nav class="bg-ui-header shadow-lg sticky top-0 z-50">
  <div class="w-full px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between h-16">
      
      <!-- Logo / Brand -->
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center shadow-lg">
          <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
          </svg>
        </div>
        <div class="hidden sm:block">
          <h1 class="text-lg font-bold text-white drop-shadow-lg">Pengaduan Sarpras</h1>
          <p class="text-xs text-indigo-100 -mt-1 font-medium">Sistem Pelaporan</p>
        </div>
      </div>

      <!-- Menu Desktop -->
  <div class="hidden md:flex items-center gap-1">
        <?php 
          $role = session()->get('role') ?? 'user';
          $dashboardRoutes = [
            'user'    => 'user/dashboard',
            'siswa'   => 'siswa/dashboard',
            'guru'    => 'guru/dashboard',
            'admin'   => 'admin/dashboard',
            'petugas' => 'petugas/dashboard',
          ];
          $dashboardUrl = isset($dashboardRoutes[$role]) ? base_url($dashboardRoutes[$role]) : base_url('/');
          $currentUri = uri_string();
        ?>
        
  <a href="<?= $dashboardUrl ?>" class="nav-link flex items-center gap-2 px-4 py-2 rounded-lg font-semibold text-sm transition-all duration-200 <?= ($currentUri == $dashboardRoutes[$role]) ? 'bg-white/20 text-white shadow-md' : 'text-white/90 hover:bg-white/10 hover:text-white' ?>">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
          </svg>
          Dashboard
        </a>
        
  <a href="<?= base_url('user/pengaduan') ?>" class="nav-link flex items-center gap-2 px-4 py-2 rounded-lg font-semibold text-sm transition-all duration-200 <?= ($currentUri == 'user/pengaduan' || $currentUri == 'user/pengaduan/index') ? 'bg-white/20 text-white shadow-md' : 'text-white/90 hover:bg-white/10 hover:text-white' ?>">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
          </svg>
          Ajukan Aduan
        </a>
        
  <a href="<?= base_url('user/riwayat') ?>" class="nav-link flex items-center gap-2 px-4 py-2 rounded-lg font-semibold text-sm transition-all duration-200 <?= ($currentUri == 'user/riwayat') ? 'bg-white/20 text-white shadow-md' : 'text-white/90 hover:bg-white/10 hover:text-white' ?>">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
          </svg>
          Riwayat
        </a>

        <!-- Notification Bell -->
        <?= view('components/notif_bell') ?>

        <!-- Separator -->
        <div class="h-8 w-px bg-white/30 mx-2"></div>

        <!-- User Profile Dropdown -->
        <div class="relative" x-data="{ open: false }">
          <button @click="open = !open" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/20 transition-all duration-200">
            <?php if (!empty($foto)): ?>
              <img src="<?= base_url('uploads/foto_user/' . $foto) ?>" alt="profile" class="w-9 h-9 rounded-full object-cover border-2 border-white shadow-lg">
            <?php else: ?>
              <div class="w-9 h-9 rounded-full bg-white/30 backdrop-blur-sm flex items-center justify-center font-bold text-white shadow-lg"><?= $inisial ?></div>
            <?php endif; ?>
            <div class="hidden lg:block text-left">
              <p class="text-sm font-bold text-white drop-shadow"><?= esc($username) ?></p>
              <p class="text-xs text-indigo-100 font-medium"><?= ucfirst($role) ?></p>
            </div>
            <svg class="w-4 h-4 text-white" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
            </svg>
          </button>

          <!-- Dropdown Menu -->
          <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50">
            <a href="<?= base_url('user/profile') ?>" class="flex items-center gap-3 px-4 py-2 hover:bg-gray-100 transition">
              <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
              </svg>
              <span class="text-sm font-medium text-gray-700">Edit Profil</span>
            </a>
            <hr class="my-1">
            <form action="<?= base_url('auth/logout') ?>" method="post">
              <?= csrf_field() ?>
              <button type="submit" class="w-full flex items-center gap-3 px-4 py-2 hover:bg-red-50 transition text-left">
                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                <span class="text-sm font-medium text-red-600">Keluar</span>
              </button>
            </form>
          </div>
        </div>
      </div>

      <!-- Mobile menu button -->
      <div class="md:hidden flex items-center">
  <button id="mobileMenuBtn" class="p-2 rounded-lg hover:bg-white/10 transition">
          <svg id="menuIcon" class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"/>
          </svg>
          <svg id="closeIcon" class="w-6 h-6 text-white hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
      </div>
    </div>
  </div>

  <!-- Mobile Menu -->
  <div id="mobileMenu" class="md:hidden hidden border-t border-white/30 mobile-menu-ui">
    <div class="px-4 py-3 space-y-1">
      <?php 
        $role = session()->get('role') ?? 'user';
        $dashboardRoutes = [
          'user'    => 'user/dashboard',
          'siswa'   => 'siswa/dashboard',
          'guru'    => 'guru/dashboard',
          'admin'   => 'admin/dashboard',
          'petugas' => 'petugas/dashboard',
        ];
        $dashboardUrl = isset($dashboardRoutes[$role]) ? base_url($dashboardRoutes[$role]) : base_url('/');
        $currentUri = uri_string();
      ?>
      
      <a href="<?= $dashboardUrl ?>" class="flex items-center gap-3 px-4 py-3 rounded-lg font-semibold text-sm transition <?= ($currentUri == $dashboardRoutes[$role]) ? 'bg-white/30 backdrop-blur-sm text-white shadow-md' : 'text-white/90 hover:bg-white/20 hover:text-white' ?>">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
        </svg>
        Dashboard
      </a>
      
  <a href="<?= base_url('user/pengaduan') ?>" class="flex items-center gap-3 px-4 py-3 rounded-lg font-semibold text-sm transition <?= ($currentUri == 'user/pengaduan' || $currentUri == 'user/pengaduan/index') ? 'bg-white/30 backdrop-blur-sm text-white shadow-md' : 'text-white/90 hover:bg-white/20 hover:text-white' ?>">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
        </svg>
        Ajukan Aduan
      </a>
      
      <a href="<?= base_url('user/riwayat') ?>" class="flex items-center gap-3 px-4 py-3 rounded-lg font-semibold text-sm transition <?= ($currentUri == 'user/riwayat') ? 'bg-white/30 backdrop-blur-sm text-white shadow-md' : 'text-white/90 hover:bg-white/20 hover:text-white' ?>">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
        Riwayat
      </a>

      <hr class="my-2 border-white/30">

      <!-- User Info Mobile -->
      <div class="flex items-center gap-3 px-4 py-3">
        <?php if (!empty($foto)): ?>
          <img src="<?= base_url('uploads/foto_user/' . $foto) ?>" alt="profile" class="w-10 h-10 rounded-full object-cover border-2 border-white shadow-lg">
        <?php else: ?>
          <div class="w-10 h-10 rounded-full bg-white/30 backdrop-blur-sm flex items-center justify-center font-bold text-white shadow-lg"><?= $inisial ?></div>
        <?php endif; ?>
        <div>
          <p class="text-sm font-bold text-white drop-shadow"><?= esc($username) ?></p>
          <p class="text-xs text-indigo-100 font-medium"><?= ucfirst($role) ?></p>
        </div>
      </div>

      <a href="<?= base_url('user/profile') ?>" class="flex items-center gap-3 px-4 py-3 rounded-lg font-semibold text-sm text-white/90 hover:bg-white/20 hover:text-white transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
        </svg>
        Edit Profil
      </a>

      <form action="<?= base_url('auth/logout') ?>" method="post">
        <?= csrf_field() ?>
        <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg font-semibold text-sm text-red-100 hover:bg-red-500/30 hover:text-white transition">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
          </svg>
          Keluar
        </button>
      </form>
    </div>
  </div>
</nav>

<!-- Alpine.js for dropdown -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<script>
  // Mobile menu toggle with animation
  const mobileBtn = document.getElementById('mobileMenuBtn');
  const mobileMenu = document.getElementById('mobileMenu');
  const menuIcon = document.getElementById('menuIcon');
  const closeIcon = document.getElementById('closeIcon');

  mobileBtn.addEventListener('click', () => {
    mobileMenu.classList.toggle('hidden');
    menuIcon.classList.toggle('hidden');
    closeIcon.classList.toggle('hidden');
  });

  // Close mobile menu when clicking outside
  document.addEventListener('click', (e) => {
    if (!mobileBtn.contains(e.target) && !mobileMenu.contains(e.target)) {
      mobileMenu.classList.add('hidden');
      menuIcon.classList.remove('hidden');
      closeIcon.classList.add('hidden');
    }
  });
</script>
