<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Edit Profil
<?= $this->endSection() ?>

<?= $this->section('head') ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php
$user = $user ?? [];
$nama_pengguna = $user['nama_pengguna'] ?? '';
$username = $user['username'] ?? '';
$foto = $user['foto'] ?? null;
$profileImg = $foto && $foto !== 'default.png' ? base_url('uploads/foto_user/' . $foto) : 'https://via.placeholder.com/150';
?>

<div class="min-h-screen bg-ui-page py-8 px-6">
  <div class="max-w-7xl mx-auto">
    
    <!-- Header -->
    <div class="mb-6 flex justify-between items-center">
      <div>
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-1">👤 Edit Profil</h1>
        <p class="text-gray-600">Perbarui informasi akun Anda</p>
      </div>

    </div>

    <!-- Form Profile -->
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl mx-auto p-8">
      <h2 class="text-3xl font-bold text-blue-600 mb-6 text-center">Informasi Akun</h2>

      <?php if (session()->getFlashdata('success')): ?>
        <div class="bg-green-50 text-green-700 px-5 py-3 rounded-xl mb-4 text-center shadow-lg font-medium">
          <i class="fas fa-check-circle mr-2"></i>
          <?= session()->getFlashdata('success') ?>
        </div>
      <?php endif; ?>

      <?php if (session()->getFlashdata('error')): ?>
        <div class="bg-red-50 text-red-700 px-5 py-3 rounded-xl mb-4 text-center shadow-lg font-medium">
          <i class="fas fa-exclamation-circle mr-2"></i>
          <?= session()->getFlashdata('error') ?>
        </div>
      <?php endif; ?>

  <form id="profile-form" action="<?= base_url('user/profile/update') ?>" method="post" enctype="multipart/form-data" class="flex flex-col gap-6">
      <?= csrf_field() ?>

      <!-- Foto Profile -->
      <div class="flex flex-col items-center gap-2">
        <div class="relative w-36 h-36">
          <img id="preview-img" src="<?= $profileImg ?>" alt="Profile" class="w-36 h-36 object-cover rounded-full border-4 border-blue-300 shadow-xl">
          <button type="button" id="pick-photo" class="absolute bottom-0 right-0 bg-blue-600 text-white w-12 h-12 rounded-full flex items-center justify-center shadow-xl hover:bg-blue-700 transition">
            <i class="fa-solid fa-camera text-lg"></i>
          </button>
          <input type="file" name="profile_image" id="profile_image" accept="image/*" hidden>
        </div>
      </div>

      <!-- Nama Pengguna -->
      <div class="flex flex-col">
        <label class="mb-2 text-sm font-bold text-gray-700">📝 Nama Pengguna</label>
        <input type="text" name="nama_pengguna" value="<?= esc($nama_pengguna) ?>" required
               class="px-4 py-3 rounded-xl border-2 border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition font-medium">
      </div>

      <!-- Username -->
      <div class="flex flex-col">
        <label class="mb-2 text-sm font-bold text-gray-700">👤 Username</label>
        <input type="text" name="username" value="<?= esc($username) ?>" required
               class="px-4 py-3 rounded-xl border-2 border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition font-medium">
      </div>

      <!-- Password -->
      <div class="flex flex-col">
        <label class="mb-2 text-sm font-bold text-gray-700">🔒 Password (opsional)</label>
        <input type="password" name="password" id="password-input" placeholder="Isi jika ingin mengganti"
               minlength="6"
               class="px-4 py-3 rounded-xl border-2 border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition font-medium">
        <p id="password-help" class="text-xs text-gray-500 mt-2">Kosongkan jika tidak ingin mengganti. Jika diisi, minimal 6 karakter.</p>
        <p id="password-error" class="text-xs text-red-600 mt-2 hidden">Password harus minimal 6 karakter.</p>
      </div>

      <!-- Submit Button -->
      <div class="flex gap-3">
        <button type="submit" class="flex-1 btn-ui px-6 py-3.5">
          <i class="fas fa-save mr-2"></i>Simpan Perubahan
        </button>
        <?php 
          $role = session()->get('role') ?? 'siswa';
          $dashboardRoutes = [
            'siswa' => 'siswa/dashboard',
            'guru'  => 'guru/dashboard',
          ];
          $dashboardUrl = isset($dashboardRoutes[$role]) ? base_url($dashboardRoutes[$role]) : base_url('/');
        ?>
        <a href="<?= $dashboardUrl ?>" class="px-6 py-3.5 bg-gray-200 text-gray-700 font-bold rounded-xl shadow-lg hover:bg-gray-300 hover:shadow-xl transition">
          Batal
        </a>
      </div>
      </form>
    </div>
  </div>
</div>

<?= $this->section('scripts') ?>
<script>
  // Klik tombol camera → pilih file
  document.getElementById("pick-photo").addEventListener("click", () => {
      document.getElementById("profile_image").click();
  });

  // Preview foto langsung
  document.getElementById("profile_image").addEventListener("change", (event) => {
      let file = event.target.files[0];
      if(file) {
          document.getElementById("preview-img").src = URL.createObjectURL(file);
      }
  });

  // Client-side validation for password length (optional)
  document.getElementById('profile-form').addEventListener('submit', function (e) {
    const pwd = document.getElementById('password-input').value || '';
    const errEl = document.getElementById('password-error');
    if (pwd.length > 0 && pwd.length < 6) {
      // show error and prevent submit
      errEl.classList.remove('hidden');
      e.preventDefault();
      return false;
    } else {
      errEl.classList.add('hidden');
    }
  });
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>
