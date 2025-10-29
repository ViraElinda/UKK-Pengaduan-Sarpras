<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Generate Laporan Pengaduan</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css'); ?>">
</head>

<body class="user-admin-body">
  <div class="user-admin-container">
    <div class="user-admin-header">
      <h2>Generate Laporan Pengaduan</h2>
      <a href="<?= base_url('dashboard/admin') ?>" class="riwayat-btn-back">← Kembali</a>
    </div>

    <?php if(session()->getFlashdata('error')): ?>
      <p style="color:red; margin-top:12px"><?= session()->getFlashdata('error') ?></p>
    <?php endif; ?>

  <form action="<?= base_url('admin/laporan/preview') ?>" method="post" class="pengaduan-form" style="margin-top:14px">
      <label for="tgl_mulai">Tanggal Mulai</label>
      <input type="datetime-local" id="tgl_mulai" name="tgl_mulai" required>

      <label for="tgl_selesai">Tanggal Selesai</label>
      <input type="datetime-local" id="tgl_selesai" name="tgl_selesai" required>

      <button type="submit" class="user-admin-btn" style="margin-top:10px">Tampilkan Laporan</button>
    </form>

  <!-- Info jumlah & Daftar pengaduan untuk referensi sebelum generate laporan -->
  <?php $count = isset($pengaduan) ? count($pengaduan) : 0; ?>
  <p style="margin-top:14px; color:#475569; font-weight:600">Menampilkan: <?= $count ?> pengaduan</p>
  <div class="user-admin-table-wrapper" style="margin-top:8px">
      <table class="user-admin-table">
        <thead>
          <tr>
            <th class="id-col">ID</th>
            <th>Nama Pengaduan</th>
            <th>Deskripsi</th>
            <th>Lokasi</th>
            <th class="foto-col">Foto</th>
            <th>Status</th>
            <th>Petugas</th>
            <th>Item</th>
            <th>Tgl Pengajuan</th>
            <th>Tgl Selesai</th>
            <th>Saran Petugas</th>
          </tr>
        </thead>
        <tbody>
          <?php if(!empty($pengaduan)): ?>
            <?php foreach($pengaduan as $p): ?>
            <tr>
              <td class="id-col" data-label="ID"><?= $p['id_pengaduan']; ?></td>
              <td data-label="Nama Pengaduan"><?= esc($p['nama_pengaduan']); ?></td>
              <td data-label="Deskripsi"><?= esc($p['deskripsi']); ?></td>
              <td data-label="Lokasi"><?= esc($p['lokasi']); ?></td>
              <td class="foto-col" data-label="Foto">
                <?php if(!empty($p['foto'])): ?>
                  <img src="<?= base_url('uploads/'.$p['foto']); ?>" alt="Foto" class="table-img">
                <?php else: ?>
                  <em>-</em>
                <?php endif; ?>
              </td>
              <td data-label="Status"><span class="status-badge <?= strtolower($p['status']); ?>"><?= esc($p['status']); ?></span></td>
              <td data-label="Petugas"><?= esc($p['id_petugas'] ?? '-'); ?></td>
              <td data-label="Item"><?= esc($p['id_item'] ?? '-'); ?></td>
              <td data-label="Tgl Pengajuan"><?= esc($p['tgl_pengajuan']); ?></td>
              <td data-label="Tgl Selesai"><?= esc($p['tgl_selesai'] ?? '-'); ?></td>
              <td data-label="Saran Petugas"><?= !empty($p['saran_petugas']) ? esc($p['saran_petugas']) : '<em>-</em>'; ?></td>
            </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr><td colspan="11"><em>Tidak ada pengaduan ditemukan.</em></td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
  <script>
    // Cek kalau ada flashdata sukses dari PHP
    <?php if(session()->getFlashdata('success')): ?>
        showSuccessPopup("<?= session()->getFlashdata('success'); ?>");
    <?php endif; ?>

    function showSuccessPopup(message) {
        // Buat element popup
        const popup = document.createElement('div');
        popup.classList.add('popup-success');
        popup.innerHTML = `
            <svg viewBox="0 0 24 24">
                <polyline points="20 6 9 17 4 12" />
            </svg>
            <span>${message}</span>
        `;
        document.body.appendChild(popup);

        // Hapus popup setelah animasi selesai
        setTimeout(() => {
            popup.remove();
        }, 3000);
    }
</script>
</body>
</html>
