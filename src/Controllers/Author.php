<?php

namespace Controllers;

use Models\Wishlist;

class Author extends \Models\Author
{
    public function index()
    {
        echo jsonResponse($this->all());
    }

    public function show($id)
    {
        echo jsonResponse($this->find($id));
    }

    public function destroy($id)
    {

    }

    public function books($id): void
    {
        $author = $this->find($id);
        $books = new Book();
        $author['books'] = $books->findAll($id, 'author_id');
        echo jsonResponse($author);
    }

    public function profile($id)
    {
        $customQuery = "
            SELECT 
            CONCAT(authors.firstname, ' ', authors.lastname) AS name, 
            COUNT(DISTINCT libraries.book_version_id) AS booksAddedToLibraries,
            COUNT(DISTINCT wishlists.book_version_id) AS booksAddedToWishlists,
            AVG(comments.review) AS averageRating
            FROM 
            authors
            LEFT JOIN books ON authors.id = books.author_id
            LEFT JOIN book_version ON books.id = book_version.book_id
            LEFT JOIN libraries ON book_version.id = libraries.book_version_id
            LEFT JOIN wishlists ON book_version.id = wishlists.book_version_id
            LEFT JOIN comments ON books.id = comments.book_id
            GROUP BY 
            authors.id;
            ";
        echo jsonResponse($this->customQuery($customQuery)->fetch());
    }
}