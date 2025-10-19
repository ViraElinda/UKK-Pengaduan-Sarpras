<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'HomeController::index');

// === AUTH ROUTES ===
$routes->group('auth', function($routes){
    $routes->get('register', 'Auth\RegisterController::index');
    $routes->post('register', 'Auth\RegisterController::register');

    $routes->get('login', 'Auth\LoginController::index');
    $routes->post('login', 'Auth\LoginController::login');
    $routes->post('logout', 'Auth\LoginController::logout');
});

$routes->get('/unauthorized', 'Auth\LoginController::unauthorized');

// === DASHBOARD ROUTES ===
$routes->get('/admin/dashboard', 'DashboardController::admin', ['filter' => 'role:admin']);
$routes->get('/petugas/dashboard', 'DashboardController::petugas', ['filter' => 'role:petugas']);
$routes->get('/guru/dashboard', 'DashboardController::guru', ['filter' => 'role:guru']);
$routes->get('/siswa/dashboard', 'DashboardController::siswa', ['filter' => 'role:siswa']);

// === USER ROUTES ===
$routes->group('user', ['filter' => 'role:user,guru,siswa'], function($routes){
    $routes->get('', 'User\PengaduanController::index'); 
    $routes->post('store', 'User\PengaduanController::store');
    $routes->get('index', 'User\PengaduanController::index');
    $routes->get('riwayat', 'User\PengaduanController::riwayat');
    $routes->get('detail/(:num)', 'User\PengaduanController::detail/$1');
});

// === ADMIN ROUTES ===
$routes->group('admin', ['filter' => 'role:admin'], function($routes){
    // PENGADUAN CRUD
    $routes->get('pengaduan', 'Admin\PengaduanController::index');
    $routes->get('pengaduan/create', 'Admin\PengaduanController::create');
    $routes->post('pengaduan/store', 'Admin\PengaduanController::store');
    $routes->get('pengaduan/edit/(:num)', 'Admin\PengaduanController::edit/$1');
    $routes->post('pengaduan/update/(:num)', 'Admin\PengaduanController::update/$1');
    $routes->get('pengaduan/delete/(:num)', 'Admin\PengaduanController::delete/$1');

    // USERS CRUD
    $routes->get('users', 'Admin\UserController::index');
    $routes->get('users/create', 'Admin\UserController::create');
    $routes->post('users/store', 'Admin\UserController::store');
    $routes->get('users/edit/(:num)', 'Admin\UserController::edit/$1');
    $routes->post('users/update/(:num)', 'Admin\UserController::update/$1');
    $routes->get('users/delete/(:num)', 'Admin\UserController::delete/$1');

    $routes->get('items', 'Admin\ItemController::index');
    $routes->get('items/create', 'Admin\ItemController::create');
    $routes->post('items/store', 'Admin\ItemController::store');
    $routes->get('items/edit/(:num)', 'Admin\ItemController::edit/$1');
    $routes->post('items/update/(:num)', 'Admin\ItemController::update/$1');
    $routes->get('items/delete/(:num)', 'Admin\ItemController::delete/$1');
    $routes->get('laporan', 'Admin\LaporanController::index');
    $routes->post('laporan/preview', 'Admin\LaporanController::preview');
    $routes->get('laporan/cetak/(:any)/(:any)', 'Admin\LaporanController::cetak/$1/$2');
});
