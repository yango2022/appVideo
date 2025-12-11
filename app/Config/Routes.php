<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// app/Config/Routes.php (apagar/editar conforme o teu ficheiro)
$routes->get('video/join', 'VideoController::joinView');
$routes->match(['get','post'], 'video/token', 'VideoController::token');
