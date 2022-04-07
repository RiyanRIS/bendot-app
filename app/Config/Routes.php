<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Auth');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Auth::login');
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::loginAction');
$routes->get('logout', 'Auth::logout');

$routes->add('bot', 'BotmanController::handle');
$routes->add('setbot', 'BotmanController::setWebhook');

$routes->group('anggota', ['filter' => 'authfilter:Admin'], function ($routes) {
    $routes->get('/', 'Anggota::index');
    $routes->get('add', 'Anggota::add');
    $routes->post('add', 'Anggota::insert');
    $routes->get('update/(:any)', 'Anggota::update/$1');
    $routes->post('update', 'Anggota::updateAction');
    $routes->get('delete/(:any)', 'Anggota::delete/$1');

});

$routes->group('bulanan', ['filter' => 'authfilter:Bendahara'], function ($routes) {
    $routes->get('/', 'Bulanan::index');
    $routes->get('bayar/(:any)/(:any)/(:any)', 'Bulanan::bayar/$1/$2/$3');
    $routes->get('cek', 'Bulanan::cek');

});

$routes->group('himpunan',['filter' => 'authfilter:Bendahara'], function ($routes) {
    $routes->get('/', 'Himpunan::index');
    $routes->get('add', 'Himpunan::add');
    $routes->post('add', 'Himpunan::insert');
    $routes->get('update/(:any)', 'Himpunan::update/$1');
    $routes->post('update', 'Himpunan::updateAction');
    $routes->get('delete/(:any)', 'Himpunan::delete/$1');
});

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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
