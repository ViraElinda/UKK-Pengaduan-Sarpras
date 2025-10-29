<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Manajemen Item</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css'); ?>" />
</head>

<body class="user-admin-body">

    <div class="user-admin-container">
        <h2 class="user-admin-title">Daftar Item</h2>
        <a href="<?= base_url('admin/items/create'); ?>" class="user-admin-btn">Tambah Item</a>

        <?php if(session()->getFlashdata('success')): ?>
            <p class="user-admin-success"><?= session()->getFlashdata('success') ?></p>
        <?php endif; ?>

        <table class="user-admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Item</th>
                    <th>Lokasi</th>
                    <th>Deskripsi</th>
                    <th>Foto</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($items as $item): ?>
                <tr>
                    <td><?= $item['id_item']; ?></td>
                    <td><?= esc($item['nama_item']); ?></td>
                    <td><?= esc($item['lokasi']); ?></td>
                    <td><?= esc($item['deskripsi']); ?></td>
                    <td>
                        <?php if ($item['foto']): ?>
                            <img src="<?= base_url('uploads/foto_items/' . $item['foto']); ?>" alt="<?= esc($item['nama_item']); ?>" style="width:80px;">
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?= base_url('admin/items/edit/'.$item['id_item']); ?>" class="user-admin-btn-edit">Edit</a>
                        <a href="<?= base_url('admin/items/delete/'.$item['id_item']); ?>" onclick="return confirm('Yakin hapus item ini?')" class="user-admin-btn-delete">Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
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
