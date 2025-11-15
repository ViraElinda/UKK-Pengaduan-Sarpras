<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Akses Ditolak</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">
    <div class="text-center">
        <h1 class="display-4 text-danger">403 - Akses Ditolak</h1>
        <p class="lead">Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.</p>
        
        <!-- Tombol kembali ke beranda -->
      <?php
$session = session();
$role = $session->get('role');

switch ($role) {
    case 'admin':
        $home = base_url('admin/dashboard');
        break;
    case 'petugas':
        $home = base_url('petugas/dashboard');
        break;
    case 'user':
        $home = base_url('user/dashboard');
        break;
    default:
        $home = base_url('/');
        break;
}
?>

<a href="<?= $home ?>" class="btn btn-primary">Kembali ke Beranda</a>

    </div>
</body>
</html>
