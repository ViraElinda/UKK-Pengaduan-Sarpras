<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Generate Laporan Pengaduan</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css'); ?>">
</head>
<body class="pengaduan-body">
  <div class="pengaduan-form-container">
    <h2 class="pengaduan-title">Generate Laporan Pengaduan</h2>

    <?php if(session()->getFlashdata('error')): ?>
      <p style="color:red;"><?= session()->getFlashdata('error') ?></p>
    <?php endif; ?>

    <form action="<?= base_url('admin/laporan/preview') ?>" method="post" class="pengaduan-form">
      <label for="tgl_mulai">Tanggal Mulai</label>
      <input type="datetime-local" id="tgl_mulai" name="tgl_mulai" required>

      <label for="tgl_selesai">Tanggal Selesai</label>
      <input type="datetime-local" id="tgl_selesai" name="tgl_selesai" required>

      <button type="submit" class="pengaduan-btn">Tampilkan Laporan</button>
    </form>
  </div>
</body>
</html>
