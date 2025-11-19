<?php
$session = session();

// Prefer 'user' array in session as single source of truth when available
$userSession = $session->get('user') ?? [];
$username = $userSession['username'] ?? $session->get('username') ?? $userSession['nama_pengguna'] ?? $session->get('nama_pengguna') ?? 'User';
$foto = $userSession['foto'] ?? $session->get('foto') ?? null;
$lastUpdate = $session->get('last_profile_update') ?? time();

$avatarUrl = null;
if (!empty($foto) && $foto !== 'default.png') {
    $localPath = FCPATH . 'uploads/foto_user/' . $foto;
    if (is_file($localPath)) {
        // Gunakan timestamp dari session atau filemtime untuk cache busting
        $fileTime = filemtime($localPath);
        $cacheBuster = $lastUpdate . '_' . $fileTime;
        $avatarUrl = base_url('uploads/foto_user/' . $foto) . '?v=' . $cacheBuster;
    } else {
        // Jika file tidak ditemukan, gunakan default
        $avatarUrl = base_url('assets/images/default-avatar.png') . '?v=' . $lastUpdate;
    }
} else {
    $avatarUrl = base_url('assets/images/default-avatar.png') . '?v=' . $lastUpdate;
}

$role = $session->get('role') ?? 'user';
$inisial = strtoupper(substr($username, 0, 1));
?>

<!-- NAVBAR MODERN GRADIENT TAILWIND USER -->
<nav class="bg-gradient-to-r from-indigo-600 via-blue-600 to-blue-500 shadow-lg sticky top-0 z-50 backdrop-blur-sm border-b border-white/10">
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
        <!-- ... (kode menu desktop tetap sama) ... -->
        
        <!-- User Profile Dropdown -->
        <div class="relative" x-data="{ open: false }">
          <button @click="open = !open" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/20 transition-all duration-200">
            <!-- Force image reload dengan cache buster -->
            <img src="<?= esc($avatarUrl) ?>" 
                 alt="profile" 
                 class="w-9 h-9 rounded-full object-cover border-2 border-white shadow-lg"
                 onerror="this.src='<?= base_url('assets/images/default-avatar.png') ?>?v=<?= time() ?>'">
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
  <div id="mobileMenu" class="md:hidden hidden bg-gradient-to-b from-indigo-600 to-blue-500 border-t border-white/10 mobile-menu-ui">
    <div class="px-4 py-3 space-y-1">
      <!-- ... (kode menu mobile tetap sama) ... -->

      <!-- User Info Mobile -->
      <div class="flex items-center gap-3 px-4 py-3">
        <!-- Force image reload dengan cache buster -->
        <img src="<?= esc($avatarUrl) ?>" 
             alt="profile" 
             class="w-10 h-10 rounded-full object-cover border-2 border-white shadow-lg"
             onerror="this.src='<?= base_url('assets/images/default-avatar.png') ?>?v=<?= time() ?>'">
        <div>
          <p class="text-sm font-bold text-white drop-shadow"><?= esc($username) ?></p>
          <p class="text-xs text-indigo-100 font-medium"><?= ucfirst($role) ?></p>
        </div>
      </div>

      <!-- ... (sisa kode menu mobile) ... -->
    </div>
  </div>
</nav>

<!-- Alpine.js for dropdown -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<script>
  // Mobile menu toggle dengan force refresh avatar setelah update
  const mobileBtn = document.getElementById('mobileMenuBtn');
  const mobileMenu = document.getElementById('mobileMenu');
  const menuIcon = document.getElementById('menuIcon');
  const closeIcon = document.getElementById('closeIcon');

  mobileBtn.addEventListener('click', () => {
    mobileMenu.classList.toggle('hidden');
    menuIcon.classList.toggle('hidden');
    closeIcon.classList.toggle('hidden');
    
    // Force refresh avatar images ketika mobile menu dibuka
    if (!mobileMenu.classList.contains('hidden')) {
      document.querySelectorAll('img[alt="profile"]').forEach(img => {
        const src = img.src;
        if (src.includes('uploads/foto_user')) {
          img.src = src.split('?')[0] + '?v=' + Date.now();
        }
      });
    }
  });

  // Close mobile menu when clicking outside
  document.addEventListener('click', (e) => {
    if (!mobileBtn.contains(e.target) && !mobileMenu.contains(e.target)) {
      mobileMenu.classList.add('hidden');
      menuIcon.classList.remove('hidden');
      closeIcon.classList.add('hidden');
    }
  });

  // Force refresh avatar images pada page load jika ada parameter success
  if (window.location.search.includes('success')) {
    setTimeout(() => {
      document.querySelectorAll('img[alt="profile"]').forEach(img => {
        const src = img.src;
        if (src.includes('uploads/foto_user')) {
          img.src = src.split('?')[0] + '?v=' + Date.now();
        }
      });
    }, 500);
  }
</script>