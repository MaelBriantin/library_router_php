<?php
$router = new \Core\Router();

//Ajout de livres dans la liste globale des livres de l’application, sans lien avec un utilisateur
$router->post('/books', [\Controllers\Book::class, 'create']);

//Attribution/suppression de tags à un livre, sans lien avec un utilisateur
$router->post('/books/{id}/tags', [\Controllers\Book::class, 'addTag']);
$router->delete('/books/{id}/tags', [\Controllers\Book::class, 'removeTag']);

//Ajout d’éditions d’un livre dans la bibliothèque personnelle d’un utilisateur
$router->post('/users/{id}/libraries', [\Controllers\User::class, 'addBookToLibrary']);

//Ajout d’éditions d’un livre dans la liste d’envie d’un utilisateur
$router->post('/users/{id}/wishlists', [\Controllers\User::class, 'addBookToWishlist']);

//Ajout et modification d’une note d’un livre possédé
$router->post('/users/{id}/reviews', [\Controllers\User::class, 'postReview']);
$router->put('/users/{id}/reviews', [\Controllers\User::class, 'updateReview']);

//Recherche de livre pour ajouter à sa bibliothèque:
//○ par auteur
$router->get('/search/author', [\Controllers\Book::class, 'searchElement']);
//○ par genre/tags
$router->get('/search/tag', [\Controllers\Book::class, 'searchInArray']);
//○ par titre
$router->get('/search/title', [\Controllers\Book::class, 'searchElement']);
//○ par éditeur
$router->get('/search/publisher', [\Controllers\Book::class, 'searchElement']);
//○ (facultatif) par édition
$router->get('/search/edition', [\Controllers\Book::class, 'searchElement']);

//Dans les résultats de la recherche on aimerait pouvoir voir en plus des attributs du livre, l’auteur, la maison d’édition, les éditions disponibles et la note moyenne donnée par les utilisateurs.
$router->get('/books/{id}', [\Controllers\Book::class, 'show']);

//La recherche est limitée à un certain nombre de résultats par page et les livres sont triés du plus récent au plus ancien.
$router->get('/books', [\Controllers\Book::class, 'index']);

//Sur une page profil on devrait pouvoir afficher le nombre de livres possédés (peu importe l’édition), le nombre de livres en cours de lecture, le nombre de livres lus lors du dernier mois.
$router->get('/users/{id}', [\Controllers\User::class, 'show']);

//Une page auteur pourrait afficher le nombre de livres ajoutés dans les listes d’envie/les bibliothèques et la note moyenne de ses ouvrages.
$router->post('/authors', [\Controllers\Book::class, 'author']);

$router->get('/users', [\Controllers\User::class, 'index']);
$router->get('/users/{id}', [\Controllers\User::class, 'show']);

$router->get('/books', [\Controllers\Book::class, 'index']);
$router->post('/books', [\Controllers\Book::class, 'create']);
$router->get('/books/{id}', [\Controllers\Book::class, 'show']);

$router->init();
