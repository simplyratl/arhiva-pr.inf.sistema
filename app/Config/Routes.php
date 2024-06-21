<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('temp-documents/(:num)', 'Home::update/$1');
$routes->put('temp-documents/update', 'Home::updateReq/$1');

