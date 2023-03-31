<?php

namespace Controllers;


use PDO;
use Core\Connection;
use Traits\ReturnJson;

class Book
{
    use ReturnJson;
    protected $connection;
    protected $table = 'books';
    public function __construct()
    {
        $this->connection = Connection::get();
    }

    public function index()
    {
//        $sql = $this->connection->prepare("SELECT * FROM $this->table INNER JOIN users ON users.id = books.author_id");
        $sql = $this->connection->prepare("
            SELECT 
            books.id AS id, 
            books.title AS title, 
            books.excerpt AS excerpt, 
            books.authors_id AS authorID, 
            CONCAT(authors.firstname, ' ', authors.lastname) AS author, 
            genres.id AS genreId, 
            genres.name AS genre 
            FROM library.books
            INNER JOIN authors 
            ON books.authors_id = authors.id 
            INNER JOIN genres 
            ON books.genres_id = genres.id;
        ");
        $sql->execute();
        echo $this->returnJsonFormat($sql->fetchAll());
    }

    public function show($id)
    {
        $sql = $this->connection->prepare("
        SELECT 
        books.id AS id, 
        books.title AS title, 
        books.excerpt AS excerpt, 
        books.authors_id AS authorID, 
        CONCAT(authors.firstname, ' ', authors.lastname) AS author, 
        genres.id AS genreId, 
        genres.name AS genre 
        FROM library.books
        INNER JOIN authors 
        ON books.authors_id = authors.id 
        INNER JOIN genres 
        ON books.genres_id = genres.id
        WHERE books.id = :id;
        ");
        $sql->bindValue(':id', $id, PDO::PARAM_INT);
        $sql->execute();
        echo $this->returnJsonFormat($sql->fetch());
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