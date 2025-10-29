<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Buat Pengaduan</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css'); ?>">
</head>
<body class="pengaduan-body">

<div class="pengaduan-form-container">
    <h2 class="pengaduan-title">Buat Pengaduan</h2>

    <form action="<?= base_url('petugas/pengaduan/store'); ?>" method="post" enctype="multipart/form-data" class="pengaduan-form">

        <label for="nama_pengaduan">Nama Pengaduan</label>
        <input type="text" id="nama_pengaduan" name="nama_pengaduan" placeholder="Masukkan nama pengaduan" required>

        <label for="deskripsi">Deskripsi</label>
        <textarea id="deskripsi" name="deskripsi" placeholder="Masukkan deskripsi pengaduan" required></textarea>

        <label for="lokasi">Lokasi Kejadian</label>
        <input type="text" id="lokasi" name="lokasi" placeholder="Masukkan lokasi kejadian" required>

        <label for="foto">Foto (opsional)</label>
        <input type="file" id="foto" name="foto" accept="image/*">

        <label for="status">Status</label>
        <select id="status" name="status" required>
            <option value="Diajukan">Diajukan</option>
            <option value="Diproses">Diproses</option>
            <option value="Selesai">Selesai</option>
        </select>

        <label for="id_user">Pilih User Pelapor</label>
        <select name="id_user" id="id_user" required>
            <option value="">-- Pilih User --</option>
            <?php foreach ($users as $user): ?>
                <option value="<?= esc($user['id_user']); ?>"><?= esc($user['nama_pengguna']); ?></option>
            <?php endforeach; ?>
        </select>

        <label for="id_item">ID Item (opsional)</label>
        <input type="number" id="id_item" name="id_item" placeholder="Masukkan ID Item">

        <label for="tgl_selesai">Tanggal Selesai (opsional)</label>
        <input type="datetime-local" id="tgl_selesai" name="tgl_selesai">

        <label for="saran_petugas">Saran Petugas (opsional)</label>
        <textarea id="saran_petugas" name="saran_petugas" placeholder="Masukkan saran petugas"></textarea>

        <button type="submit" class="pengaduan-btn">Kirim</button>
    </form>
</div>

</body>
</html>
