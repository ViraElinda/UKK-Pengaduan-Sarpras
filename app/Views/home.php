<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pengaduan Sarpras Sekolah - Lapor Mudah, Cepat, Transparan</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <script src="https://unpkg.com/lucide@latest"></script>
  <style>
    body { 
      font-family: 'Poppins', sans-serif;
      scroll-behavior: smooth;
    }
    .animate-fadeIn {
      animation: fadeIn 0.8s ease-out forwards;
    }
    .animate-slideUp {
      animation: slideUp 0.6s ease-out forwards;
    }
    .animate-scaleIn {
      animation: scaleIn 0.5s ease-out forwards;
    }
    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }
    @keyframes slideUp {
      from { transform: translateY(30px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }
    @keyframes scaleIn {
      from { transform: scale(0.9); opacity: 0; }
      to { transform: scale(1); opacity: 1; }
    }
    .hero-pattern {
      background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
      position: relative;
    }
  </style>
</head>
<body class="overflow-x-hidden bg-gray-50">

  <!-- Navbar -->
  <nav class="w-full bg-white/95 backdrop-blur-lg shadow-xl fixed top-0 left-0 z-50 border-b border-blue-100">
    <div class="max-w-7xl mx-auto flex justify-between items-center py-4 px-6">
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg">
          <i data-lucide="clipboard-list" class="text-white w-6 h-6"></i>
        </div>
        <h1 class="text-2xl font-extrabold text-blue-600">Pengaduan Sarpras</h1>
      </div>
      
      <!-- Desktop Menu -->
      <div class="hidden md:flex items-center gap-6">
        <a href="#beranda" class="text-gray-700 font-semibold hover:text-blue-600 transition-colors">Beranda</a>
        <a href="#fitur" class="text-gray-700 font-semibold hover:text-blue-600 transition-colors">Fitur</a>
        <a href="#statistik" class="text-gray-700 font-semibold hover:text-blue-600 transition-colors">Statistik</a>
        <a href="<?= base_url('auth/login') ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl font-bold shadow-lg hover:shadow-xl transition-all">Login</a>
        <a href="<?= base_url('auth/register') ?>" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2.5 rounded-xl font-bold shadow-lg hover:shadow-xl transition-all">Register</a>
      </div>

      <!-- Mobile Menu Button -->
      <button id="mobileMenuBtn" class="md:hidden text-blue-600">
        <i data-lucide="menu" class="w-7 h-7"></i>
      </button>
    </div>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="hidden md:hidden bg-white/95 backdrop-blur-lg border-t border-blue-100">
      <div class="flex flex-col gap-2 p-4">
        <a href="#beranda" class="text-gray-700 font-semibold px-4 py-3 rounded-lg hover:bg-blue-50 transition-colors">Beranda</a>
        <a href="#fitur" class="text-gray-700 font-semibold px-4 py-3 rounded-lg hover:bg-blue-50 transition-colors">Fitur</a>
        <a href="#statistik" class="text-gray-700 font-semibold px-4 py-3 rounded-lg hover:bg-blue-50 transition-colors">Statistik</a>
        <a href="<?= base_url('auth/login') ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-xl font-bold shadow-lg text-center transition-all">Login</a>
        <a href="<?= base_url('auth/register') ?>" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-3 rounded-xl font-bold shadow-lg text-center transition">Register</a>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section id="beranda" class="relative pt-32 pb-20 hero-pattern">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center gap-12 px-6">
      
      <!-- Teks -->
      <div class="md:w-1/2 animate-slideUp">
        <div class="inline-block bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full mb-6 border border-white/30">
          <span class="text-white font-semibold text-sm">🎯 Sistem Pelaporan Modern</span>
        </div>
        <h2 class="text-4xl md:text-6xl font-extrabold text-white mb-6 leading-tight drop-shadow-2xl">
          Sampaikan Keluhan Sarana & Prasarana <span class="text-yellow-400">SMKN 1 Bantul</span>
        </h2>
        <p class="text-white/90 text-lg mb-8 leading-relaxed font-medium">
          Mudah, cepat, dan transparan. Semua laporan ditindaklanjuti oleh petugas sekolah dengan sistem tracking real-time.
        </p>
        <div class="flex flex-col sm:flex-row gap-4">
          <a href="<?= base_url('auth/login') ?>" class="group bg-white hover:bg-white/95 text-blue-600 px-8 py-4 rounded-xl font-bold shadow-2xl hover:shadow-3xl transition-all flex items-center justify-center gap-2">
            <span>Mulai Lapor</span>
            <i data-lucide="arrow-right" class="w-5 h-5 group-hover:translate-x-1 transition-transform"></i>
          </a>
          <a href="<?= base_url('auth/register') ?>" class="bg-white/20 backdrop-blur-sm hover:bg-white/30 border-2 border-white/50 text-white px-8 py-4 rounded-xl font-bold shadow-xl hover:shadow-2xl transition-all flex items-center justify-center gap-2">
            <span>Daftar Sekarang</span>
          </a>
        </div>

        <!-- Stats Quick -->
        <div class="mt-10 flex flex-wrap gap-6">
          <div class="flex items-center gap-2 bg-white/10 backdrop-blur-sm px-4 py-2 rounded-xl border border-white/20">
            <i data-lucide="users" class="w-5 h-5 text-yellow-300"></i>
            <span class="text-white font-bold">Proses Cepat</span>
          </div>
          <div class="flex items-center gap-2 bg-white/10 backdrop-blur-sm px-4 py-2 rounded-xl border border-white/20">
            <i data-lucide="check-circle" class="w-5 h-5 text-green-300"></i>
            <span class="text-white font-bold">Terselesaikan</span>
          </div>
        </div>
      </div>

      <!-- Ilustrasi / Gambar -->
      <div class="md:w-1/2 animate-scaleIn">
        <div class="relative">
          <div class="absolute inset-0 bg-blue-400/20 rounded-3xl blur-3xl opacity-30"></div>
          <div class="relative bg-white/10 backdrop-blur-xl rounded-3xl p-8 border border-white/20 shadow-2xl">
            <div class="bg-blue-600 rounded-2xl p-1">
              <div class="bg-white rounded-2xl p-8">
                <i data-lucide="clipboard-check" class="w-32 h-32 mx-auto text-indigo-600"></i>
                <h3 class="text-center mt-6 text-xl font-bold text-gray-800">Lapor Mudah & Cepat</h3>
                <p class="text-center text-gray-600 mt-2">Proses pelaporan hanya 2 menit</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Fitur Section -->
  <section id="fitur" class="py-20 bg-gradient-to-br from-indigo-100 via-purple-100 to-pink-100">
    <div class="max-w-7xl mx-auto px-6">
      <div class="text-center mb-16 animate-fadeIn">
        <span class="text-indigo-700 font-bold text-sm uppercase tracking-wider">Kenapa Pilih Kami?</span>
        <h3 class="text-4xl md:text-5xl font-extrabold text-gray-900 mt-3 mb-4">Keunggulan Sistem</h3>
        <p class="text-gray-700 text-lg max-w-2xl mx-auto">Sistem pelaporan modern dengan teknologi terkini untuk kemudahan dan kecepatan</p>
      </div>
      
      <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
        <!-- Card 1 -->
        <div class="group bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg hover:shadow-2xl p-8 text-center transition-all hover:-translate-y-2">
          <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-xl group-hover:scale-110 transition-transform">
            <i data-lucide="zap" class="text-blue-600 w-8 h-8"></i>
          </div>
          <h4 class="font-bold text-white mb-3 text-lg">Super Cepat</h4>
          <p class="text-blue-100 text-sm leading-relaxed">Laporan langsung diterima dan diproses dalam hitungan menit</p>
        </div>

        <!-- Card 2 -->
        <div class="group bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl shadow-lg hover:shadow-2xl p-8 text-center transition-all hover:-translate-y-2">
          <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-xl group-hover:scale-110 transition-transform">
            <i data-lucide="eye" class="text-purple-600 w-8 h-8"></i>
          </div>
          <h4 class="font-bold text-white mb-3 text-lg">100% Transparan</h4>
          <p class="text-purple-100 text-sm leading-relaxed">Status laporan dapat dipantau real-time oleh pengadu</p>
        </div>

        <!-- Card 3 -->
        <div class="group bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-lg hover:shadow-2xl p-8 text-center transition-all hover:-translate-y-2">
          <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-xl group-hover:scale-110 transition-transform">
            <i data-lucide="shield-check" class="text-green-600 w-8 h-8"></i>
          </div>
          <h4 class="font-bold text-white mb-3 text-lg">Tindak Lanjut Pasti</h4>
          <p class="text-green-100 text-sm leading-relaxed">Petugas menangani pengaduan dengan SLA yang jelas</p>
        </div>

        <!-- Card 4 -->
        <div class="group bg-gradient-to-br from-amber-500 to-orange-500 rounded-2xl shadow-lg hover:shadow-2xl p-8 text-center transition-all hover:-translate-y-2">
          <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-xl group-hover:scale-110 transition-transform">
            <i data-lucide="smartphone" class="text-amber-600 w-8 h-8"></i>
          </div>
          <h4 class="font-bold text-white mb-3 text-lg">Akses Mudah</h4>
          <p class="text-amber-100 text-sm leading-relaxed">Bisa diakses dari komputer, tablet, maupun smartphone</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Statistik Section -->
  <section id="statistik" class="py-20 bg-gradient-to-br from-pink-100 via-rose-100 to-orange-100">
    <div class="max-w-7xl mx-auto px-6">
      <div class="text-center mb-16 animate-fadeIn">
        <span class="text-rose-700 font-bold text-sm uppercase tracking-wider">Data Real-Time</span>
        <h3 class="text-4xl md:text-5xl font-extrabold text-gray-900 mt-3 mb-4">Statistik Sistem</h3>
        <p class="text-gray-700 text-lg max-w-2xl mx-auto">Kepercayaan dari ratusan pengguna yang telah merasakan manfaatnya</p>
      </div>
      
      <!-- CTA Section -->
      <div class="mt-16 bg-blue-600 rounded-3xl p-12 text-center shadow-2xl">
        <h4 class="text-3xl md:text-4xl font-extrabold text-white mb-4">Siap Mulai Melaporkan?</h4>
        <p class="text-white/90 text-lg mb-8 max-w-2xl mx-auto">Bergabunglah dengan ratusan pengguna lainnya untuk menciptakan lingkungan sekolah yang lebih baik</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
          <a href="<?= base_url('auth/register') ?>" class="bg-white hover:bg-gray-50 text-blue-600 px-8 py-4 rounded-xl font-bold shadow-xl hover:shadow-2xl transition-all inline-flex items-center justify-center gap-2">
            <span>Daftar Gratis</span>
            <i data-lucide="arrow-right" class="w-5 h-5"></i>
          </a>
          <a href="<?= base_url('auth/login') ?>" class="bg-white/20 backdrop-blur-sm hover:bg-white/30 border-2 border-white text-white px-8 py-4 rounded-xl font-bold shadow-xl hover:shadow-2xl transition-all">
            Sudah Punya Akun?
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-gray-900 text-white py-16">
    <div class="max-w-7xl mx-auto px-6">
      <div class="grid md:grid-cols-4 gap-8 mb-12">
        <!-- Brand -->
        <div class="col-span-2">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg">
              <i data-lucide="clipboard-list" class="text-white w-7 h-7"></i>
            </div>
            <h3 class="text-2xl font-extrabold">Pengaduan Sarpras</h3>
          </div>
          <p class="text-gray-400 mb-6 leading-relaxed max-w-md">Sistem pelaporan sarana dan prasarana sekolah yang mudah, cepat, dan transparan. Wujudkan lingkungan sekolah yang lebih baik bersama-sama.</p>
          <div class="flex gap-3">
            <a href="#" class="w-10 h-10 bg-white/10 hover:bg-white/20 rounded-lg flex items-center justify-center transition-colors">
              <i data-lucide="facebook" class="w-5 h-5"></i>
            </a>
            <a href="#" class="w-10 h-10 bg-white/10 hover:bg-white/20 rounded-lg flex items-center justify-center transition-colors">
              <i data-lucide="twitter" class="w-5 h-5"></i>
            </a>
            <a href="#" class="w-10 h-10 bg-white/10 hover:bg-white/20 rounded-lg flex items-center justify-center transition-colors">
              <i data-lucide="instagram" class="w-5 h-5"></i>
            </a>
          </div>
        </div>

        <!-- Quick Links -->
        <div>
          <h4 class="font-bold text-lg mb-4">Menu Cepat</h4>
          <ul class="space-y-3">
            <li><a href="#beranda" class="text-gray-400 hover:text-white transition-colors flex items-center gap-2"><i data-lucide="chevron-right" class="w-4 h-4"></i> Beranda</a></li>
            <li><a href="#fitur" class="text-gray-400 hover:text-white transition-colors flex items-center gap-2"><i data-lucide="chevron-right" class="w-4 h-4"></i> Fitur</a></li>
            <li><a href="#statistik" class="text-gray-400 hover:text-white transition-colors flex items-center gap-2"><i data-lucide="chevron-right" class="w-4 h-4"></i> Statistik</a></li>
            <li><a href="<?= base_url('auth/login') ?>" class="text-gray-400 hover:text-white transition-colors flex items-center gap-2"><i data-lucide="chevron-right" class="w-4 h-4"></i> Login</a></li>
          </ul>
        </div>

        <!-- Contact -->
        <div>
          <h4 class="font-bold text-lg mb-4">Kontak</h4>
          <ul class="space-y-3">
            <li class="flex items-start gap-3 text-gray-400">
              <i data-lucide="mail" class="w-5 h-5 mt-0.5 flex-shrink-0"></i>
              <span>infosarpras@gmail.com</span>
            </li>
            <li class="flex items-start gap-3 text-gray-400">
              <i data-lucide="phone" class="w-5 h-5 mt-0.5 flex-shrink-0"></i>
              <span>0831-2009-7334</span>
            </li>
            <li class="flex items-start gap-3 text-gray-400">
              <i data-lucide="map-pin" class="w-5 h-5 mt-0.5 flex-shrink-0"></i>
              <span>Jl. Kenanga No. 123, Yogyakarta</span>
            </li>
          </ul>
        </div>
      </div>

      <!-- Bottom Bar -->
      <div class="border-t border-gray-700 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
        <p class="text-gray-400 text-sm">&copy; <?= date('Y') ?> Pengaduan Sarpras Sekolah. All rights reserved.</p>
        <div class="flex gap-6 text-sm">
          <a href="#" class="text-gray-400 hover:text-white transition-colors">Kebijakan Privasi</a>
          <a href="#" class="text-gray-400 hover:text-white transition-colors">Syarat & Ketentuan</a>
        </div>
      </div>
    </div>
  </footer>

  <!-- Mobile Menu Script -->
  <script>
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    
    mobileMenuBtn.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
    });

    // Close mobile menu on link click
    mobileMenu.querySelectorAll('a').forEach(link => {
      link.addEventListener('click', () => {
        mobileMenu.classList.add('hidden');
      });
    });

    // Initialize Lucide icons
    lucide.createIcons();
  </script>

</body>
</html>
