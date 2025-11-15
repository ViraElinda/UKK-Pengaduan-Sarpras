
<!-- NAVBAR ADMIN (cleaner & responsive) -->
<nav class="bg-blue-600 shadow-md px-4 py-3 sticky top-0 z-50" role="navigation" aria-label="Main navigation">
  <div class="max-w-7xl mx-auto flex items-center justify-between gap-4">
    <!-- Brand + mobile toggle -->
    <div class="flex items-center gap-3">
      <button id="mobileMenuBtn" class="md:hidden p-2 rounded-md text-white hover:bg-white/10 focus:outline-none" aria-controls="mobileMenu" aria-expanded="false" aria-label="Toggle menu">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
      </button>

      <a href="<?= base_url('admin/dashboard') ?>" class="flex items-center gap-3 no-underline">
        <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center shadow-sm">
          <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V7M8 3h8l3 4H5l3-4z"/>
          </svg>
        </div>
        <div class="leading-tight">
          <div class="text-white text-base font-semibold">Sistem Pengaduan</div>
          <div class="text-blue-100 text-xs">Area Admin</div>
        </div>
      </a>
    </div>

    <!-- Desktop menu (compact, left-aligned with icons) -->
    <?php $active = uri_string(); ?>
    <?php
      $items = [
        ['url' => 'admin/dashboard', 'label' => 'Dashboard', 'icon' => '<svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6"/></svg>'],
        ['url' => 'admin/users', 'label' => 'User', 'icon' => '<svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A9 9 0 1118.879 6.196 9 9 0 015.12 17.804z"/></svg>'],
        ['url' => 'admin/petugas', 'label' => 'Petugas', 'icon' => '<svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7a4 4 0 018 0M5 21v-2a4 4 0 014-4h6a4 4 0 014 4v2"/></svg>'],
        ['url' => 'admin/pengaduan', 'label' => 'Aduan', 'icon' => '<svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m2 0a2 2 0 100-4H7a2 2 0 100 4m0 8h10"/></svg>'],
        ['url' => 'admin/items', 'label' => 'Sarpras', 'icon' => '<svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V7a2 2 0 00-2-2H6a2 2 0 00-2 2v6"/></svg>'],
        ['url' => 'admin/temporary_items', 'label' => 'Temporary', 'icon' => '<svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3"/></svg>'],
        ['url' => 'admin/laporan', 'label' => 'Laporan', 'icon' => '<svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6a2 2 0 012-2h2a2 2 0 012 2v6"/></svg>'],
      ];
    ?>
    <div class="hidden md:flex items-center gap-2 flex-1 pl-6" role="menubar">
      <?php foreach ($items as $it): $u = $it['url']; $isActive = ($active == $u || strpos($active, $u) === 0); ?>
        <a href="<?= base_url($u) ?>" role="menuitem" class="flex items-center gap-2 px-3 py-2 rounded-md text-sm font-semibold transition-colors duration-150 <?= $isActive ? 'bg-white/20 text-white shadow-md' : 'text-white/90 hover:bg-white/10 hover:text-white' ?>" aria-current="<?= $isActive ? 'page' : 'false' ?>" title="<?= esc($it['label']) ?>">
          <?= $it['icon'] ?> <span class="hidden md:inline"><?= $it['label'] ?></span>
        </a>
      <?php endforeach; ?>
    </div>

    <!-- Right controls: notifications + profile + logout -->
    <div class="flex items-center gap-3">
      <?= view('components/notif_bell') ?>

      <!-- Visible logout button (desktop) -->
      <form action="<?= base_url('auth/logout') ?>" method="post" class="hidden md:inline">
        <?= function_exists('csrf_field') ? csrf_field() : '' ?>
        <button type="submit" class="ml-2 inline-flex items-center gap-2 px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded-md text-sm font-semibold shadow-sm focus:outline-none" aria-label="Logout">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7"/></svg>
          Logout
        </button>
      </form>

      <!-- Profile dropdown -->
      <div class="relative group">
        <button class="flex items-center gap-2 text-white focus:outline-none" aria-haspopup="true" aria-expanded="false">
          <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center overflow-hidden">
            <?php if (session('foto')): ?>
              <img src="<?= base_url('writable/uploads/profile/' . session('foto')) ?>" alt="Profile" class="w-full h-full object-cover" />
            <?php else: ?>
              <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            <?php endif; ?>
          </div>
          <span class="text-white font-medium hidden lg:inline"><?= session('username') ?></span>
          <svg class="w-4 h-4 text-white hidden lg:inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
        </button>

        <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
          <div class="py-1">
            <div class="px-4 py-2 border-b border-gray-200">
              <p class="text-sm font-semibold text-gray-800"><?= session('nama_pengguna') ?></p>
              <p class="text-xs text-gray-500">Administrator</p>
            </div>
            <a href="<?= base_url('auth/logout') ?>" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition duration-200">
              <div class="flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                <span>Logout</span>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Mobile menu (hidden by default) -->
  <div id="mobileMenu" class="md:hidden hidden bg-blue-600/95 px-4 pb-4">
    <div class="space-y-2 pt-3">
      <?php foreach ($items as $it): $u = $it['url']; $isActive = ($active == $u || strpos($active, $u) === 0); ?>
        <a href="<?= base_url($u) ?>" class="block px-3 py-2 rounded-md text-white <?= $isActive ? 'bg-white/20' : 'hover:bg-white/10' ?>"><?= $it['label'] ?></a>
      <?php endforeach; ?>
      <form action="<?= base_url('auth/logout') ?>" method="post" class="pt-2">
        <?= function_exists('csrf_field') ? csrf_field() : '' ?>
        <button type="submit" class="w-full text-left px-3 py-2 rounded-md bg-red-600 hover:bg-red-700 text-white font-semibold">Logout</button>
      </form>
    </div>
  </div>
</nav>

<script>
  // Mobile toggle (safe minimal)
  (function(){
    const btn = document.getElementById('mobileMenuBtn');
    const menu = document.getElementById('mobileMenu');
    if (btn && menu) btn.addEventListener('click', function(){
      const expanded = this.getAttribute('aria-expanded') === 'true';
      this.setAttribute('aria-expanded', (!expanded).toString());
      menu.classList.toggle('hidden');
    });
  })();
</script>
