<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Dashboard - Pengaduan Sarpras
<?= $this->endSection() ?>

<?= $this->section('head') ?>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
  body { font-family: 'Poppins', sans-serif; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php
// Hitung statistik pengaduan user
$total = count($pengaduan);
$diajukan = count(array_filter($pengaduan, fn($p) => strtolower($p['status']) == 'diajukan'));
$diproses = count(array_filter($pengaduan, fn($p) => strtolower($p['status']) == 'diproses'));
$selesai = count(array_filter($pengaduan, fn($p) => strtolower($p['status']) == 'selesai'));

// Greeting berdasarkan waktu
$hour = date('H');
if ($hour < 11) {
    $greeting = "Selamat Pagi";
    $greetingIcon = "☀️";
} elseif ($hour < 15) {
    $greeting = "Selamat Siang";
    $greetingIcon = "🌤️";
} elseif ($hour < 18) {
    $greeting = "Selamat Sore";
    $greetingIcon = "🌅";
} else {
    $greeting = "Selamat Malam";
    $greetingIcon = "🌙";
}
?>

<div class="min-h-screen bg-ui-page py-6 px-4 sm:px-6 lg:px-8">
  <div class="w-full">
    
    <!-- Welcome Section -->
    <div class="mb-6">
      <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-1">
        <?= $greetingIcon ?> <?= $greeting ?>, <span class="text-ui-primary"><?= esc($username) ?></span>!
      </h1>
      <p class="text-gray-600">Kelola pengaduan sarana dan prasarana Anda dengan mudah</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
      <!-- Total Pengaduan -->
      <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-xl p-6 hover:shadow-2xl hover:scale-105 transition-all duration-300">
        <div class="flex items-center justify-between mb-3">
          <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
          </div>
        </div>
        <p class="text-4xl font-bold text-white mb-1"><?= $total ?></p>
        <p class="text-sm text-blue-100 font-semibold">Total Pengaduan</p>
      </div>

      <!-- Diajukan -->
      <div class="bg-gradient-to-br from-amber-500 to-orange-500 rounded-xl shadow-xl p-6 hover:shadow-2xl hover:scale-105 transition-all duration-300">
        <div class="flex items-center justify-between mb-3">
          <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
          </div>
        </div>
        <p class="text-4xl font-bold text-white mb-1"><?= $diajukan ?></p>
        <p class="text-sm text-amber-100 font-semibold">Menunggu</p>
      </div>

      <!-- Diproses -->
      <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl shadow-xl p-6 hover:shadow-2xl hover:scale-105 transition-all duration-300">
        <div class="flex items-center justify-between mb-3">
          <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
          </div>
        </div>
        <p class="text-4xl font-bold text-white mb-1"><?= $diproses ?></p>
        <p class="text-sm text-indigo-100 font-semibold">Diproses</p>
      </div>

      <!-- Selesai -->
      <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl shadow-xl p-6 hover:shadow-2xl hover:scale-105 transition-all duration-300">
        <div class="flex items-center justify-between mb-3">
          <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
          </div>
        </div>
        <p class="text-4xl font-bold text-white mb-1"><?= $selesai ?></p>
        <p class="text-sm text-green-100 font-semibold">Selesai</p>
      </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
      <!-- CTA Card -->
      <div class="bg-gradient-to-br from-blue-600 to-indigo-600 rounded-xl shadow-2xl p-6 hover:scale-105 transition-transform duration-300 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
        <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/10 rounded-full -ml-12 -mb-12"></div>
        <div class="relative z-10">
          <div class="flex items-start justify-between mb-4">
            <div>
              <h3 class="text-xl font-bold mb-2 text-white">Ada Masalah Sarpras?</h3>
              <p class="text-blue-100 text-sm font-medium">Laporkan sekarang dan kami akan segera menindaklanjuti</p>
            </div>
            <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center">
              <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
              </svg>
            </div>
          </div>
          <a href="<?= base_url('user') ?>" class="inline-flex items-center gap-2 bg-white text-blue-600 px-6 py-3 rounded-xl font-bold shadow-lg hover:shadow-xl hover:bg-blue-50 transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
            </svg>
            Buat Pengaduan Baru
          </a>
        </div>
      </div>

      <!-- Info Card -->
      <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl shadow-2xl p-6 hover:scale-105 transition-transform duration-300 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
        <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/10 rounded-full -ml-12 -mb-12"></div>
        <div class="relative z-10 flex items-start gap-4">
          <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center flex-shrink-0">
            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
          </div>
          <div class="flex-1">
            <h3 class="text-lg font-bold mb-2 text-white">Informasi Penting</h3>
            <p class="text-emerald-100 text-sm mb-4 font-medium">Pengaduan Anda akan diproses maksimal 3x24 jam setelah diajukan.</p>
            <a href="<?= base_url('user/riwayat') ?>" class="inline-flex items-center gap-2 bg-white text-emerald-600 px-5 py-2.5 rounded-xl font-bold shadow-lg hover:shadow-xl hover:bg-emerald-50 transition-all">
              Lihat Riwayat
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
              </svg>
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- Recent Activity -->
    <?php if (!empty($pengaduan)): ?>
    <div class="bg-white rounded-xl shadow-2xl overflow-hidden">
      <div class="px-6 py-4 bg-ui-header">
        <h3 class="text-lg font-bold text-white">📋 Pengaduan Terbaru</h3>
      </div>
      <div class="divide-y divide-gray-100">
        <?php 
        $recent = array_slice($pengaduan, 0, 5);
        foreach ($recent as $p): 
          $statusClasses = [
            'diajukan' => 'badge-status-diajukan',
            'diproses' => 'badge-status-diproses',
            'selesai'  => 'badge-status-selesai',
            'ditolak'  => 'badge-status-ditolak',
          ];
          $statusClass = $statusClasses[strtolower($p['status'])] ?? 'badge-ui';
        ?>
  <div class="px-6 py-4 hover:bg-blue-50 transition">
          <div class="flex items-center justify-between">
            <div class="flex-1">
              <h4 class="font-semibold text-gray-900"><?= esc($p['nama_pengaduan']) ?></h4>
              <p class="text-sm text-gray-600 mt-1">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <?= date('d M Y', strtotime($p['tgl_pengajuan'])) ?>
              </p>
            </div>
            <div class="flex items-center gap-3">
              <span class="text-xs <?= $statusClass ?> shadow-sm">
                <?= esc(ucfirst($p['status'])) ?>
              </span>
              <a href="<?= base_url('user/detail/' . $p['id_pengaduan']) ?>" class="btn-ui p-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
              </a>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
      <?php if (count($pengaduan) > 5): ?>
      <div class="px-6 py-4 bg-gray-50 text-center">
        <a href="<?= base_url('user/riwayat') ?>" class="text-ui-primary hover:underline font-bold text-sm inline-flex items-center gap-2">
          Lihat Semua Pengaduan 
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
          </svg>
        </a>
      </div>
      <?php endif; ?>
    </div>
    <?php else: ?>
    <!-- Empty State -->
    <div class="bg-white rounded-xl shadow-2xl p-12 text-center">
      <div class="w-24 h-24 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
        <svg class="w-12 h-12 text-ui-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
      </div>
      <h3 class="text-2xl font-bold text-gray-900 mb-2">Belum Ada Pengaduan</h3>
      <p class="text-gray-600 mb-6 text-lg">Mulai buat pengaduan pertama Anda sekarang</p>
      <a href="<?= base_url('user') ?>" class="btn-ui px-8 py-4 rounded-xl shadow-xl hover:shadow-2xl">
        Buat Pengaduan Sekarang
      </a>
    </div>
    <?php endif; ?>

  </div>
</div>
<?= $this->endSection() ?>
