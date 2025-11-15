<?= $this->extend('layout/admin') ?>

<?= $this->section('title') ?>
Edit Item
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="min-h-screen bg-ui-page py-8 px-4 sm:px-6 lg:px-8">
  <div class="max-w-3xl mx-auto">
    
    <!-- Header -->
    <div class="mb-6">
      <h1 class="text-3xl font-bold text-white drop-shadow-lg mb-2">
        🔧 Edit Item
      </h1>
      <p class="text-indigo-100 font-medium">Perbarui informasi item sarana/prasarana</p>
    </div>

    <!-- Form Card -->
    <div class="bg-white/90 backdrop-blur-md rounded-2xl shadow-2xl p-8 border border-white/30">
      <form action="<?= base_url('admin/items/update/'.$item['id_item']); ?>" method="post" enctype="multipart/form-data" class="space-y-6">
        
        <!-- Nama Item -->
        <div>
          <label for="nama_item" class="block text-gray-700 font-bold mb-2 text-sm">Nama Item</label>
          <input type="text" id="nama_item" name="nama_item" value="<?= esc($item['nama_item']); ?>" placeholder="Contoh: Kursi Kelas"
                 class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all font-medium" required>
        </div>

        <!-- Lokasi (Multiple Select) -->
        <div>
          <label class="block text-gray-700 font-bold mb-2 text-sm">
            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Tersedia di Lokasi <span class="text-red-500">*</span>
          </label>
          <p class="text-xs text-gray-500 mb-2">Pilih satu atau lebih lokasi dimana item ini tersedia</p>
          <div class="border-2 border-gray-200 rounded-xl p-4 max-h-60 overflow-y-auto space-y-2">
            <?php if(empty($lokasi)): ?>
              <p class="text-gray-500 text-sm italic">Belum ada data lokasi.</p>
            <?php else: ?>
              <?php foreach($lokasi as $lok): ?>
                <label class="flex items-center gap-3 p-3 hover:bg-blue-50 rounded-lg cursor-pointer transition-colors">
                  <input 
                    type="checkbox" 
                    name="lokasi_ids[]" 
                    value="<?= $lok['id_lokasi'] ?>"
                    <?= in_array($lok['id_lokasi'], $selected_lokasi ?? []) ? 'checked' : '' ?>
                    class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                  >
                  <span class="text-gray-700 font-medium">📍 <?= esc($lok['nama_lokasi']) ?></span>
                </label>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
        </div>

        <!-- Deskripsi -->
        <div>
          <label for="deskripsi" class="block text-gray-700 font-bold mb-2 text-sm">Deskripsi</label>
          <textarea id="deskripsi" name="deskripsi" rows="4" placeholder="Jelaskan detail item..."
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all font-medium" required><?= esc($item['deskripsi']); ?></textarea>
        </div>

        <!-- Foto Current -->
        <?php if (!empty($item['foto'])): ?>
          <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
            <p class="text-sm font-bold text-gray-700 mb-3">Foto Saat Ini:</p>
            <img src="<?= base_url('uploads/foto_items/'.$item['foto']); ?>" alt="<?= esc($item['nama_item']); ?>" class="w-32 h-32 object-cover rounded-xl shadow-md">
          </div>
        <?php endif; ?>

        <!-- Upload Foto Baru -->
        <div>
          <label for="foto" class="block text-gray-700 font-bold mb-2 text-sm">Ganti Foto (opsional)</label>
          <input type="file" id="foto" name="foto" accept="image/*"
                 class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all font-medium file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 file:font-semibold hover:file:bg-blue-100">
        </div>

        <!-- Submit Button -->
        <div class="flex gap-4 pt-4">
          <button type="submit"
                  class="flex-1 btn-ui py-3.5">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
            </svg>
            <span>Update Item</span>
          </button>
          <a href="<?= base_url('admin/items') ?>"
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
