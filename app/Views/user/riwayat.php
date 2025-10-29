<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Riwayat Pengaduan
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
<div class="riwayat-container">
    <div class="riwayat-header">
        <h3 class="riwayat-title">Riwayat Pengaduan Saya</h3>
        <?php 
        // pastikan tombol kembali sesuai route dashboard yang ada
        $role = session()->get('role') ?? 'siswa';
        // mapping role ke route dashboard
        $dashboardRoutes = [
            'siswa' => 'siswa/dashboard',
            'guru'  => 'guru/dashboard',
        ];
        $dashboardUrl = isset($dashboardRoutes[$role]) ? base_url($dashboardRoutes[$role]) : base_url('/');
        ?>
        <a href="<?= $dashboardUrl ?>" class="riwayat-btn-back">← Kembali</a>
    </div>

    <?php if (empty($pengaduan)): ?>
        <p class="riwayat-empty">Belum ada pengaduan.</p>
    <?php else: ?>
        <div class="riwayat-table-wrapper">
            <table class="riwayat-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Pengaduan</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pengaduan as $key => $p): 
                        $rawStatus = strtolower(trim($p['status'] ?? ''));
                        $statusMap = [
                            'diajukan'  => 'riwayat-badge-ajukan',
                            'diproses'  => 'riwayat-badge-proses',
                            'disetujui' => 'riwayat-badge-setuju',
                            'selesai'   => 'riwayat-badge-setuju',
                        ];
                        $badgeClass = $statusMap[$rawStatus] ?? 'riwayat-badge-lain';
                    ?>
                        <tr>
                            <td><?= $key + 1 ?></td>
                            <td><?= esc($p['nama_pengaduan']) ?></td>
                            <td>
                                <span class="riwayat-badge <?= $badgeClass ?>">
                                    <?= esc(ucfirst($rawStatus ?: $p['status'])) ?>
                                </span>
                            </td>
                            <td><?= date('d-m-Y', strtotime($p['tgl_pengajuan'])) ?></td>
                            <td>
                                <a href="<?= base_url('user/detail/' . $p['id_pengaduan']) ?>" class="riwayat-btn">Detail</a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    <?php endif ?>
</div>
<?= $this->endSection() ?>
