<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Pengaduan</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css'); ?>">
</head>
<body class="pengaduan-body">

<div class="pengaduan-form-container">
    <h2 class="pengaduan-title">Edit Pengaduan</h2>

    <?php
        $tglSelesaiValue = '';
        if (!empty($pengaduan['tgl_selesai'])) {
            $tglSelesaiValue = date('Y-m-d\TH:i', strtotime($pengaduan['tgl_selesai']));
        }
    ?>

    <form action="<?= base_url('petugas/pengaduan/update/'.$pengaduan['id_pengaduan']); ?>" method="post" enctype="multipart/form-data" class="pengaduan-form">

        <label for="nama_pengaduan">Nama Pengaduan</label>
        <input type="text" id="nama_pengaduan" name="nama_pengaduan" value="<?= esc($pengaduan['nama_pengaduan']); ?>" required>

        <label for="deskripsi">Deskripsi</label>
        <textarea id="deskripsi" name="deskripsi" required><?= esc($pengaduan['deskripsi']); ?></textarea>

        <label for="lokasi">Lokasi Kejadian</label>
        <input type="text" id="lokasi" name="lokasi" value="<?= esc($pengaduan['lokasi']); ?>" required>

        <?php if(!empty($pengaduan['foto'])): ?>
            <p>Foto Saat Ini:</p>
            <img src="<?= base_url('uploads/foto_pengaduan/'.$pengaduan['foto']); ?>" alt="foto" width="100">
        <?php endif; ?>

        <label for="foto">Ganti Foto (opsional)</label>
        <input type="file" id="foto" name="foto" accept="image/*">

        <label for="status">Status</label>
        <select id="status" name="status" required>
            <option value="Diajukan" <?= $pengaduan['status']=='Diajukan'?'selected':''; ?>>Diajukan</option>
            <option value="Diproses" <?= $pengaduan['status']=='Diproses'?'selected':''; ?>>Diproses</option>
            <option value="Selesai" <?= $pengaduan['status']=='Selesai'?'selected':''; ?>>Selesai</option>
        </select>

        <label for="id_user">Pilih User Pelapor</label>
        <select name="id_user" id="id_user" required>
            <?php foreach ($users as $user): ?>
                <option value="<?= esc($user['id_user']); ?>" <?= $user['id_user'] == $pengaduan['id_user'] ? 'selected' : '' ?>>
                    <?= esc($user['nama_pengguna']); ?> (ID: <?= esc($user['id_user']); ?>)
                </option>
            <?php endforeach; ?>
        </select>

        <label for="id_item">ID Item (opsional)</label>
        <input type="number" id="id_item" name="id_item" value="<?= esc($pengaduan['id_item'] ?? ''); ?>">

        <label for="tgl_selesai">Tanggal Selesai (opsional)</label>
        <input type="datetime-local" id="tgl_selesai" name="tgl_selesai" value="<?= $tglSelesaiValue; ?>">

        <label for="saran_petugas">Saran Petugas</label>
        <textarea id="saran_petugas" name="saran_petugas"><?= esc($pengaduan['saran_petugas'] ?? ''); ?></textarea>

        <button type="submit" class="pengaduan-btn">Update</button>
    </form>
</div>

</body>
</html>
