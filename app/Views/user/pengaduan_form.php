<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Form Pengaduan Baru
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="min-h-screen bg-ui-page py-8 px-6">
  <style>
    /* Choices dropdown styling: keep it compact and scrollable so it won't overflow screen */
    .choices__list--dropdown .choices__list {
      max-height: 240px;
      overflow-y: auto;
    }
    .choices__item--choice {
      padding: 0.5rem 0.75rem;
      font-size: 1rem;
    }
    /* Ensure the original select isn't forcing strange native appearance when Choices is active */
    select { -webkit-appearance: none; appearance: none; }
  </style>
  <div class="max-w-7xl mx-auto">
    
    <!-- Header -->
    <div class="mb-6 flex justify-between items-center">
      <div>
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-1">📝 Buat Pengaduan</h1>
        <p class="text-gray-600 font-medium">Laporkan masalah sarana dan prasarana</p>
      </div>

    </div>

    <!-- Form Container -->
    <div class="max-w-3xl mx-auto">
  <form action="<?= base_url('user/pengaduan/store') ?>" method="POST" enctype="multipart/form-data" class="bg-white rounded-3xl shadow-2xl p-8 space-y-6">
        <div class="text-center mb-6">
          <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mb-3 shadow-lg">
            <svg class="w-8 h-8 text-ui-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
          </div>
          <h2 class="text-2xl font-bold text-ui-primary">Formulir Pengaduan</h2>
        </div>

        <!-- Error Messages -->
        <?php if(session()->getFlashdata('errors')): ?>
          <div class="bg-red-50 text-red-700 p-4 rounded-xl text-sm font-medium shadow border border-red-200">
            <?php foreach(session()->getFlashdata('errors') as $err) echo '• '.$err.'<br>'; ?>
          </div>
        <?php endif; ?>

        <!-- Nama Pengaduan -->
        <div>
          <label class="block font-bold text-gray-700 mb-2">
            <span class="inline-flex items-center gap-2">
              📌 Nama Pengaduan
              <span class="text-red-500">*</span>
            </span>
          </label>
          <input type="text" name="nama_pengaduan" value="<?= old('nama_pengaduan') ?>" required
            class="w-full p-4 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition font-medium"
            placeholder="Contoh: Kursi rusak di kelas XII-A">
        </div>

        <!-- Deskripsi -->
        <div>
          <label class="block font-bold text-gray-700 mb-2">
            <span class="inline-flex items-center gap-2">
              📄 Deskripsi
              <span class="text-red-500">*</span>
            </span>
          </label>
          <textarea name="deskripsi" rows="4" required
            class="w-full p-4 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition font-medium resize-none"
            placeholder="Jelaskan masalah secara detail..."><?= old('deskripsi') ?></textarea>
        </div>

        <!-- Pilih Lokasi -->
        <div>
          <label class="block font-bold text-gray-700 mb-2">
            <span class="inline-flex items-center gap-2">
              📍 Pilih Lokasi
              <span class="text-red-500">*</span>
            </span>
          </label>
          <select id="lokasi" name="id_lokasi" required
            class="w-full p-4 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition font-medium">
            <option value="">-- Pilih Lokasi --</option>
            <?php foreach($lokasi as $lok): ?>
              <option value="<?= $lok['id_lokasi'] ?>"><?= esc($lok['nama_lokasi']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- Pilih Item -->
        <div>
          <label class="block font-bold text-gray-700 mb-2">
            <span class="inline-flex items-center gap-2">
              🔧 Pilih Item
            </span>
          </label>
          <select id="item" name="id_item"
            class="w-full p-4 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition font-medium">
            <option value="">Pilih lokasi terlebih dahulu</option>
          </select>
        </div>

        <!-- Item Baru -->
        <div>
          <label class="block font-bold text-gray-700 mb-2">
            <span class="inline-flex items-center gap-2">
              ➕ Item Tidak Ada? Tulis di sini
            </span>
          </label>
          <input type="text" name="item_baru" placeholder="Masukkan nama item baru"
            class="w-full p-4 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition font-medium">
          <p class="text-sm text-blue-600 mt-1">💡 <strong>Tip:</strong> Jika Anda mengisi field ini, pilihan item di atas akan diabaikan</p>
        </div>

        <!-- Upload Foto -->
        <div>
          <label class="block font-bold text-gray-700 mb-2">
            <span class="inline-flex items-center gap-2">
              📷 Upload Foto
              <span class="text-red-500">*</span>
            </span>
          </label>
          <div class="relative">
            <input type="file" name="foto" accept="image/*" id="foto-input" required
              class="w-full p-4 border-2 border-dashed border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition font-medium file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-purple-100 file:text-purple-700 file:font-semibold hover:file:bg-purple-200">
          </div>
          <p class="text-sm text-gray-500 mt-1">* Foto wajib diunggah untuk mendukung pengaduan Anda</p>
        </div>

        <!-- Submit Button -->
        <div class="pt-4">
          <button type="submit" id="submit-btn" class="w-full btn-ui py-4 rounded-xl shadow-xl hover:shadow-2xl">
            <span class="inline-flex items-center justify-center gap-2">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
              Kirim Pengaduan
            </span>
          </button>
        </div>
      </form>
    </div>
  </div>
</div>


<?= $this->section('scripts') ?>
<!-- jQuery (used for ajax) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Choices.js for nicer dropdowns on non-touch devices -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

<script>
  $(document).ready(function () {
  // Force Choices on all devices to avoid native huge dropdowns; Choices will render a scrollable HTML list
  const useChoices = true;
    let lokasiChoices = null;
    let itemChoices = null;

    function initChoicesIfNeeded() {
      if (!useChoices) return;
      try {
        if (!lokasiChoices) {
          lokasiChoices = new Choices('#lokasi', {
            searchEnabled: false,
            itemSelectText: '',
            shouldSort: false,
            position: 'bottom'
          });
        }
        if (!itemChoices) {
          itemChoices = new Choices('#item', {
            searchEnabled: true,
            itemSelectText: '',
            shouldSort: false,
            position: 'bottom'
          });
        }
      } catch (e) {
        console.warn('Choices init failed:', e);
      }
    }

    function loadItems(lokasiId, selected = '') {
      const itemSelect = $('#item');
      if (useChoices && itemChoices) {
        itemChoices.setChoices([{value:'',label:'⏳ Memuat...',disabled:true}], 'value', 'label', true);
      } else {
        itemSelect.html('<option>⏳ Memuat...</option>');
      }

      if (lokasiId) {
        $.ajax({
          url: '<?= base_url('user/pengaduan/getItems/') ?>' + lokasiId,
          type: 'GET',
          dataType: 'json',
          success: function (data) {
            if (useChoices && itemChoices) {
              if (data.length > 0) {
                const choices = [];
                data.forEach(function(it){ choices.push({value: it.id_item, label: it.nama_item}); });
                itemChoices.setChoices(choices, 'value', 'label', true);
                if (selected) itemChoices.setChoiceByValue(selected);
              } else {
                itemChoices.setChoices([{value:'',label:'❌ Tidak ada item di lokasi ini'}], 'value', 'label', true);
              }
            } else {
              itemSelect.empty();
              if (data.length > 0) {
                data.forEach(function(item){
                  let sel = (selected == item.id_item) ? 'selected' : '';
                  itemSelect.append('<option value="' + item.id_item + '" '+sel+'>' + item.nama_item + '</option>');
                });
              } else {
                itemSelect.append('<option value="">❌ Tidak ada item di lokasi ini</option>');
              }
            }
          },
          error: function () {
            if (useChoices && itemChoices) {
              itemChoices.setChoices([{value:'',label:'⚠️ Gagal memuat item'}], 'value', 'label', true);
            } else {
              itemSelect.html('<option value="">⚠️ Gagal memuat item</option>');
            }
          }
        });
      } else {
        if (useChoices && itemChoices) {
          itemChoices.setChoices([{value:'',label:'📍 Pilih lokasi terlebih dahulu'}], 'value', 'label', true);
        } else {
          itemSelect.html('<option value="">📍 Pilih lokasi terlebih dahulu</option>');
        }
      }
    }

    // Initialize Choices (if applicable) then wire change handler
    initChoicesIfNeeded();

    $('#lokasi').change(function () {
      loadItems($(this).val());
    });

    let oldLokasi = '<?= old('id_lokasi') ?>';
    let oldItem = '<?= old('id_item') ?>';
    if(oldLokasi) loadItems(oldLokasi, oldItem);

    // Validasi foto sebelum submit
    $('form').on('submit', function(e) {
      const fotoInput = $('#foto-input')[0];
      if (!fotoInput.files || fotoInput.files.length === 0) {
        e.preventDefault();
        Swal.fire({
          icon: 'warning',
          title: 'Foto Wajib!',
          text: 'Silakan upload foto untuk mendukung pengaduan Anda',
          confirmButtonColor: '#f59e0b',
          confirmButtonText: 'Mengerti'
        });
        return false;
      }
      
      // Validasi ukuran file (max 2MB)
      const file = fotoInput.files[0];
      if (file.size > 2048 * 1024) {
        e.preventDefault();
        Swal.fire({
          icon: 'error',
          title: 'File Terlalu Besar!',
          text: 'Ukuran foto maksimal 2MB',
          confirmButtonColor: '#ef4444',
          confirmButtonText: 'Mengerti'
        });
        return false;
      }
    });

    // Visual feedback saat foto dipilih
    $('#foto-input').on('change', function() {
      const file = this.files[0];
      if (file) {
        const fileName = file.name;
        const fileSize = (file.size / 1024 / 1024).toFixed(2);
        $(this).next('.file-info').remove();
        $(this).parent().append(`
          <div class="file-info mt-2 text-sm text-green-600 font-medium">
            ✅ ${fileName} (${fileSize} MB)
          </div>
        `);
      }
    });
  });
</script>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  // Show error popup for duplicate complaint
  <?php if(session()->getFlashdata('error')): ?>
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      html: "<?= session()->getFlashdata('error'); ?>",
      confirmButtonColor: '#ef4444',
      confirmButtonText: 'Mengerti',
      footer: '<span class="text-sm text-gray-500">Silakan pilih lokasi atau item yang berbeda</span>'
    });
  <?php endif; ?>
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>
