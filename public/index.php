<?php

session_start();
ob_start("ob_gzhandler");

require_once __DIR__ . '/../app/Core/Router.php';
require_once __DIR__ . '/../app/Core/Controller.php';
require_once __DIR__ . '/../app/Core/Database.php';
require_once __DIR__ . '/../app/Core/Model.php';
require_once __DIR__ . '/../vendor/autoload.php'; // Composer Autoloader

// Autoloader could be added here, but for simplicity we'll require core files manually or use a simple spl_autoload_register
spl_autoload_register(function ($class) {
    // Handle namespace mapping to directories
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/../app/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

use App\Core\Router;

$router = new Router();

// Define Routes
$router->get('/', 'HomeController@index');
$router->get('/rsvp', 'GuestController@index');
$router->get('/programme', 'ProgramController@index');
$router->get('/a-propos', 'AboutController@index');
$router->get('/admin', 'AdminController@index');
$router->post('/admin/approve', 'AdminController@approve');
$router->post('/admin/reject', 'AdminController@reject');
$router->get('/cagnotte', 'GiftController@index');
$router->get('/dress-code', 'DressCodeController@index');
$router->get('/invites', 'GuestListController@index');
$router->post('/rsvp/submit', 'GuestController@submit');
$router->post('/gift/submit', 'GiftController@submit');

// Auth Routes
$router->get('/login', 'AuthController@login');
$router->post('/login', 'AuthController@attemptLogin');
$router->get('/logout', 'AuthController@logout');

// Dispatch
$router->dispatch($_SERVER['REQUEST_URI']);
