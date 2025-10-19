<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Riwayat Pengaduan
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <h3 class="text-primary mb-4">Riwayat Pengaduan Saya</h3>

    <?php if (empty($pengaduan)): ?>
        <p class="text-muted">Belum ada pengaduan.</p>
    <?php else: ?>
        <table class="table table-bordered table-striped">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Nama Pengaduan</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pengaduan as $key => $p): ?>
                    <tr>
                        <td><?= $key + 1 ?></td>
                        <td><?= esc($p['nama_pengaduan']) ?></td>
                        <td><span class="badge bg-info"><?= esc($p['status']) ?></span></td>
                        <td><?= date('d-m-Y', strtotime($p['tgl_pengajuan'])) ?></td>
                        <td>
                            <a href="<?= base_url('user/detail/' . $p['id_pengaduan']) ?>" class="btn btn-sm btn-primary">Detail</a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php endif ?>
</div>
<?= $this->endSection() ?>
