<?php
$router = new \Core\Router();



$router->get('/users', [\Controllers\User::class, 'index']);
$router->get('/users/{id}', [\Controllers\User::class, 'show']);
$router->get('/users/{id}/libraries', [\Controllers\User::class, 'libraries']);
$router->delete('/users/{id}', [\Controllers\User::class, 'destroy']);
$router->post('/users', [\Controllers\User::class, 'create']);

$router->get('/authors', [\Controllers\Author::class, 'index']);
$router->get('/authors/{id}', [\Controllers\Author::class, 'show']);
$router->get('/authors/{id}/books', [\Controllers\Author::class, 'books']);
$router->delete('/authors/{id}', [\Controllers\Author::class, 'destroy']);
$router->put('/authors/{id}', [\Controllers\Author::class, 'update']);
$router->post('/authors', [\Controllers\Author::class, 'create']);

$router->get('/books', [\Controllers\Book::class, 'index']);
$router->post('/books', [\Controllers\Book::class, 'create']);
$router->get('/books/{id}', [\Controllers\Book::class, 'show']);
$router->delete('/books/{id}', [\Controllers\Book::class, 'destroy']);
$router->post('/books/{id}/tags', [\Controllers\Book::class, 'addTags']);
$router->get('/books/{id}/editions', [\Controllers\Book::class, 'editions']);
$router->get('/books/{id}/publishers', [\Controllers\Book::class, 'publishers']);

$router->get('/bookVersions', [\Controllers\BookVersion::class, 'index']);

$router->get('/libraries', [\Controllers\Library::class, 'index']);
$router->get('/libraries/{id}', [\Controllers\Library::class, 'show']);

$router->get('/books_tags', [\Controllers\BookTag::class, 'index']);



$router->init();
