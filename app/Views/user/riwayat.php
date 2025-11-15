<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Riwayat Pengaduan
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="min-h-screen bg-ui-page py-8 px-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-1">
                        📋 Riwayat Pengaduan
                    </h1>
                    <p class="text-gray-600 font-medium">Lihat status dan detail pengaduan Anda</p>
                </div>

            </div>
        </div>

        <!-- Content Section -->
        <?php if (empty($pengaduan)): ?>
            <!-- Empty State -->
            <div class="bg-white rounded-3xl shadow-2xl p-12 text-center">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-blue-100 rounded-full mb-4 shadow-lg">
                    <svg class="w-12 h-12 text-ui-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Belum Ada Pengaduan</h3>
                <p class="text-gray-600 text-lg mb-6">Anda belum membuat pengaduan apapun</p>
                <a href="<?= base_url('user') ?>" class="btn-ui inline-flex items-center gap-2 px-8 py-4 rounded-xl shadow-xl hover:shadow-2xl font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    Buat Pengaduan
                </a>
            </div>
        <?php else: ?>
            <!-- Desktop Table View (hidden on mobile) -->
            <div class="hidden lg:block bg-white rounded-3xl shadow-2xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-ui-header">
                                <th class="px-6 py-4 text-left text-sm font-bold text-white">#</th>
                                <th class="px-6 py-4 text-left text-sm font-bold text-white">Nama Pengaduan</th>
                                <th class="px-6 py-4 text-left text-sm font-bold text-white">Status</th>
                                <th class="px-6 py-4 text-left text-sm font-bold text-white">Tanggal</th>
                                <th class="px-6 py-4 text-left text-sm font-bold text-white">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php foreach ($pengaduan as $key => $p): 
                                $rawStatus = strtolower(trim($p['status'] ?? ''));
                                $statusConfig = [
                                    'diajukan'  => ['class' => 'badge-status-diajukan', 'icon' => '⏳'],
                                    'diproses'  => ['class' => 'badge-status-diproses', 'icon' => '⚙️'],
                                    'disetujui' => ['class' => 'badge-status-selesai', 'icon' => '✓'],
                                    'selesai'   => ['class' => 'badge-status-selesai', 'icon' => '✓'],
                                    'ditolak'   => ['class' => 'badge-status-ditolak', 'icon' => '✗'],
                                ];
                                $status = $statusConfig[$rawStatus] ?? ['class' => 'badge-ui', 'icon' => '•'];
                            ?>
                            <tr class="hover:bg-blue-50 transition">
                                <td class="px-6 py-4 text-gray-700 font-semibold"><?= $key + 1 ?></td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-900"><?= esc($p['nama_pengaduan']) ?></div>
                                    <div class="text-sm text-gray-500">📍 <?= esc($p['nama_lokasi'] ?? $p['lokasi'] ?? '-') ?></div>
                                    <div class="text-sm text-gray-500 mt-1">🔧 Item: <?= esc($p['nama_item'] ?? ($p['id_temporary'] ? 'Barang baru (menunggu persetujuan)' : '-')) ?></div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1 text-xs font-bold <?= $status['class'] ?> shadow-sm px-3 py-1 rounded-lg">
                                        <span><?= $status['icon'] ?></span>
                                        <?= esc(ucfirst($rawStatus ?: $p['status'])) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-700 font-medium"><?= date('d M Y', strtotime($p['tgl_pengajuan'])) ?></td>
                                <td class="px-6 py-4">
                                    <a href="<?= base_url('user/detail/' . $p['id_pengaduan']) ?>" 
                                       class="btn-ui inline-flex items-center gap-2 px-5 py-2 text-sm font-bold">
                                        Detail
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Mobile Card View (visible on mobile only) -->
            <div class="lg:hidden space-y-4">
                <?php foreach ($pengaduan as $key => $p): 
                    $rawStatus = strtolower(trim($p['status'] ?? ''));
                    $statusConfig = [
                        'diajukan'  => ['class' => 'badge-status-diajukan', 'icon' => '⏳'],
                        'diproses'  => ['class' => 'badge-status-diproses', 'icon' => '⚙️'],
                        'disetujui' => ['class' => 'badge-status-selesai', 'icon' => '✓'],
                        'selesai'   => ['class' => 'badge-status-selesai', 'icon' => '✓'],
                        'ditolak'   => ['class' => 'badge-status-ditolak', 'icon' => '✗'],
                    ];
                    $status = $statusConfig[$rawStatus] ?? ['class' => 'badge-ui', 'icon' => '•'];
                ?>
                <div class="bg-white rounded-2xl shadow-xl hover:shadow-2xl transition">
                    <div class="p-4">
                        <div class="flex items-start justify-between mb-2">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="inline-flex items-center justify-center w-6 h-6 bg-gray-100 text-gray-600 rounded-full text-xs font-bold">
                                        <?= $key + 1 ?>
                                    </span>
                                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium <?= $status['class'] ?>">
                                        <span><?= $status['icon'] ?></span>
                                        <?= esc(ucfirst($rawStatus ?: $p['status'])) ?>
                                    </span>
                                </div>
                                <h3 class="text-base font-bold text-gray-800 mb-1"><?= esc($p['nama_pengaduan']) ?></h3>
                                <p class="text-xs text-gray-500">📍 <?= esc($p['nama_lokasi'] ?? $p['lokasi'] ?? 'Lokasi tidak tersedia') ?></p>
                                <p class="text-xs text-gray-500 mt-1">🔧 Item: <?= esc($p['nama_item'] ?? ($p['id_temporary'] ? 'Barang baru (menunggu persetujuan)' : '-')) ?></p>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-1 text-xs text-gray-500 mb-3">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <?= date('d M Y', strtotime($p['tgl_pengajuan'])) ?>
                        </div>
                        
                        <a href="<?= base_url('user/detail/' . $p['id_pengaduan']) ?>" 
                           class="btn-ui flex items-center justify-center gap-2 w-full px-5 py-3 font-bold">
                            Lihat Detail
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
                <?php endforeach ?>
            </div>
        <?php endif ?>
    </div>
</div>
<?= $this->endSection() ?>
