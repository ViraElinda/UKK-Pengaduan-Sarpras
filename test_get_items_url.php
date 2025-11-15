<?php

// Test URL Generator untuk getItems
define('ROOTPATH', __DIR__ . DIRECTORY_SEPARATOR);
define('APPPATH', ROOTPATH . 'app' . DIRECTORY_SEPARATOR);
define('SYSTEMPATH', ROOTPATH . 'vendor/codeigniter4/framework/system' . DIRECTORY_SEPARATOR);
define('FCPATH', ROOTPATH . 'public' . DIRECTORY_SEPARATOR);

require ROOTPATH . 'vendor/autoload.php';

echo "=== TEST URL GENERATOR ===\n\n";

// Simulasi base_url
$baseURL = 'http://localhost/pengaduan4/pengaduan4/public';

echo "Base URL: $baseURL\n\n";

echo "1. URL untuk getItems dengan ID 1:\n";
echo "   " . $baseURL . "/user/pengaduan/getItems/1\n\n";

echo "2. URL untuk getItems dengan ID 5:\n";
echo "   " . $baseURL . "/user/pengaduan/getItems/5\n\n";

echo "3. URL Pattern di Routes.php:\n";
echo "   user/pengaduan/getItems/(:num)\n\n";

echo "4. Controller Method:\n";
echo "   User\PengaduanController::getItems(\$id_lokasi)\n\n";

echo "✅ Pastikan route ini ada di Routes.php dalam group 'user'\n";
