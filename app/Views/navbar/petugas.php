<nav class="bg-gradient-to-r from-blue-600 to-blue-800 shadow-lg">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center py-4">
            <!-- Logo & Brand -->
            <div class="flex items-center space-x-3">
                <div class="bg-white p-2 rounded-lg shadow-md">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-white text-xl font-bold">Sistem Pengaduan Sarpras</h1>
                    <p class="text-blue-200 text-xs">Portal Petugas</p>
                </div>
            </div>

            <!-- Navigation Menu -->
            <div class="flex items-center space-x-6">
                <a href="<?= base_url('petugas/dashboard') ?>" class="text-white hover:text-blue-200 transition duration-300 flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span class="font-medium">Dashboard</span>
                </a>

                <a href="<?= base_url('petugas/pengaduan') ?>" class="text-white hover:text-blue-200 transition duration-300 flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>
                    <span class="font-medium">Kelola Pengaduan</span>
                </a>

                <!-- Notification Bell -->
                <?= view('components/notif_bell') ?>

                <!-- Top-level Logout (visible on desktop) -->
                <form action="<?= base_url('auth/logout') ?>" method="post" class="inline ml-2 hidden sm:inline">
                    <?= function_exists('csrf_field') ? csrf_field() : '' ?>
                    <button type="submit" class="ml-2 btn-danger-ui">Logout</button>
                </form>

                <!-- Profile Dropdown -->
                <div class="relative group">
                    <button class="text-white hover:text-blue-200 transition duration-300 flex items-center space-x-2 focus:outline-none">
                        <div class="bg-white p-1 rounded-full">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <span class="font-medium"><?= session('username') ?></span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                        <div class="py-1">
                            <div class="px-4 py-2 border-b border-gray-200">
                                <p class="text-sm font-semibold text-gray-800"><?= session('nama_pengguna') ?></p>
                                <p class="text-xs text-gray-500">Petugas</p>
                            </div>
                            <a href="<?= base_url('auth/logout') ?>" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition duration-200">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    <span>Logout</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
