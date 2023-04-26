<?php

namespace Controllers;


use PDO;
use Core\Connection;

class Book extends \Models\Book
{
    protected $connection;
//    protected $statement = ['id',
//                            'genres_id',
//                            'author_id',
//                            'title',
//                            'excerpt',
//                            'published_year'];
//    public function __construct()
//    {
//        $this->connection = Connection::get();
//    }

    public function index(array $param=null)
    {
//        $query = "
//            SELECT
//            books.id AS id,
//            books.title AS title,
//            books.excerpt AS excerpt,
//            books.authors_id AS authorID,
//            CONCAT(authors.firstname, ' ', authors.lastname) AS author,
//            genres.id AS genreId,
//            genres.name AS genre,
//            GROUP_CONCAT(tags.name SEPARATOR ',') AS tags
//            FROM library.books
//            INNER JOIN authors ON books.authors_id = authors.id
//            INNER JOIN genres ON books.genres_id = genres.id
//            LEFT JOIN books_tags ON books.id = books_tags.books_id
//            LEFT JOIN tags ON books_tags.tags_id = tags.id
//        ";
//
//        if(isset($param)) {
//            $query .= " WHERE $param[0] = :param ";
//        }
//
//        $query .= ' GROUP BY books.id';
//
//        $sql = $this->connection->prepare($query);
//        if(isset($param)) {
//            $sql->bindParam(':param', $param[1]);
//        }
//
//        $sql->execute();
//        $books = $sql->fetchAll();
//        foreach ($books as &$book) {
//            $book['tags'] = isset($book['tags']) ? explode(',', $book['tags']) : [];
//        }
//        if (isset($param)) {
//            return $books;
//        } else {
//            echo return_json($books);
//        }
        echo jsonResponse($this->all());
    }

    public function show($id)
    {
        //dd('bonjour');
//        $sql = $this->connection->prepare("
//        SELECT
//        books.id AS id,
//        books.title AS title,
//        books.excerpt AS excerpt,
//        books.authors_id AS authorID,
//        CONCAT(authors.firstname, ' ', authors.lastname) AS author,
//        genres.id AS genreId,
//        genres.name AS genre,
//        GROUP_CONCAT(tags.name SEPARATOR ',') AS tags
//        FROM library.books
//        INNER JOIN authors
//            ON books.authors_id = authors.id
//        INNER JOIN genres
//            ON books.genres_id = genres.id
//        LEFT JOIN books_tags
//            ON books.id = books_tags.books_id
//        LEFT JOIN tags
//            ON books_tags.tags_id = tags.id
//        WHERE books.id = :id;
//        ");
//        $sql->bindValue(':id', $id, PDO::PARAM_INT);
//        $sql->execute();
//        $book = $sql->fetch();
//        $book['tags'] = isset($book['tags']) ? explode(',', $book['tags']) : [];
//        echo return_json($book);
        echo jsonResponse($this->find($id));
    }

    public function update($object, $id)
    {
        //
    }


    public function create($object)
    {
        $this->post($object);
    }

    public function destroy($id)
    {
        //
    }

    public function add_tag($tag_id)
    {

    }

    static function validator($request)
    {

    }

}