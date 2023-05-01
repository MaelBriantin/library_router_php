<?php

namespace Controllers;


use PDO;
use Core\Connection;

class Book extends \Models\Book
{

    public function index(array $param=null)
    {
        echo jsonResponse($this->all());
    }

    public function show($id)
    {
        echo jsonResponse($this->find($id));
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