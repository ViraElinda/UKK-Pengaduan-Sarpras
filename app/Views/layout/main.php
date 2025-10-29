<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title><?= $this->renderSection('title') ?? 'Pengaduan Sarpras' ?></title>

    <!-- Bootstrap CSS dari CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Section untuk tambahan <head> jika diperlukan -->
    <?= $this->renderSection('head') ?>
</head>
<body>

    <?= view('navbar/user') ?>

    <!-- Konten halaman -->
    <div class="container py-4">
        <?= $this->renderSection('content') ?>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Section untuk tambahan script jika dibutuhkan -->
    <?= $this->renderSection('scripts') ?>
</body>
</html>
