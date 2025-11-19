<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Form Pengaduan Baru
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="min-h-screen bg-ui-page py-4 md:py-8 px-3 md:px-6">
  <style>
    /* Choices dropdown styling: keep it compact and scrollable so it won't overflow screen */
    .choices__list--dropdown .choices__list {
      max-height: 180px;
      overflow-y: auto;
    }
    .choices__item--choice {
      padding: 0.4rem 0.6rem;
      font-size: 0.9rem;
    }
    /* Ensure the original select isn't forcing strange native appearance when Choices is active */
    select { -webkit-appearance: none; appearance: none; }
    
    /* Mobile-first responsive sizing */
    @media (max-width: 640px) {
      .form-input, .form-textarea, .form-select {
        padding: 0.75rem !important;
        font-size: 0.95rem !important;
      }
    }
  </style>
  <div class="max-w-4xl mx-auto">
    
    <!-- Header -->
    <div class="mb-4 md:mb-6">
      <div>
        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-1">📝 Buat Pengaduan</h1>
        <p class="text-sm md:text-base text-gray-600 font-medium">Laporkan masalah sarana dan prasarana</p>
      </div>
    </div>

    <!-- Form Container -->
    <div class="max-w-2xl mx-auto">
      <!-- use ui-card for consistent look -->
      <form action="<?= base_url('user/pengaduan/store') ?>" method="POST" enctype="multipart/form-data" class="ui-card p-4 md:p-6 space-y-4 md:space-y-5">
        <div class="text-center mb-3">
          <h2 class="text-xl font-semibold text-gray-800">Buat Pengaduan</h2>
          <p class="text-sm text-gray-500">Laporkan masalah sarana dan prasarana</p>
        </div>

        <!-- Error Messages -->
        <?php if(session()->getFlashdata('errors')): ?>
          <div class="bg-red-50 text-red-700 p-3 md:p-4 rounded-xl text-xs md:text-sm font-medium shadow border border-red-200">
            <?php foreach(session()->getFlashdata('errors') as $err) echo '• '.$err.'<br>'; ?>
          </div>
        <?php endif; ?>

        <!-- Nama Pengaduan -->
        <div>
          <label class="block font-medium text-gray-700 mb-1 text-sm">
            Nama Pengaduan <span class="text-red-500">*</span>
          </label>
          <input type="text" name="nama_pengaduan" value="<?= old('nama_pengaduan') ?>" required
            class="form-input w-full p-3 md:p-3.5 border-2 border-gray-300 rounded-lg md:rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition font-medium text-sm md:text-base"
            placeholder="Contoh: Kursi rusak di kelas XII-A">
        </div>

        <!-- Deskripsi -->
        <div>
          <label class="block font-medium text-gray-700 mb-1 text-sm">
            Deskripsi <span class="text-red-500">*</span>
          </label>
          <textarea name="deskripsi" rows="3" required
            class="form-textarea w-full p-3 md:p-3.5 border-2 border-gray-300 rounded-lg md:rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition font-medium resize-none text-sm md:text-base"
            placeholder="Jelaskan masalah secara detail..."><?= old('deskripsi') ?></textarea>
        </div>

        <!-- Pilih Lokasi & Item (responsive two-column) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-4">
          <div>
            <label class="block font-medium text-gray-700 mb-1 text-sm">Pilih Lokasi <span class="text-red-500">*</span></label>
            <select id="lokasi" name="id_lokasi" required
              class="form-select w-full p-3 md:p-3.5 border-2 border-gray-300 rounded-lg md:rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition font-medium text-sm md:text-base">
              <option value="">-- Pilih Lokasi --</option>
              <?php foreach($lokasi as $lok): ?>
                <option value="<?= $lok['id_lokasi'] ?>" <?= old('id_lokasi') == $lok['id_lokasi'] ? 'selected' : '' ?>>
                  <?= esc($lok['nama_lokasi']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div>
            <label class="block font-medium text-gray-700 mb-1 text-sm">Pilih Item</label>
            <select id="item" name="id_item"
              class="form-select w-full p-3 md:p-3.5 border-2 border-gray-300 rounded-lg md:rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition font-medium text-sm md:text-base">
              <option value="">Pilih lokasi terlebih dahulu</option>
            </select>
          </div>
        </div>

        <!-- Item Baru (collapsed by default) -->
        <div>
          <div>
            <label class="block font-medium text-gray-700 mb-1 text-sm">Item baru (opsional)</label>
            <div id="item-baru-wrapper" class="mt-2">
              <input type="text" name="item_baru" id="item-baru-input" value="<?= esc(old('item_baru')) ?>" placeholder="Nama item baru"
                class="form-input w-full p-2.5 border rounded-lg border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-400 transition text-sm">
              <p class="text-xs text-gray-500 mt-1">Mengisi item baru akan mengabaikan pilihan item di atas.</p>
            </div>
          </div>
        </div>

        <!-- Upload Foto with preview -->
        <div>
          <label class="block font-medium text-gray-700 mb-1 text-sm">Foto bukti <span class="text-red-500">*</span></label>
          <div>
            <input type="file" name="foto" accept="image/*" id="foto-input" required
              class="w-full p-2 border border-dashed border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-400 transition text-sm">
          </div>
          <div id="foto-preview" class="mt-2 hidden">
            <div class="inline-flex items-center gap-2 md:gap-3">
              <img id="foto-preview-img" src="#" alt="Preview" class="w-16 h-16 md:w-20 md:h-20 object-cover rounded-lg shadow-sm border" />
              <div>
                <div id="foto-preview-name" class="text-xs md:text-sm font-medium text-gray-700"></div>
                <div id="foto-preview-size" class="text-xs text-gray-500"></div>
              </div>
            </div>
          </div>
          <p class="text-xs text-gray-500 mt-1">* Foto wajib untuk mendukung pengaduan</p>
        </div>

        <!-- Submit Button -->
        <div class="pt-2 md:pt-4">
          <button type="submit" id="submit-btn" class="w-full btn-ui py-3 md:py-3.5 rounded-lg md:rounded-xl shadow-lg md:shadow-xl hover:shadow-xl md:hover:shadow-2xl text-sm md:text-base">
            <span class="inline-flex items-center justify-center gap-2">
              <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

    // Initialize Choices
    initChoicesIfNeeded();

    // Event handler for lokasi change
    $('#lokasi').change(function () {
      loadItems($(this).val());
    });

    // Load items if old lokasi exists
    let oldLokasi = '<?= old('id_lokasi') ?>';
    let oldItem = '<?= old('id_item') ?>';
    if(oldLokasi) {
      loadItems(oldLokasi, oldItem);
    }

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
      
      // Validasi ukuran file (max 3MB)
      const file = fotoInput.files[0];
      if (file.size > 3072 * 1024) {
        e.preventDefault();
        Swal.fire({
          icon: 'error',
          title: 'File Terlalu Besar!',
          text: 'Ukuran foto maksimal 3MB',
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

<!-- Autosave draft for Ajukan Aduan form -->
<script>
  (function(){
    const FORM_KEY = 'draft_pengaduan_v1';
    const form = document.querySelector('form[action="<?= base_url('user/pengaduan/store') ?>"]');
    if(!form) return;

    const fields = ['nama_pengaduan','deskripsi','id_lokasi','id_item','item_baru'];
    const saveDelay = 600; // ms
    let timer = null;

    function saveDraft(){
      const data = {};
      fields.forEach(f => {
        const el = form.querySelector('[name="'+f+'"]');
        if(!el) return;
        if(el.type === 'checkbox' || el.type === 'radio') data[f] = el.checked;
        else data[f] = el.value;
      });
      try { localStorage.setItem(FORM_KEY, JSON.stringify({ts: Date.now(), data})); } catch(e) {}
    }

    function scheduleSave(){
      clearTimeout(timer);
      timer = setTimeout(saveDraft, saveDelay);
    }

    // Restore draft if available
    try {
      const raw = localStorage.getItem(FORM_KEY);
      if(raw){
        const parsed = JSON.parse(raw);
        if(parsed && parsed.data){
          // Ask user if they'd like to restore
          if(confirm('Ditemukan draf pengaduan yang belum dikirim. Pulihkan draf?')){
            const d = parsed.data;
            fields.forEach(f => {
              const el = form.querySelector('[name="'+f+'"]');
              if(!el) return;
              el.value = d[f] || '';
              if(f === 'id_lokasi' && d[f]) {
                // trigger change to load items
                const ev = new Event('change', { bubbles: true });
                el.dispatchEvent(ev);
              }
            });
            // visual hint
            const note = document.createElement('div');
            note.className = 'bg-yellow-50 text-yellow-700 p-3 rounded-xl text-sm mb-3';
            note.id = 'draft-restored-note';
            note.innerHTML = 'Draf dipulihkan dari penyimpanan lokal. <button id="clear-draft" class="ml-2 underline font-semibold text-sm">Hapus draf</button>';
            form.insertBefore(note, form.firstChild);
            const clearBtn = document.getElementById('clear-draft');
            if(clearBtn) clearBtn.addEventListener('click', function(e){ e.preventDefault(); localStorage.removeItem(FORM_KEY); note.remove(); });
          }
        }
      }
    } catch(e) { console.warn('Draft restore failed', e); }

    // Attach listeners
    fields.forEach(f => {
      const el = form.querySelector('[name="'+f+'"]');
      if(!el) return;
      el.addEventListener('input', scheduleSave);
      el.addEventListener('change', scheduleSave);
    });

    // Clear draft on successful submit
    form.addEventListener('submit', function(){
      try { localStorage.removeItem(FORM_KEY); } catch(e) {}
    });
  })();
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