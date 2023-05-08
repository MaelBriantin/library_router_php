<?php
$router = new \Core\Router();
//Routes de l'exercice

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
$router->post('/authors/{id}/books', [\Controllers\Author::class, 'books']);
//○ par genre/tags
$router->post('/tags/{id}/books', [\Controllers\Tag::class, 'books']);
//○ par titre
$router->post('/search/title', [\Controllers\Book::class, 'search']);
//○ par éditeur
$router->post('/publishers/{id}/books', [\Controllers\BookVersion::class, 'findByPublisher']);
//○ (facultatif) par édition
$router->post('/editions/{id}/books', [\Controllers\BookVersion::class, 'findByEdition']);

//Dans les résultats de la recherche on aimerait pouvoir voir en plus des attributs du livre, l’auteur, la maison d’édition, les éditions disponibles et la note moyenne donnée par les utilisateurs.
$router->get('/books/{id}/infos', [\Controllers\Book::class, 'infos']);

//La recherche est limitée à un certain nombre de résultats par page et les livres sont triés du plus récent au plus ancien.
$router->get('/books', [\Controllers\Book::class, 'index']);

//Sur une page profil on devrait pouvoir afficher le nombre de livres possédés (peu importe l’édition), le nombre de livres en cours de lecture, le nombre de livres lus lors du dernier mois.
$router->get('/users/{id}/profile', [\Controllers\User::class, 'profile']);

//Une page auteur pourrait afficher le nombre de livres ajoutés dans les listes d’envie/les bibliothèques et la note moyenne de ses ouvrages.
$router->get('/authors/{id}/profile', [\Controllers\Author::class, 'profile']);


//users
$router->get('/users', [\Controllers\User::class, 'index']);
$router->get('/users/{id}', [\Controllers\User::class, 'show']);
$router->get('/users/{id}/libraries', [\Controllers\User::class, 'libraries']);
$router->post('/users/{id}/libraries', [\Controllers\User::class, 'addBookToLibrary']);
$router->delete('/users/{id}/libraries', [\Controllers\User::class, 'removeBookFromLibrary']);
$router->delete('/users/{id}/wishlists', [\Controllers\User::class, 'removeBookFromWishlist']);
$router->post('/users/{id}/wishlists', [\Controllers\User::class, 'addBookToWishlist']);
$router->get('/users/{id}/wishlists', [\Controllers\User::class, 'wishlists']);
$router->get('/users/{id}/reviews', [\Controllers\User::class, 'showReviews']);
$router->post('/users/{id}/reviews', [\Controllers\User::class, 'postReview']);
$router->put('/users/{id}/reviews', [\Controllers\User::class, 'updateReview']);
$router->get('/users/{id}/profile', [\Controllers\User::class, 'profile']);
$router->delete('/users/{id}', [\Controllers\User::class, 'destroy']);
$router->put('/users/{id}', [\Controllers\User::class, 'update']);
$router->post('/users', [\Controllers\User::class, 'create']);
//authors
$router->get('/authors', [\Controllers\Author::class, 'index']);
$router->get('/authors/{id}', [\Controllers\Author::class, 'show']);
$router->get('/authors/{id}/books', [\Controllers\Author::class, 'books']);
$router->get('/authors/{id}/profile', [\Controllers\Author::class, 'profile']);
$router->delete('/authors/{id}', [\Controllers\Author::class, 'destroy']);
$router->put('/authors/{id}', [\Controllers\Author::class, 'update']);
$router->post('/authors', [\Controllers\Author::class, 'create']);
//books
$router->get('/books', [\Controllers\Book::class, 'index']);
$router->post('/books', [\Controllers\Book::class, 'create']);
$router->get('/books/{id}', [\Controllers\Book::class, 'show']);
$router->get('/books/{id}/tags', [\Controllers\Book::class, 'tags']);
$router->delete('/books/{id}', [\Controllers\Book::class, 'destroy']);
$router->post('/books/{id}/tags', [\Controllers\Book::class, 'addTag']);
$router->delete('/books/{id}/tags', [\Controllers\Book::class, 'removeTag']);
$router->get('/books/{id}/editions', [\Controllers\Book::class, 'editions']);
$router->get('/books/{id}/publishers', [\Controllers\Book::class, 'publishers']);
$router->post('/books/{id}/comments', [\Controllers\Book::class, 'addComment']);
$router->get('/books/{id}/comments', [\Controllers\Book::class, 'comments']);
$router->get('/books/{id}/reviews', [\Controllers\Book::class, 'comments']);
$router->get('/books/{id}/infos', [\Controllers\Book::class, 'infos']);
$router->post('/search/title', [\Controllers\Book::class, 'search']);
$router->get('/books/versions', [\Controllers\BookVersion::class, 'index']);
//libraries
$router->get('/libraries/{id}', [\Controllers\Library::class, 'show']);
$router->get('/libraries', [\Controllers\Library::class, 'index']);
//tags
$router->get('/tags', [\Controllers\Tag::class, 'index']);
$router->get('/tags/{id}/books', [\Controllers\Tag::class, 'books']);
//reading state
$router->get('/reading-state', [\Controllers\ReadingState::class, 'index']);
//book version (edition, publisher)
$router->get('/publishers/{id}/books', [\Controllers\BookVersion::class, 'findByPublisher']);
$router->get('/editions/{id}/books', [\Controllers\BookVersion::class, 'findByEdition']);


$router->init();
