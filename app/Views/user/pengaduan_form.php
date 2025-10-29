<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Buat Pengaduan</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body>

<?= view('navbar/user') ?>

<div class="pgdn-wrapper">
  <div class="pgdn-form">
    <h2>Buat Pengaduan</h2>

    <?php if (session()->getFlashdata('errors')): ?>
      <div class="pgdn-alert">
        <ul>
          <?php foreach (session()->getFlashdata('errors') as $error): ?>
            <li><?= esc($error) ?></li>
          <?php endforeach ?>
        </ul>
      </div>
    <?php endif ?>

    <form action="<?= base_url('user/store') ?>" method="post" enctype="multipart/form-data">

      <!-- NAMA -->
      <div class="pgdn-field">
        <label>Nama Pengaduan</label>
        <input type="text" name="nama_pengaduan" value="<?= old('nama_pengaduan') ?>" required>
      </div>

      <!-- DESKRIPSI -->
      <div class="pgdn-field">
        <label>Deskripsi</label>
        <textarea name="deskripsi" rows="4" required><?= old('deskripsi') ?></textarea>
      </div>

      <!-- LOKASI -->
      <div class="pgdn-field">
        <label>Lokasi</label>
        <input type="text" id="lokasi" name="lokasi" value="<?= old('lokasi') ?>" required>
      </div>

      <!-- FOTO -->
      <div class="pgdn-field">
        <label>Upload Foto (Opsional)</label>

        <div class="pgdn-upload" onclick="document.getElementById('foto').click()">
          <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" fill="none" stroke="#4A90E2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 16l9-9 9 9M12 7v14"/>
            <path d="M21 19a9 9 0 11-18 0"/>
          </svg>
          <p id="file-name">Klik untuk pilih foto</p>
          <input type="file" id="foto" name="foto" accept="image/*" onchange="previewFoto(event)" hidden>
        </div>

        <img id="preview-image" class="pgdn-preview" style="display:none"/>
      </div>

      <button type="submit" class="pgdn-btn">Kirim Pengaduan</button>
    </form>
  </div>
</div>

<!-- ITEM TERDEKAT -->
<div id="item-lokasi" style="margin-top:20px;"></div>


<!-- ✅ AUTO-DETECT LOKASI -->
<script>
function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition, showError);
  } else {
    alert("Browser Anda tidak mendukung GPS");
  }
}

function showPosition(position) {
  document.getElementById("lokasi").value =
    position.coords.latitude + ", " + position.coords.longitude;

  loadItems();
}

function showError(error) {
  console.log("Gagal mendeteksi lokasi:", error);
}
}

// jalankan otomatis
window.onload = getLocation;
</script>


<!-- ✅ LOAD ITEM TERDEKAT -->
<script>
async function loadItems() {
  let lokasi = document.getElementById("lokasi").value;
  if (!lokasi) return;

  let res = await fetch("<?= base_url('user/item-by-location') ?>?lokasi=" + lokasi);

  if (!res.ok) return;

  let data = await res.json();

  let html = "<h3>Item Terdekat</h3>";
  if (data.length === 0) {
    html += "<p>Tidak ada item terdekat.</p>";
  }

  data.forEach(item => {
    html += `
      <div class="item-card">
        <p><strong>${item.nama}</strong></p>
        <p>${item.deskripsi}</p>
      </div>
    `;
  });

  document.getElementById("item-lokasi").innerHTML = html;
}
</script>


<!-- ✅ PREVIEW FOTO -->
<script>
function previewFoto(event) {
  const preview = document.getElementById('preview-image');
  const file = event.target.files[0];
  const fileName = document.getElementById('file-name');

  if (file) {
    fileName.textContent = file.name;
    preview.src = URL.createObjectURL(file);
    preview.style.display = 'block';
  }
}
</script>

</body>
</html>
