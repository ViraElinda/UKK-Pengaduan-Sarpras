<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Item</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css'); ?>">
</head>
<body class="pengaduan-body">

<div class="pengaduan-form-container">
    <h2 class="pengaduan-title">Edit Item</h2>

    <form action="<?= base_url('admin/items/update/'.$item['id_item']); ?>" method="post" enctype="multipart/form-data" class="pengaduan-form">

        <label for="nama_item">Nama Item</label>
        <input type="text" id="nama_item" name="nama_item" value="<?= esc($item['nama_item']); ?>" required>

        <label for="lokasi">Lokasi</label>
        <input type="text" id="lokasi" name="lokasi" value="<?= esc($item['lokasi']); ?>" required>

        <label for="deskripsi">Deskripsi</label>
        <textarea id="deskripsi" name="deskripsi" required><?= esc($item['deskripsi']); ?></textarea>

        <?php if ($item['foto']): ?>
            <label>Foto Saat Ini</label>
            <img src="<?= base_url('uploads/foto_items/'.$item['foto']); ?>" alt="<?= esc($item['nama_item']); ?>" style="width:120px; margin-bottom: 10px;">
        <?php endif; ?>

        <label for="foto">Ganti Foto (opsional)</label>
        <input type="file" name="foto" id="foto" accept="image/*">

        <button type="submit" class="pengaduan-btn">Update</button>
    </form>
</div>

</body>
</html>
