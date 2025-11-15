<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('HomeController');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

// ===========================
// HALAMAN UTAMA (Landing Page)
// ===========================
// Note: do NOT redirect logged-in users here; keep the landing page accessible
$routes->get('/', 'HomeController::index');

// ===========================
// AUTH (Login, Register, Logout)
// ===========================
$routes->group('auth', ['filter' => 'guest'], function ($routes) {
    $routes->get('login', 'Auth\LoginController::index');
    $routes->post('login', 'Auth\LoginController::login');

    $routes->get('register', 'Auth\RegisterController::index');
    $routes->post('register', 'Auth\RegisterController::register');
});

// Logout → hanya bisa dilakukan kalau sudah login
$routes->match(['get', 'post'], 'auth/logout', 'Auth\LoginController::logout', ['filter' => 'auth']);

// Unauthorized (akses ditolak karena role salah)
//$routes->get('unauthorized', 'Auth\LoginController::unauthorized');

// ===========================
// ADMIN DASHBOARD & FITUR
// ===========================
$routes->group('admin', ['filter' => 'role:admin'], function ($routes) {
    $routes->get('dashboard', 'DashboardController::admin');

    // Pengaduan
    $routes->group('pengaduan', function ($routes) {
        $routes->get('/', 'Admin\PengaduanController::index');
        $routes->get('create', 'Admin\PengaduanController::create');
        $routes->post('store', 'Admin\PengaduanController::store');
        $routes->get('edit/(:num)', 'Admin\PengaduanController::edit/$1');
        $routes->post('update/(:num)', 'Admin\PengaduanController::update/$1');
        $routes->get('delete/(:num)', 'Admin\PengaduanController::delete/$1');
    });

    // Users
    $routes->group('users', function ($routes) {
        $routes->get('/', 'Admin\UserController::index');
        $routes->get('create', 'Admin\UserController::create');
        $routes->post('store', 'Admin\UserController::store');
        $routes->get('edit/(:num)', 'Admin\UserController::edit/$1');
        $routes->post('update/(:num)', 'Admin\UserController::update/$1');
        $routes->get('delete/(:num)', 'Admin\UserController::delete/$1');
    });

    // Petugas management (admin)
    $routes->group('petugas', function ($routes) {
        $routes->get('/', 'Admin\PetugasController::index');
        $routes->get('create', 'Admin\PetugasController::create');
        $routes->post('store', 'Admin\PetugasController::store');
        $routes->get('edit/(:num)', 'Admin\PetugasController::edit/$1');
        $routes->post('update/(:num)', 'Admin\PetugasController::update/$1');
        $routes->get('delete/(:num)', 'Admin\PetugasController::delete/$1');
    });

    // Items
    $routes->group('items', function ($routes) {
        $routes->get('/', 'Admin\ItemController::index');
        $routes->get('create', 'Admin\ItemController::create');
        $routes->post('store', 'Admin\ItemController::store');
        $routes->get('edit/(:num)', 'Admin\ItemController::edit/$1');
        $routes->post('update/(:num)', 'Admin\ItemController::update/$1');
        $routes->get('delete/(:num)', 'Admin\ItemController::delete/$1');
    });

    // Temporary Items
    $routes->group('temporary_items', function ($routes) {
        $routes->get('/', 'Admin\TemporaryItemController::index');
        $routes->get('approve/(:num)', 'Admin\TemporaryItemController::approve/$1');
        $routes->get('reject/(:num)', 'Admin\TemporaryItemController::reject/$1');
        $routes->get('history', 'Admin\TemporaryItemController::history');
    });

    // Laporan
    $routes->group('laporan', function ($routes) {
        $routes->get('/', 'Admin\LaporanController::index');
        $routes->post('preview', 'Admin\LaporanController::preview');
        $routes->get('cetak/(:any)/(:any)', 'Admin\LaporanController::cetak/$1/$2');
    });
});

// ===========================
// PETUGAS DASHBOARD & FITUR
// ===========================
$routes->group('petugas', ['filter' => 'role:petugas'], function ($routes) {
    $routes->get('dashboard', 'DashboardController::petugas');

    // Pengaduan
    $routes->group('pengaduan', function ($routes) {
        $routes->get('/', 'Petugas\PengaduanController::index');
        $routes->get('edit/(:num)', 'Petugas\PengaduanController::edit/$1');
        $routes->post('update/(:num)', 'Petugas\PengaduanController::update/$1');
    });

    // Items
    $routes->group('items', function ($routes) {
        $routes->get('/', 'Admin\ItemController::index');
        $routes->get('edit/(:num)', 'Admin\ItemController::edit/$1');
        $routes->post('update/(:num)', 'Admin\ItemController::update/$1');
    });

    // Laporan
    $routes->group('laporan', function ($routes) {
        $routes->get('/', 'Admin\LaporanController::index');
        $routes->post('preview', 'Admin\LaporanController::preview');
    });
});

// ===========================
// USER DASHBOARD & FITUR
// ===========================
$routes->group('user', ['filter' => 'role:user'], function ($routes) {
    // Default user entry point (GET /user)
    $routes->get('/', 'DashboardController::user');
    $routes->get('dashboard', 'DashboardController::user');

    // Direct route for user riwayat (convenience URL)
    $routes->get('riwayat', 'User\PengaduanController::riwayat');
     $routes->get('detail/(:num)', 'User\PengaduanController::detail/$1');
    // Pengaduan
    $routes->group('pengaduan', function ($routes) {
        $routes->get('/', 'User\PengaduanController::index');
        $routes->post('store', 'User\PengaduanController::store');
        $routes->get('riwayat', 'User\PengaduanController::riwayat');
       
        $routes->get('getItems/(:num)', 'User\PengaduanController::getItems/$1');
    });

    // Profile
    $routes->group('profile', function ($routes) {
        $routes->get('/', 'User\ProfileController::index');
        $routes->post('update', 'User\ProfileController::update');
    });
});

// ===========================
// NOTIFIKASI (semua role login)
// ===========================
$routes->group('notif', ['filter' => 'auth'], function ($routes) {
    $routes->get('get', 'NotifController::getNotifications');
    $routes->post('read/(:num)', 'NotifController::markAsRead/$1');
    $routes->post('read-all', 'NotifController::markAllAsRead');
    $routes->delete('delete/(:num)', 'NotifController::delete/$1');
});

// Notifikasi per role
$routes->get('admin/notifikasi', 'NotifController::index', ['filter' => 'role:admin']);
$routes->get('petugas/notifikasi', 'NotifController::index', ['filter' => 'role:petugas']);
$routes->get('user/notifikasi', 'NotifController::index', ['filter' => 'role:user']);

// ===========================
// DEBUG SESSION (hapus di production)
// ===========================
$routes->get('debug/session', function () {
    return view('debug_session');
});

// ===========================
// PROFILE IMAGE HANDLER
// ===========================
$routes->get('profile/(:any)', function ($image) {
    $path = WRITEPATH . 'uploads/profile/' . $image;

    if (file_exists($path)) {
        $mime = mime_content_type($path);
        header('Content-Type: ' . $mime);
        return file_get_contents($path);
    }

    throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
});
