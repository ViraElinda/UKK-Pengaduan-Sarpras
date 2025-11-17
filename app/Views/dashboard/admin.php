<?= $this->extend('layout/admin') ?>

<?= $this->section('title') ?>
Dashboard Admin
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="min-h-screen bg-ui-page py-8 px-4 sm:px-6 lg:px-8">
  <div class="max-w-7xl mx-auto">
    <!-- Welcome -->
    <div class="mb-8">
      <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-2">
        👋 Selamat Datang, <span class="text-ui-primary font-extrabold"><?= $username ?></span>
      </h1>
      <p class="text-gray-600 font-medium">Sistem Pengaduan Sarana & Prasarana Sekolah</p>
      <p class="text-gray-500 text-xs mt-1">Hari ini: <?= date('l, d F Y'); ?> | Data diperbarui otomatis setiap 24 jam ⏰</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-5 mb-8">
  <div class="ui-card rounded-2xl shadow-2xl p-6 flex flex-col items-center hover:scale-105 transition-all">
        <i data-lucide="x-circle" class="text-ui-primary w-10 h-10 mb-2" stroke-width="2.5"></i>
        <h3 class="text-4xl font-extrabold text-gray-900 tracking-wide"><?= $aduan_ditolak ?></h3>
        <p class="text-muted text-base font-semibold mt-1">Ditolak</p>
      </div>
  <div class="ui-card rounded-2xl shadow-2xl p-6 flex flex-col items-center hover:scale-105 transition-all">
        <i data-lucide="send" class="text-ui-primary w-10 h-10 mb-2" stroke-width="2.5"></i>
        <h3 class="text-4xl font-extrabold text-gray-900 tracking-wide"><?= $aduan_diajukan ?></h3>
        <p class="text-muted text-base font-semibold mt-1">Diajukan</p>
      </div>
  <div class="ui-card rounded-2xl shadow-2xl p-6 flex flex-col items-center hover:scale-105 transition-all">
        <i data-lucide="check-square" class="text-ui-primary w-10 h-10 mb-2" stroke-width="2.5"></i>
        <h3 class="text-4xl font-extrabold text-gray-900 tracking-wide"><?= $aduan_disetujui ?></h3>
        <p class="text-muted text-base font-semibold mt-1">Disetujui</p>
      </div>
  <div class="ui-card rounded-2xl shadow-2xl p-6 flex flex-col items-center hover:scale-105 transition-all">
        <i data-lucide="clock" class="text-ui-primary w-10 h-10 mb-2" stroke-width="2.5"></i>
        <h3 class="text-4xl font-extrabold text-gray-900 tracking-wide"><?= $aduan_diproses ?></h3>
        <p class="text-muted text-base font-semibold mt-1">Diproses</p>
      </div>
  <div class="ui-card rounded-2xl shadow-2xl p-6 flex flex-col items-center hover:scale-105 transition-all">
        <i data-lucide="check-circle" class="text-ui-primary w-10 h-10 mb-2" stroke-width="2.5"></i>
        <h3 class="text-4xl font-extrabold text-gray-900 tracking-wide"><?= $aduan_selesai ?></h3>
        <p class="text-muted text-base font-semibold mt-1">Selesai</p>
      </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-xl p-6 border border-white/30">
        <h4 class="text-base font-bold text-ui-primary mb-4 flex items-center gap-2">📊 Statistik Pengaduan 7 Hari Terakhir</h4>
        <canvas id="chartBar" class="w-full h-56"></canvas>
      </div>
      <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-xl p-6 border border-white/30">
        <h4 class="text-base font-bold text-ui-primary mb-4 flex items-center gap-2">📈 Persentase Status Pengaduan</h4>
        <canvas id="chartDonut" class="w-full h-56"></canvas>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://unpkg.com/lucide@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  lucide.createIcons();

  // ===== Grafik Harian
  new Chart(document.getElementById('chartBar'), {
    type: 'bar',
    data: {
      labels: <?= $tanggal_harian ?>,
      datasets: [{
        label: 'Jumlah Pengaduan',
        data: <?= $jumlah_harian ?>,
        backgroundColor: [
          '#f43f5e', 
          '#0ea5e9', 
          '#8bf0ffff', 
          '#22c55e',
          '#f59e42', 
          '#eab308', 
          '#6366f1'  
        ],
        borderRadius: 10,
        borderWidth: 2,
        borderColor: '#fff',
      }]
    },
    options: {
      responsive: true,
      plugins: { legend: { display: false } },
      scales: {
        y: { beginAtZero: true, ticks: { color: '#2563eb', font: { weight: 'bold' } } },
        x: { ticks: { color: '#2563eb', font: { weight: 'bold' } } }
      }
    }
  });

  new Chart(document.getElementById('chartDonut'), {
    type: 'doughnut',
    data: {
      labels: ['Ditolak', 'Diajukan', 'Disetujui', 'Diproses', 'Selesai'],
      datasets: [{
        data: [
          <?= $aduan_ditolak ?>,
          <?= $aduan_diajukan ?>,
          <?= $aduan_disetujui ?>,
          <?= $aduan_diproses ?>,
          <?= $aduan_selesai ?>
        ],
        backgroundColor: [
          '#f43f5e', 
          '#0ea5e9', 
          '#22c55e', 
          '#eab308', 
          '#06b6d4'  
        ],
        borderWidth: 2,
        borderColor: '#fff',
      }]
    },
    options: {
      cutout: '70%',
      plugins: {
        legend: { position: 'bottom', labels: { color: '#2563eb', font: { weight: 'bold' } } }
      }
    }
  });
</script>
<?= $this->endSection() ?>
