<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<?= view('navbar/user') ?>
<div class="container mt-5">
    <h3 class="text-primary mb-4">Detail Pengaduan</h3>

    <table class="table table-bordered">
    <tr>
        <th>Judul Pengaduan</th>
        <td><?= esc($pengaduan['nama_pengaduan']) ?></td>
    </tr>
    <tr>
    <th>Deskripsi</th>
    <td><?= esc($pengaduan['deskripsi']) ?></td>
</tr>

    <tr>
        <th>Lokasi</th>
        <td><?= esc($pengaduan['lokasi']) ?></td>
    </tr>
    <tr>
        <th>Foto</th>
        <td>
            <?php if (!empty($pengaduan['foto'])): ?>
                <img src="<?= base_url('uploads/foto_pengaduan/' . $pengaduan['foto']) ?>" alt="Foto Pengaduan" style="max-width:300px;" class="img-thumbnail" />
            <?php else: ?>
                <span class="text-muted">Tidak ada foto</span>
            <?php endif ?>
        </td>
    </tr>
    <tr>
        <th>Status</th>
        <td><span class="badge bg-info"><?= esc($pengaduan['status']) ?></span></td>
    </tr>
    <tr>
        <th>Tanggal Pengajuan</th>
        <td><?= date('d-m-Y H:i', strtotime($pengaduan['tgl_pengajuan'])) ?></td>
    </tr>
    <tr>
        <th>Tanggal Selesai</th>
        <td>
            <?= !empty($pengaduan['tgl_selesai']) ? date('d-m-Y H:i', strtotime($pengaduan['tgl_selesai'])) : '-' ?>
        </td>
    </tr>
    <tr>
        <th>Saran Petugas</th>
        <td><?= !empty($pengaduan['saran_petugas']) ? esc($pengaduan['saran_petugas']) : '-' ?></td>
    </tr>
</table>


    <a href="<?= base_url('user/riwayat') ?>" class="btn btn-secondary mt-3">Kembali ke Riwayat</a>
</div>

<?= $this->endSection() ?>
