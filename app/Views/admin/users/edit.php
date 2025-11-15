<?= $this->extend('layout/admin') ?>

<?= $this->section('title') ?>
Edit User
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="min-h-screen bg-ui-page py-8 px-4 sm:px-6 lg:px-8">
  <div class="max-w-3xl mx-auto">
    
    <!-- Header -->
    <div class="mb-6">
      <h1 class="text-3xl font-bold text-gray-900 mb-2">
        ✏️ Edit User
      </h1>
      <p class="text-gray-600 font-medium">Perbarui data pengguna</p>
    </div>

    <!-- Form Card -->
    <div class="bg-white/90 backdrop-blur-md rounded-2xl shadow-2xl p-8 border border-white/30">
      <form action="<?= base_url('admin/users/update/'.$user['id_user']); ?>" method="post" class="space-y-6">
        
        <!-- Username -->
        <div>
          <label for="username" class="block text-gray-700 font-bold mb-2 text-sm">Username</label>
          <input type="text" id="username" name="username" value="<?= esc($user['username']); ?>" placeholder="Masukkan username"
                 class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all font-medium" required>
        </div>

        <!-- Password -->
        <div>
          <label for="password" class="block text-gray-700 font-bold mb-2 text-sm">Password (opsional)</label>
          <input type="password" id="password" name="password" placeholder="Kosongkan jika tidak diubah"
                 class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all font-medium">
          <p class="text-xs text-gray-500 mt-1">💡 Kosongkan jika tidak ingin mengubah password</p>
        </div>

        <!-- Nama Pengguna -->
        <div>
          <label for="nama_pengguna" class="block text-gray-700 font-bold mb-2 text-sm">Nama Lengkap</label>
          <input type="text" id="nama_pengguna" name="nama_pengguna" value="<?= esc($user['nama_pengguna']); ?>" placeholder="Masukkan nama lengkap"
                 class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all font-medium" required>
        </div>

        <!-- Role -->
        <div>
          <label for="role" class="block text-gray-700 font-bold mb-2 text-sm">Role</label>
          <select id="role" name="role"
                  class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all font-medium" required>
            <option value="admin" <?= $user['role']=='admin'?'selected':''; ?>>👨‍💼 Admin</option>
            <option value="petugas" <?= $user['role']=='petugas'?'selected':''; ?>>🔧 Petugas</option>
            <option value="user" <?= $user['role']=='user'?'selected':''; ?>>👤 User</option>
          </select>
        </div>

        <!-- Submit Button -->
        <div class="flex gap-4 pt-4">
          <button type="submit"
                  class="flex-1 btn-ui py-3.5">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
            </svg>
            <span>Update User</span>
          </button>
          <a href="<?= base_url('admin/users') ?>"
             class="px-8 py-3.5 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold rounded-xl transition-all">
            Batal
          </a>
        </div>
      </form>
    </div>

  </div>
</div>

<script src="https://unpkg.com/lucide@latest"></script>
<script>
  lucide.createIcons();
</script>

<?= $this->endSection() ?>
