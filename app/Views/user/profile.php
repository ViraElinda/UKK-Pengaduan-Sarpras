<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('css/profile.css') ?>">
</head>

<body class="profile-page">
    <div class="profile-wrap">

        <div class="profile-card">
            <h2>Edit Profil</h2>

            <?php if (session()->getFlashdata('success')): ?>
                <p class="success-msg"><?= session()->getFlashdata('success') ?></p>
            <?php endif; ?>

            <form action="<?= base_url('/user/profile/update') ?>" 
                  method="post" enctype="multipart/form-data">

                <?= csrf_field() ?>

                <!-- ✅ Foto profile -->
                <div class="profile-img-wrap">
                    <img id="preview-img" 
                        src="<?= base_url('profile/' . $user['foto']) ?>" 
                        alt="Profile">

                    <button type="button" class="photo-btn" id="pick-photo">
                        <i class="fa-solid fa-camera"></i>
                    </button>

                    <input type="file" name="profile_image" id="profile_image" accept="image/*" hidden>
                </div>

                <!-- ✅ Nama Pengguna -->
                <div class="form-group">
                    <label>Nama Pengguna</label>
                    <input type="text" name="nama_pengguna" value="<?= esc($user['nama_pengguna']) ?>" required>
                </div>

                <!-- ✅ Username -->
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" value="<?= esc($user['username']) ?>" required>
                </div>

                <!-- ✅ Password -->
                <div class="form-group">
                    <label>Password (opsional)</label>
                    <input type="password" name="password">
                </div>

                <button type="submit" class="btn-save">Simpan</button>
            </form>

        </div>

    </div>

<script>
    // button camera → click input file
    document.getElementById("pick-photo").addEventListener("click", () => {
        document.getElementById("profile_image").click();
    });

    // preview langsung
    document.getElementById("profile_image").addEventListener("change", (event) => {
        let file = event.target.files[0];
        if (file) {
            document.getElementById("preview-img").src = URL.createObjectURL(file);
        }
    });
</script>

</body>
</html>
