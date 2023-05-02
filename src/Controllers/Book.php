<?php

namespace Controllers;


use MongoDB\BSON\ObjectId;
use PDO;
use Core\Connection;

class Book extends \Models\Book
{
    protected $connection;

    public function __construct()
    {
        $this->connection = new Connection();
        $this->connection->get()->selectCollection($this->table);
    }

    public function index()
    {
        echo jsonResponse($this->connection->get()->selectCollection($this->table)->find([], ['limit' => 4, 'skip' => 0])->toArray());
    }

    public function show($id)
    {
        $oid = new ObjectId($id);
        echo jsonResponse($this->connection->get()->selectCollection($this->table)->findOne(['_id' => $oid]));
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

    public function addTags($id, $request)
    {
        $newTagRelation['books_id'] = $id;
        $newTagRelation['tags_id'] = $request['id'];
        $bookTag = new BookTag();
        $bookTag->save($bookTag->validate($newTagRelation));
    }

}