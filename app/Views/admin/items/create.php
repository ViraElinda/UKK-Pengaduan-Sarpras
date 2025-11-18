<?= $this->extend('layout/admin') ?>

<?= $this->section('title') ?>
Tambah Item Baru
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="min-h-screen bg-ui-page py-8 px-4 sm:px-6 lg:px-8">
  <div class="max-w-3xl mx-auto">
    
    <!-- Header (compact) -->
    <div class="mb-4">
      <h1 class="text-2xl font-semibold text-gray-900 mb-1">Tambah Item Sarpras</h1>
      <p class="text-sm text-gray-600">Tambahkan sarana dan prasarana baru ke sistem</p>
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

    <!-- Form Card (compact) -->
    <div class="bg-white/90 rounded-lg shadow p-4 border border-gray-100">
      <form action="<?= base_url('admin/items/store') ?>" method="post" enctype="multipart/form-data" class="space-y-4">
        
        <!-- Nama Item -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Nama Item <span class="text-red-500">*</span></label>
          <input 
            type="text" 
            name="nama_item" 
            placeholder="Contoh: Meja Belajar, Kursi Lipat, Proyektor" 
            required
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all text-sm"
          >
        </div>

        <!-- Lokasi (Multiple Select) -->
        <div>
          <label class="block text-sm font-bold text-gray-700 mb-2">
            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Tersedia di Lokasi <span class="text-red-500">*</span>
          </label>
          <p class="text-xs text-gray-500 mb-2">Pilih satu atau lebih lokasi dimana item ini tersedia</p>
          <div class="border border-gray-300 rounded-md p-3 max-h-56 overflow-y-auto space-y-2">
            <?php if(empty($lokasi)): ?>
              <p class="text-gray-500 text-sm italic">Belum ada data lokasi. Tambahkan lokasi terlebih dahulu.</p>
            <?php else: ?>
              <?php foreach($lokasi as $lok): ?>
                <label class="flex items-center gap-3 p-2 hover:bg-blue-50 rounded-md cursor-pointer transition-colors">
                  <input 
                    type="checkbox" 
                    name="lokasi_ids[]" 
                    value="<?= $lok['id_lokasi'] ?>"
                    class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                  >
                  <span class="text-gray-700 font-medium"><?= esc($lok['nama_lokasi']) ?></span>
                </label>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
        </div>

        <!-- Deskripsi -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi <span class="text-red-500">*</span></label>
          <textarea 
            name="deskripsi" 
            placeholder="Jelaskan detail item, kondisi, spesifikasi, dll..." 
            rows="4"
            required
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all text-sm"
          ></textarea>
        </div>

        <!-- Foto -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Foto Item</label>
          <input 
            type="file" 
            name="foto" 
            accept="image/*"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all text-sm"
          >
          <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, WEBP (Max: 4MB)</p>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-3 pt-3">
          <button 
            type="submit" 
            class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-4 py-2.5 rounded-md font-semibold transition-all flex items-center justify-center gap-2 text-sm"
          >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            Simpan
          </button>
          <a 
            href="<?= base_url('admin/items') ?>" 
            class="px-4 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-md font-semibold transition-all text-sm flex items-center justify-center gap-2"
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
