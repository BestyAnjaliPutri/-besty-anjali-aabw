<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('/akun1', 'Akun1::index');
$routes->get('/akun1/new', 'Akun1::new');
$routes->post('/akun1/post', 'Akun1::store');
$routes->get('/akun1/edit/(:segment)', 'Akun1::edit/$1');
$routes->put('/akun1/edit/(:any)', 'Akun1::update/$1');
$routes->delete('/akun1/(:segment)', 'Akun1::destroy/$1');

$routes->get('/akun2', 'Akun2::index');
$routes->get('/akun2/new', 'Akun2::new');
$routes->post('/akun2/post', 'Akun2::create');
$routes->post('/akun2', 'Akun2::create');
$routes->get('/akun2/(:segment)', 'Akun2::show/$1');
$routes->get('/akun2/(:segment)/edit', 'Akun2::edit/$1');
$routes->put('/akun2/(:segment)', 'Akun2::update/$1');
$routes->delete('/akun2/(:segment)/delete', 'Akun2::delete/$1');
$routes->delete('/akun2/(:segment)', 'Akun2::delete/$1');
$routes->post('/akun2/(:segment)/delete', 'Akun2::delete/$1');
$routes->resource('akun2');

$routes->get('/akun3', 'Akun3::index');
$routes->get('/akun3/new', 'Akun3::new');
$routes->post('/akun3/post', 'Akun3::create');
$routes->post('/akun3', 'Akun3::create');           
$routes->get('/akun3/(:segment)', 'Akun3::show/$1');    
$routes->get('/akun3/(:segment)/edit', 'Akun3::edit/$1');
$routes->put('/akun3/(:segment)', 'Akun3::update/$1');
$routes->delete('/akun3/(:segment)/delete', 'Akun3::delete/$1');
$routes->delete('/akun3/(:segment)', 'Akun3::delete/$1');
$routes->post('/akun3/(:segment)/delete', 'Akun3::delete/$1');
$routes->resource('akun3');

$routes->get('/transaksi', 'Transaksi::index');
$routes->get('/transaksi/new', 'Transaksi::new');
$routes->get('/transaksi/akun3', 'Transaksi::akun3');
$routes->get('/transaksi/status', 'Transaksi::status');
$routes->post('/transaksi/post', 'Transaksi::create'); 
$routes->post('/transaksi', 'Transaksi::create'); 
$routes->get('/transaksi/(:segment)/edit', 'Transaksi::edit/$1');
$routes->put('/transaksi/(:segment)', 'Transaksi::update/$1');
$routes->post('/transaksi/(:segment)', 'Transaksi::update/$1');
$routes->post('/transaksi/(:segment)/edit', 'Transaksi::update/$1');
$routes->delete('/transaksi/(:segment)/delete', 'Transaksi::delete/$1');
$routes->delete('/transaksi/(:segment)', 'Transaksi::delete/$1');
$routes->post('/transaksi/(:segment)/delete', 'Transaksi::delete/$1');
$routes->get('/transaksi/(:any)', 'Transaksi::show/$1');
$routes->resource('transaksi');

$routes->get('/penyesuaian', 'Penyesuaian::index');
$routes->get('/penyesuaian/new', 'Penyesuaian::new');
$routes->post('/penyesuaian/post', 'Penyesuaian::create'); 
$routes->post('/penyesuaian', 'Penyesuaian::create'); 
$routes->get('/penyesuaian/(:segment)/edit', 'Penyesuaian::edit/$1');
$routes->put('/penyesuaian/(:segment)', 'Penyesuaian::update/$1');
$routes->post('/penyesuaian/(:segment)', 'Penyesuaian::update/$1');
$routes->post('/penyesuaian/(:segment)/edit', 'Penyesuaian::update/$1');
$routes->delete('/penyesuaian/(:segment)/delete', 'Penyesuaian::delete/$1');
$routes->delete('/penyesuaian/(:segment)', 'Penyesuaian::delete/$1');
$routes->post('/penyesuaian/(:segment)/delete', 'Penyesuaian::delete/$1');
$routes->get('/penyesuaian/(:any)', 'Penyesuaian::show/$1');

$routes->resource('penyesuaian');

$routes->get('/jurnalumum', 'JurnalUmum::index');
$routes->get('/jurnalumum/cetakjurnal', 'JurnalUmum::cetakjurnal');

$routes->get('/posting', 'Posting::index');
$routes->get('/posting/cetakposting', 'Posting::cetakposting');

$routes->get('/neracasaldo', 'NeracaSaldo::index');
$routes->get('/neracasaldo/cetakneracasaldo', 'NeracaSaldo::cetakneracasaldo');
$routes->get('/neracasaldo/neracasaldopdf', 'NeracaSaldo::neracasaldopdf');

$routes->get('/neracalajur', 'NeracaLajur::index');
$routes->get('/neracalajur/neracalajurpdf', 'NeracaLajur::neracalajurpdf');

$routes->get('/labarugi', 'LabaRugi::index');
$routes->get('/labarugi/labarugipdf', 'LabaRugi::labarugipdf');

$routes->get('/perubahanmodal', 'PerubahanModal::index');
$routes->get('/perubahanmodal/perubahanmodalpdf', 'PerubahanModal::perubahanmodalpdf');

$routes->get('/neraca', 'Neraca::index');
$routes->get('/neraca/neracapdf', 'Neraca::neracapdf');

$routes->get('/aruskas', 'ArusKas::index');
$routes->get('/aruskas/aruskaspdf', 'ArusKas::aruskaspdf');

// User Management (Video 18-19)
$routes->get('/user', 'User::index');
$routes->post('/user/changeRole/(:segment)', 'User::changeRole/$1');
$routes->get('/user/toggleStatus/(:segment)', 'User::toggleStatus/$1');
$routes->post('/user/delete/(:segment)', 'User::delete/$1');
$routes->delete('/user/(:segment)', 'User::delete/$1');
