<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->group('', ['filter' => 'auth'], function ($routes) {

    // Document
    $routes->get('/', 'Document::index');
    $routes->get('/create', 'Document::create');
    $routes->get('/update/(:num)', 'Document::update/$1');

    $routes->post('/update-req/(:num)', 'Document::updateReq/$1');
    $routes->delete('/(:num)', 'Document::delete/$1');

    // Document Type
    $routes->get('document-types', 'DocumentType::index');
    $routes->get('document-types/create', 'DocumentType::create');
    $routes->get('document-types/update/(:num)', 'DocumentType::update/$1');

    $routes->post('document-types/update-req/(:num)', 'DocumentType::updateReq/$1');
    $routes->post('document-types/add', 'DocumentType::add');
    $routes->delete('document-types/(:num)', 'DocumentType::delete/$1');

    // Sector
    $routes->get('sectors', 'Sector::index');
    $routes->get('sectors/create', 'Sector::create');
    $routes->get('sectors/update/(:num)', 'Sector::update/$1');

    $routes->post('sectors/update-req/(:num)', 'Sector::updateReq/$1');
    $routes->post('sectors/add', 'Sector::add');
    $routes->delete('sectors/(:num)', 'Sector::delete/$1');


    // Temp documents
    $routes->get('temp-documents', 'TempDocument::index');
    $routes->get('temp-documents/create', 'TempDocument::create');
    $routes->get('temp-documents/update/(:num)', 'TempDocument::update/$1');

    $routes->post('temp-documents/update-req/(:num)', 'TempDocument::updateReq/$1');
    $routes->post('temp-documents/add', 'TempDocument::add');
    $routes->post('temp-documents/add-as-document/(:num)', 'TempDocument::createDocument/$1');


    $routes->delete('temp-documents/(:num)', 'TempDocument::delete/$1');

    //Files
    $routes->get('temp-documents/file/(:num)', 'File::getTempDocumentImage/$1');
    $routes->get('documents/file/(:num)', 'File::getDocumentImage/$1');
});

service('auth')->routes($routes);
