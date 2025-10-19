<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Item Baru</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css'); ?>">
</head>
<body class="pengaduan-body">

<div class="pengaduan-form-container">
    <h2 class="pengaduan-title">Tambah Item Baru</h2>

    <form action="<?= base_url('admin/items/store'); ?>" method="post" enctype="multipart/form-data" class="pengaduan-form">

        <label for="nama_item">Nama Item</label>
        <input type="text" id="nama_item" name="nama_item" placeholder="Masukkan nama item" required>

        <label for="lokasi">Lokasi</label>
        <input type="text" id="lokasi" name="lokasi" placeholder="Masukkan lokasi item" required>

        <label for="deskripsi">Deskripsi</label>
        <textarea id="deskripsi" name="deskripsi" placeholder="Masukkan deskripsi item" required></textarea>

        <label for="foto">Foto</label>
        <input type="file" id="foto" name="foto" accept="image/*">

        <button type="submit" class="pengaduan-btn">Simpan</button>
    </form>
</div>

</body>
</html>
