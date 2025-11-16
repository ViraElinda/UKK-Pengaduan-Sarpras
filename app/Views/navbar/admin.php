
<!-- NAVBAR ADMIN - Elegant Blue Design -->
<nav class="bg-gradient-to-r from-blue-500 via-blue-600 to-cyan-500 shadow-xl sticky top-0 z-50 backdrop-blur-md border-b border-blue-400/20" role="navigation" aria-label="Main navigation">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between h-16">
      <!-- Brand + Mobile Toggle -->
      <div class="flex items-center gap-4">
        <button id="mobileMenuBtn" class="md:hidden p-2 rounded-lg text-white/90 hover:text-white hover:bg-white/15 focus:outline-none focus:ring-2 focus:ring-blue-300/50 transition-all duration-200" aria-controls="mobileMenu" aria-expanded="false" aria-label="Toggle menu">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>

        <a href="<?= base_url('admin/dashboard') ?>" class="flex items-center gap-3 no-underline group">
          <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-sm group-hover:shadow-md group-hover:scale-105 transition-all duration-200">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
            </svg>
          </div>
          <div class="leading-tight hidden sm:block">
            <div class="text-white text-lg font-semibold tracking-tight">Panel</div>
            <div class="text-blue-50 text-xs">Sistem Pengaduan</div>
          </div>
        </a>
      </div>

      <!-- Desktop Navigation Menu -->
      <?php $active = uri_string(); ?>
      <?php
        $items = [
          ['url' => 'admin/dashboard', 'label' => 'Dashboard', 'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>'],
          ['url' => 'admin/users', 'label' => 'Users', 'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>'],
          ['url' => 'admin/petugas', 'label' => 'Petugas', 'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>'],
          ['url' => 'admin/pengaduan', 'label' => 'Pengaduan', 'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>'],
          ['url' => 'admin/items', 'label' => 'Sarpras', 'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>'],
          ['url' => 'admin/temporary_items', 'label' => 'Temp', 'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'],
          ['url' => 'admin/laporan', 'label' => 'Laporan', 'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>'],
        ];
      ?>
  <div class="hidden md:flex items-center gap-2 flex-1 pl-6 max-w-3xl justify-start overflow-x-auto whitespace-nowrap" role="menubar">
        <?php foreach ($items as $it): 
          $u = $it['url']; 
          $isActive = ($active == $u || strpos($active, $u) === 0); 
        ?>
       <a href="<?= base_url($u) ?>" 
         role="menuitem" 
         class="group relative flex items-center gap-2 px-2 py-2 rounded-md text-sm font-medium transition-all duration-200 whitespace-nowrap <?= $isActive ? 'bg-white/10 text-white shadow-sm' : 'text-blue-50 hover:bg-white/8 hover:text-white' ?>" 
             aria-current="<?= $isActive ? 'page' : 'false' ?>" 
             title="<?= esc($it['label']) ?>">
            <span class="transition-transform duration-200 <?= $isActive ? '' : 'group-hover:scale-110' ?>">
              <?= $it['icon'] ?>
            </span>
            <span class="hidden lg:inline"><?= $it['label'] ?></span>
            
          </a>
        <?php endforeach; ?>
      </div>

      <!-- Right Side: Notifications + Profile + Logout -->
  <div class="flex items-center gap-3 flex-shrink-0">
        <!-- Notification Bell -->
        <div class="relative">
          <?= view('components/notif_bell') ?>
        </div>

        <!-- Logout Button (Desktop) -->
        <form action="<?= base_url('auth/logout') ?>" method="post" class="hidden md:inline">
          <?= function_exists('csrf_field') ? csrf_field() : '' ?>
    <button type="submit" 
      class="inline-flex items-center gap-2 px-3 py-2 bg-white/8 hover:bg-white/12 text-white rounded-md text-sm font-medium shadow-sm transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-300/40" 
                  aria-label="Logout">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
            </svg>
            <span class="hidden xl:inline">Logout</span>
          </button>
        </form>

        <!-- Profile Dropdown -->
        <div class="relative">
    <button id="profileMenuBtn" 
      class="flex items-center gap-2 px-3 py-2 rounded-md bg-white/8 hover:bg-white/14 text-white focus:outline-none focus:ring-2 focus:ring-blue-300/40 transition-all duration-200" 
                  aria-haspopup="true" 
                  aria-expanded="false">
            <div class="w-9 h-9 rounded-lg bg-white/20 backdrop-blur-sm flex items-center justify-center overflow-hidden border-2 border-white/30 shadow-sm">
              <?php if (session('foto')): ?>
                <img src="<?= base_url('writable/uploads/profile/' . session('foto')) ?>" alt="Profile" class="w-full h-full object-cover" />
              <?php else: ?>
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
              <?php endif; ?>
            </div>
            <span class="text-white font-semibold text-sm hidden lg:inline max-w-[120px] truncate"><?= session('username') ?></span>
            <svg id="profileMenuIcon" class="w-4 h-4 text-white hidden lg:inline transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
          </button>

          <!-- Dropdown Menu -->
    <div id="profileMenu" 
      class="hidden absolute right-0 mt-3 w-64 bg-white rounded-lg shadow-lg border border-blue-50 overflow-hidden z-50 transform origin-top-right transition-all duration-200">
            <div class="bg-gradient-to-r from-blue-500 to-cyan-500 px-4 py-4">
              <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-lg bg-white/20 backdrop-blur-sm flex items-center justify-center overflow-hidden border-2 border-white/40">
                  <?php if (session('foto')): ?>
                    <img src="<?= base_url('writable/uploads/profile/' . session('foto')) ?>" alt="Profile" class="w-full h-full object-cover" />
                  <?php else: ?>
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                  <?php endif; ?>
                </div>
                <div class="flex-1 min-w-0">
                  <p class="text-white font-bold text-sm truncate"><?= session('nama_pengguna') ?></p>
                  <p class="text-blue-50 text-xs font-medium">Administrator</p>
                  <p class="text-blue-100 text-xs truncate">@<?= session('username') ?></p>
                </div>
              </div>
            </div>
            
            <div class="py-2">
              <a href="<?= base_url('admin/dashboard') ?>" 
                 class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-blue-50 transition-colors duration-200">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span class="font-medium text-sm">Dashboard</span>
              </a>
              
              <div class="border-t border-gray-100 my-2"></div>
              
              <form action="<?= base_url('auth/logout') ?>" method="post">
                <?= function_exists('csrf_field') ? csrf_field() : '' ?>
                <button type="submit" 
                        class="w-full flex items-center gap-3 px-4 py-3 text-red-600 hover:bg-red-50 transition-colors duration-200">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                  </svg>
                  <span class="font-semibold text-sm">Logout</span>
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Mobile Menu (Slide-in from top) -->
  <div id="mobileMenu" 
    class="md:hidden hidden bg-gradient-to-b from-blue-600 to-cyan-600 border-t border-blue-400/12 shadow-md">
    <div class="px-4 py-4 space-y-1 max-h-[calc(100vh-4rem)] overflow-y-auto">
      <?php foreach ($items as $it): 
        $u = $it['url']; 
        $isActive = ($active == $u || strpos($active, $u) === 0); 
      ?>
        <a href="<?= base_url($u) ?>" 
           class="flex items-center gap-3 px-4 py-3 rounded-lg text-white font-medium transition-all duration-200 <?= $isActive ? 'bg-white/20 shadow-sm' : 'hover:bg-white/10' ?>">
          <?= $it['icon'] ?>
          <span><?= $it['label'] ?></span>
          <?php if ($isActive): ?>
            <svg class="w-5 h-5 ml-auto" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
          <?php endif; ?>
        </a>
      <?php endforeach; ?>
      
      <div class="pt-4 mt-4 border-t border-white/20">
        <form action="<?= base_url('auth/logout') ?>" method="post">
          <?= function_exists('csrf_field') ? csrf_field() : '' ?>
          <button type="submit" 
                  class="w-full flex items-center justify-center gap-3 px-4 py-3 rounded-lg bg-white/10 hover:bg-white/20 border border-white/30 text-white font-semibold shadow-sm transition-all duration-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
            </svg>
            Logout
          </button>
        </form>
      </div>
    </div>
  </div>
</nav>

<script>
  // Mobile Menu Toggle with smooth animation
  (function(){
    const btn = document.getElementById('mobileMenuBtn');
    const menu = document.getElementById('mobileMenu');
    
    if (btn && menu) {
      btn.addEventListener('click', function(){
        const expanded = this.getAttribute('aria-expanded') === 'true';
        this.setAttribute('aria-expanded', (!expanded).toString());
        menu.classList.toggle('hidden');
        
        // Animate icon rotation
        const icon = this.querySelector('svg');
        if (icon) {
          icon.style.transform = expanded ? 'rotate(0deg)' : 'rotate(90deg)';
          icon.style.transition = 'transform 0.3s ease';
        }
      });
    }
  })();

  // Profile Dropdown Toggle
  (function(){
    const btn = document.getElementById('profileMenuBtn');
    const menu = document.getElementById('profileMenu');
    const icon = document.getElementById('profileMenuIcon');
    
    if (btn && menu) {
      btn.addEventListener('click', function(e){
        e.stopPropagation();
        const expanded = this.getAttribute('aria-expanded') === 'true';
        this.setAttribute('aria-expanded', (!expanded).toString());
        menu.classList.toggle('hidden');
        
        if (icon) {
          icon.style.transform = expanded ? 'rotate(0deg)' : 'rotate(180deg)';
        }
      });
      
      // Close dropdown when clicking outside
      document.addEventListener('click', function(e){
        if (!btn.contains(e.target) && !menu.contains(e.target)) {
          btn.setAttribute('aria-expanded', 'false');
          menu.classList.add('hidden');
          if (icon) {
            icon.style.transform = 'rotate(0deg)';
          }
        }
      });
    }
  })();
</script>
