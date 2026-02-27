<?php
// app/Config/Routes.php
// ============================================================
// TechManuals Store — Rutas de la aplicación
// ============================================================

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// ── Rutas públicas del sitio ─────────────────────────────────
$routes->get('/',                   'HomeController::index');
$routes->get('/mision',             'HomeController::mision');
$routes->get('/vision',             'HomeController::vision');
$routes->get('/quienes-somos',      'HomeController::quienesSomos');
$routes->get('/portafolio',         'ShopController::portafolio');
$routes->get('/portafolio/(:segment)', 'ShopController::detail/$1');
$routes->get('/contacto',           'HomeController::contacto');
$routes->post('/contacto/enviar',   'HomeController::sendContact');

// ── Autenticación ────────────────────────────────────────────
$routes->get('/login',                      'AuthController::loginForm');
$routes->post('/login',                     'AuthController::loginPost');
$routes->get('/register',                   'AuthController::registerForm');
$routes->post('/register',                  'AuthController::registerPost');
$routes->get('/logout',                     'AuthController::logout');

// Google OAuth
$routes->get('/auth/google',                'AuthController::googleRedirect');
$routes->get('/auth/google/callback',       'AuthController::googleCallback');

// Facebook OAuth
$routes->get('/auth/facebook',              'AuthController::facebookRedirect');
$routes->get('/auth/facebook/callback',     'AuthController::facebookCallback');

// ── Compras (requieren sesión) ───────────────────────────────
$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('/checkout/(:num)',        'PaymentController::checkout/$1');
    $routes->post('/checkout/create-order', 'PaymentController::createOrder');
    $routes->post('/checkout/capture',      'PaymentController::captureOrder');
    $routes->get('/checkout/success/(:num)','PaymentController::success/$1');
    $routes->get('/checkout/cancel',        'PaymentController::cancel');
    $routes->get('/mis-compras',            'PaymentController::myPurchases');
});

// ── Descarga con token temporal ──────────────────────────────
$routes->get('/descargar/(:segment)',       'DownloadController::download/$1');

// ── Panel Admin ──────────────────────────────────────────────
$routes->group('admin', ['filter' => 'admin'], function($routes) {
    $routes->get('/',                       'AdminController::index');
    $routes->get('/manuales',               'AdminController::manuals');
    $routes->get('/manuales/nuevo',         'AdminController::newManual');
    $routes->post('/manuales/crear',        'AdminController::createManual');
    $routes->get('/manuales/editar/(:num)', 'AdminController::editManual/$1');
    $routes->post('/manuales/actualizar/(:num)', 'AdminController::updateManual/$1');
    $routes->post('/manuales/eliminar/(:num)', 'AdminController::deleteManual/$1');
    $routes->get('/ordenes',                'AdminController::orders');
    $routes->get('/mensajes',               'AdminController::messages');
    $routes->get('/usuarios',               'AdminController::users');
});
