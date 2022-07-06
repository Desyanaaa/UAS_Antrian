<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
//$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

// ROUTES ADMIN
$routes->get('admin', 'Admin\Admin::index', ['filter' => 'auth']);
$routes->post('admin/tambah', 'Admin\AdminProses::tambah', ['filter' => 'auth']);
$routes->post('admin/hapus', 'Admin\AdminProses::hapus', ['filter' => 'auth']);
$routes->post('admin/update', 'Admin\AdminProses::update', ['filter' => 'auth']);

// ROUTES ADMIN LOKET
$routes->get('admin/loket', 'Admin\Loket::index', ['filter' => 'auth']);
$routes->post('admin/loket/tambah', 'Admin\LoketProses::tambah', ['filter' => 'auth']);
$routes->post('admin/loket/hapus', 'Admin\LoketProses::hapus', ['filter' => 'auth']);
$routes->post('admin/loket/update', 'Admin\LoketProses::update', ['filter' => 'auth']);

// ROUTES ADMIN PELAYANAN
$routes->get('admin/pelayanan', 'Admin\Pelayanan::index', ['filter' => 'auth']);
$routes->post('admin/pelayanan/tambah', 'Admin\PelayananProses::tambah', ['filter' => 'auth']);
$routes->post('admin/pelayanan/hapus', 'Admin\PelayananProses::hapus', ['filter' => 'auth']);
$routes->post('admin/pelayanan/update', 'Admin\PelayananProses::update', ['filter' => 'auth']);

// ROUTES ADMIN ANTRIAN PANGGIL
$routes->get('admin/antrian/panggil/(:num)', 'Admin\Panggil::panggil/$1', ['filter' => 'auth']);
$routes->post('admin/antrian/panggil-antrian', 'Admin\PanggilProses::panggil', ['filter' => 'auth']);
$routes->post('admin/antrian/panggil/selesai', 'Admin\PanggilProses::selesai', ['filter' => 'auth']);

// ROUTES AMBIL ANTRIAN (homepage)
$routes->get('/', 'Home::index');
$routes->post('ambil-antrian', 'HomeProses::ambilAntrian');

// ROUTES ANTRIAN PUBLIC
$routes->get('antrian', 'Home::antrian');

// ROUTES LOGIN
$routes->get('login', 'Login::index');
$routes->post('login/proses', 'LoginProses::login');
$routes->get('logout', 'LoginProses::logout');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
