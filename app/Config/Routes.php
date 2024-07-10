<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('auth/register', 'RegisterController::index');
$routes->get('/', 'LoginController::index');
$routes->get('dashboard', 'AuthController::index');
$routes->get('update', 'AuthController::updateProfile');


// Smart Search
$routes->get('smart-search','SmartSearchController::index');
$routes->get('smartsearch/search', 'SmartSearchController::search');
// Authentication
$routes->post('authenticate', 'LoginController::login');
$routes->post('auth/save', 'RegisterController::register_user');
$routes->get('auth/logout', 'AuthController::logout');
// gi try nako ni basin pwede diay ma double call
$routes->match(['get','post'], 'auth/update','AuthController::updateProfile');
$routes->post('auth/update-password', 'AuthController::updatePassword');
