<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Homepage - redirects to books library
$routes->get('/', 'Books::index');

// Books routes
$routes->get('/books', 'Books::index');
$routes->get('/books/create', 'Books::create');
$routes->post('/books/store', 'Books::store');
$routes->get('/books/edit/(:num)', 'Books::edit/$1');
$routes->put('/books/update/(:num)', 'Books::update/$1');
$routes->delete('/books/delete/(:num)', 'Books::delete/$1');
$routes->post('/books/delete/(:num)', 'Books::delete/$1');

// ISBN Lookup Routes
$routes->get('/books/lookup-isbn', 'Books::lookupISBN');
$routes->post('/books/search-isbn', 'Books::searchISBN');
$routes->post('/books/add-from-isbn', 'Books::addFromISBN');

// Test route for debugging
$routes->get('/books/test-api', 'Books::testAPI');
