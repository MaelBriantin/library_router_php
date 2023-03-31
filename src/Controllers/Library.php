<?php

namespace Controllers;

use PDO;
use Core\Connection;
use Traits\ReturnJson;

class Library
{
    use ReturnJson;
    protected $connection;
    protected $table = 'libraries';
    public function __construct()
    {
        $this->connection = Connection::get();
    }

    public function index()
    {
        $sql = $this->connection->prepare("
        SELECT user_id AS userId, 
        users.username AS userName, 
        book_version_id AS bookVersionId, 
        book_version.publisher_id AS publisherId,
        publishers.name AS publisher,
        book_version.edition_id AS editionId,
        editions.name AS edition,
        editions.format AS format,
        reading_state.state AS readingState,
        books.id AS bookId,
        books.title AS title,
        books.excerpt AS excerpt,
        authors.id AS authorId,
        CONCAT(authors.firstname, ' ', authors.lastname) AS author,
        genres.id AS genreId,
        genres.name AS genre  
        FROM library.libraries 
        INNER JOIN users ON libraries.user_id = users.id 
        INNER JOIN book_version ON libraries.book_version_id = book_version.id
        INNER JOIN reading_state ON libraries.reading_state_id = reading_state.id
        INNER JOIN publishers ON book_version.publisher_id = publishers.id
        INNER JOIN editions ON book_version.edition_id = editions.id
        INNER JOIN books ON book_version_id = books.id
        INNER JOIN authors ON books.authors_id = authors.id
        INNER JOIN genres ON books.genres_id = genres.id
        ");
        $sql->execute();
        echo $this->returnJsonFormat($sql->fetchAll());
    }

    public function show($id, $return = false)
    {
        $sql = $this->connection->prepare("
        SELECT user_id AS userId, 
        users.username AS userName, 
        book_version_id AS bookVersionId, 
        book_version.publisher_id AS publisherId,
        publishers.name AS publisher,
        book_version.edition_id AS editionId,
        editions.name AS edition,
        editions.format AS format,
        reading_state.state AS readingState,
        books.id AS bookId,
        books.title AS title,
        books.excerpt AS excerpt,
        authors.id AS authorId,
        CONCAT(authors.firstname, ' ', authors.lastname) AS author,
        genres.id AS genreId,
        genres.name AS genre  
        FROM library.libraries 
        INNER JOIN users ON libraries.user_id = users.id 
        INNER JOIN book_version ON libraries.book_version_id = book_version.id
        INNER JOIN reading_state ON libraries.reading_state_id = reading_state.id
        INNER JOIN publishers ON book_version.publisher_id = publishers.id
        INNER JOIN editions ON book_version.edition_id = editions.id
        INNER JOIN books ON book_version_id = books.id
        INNER JOIN authors ON books.authors_id = authors.id
        INNER JOIN genres ON books.genres_id = genres.id
        WHERE libraries.user_id = :id
        ");
        $sql->bindValue(':id', $id, PDO::PARAM_INT);
        $sql->execute();
        if ($return) {
            return $sql->fetchAll();
        } else {
            echo $this->returnJsonFormat($sql->fetchAll());
        }
    }

    public function update($object, $id)
    {
        //
    }


    public function create($object)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}