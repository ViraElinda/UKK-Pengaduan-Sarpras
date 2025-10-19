<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Pengaduan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body class="pgdn-body">

<div class="pgdn-form-container">
    <h2>Buat Pengaduan</h2>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="pgdn-error">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif ?>

    <form action="<?= base_url('user/store') ?>" method="post" enctype="multipart/form-data">

        <label class="pgdn-label">Nama pengaduan</label>
        <input type="text" name="nama_pengaduan" value="<?= old('nama_pengaduan') ?>" class="pgdn-input" required>

        <label class="pgdn-label">Deskripsi</label>
        <textarea name="deskripsi" rows="4" class="pgdn-textarea" required><?= old('deskripsi') ?></textarea>

        <label class="pgdn-label">Lokasi</label>
        <input type="text" name="lokasi" value="<?= old('lokasi') ?>" class="pgdn-input" required>

        <label class="pgdn-label">Upload Foto (Opsional)</label>
        <input type="file" name="foto" accept="image/*" onchange="previewFoto(event)" class="pgdn-input">
        <img id="preview-image" class="pgdn-image-preview"/>

        <button type="submit" class="pgdn-button">Kirim Pengaduan</button>
    </form>
</div>

<script>
    function previewFoto(event) {
        const preview = document.getElementById('preview-image');
        const file = event.target.files[0];
        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        }
    }
</script>

</body>
</html>
