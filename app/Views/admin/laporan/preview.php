<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Preview Laporan</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css'); ?>">
</head>
<body class="pengaduan-body">
  <div class="pengaduan-form-container">
    <h2 class="pengaduan-title">Laporan: <?= esc($tgl_mulai) ?> → <?= esc($tgl_selesai) ?></h2>

    <table class="user-admin-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nama Pengaduan</th>
          <th>Tgl Pengajuan</th>
          <th>Status</th>
          <th>ID User</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($laporan as $row): ?>
        <tr>
          <td><?= esc($row['id_pengaduan']); ?></td>
          <td><?= esc($row['nama_pengaduan']); ?></td>
          <td><?= esc($row['tgl_pengajuan']); ?></td>
          <td><?= esc($row['status']); ?></td>
          <td><?= esc($row['id_user']); ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <a href="<?= base_url("admin/laporan/cetak/{$tgl_mulai}/{$tgl_selesai}") ?>" class="user-admin-btn">Cetak PDF</a>
  </div>
</body>
</html>
