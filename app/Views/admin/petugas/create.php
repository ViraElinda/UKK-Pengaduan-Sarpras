<?= $this->extend('layout/admin') ?>

<?= $this->section('title') ?>
Tambah Petugas
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="min-h-screen bg-ui-page py-8 px-4 sm:px-6 lg:px-8">
  <div class="max-w-3xl mx-auto">
    <div class="mb-6">
      <h1 class="text-2xl font-bold">Tambah Petugas</h1>
      <p class="text-gray-600">Tambahkan petugas dan kaitkan ke akun pengguna (user) bila perlu.</p>
    </div>

    <div class="bg-white/90 rounded-xl shadow p-6">
      <form action="<?= base_url('admin/petugas/store'); ?>" method="post" class="space-y-4">
        <?= function_exists('csrf_field') ? csrf_field() : '' ?>

        <div>
          <label class="block text-sm font-bold mb-2">Akun</label>
          <select name="id_user" class="w-full px-4 py-3 rounded-xl border-2 border-gray-200">
            <option value="">-- Pilih Akun (role: petugas) --</option>
            <?php if (!empty($users)): foreach($users as $u): ?>
              <option value="<?= esc($u['id_user']) ?>"><?= esc($u['username']) ?> — <?= esc($u['nama_pengguna'] ?? '') ?></option>
            <?php endforeach; endif; ?>
          </select>
        </div>

        <div>
          <label class="block text-sm font-bold mb-2">Nama Petugas</label>
          <input type="text" name="nama" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl" required />
        </div>

        <div class="flex justify-end gap-2">
          <a href="<?= base_url('admin/petugas') ?>" class="px-4 py-2 bg-gray-200 rounded-lg">Batal</a>
          <button type="submit" class="btn-ui px-6 py-2">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
