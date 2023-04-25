<?php

namespace Controllers;

use Core\Connection;
use PDO;

class Tag
{
    protected $connection;

    public function __construct()
    {
        $this->connection = Connection::get();
    }

    public function index ()
    {
        $sql = $this->connection->prepare("
        SELECT * FROM tags
        ");
        $sql->execute();
        echo jsonResponse($sql->fetchAll());
    }

    public function show_by_book_id ($book_id)
    {
        $sql = $this->connection->prepare("
        SELECT tags.name
        FROM library.tags
        INNER JOIN library.books_tags
            ON tags.id = books_tags.tags_id
        WHERE books_tags.books_id = :book_id;
        ");
        $sql->bindValue(':book_id', $book_id, PDO::PARAM_INT);
        $sql->execute();
        //echo return_json($sql->fetchAll());
        return $sql->fetchAll();
    }
}