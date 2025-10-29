<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Pengaduan</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css'); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body class="user-admin-body">
    <div class="user-admin-container">
        <div class="user-admin-header">
            <h2>📋 Daftar Pengaduan</h2>
            <a href="<?= base_url('dashboard/admin') ?>" class="riwayat-btn-back">← Kembali</a>
        </div>

        <a href="<?= base_url('admin/pengaduan/create') ?>" class="user-admin-btn">+ Tambah Pengaduan</a>

        <table class="user-admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Pengaduan</th>
                    <th>Deskripsi</th>
                    <th>Lokasi</th>
                    <th>Foto</th>
                    <th>Status</th>
                    <th>Petugas</th>
                    <th>Item</th>
                    <th>Tgl Pengajuan</th>
                    <th>Tgl Selesai</th>
                    <th>Saran Petugas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($pengaduan)): ?>
                <?php foreach($pengaduan as $p): ?>
                <tr>
                    <td><?= $p['id_pengaduan']; ?></td>
                    <td><?= esc($p['nama_pengaduan']); ?></td>
                    <td><?= esc($p['deskripsi']); ?></td>
                    <td><?= esc($p['lokasi']); ?></td>
                    <td>
                        <?php if(!empty($p['foto'])): ?>
                            <img src="<?= base_url('uploads/'.$p['foto']); ?>" alt="Foto" class="table-img">
                        <?php else: ?>
                            <em>-</em>
                        <?php endif; ?>
                    </td>
                    <td><span class="status-badge <?= strtolower($p['status']); ?>"><?= esc($p['status']); ?></span></td>
                    <td><?= esc($p['id_petugas'] ?? '-'); ?></td>
                    <td><?= esc($p['id_item'] ?? '-'); ?></td>
                    <td><?= esc($p['tgl_pengajuan']); ?></td>
                    <td><?= esc($p['tgl_selesai'] ?? '-'); ?></td>
                    <td><?= !empty($p['saran_petugas']) ? esc($p['saran_petugas']) : '<em>-</em>'; ?></td>
                    <td class="aksi-col action-col">
                        <a href="<?= base_url('admin/pengaduan/edit/'.$p['id_pengaduan']); ?>" class="btn-action edit">Edit</a>
                        <a href="<?= base_url('admin/pengaduan/delete/'.$p['id_pengaduan']); ?>" onclick="return confirm('Yakin hapus pengaduan ini?')" class="btn-action delete">Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                <tr><td colspan="12" style="text-align:center;">Tidak ada pengaduan.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Popup Success -->
    <div id="popup-success" class="popup-success hidden">
        <div class="popup-content">
            <div class="popup-checkmark">✔</div>
            <p id="popup-message">Berhasil!</p>
        </div>
    </div>

    <script>
        function showSuccessPopup(message = "Berhasil!") {
            const popup = document.getElementById('popup-success');
            const msg = document.getElementById('popup-message');
            msg.textContent = message;
            popup.classList.remove('hidden');
            popup.classList.add('show');

            setTimeout(() => popup.classList.remove('show'), 2500);
        }

        <?php if(session()->getFlashdata('success')): ?>
        document.addEventListener('DOMContentLoaded', () => {
            showSuccessPopup("<?= session()->getFlashdata('success'); ?>");
        });
        <?php endif; ?>
    </script>
</body>
</html>
