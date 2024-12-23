<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->group('admin', function($routes) {
    $routes->get('register', 'Admin\UserController::register');
    $routes->post('register', 'Admin\UserController::registerAction');
    $routes->get('login', 'Admin\UserController::login');
    $routes->post('login', 'Admin\UserController::loginAction');
    $routes->get('forgot-password', 'Admin\UserController::forgotPassword');
});
$routes->group('admin', ['filter' => 'auth'], function($routes) {
    $routes->get('logout', 'Admin\UserController::logout');
    $routes->get('dashboard', 'Admin\UserController::dashboard');
    $routes->get('/', 'Admin\UserController::dashboard');
    $routes->get('manage-cv', 'Admin\UserController::manageCv');
    $routes->post('manage-cv/upload', 'Admin\UserController::uploadCv');
    $routes->group('cms', function($routes) {
        $routes->get('about', 'Admin\CmsController::about'); // Added route for about section
        $routes->post('about', 'Admin\CmsController::aboutSet'); // Added route for about section
    });
});

$routes->get('admin/google-auth', 'Admin\UserController::loginWithGoogle');
