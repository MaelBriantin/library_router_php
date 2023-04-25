<?php

namespace Controllers;

use Core\Connection;
use PDO;

class Author
{
    protected $connection;
    protected $table = 'authors';
    public function __construct()
    {
        $this->connection = Connection::get();
    }

    public function index()
    {
        $sql = $this->connection->prepare("
            SELECT * FROM library.authors;
        ");
        $sql->execute();
        echo jsonResponse($sql->fetchAll());
    }

    public function show($id, $return=null)
    {
        $sql = $this->connection->prepare("
            SELECT * FROM library.authors WHERE id = :id;
        ");
        $sql->bindValue(':id', $id, PDO::PARAM_INT);
        $sql->execute();
        if(isset($return) && $return === true){
            return $sql->fetch();
        } else {
            echo jsonResponse($sql->fetch());
        }
    }

    public function destroy($id)
    {
        $sql = $this->connection->prepare("
            DELETE FROM library.authors WHERE id = :id;
        ");
        $sql->bindValue(':id', $id, PDO::PARAM_INT);
        $sql->execute();
    }

    public function books($id)
    {
        $author = $this->show($id, true);
        $books = new Book();
        $author_books = $books->index(['authors_id', $id]);
        $result = new \stdClass();
        $result->author = $author;
        $result->books = $author_books;
        echo jsonResponse($result);
    }
}