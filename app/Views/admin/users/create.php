<?= $this->extend('layout/admin') ?>

<?= $this->section('title') ?>
Tambah User Baru
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="min-h-screen bg-ui-page py-8 px-4 sm:px-6 lg:px-8">
  <div class="max-w-3xl mx-auto">
    
    <!-- Header -->
    <div class="mb-6">
      <h1 class="text-3xl font-bold text-gray-900 mb-2">
        ➕ Tambah User Baru
      </h1>
      <p class="text-gray-600 font-medium">Tambahkan pengguna baru ke sistem</p>
    </div>

    <!-- Success/Error Messages -->
    <?php if(session()->getFlashdata('success')): ?>
      <div class="bg-green-50 border border-green-200 text-green-700 px-5 py-4 rounded-xl mb-6 flex items-center gap-3 shadow-lg">
        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <span class="font-medium"><?= session()->getFlashdata('success') ?></span>
      </div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>
      <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-xl mb-6 flex items-center gap-3 shadow-lg">
        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <span class="font-medium"><?= session()->getFlashdata('error') ?></span>
      </div>
    <?php endif; ?>

    <!-- Form Card -->
    <div class="bg-white/90 backdrop-blur-md rounded-2xl shadow-2xl p-8 border border-white/30">
      <form action="<?= base_url('admin/users/store') ?>" method="post" class="space-y-6">
        
        <!-- Username -->
        <div>
          <label class="block text-sm font-bold text-gray-700 mb-2">
            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            Username
          </label>
          <input 
            type="text" 
            name="username" 
            placeholder="Masukkan username" 
            required
            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
          >
        </div>

        <!-- Password -->
        <div>
          <label class="block text-sm font-bold text-gray-700 mb-2">
            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
            Password
          </label>
          <input 
            type="password" 
            name="password" 
            placeholder="Masukkan password" 
            required
            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
          >
        </div>

        <!-- Nama Lengkap -->
        <div>
          <label class="block text-sm font-bold text-gray-700 mb-2">
            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Nama Lengkap
          </label>
          <input 
            type="text" 
            name="nama_pengguna" 
            placeholder="Masukkan nama lengkap" 
            required
            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
          >
        </div>

        <!-- Role -->
        <div>
          <label class="block text-sm font-bold text-gray-700 mb-2">
            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
            Role / Peran
          </label>
          <select 
            name="role" 
            required
            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all bg-white"
          >
            <option value="" disabled selected>Pilih Role</option>
            <option value="admin">👨‍💼 Admin</option>
            <option value="petugas">🔧 Petugas</option>
            <option value="user">� User</option>
          </select>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-3 pt-4">
          <button 
            type="submit" 
            class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-6 py-3 rounded-xl font-bold shadow-lg hover:shadow-xl transition-all flex items-center justify-center gap-2"
          >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            Simpan
          </button>
          <a 
            href="<?= base_url('admin/users') ?>" 
            class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-xl font-bold shadow-lg hover:shadow-xl transition-all flex items-center justify-center gap-2"
          >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            Batal
          </a>
        </div>
      </form>
    </div>
  </div>
</div>
<?= $this->endSection() ?>