<?= $this->extend('layout/petugas') ?>

<?= $this->section('title') ?>
Buat Pengaduan
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mx-auto px-4 py-8">
  <div class="max-w-3xl mx-auto bg-white/90 rounded-2xl p-6 shadow-lg">
    <h2 class="text-2xl font-bold mb-4">Buat Pengaduan</h2>

    <form action="<?= base_url('petugas/pengaduan/store'); ?>" method="post" enctype="multipart/form-data" class="space-y-4">
        <?= csrf_field() ?>

        <div>
            <label for="nama_pengaduan" class="block text-sm font-bold mb-1">Nama Pengaduan</label>
            <input type="text" id="nama_pengaduan" name="nama_pengaduan" placeholder="Masukkan nama pengaduan" required class="w-full border rounded-lg px-3 py-2" />
        </div>

        <div>
            <label for="deskripsi" class="block text-sm font-bold mb-1">Deskripsi</label>
            <textarea id="deskripsi" name="deskripsi" placeholder="Masukkan deskripsi pengaduan" required class="w-full border rounded-lg px-3 py-2"></textarea>
        </div>

        <div>
            <label for="lokasi" class="block text-sm font-bold mb-1">Lokasi Kejadian</label>
            <input type="text" id="lokasi" name="lokasi" placeholder="Masukkan lokasi kejadian" required class="w-full border rounded-lg px-3 py-2" />
        </div>

        <div>
            <label for="foto" class="block text-sm font-bold mb-1">Foto (opsional)</label>
            <input type="file" id="foto" name="foto" accept="image/*" class="w-full" />
        </div>

        <div>
            <label for="status" class="block text-sm font-bold mb-1">Status</label>
            <select id="status" name="status" required class="w-full border rounded-lg px-3 py-2">
                <option value="Diajukan">Diajukan</option>
                <option value="Diproses">Diproses</option>
                <option value="Selesai">Selesai</option>
            </select>
        </div>

        <div>
            <label for="id_user" class="block text-sm font-bold mb-1">Pilih User Pelapor</label>
            <select name="id_user" id="id_user" required class="w-full border rounded-lg px-3 py-2">
                <option value="">-- Pilih User --</option>
                <?php if (!empty($users)): foreach ($users as $user): ?>
                    <option value="<?= esc($user['id_user']); ?>"><?= esc($user['nama_pengguna']); ?></option>
                <?php endforeach; endif; ?>
            </select>
        </div>

        <div>
            <label for="id_item" class="block text-sm font-bold mb-1">ID Item (opsional)</label>
            <input type="number" id="id_item" name="id_item" placeholder="Masukkan ID Item" class="w-full border rounded-lg px-3 py-2" />
        </div>

        <div>
            <label for="tgl_selesai" class="block text-sm font-bold mb-1">Tanggal Selesai (opsional)</label>
            <input type="datetime-local" id="tgl_selesai" name="tgl_selesai" class="w-full border rounded-lg px-3 py-2" />
        </div>

        <div>
            <label for="saran_petugas" class="block text-sm font-bold mb-1">Saran Petugas (opsional)</label>
            <textarea id="saran_petugas" name="saran_petugas" placeholder="Masukkan saran petugas" class="w-full border rounded-lg px-3 py-2"></textarea>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="btn-ui px-4 py-2">Kirim</button>
            <a href="<?= base_url('petugas/pengaduan') ?>" class="px-4 py-2 bg-gray-200 rounded-lg">Batal</a>
        </div>
    </form>
  </div>
</div>
<?= $this->endSection() ?>
