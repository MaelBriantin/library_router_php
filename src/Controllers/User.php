<?php

namespace Controllers;

use Core\Connection;
use MongoDB\BSON\ObjectId;

class User extends \Models\User
{
    public function index()
    {
        echo jsonResponse($this->collection->find([], ["limit" => 10])->toArray());
    }

    public function show($id)
    {
        echo jsonResponse(
            $this->collection
                ->findOne(['_id' => new ObjectId($id)])
        );
    }

    public function update($id, $object)
    {
        //
    }


    public function create($object)
    {
        //dd($object);
        $this->collection->insertOne($object);
    }

    public function destroy($id): void
    {
        //
    }

    public function libraries(int $id): void
    {
        $user = $this->find($id);
        $library = new Library();
        $user['library'] = $library->findAll($id, 'user_id');
        echo jsonResponse($user);
    }

    public function addBookToLibrary($id, $request)
    {
        $this->collection->updateOne(["_id" => new \MongoDB\BSON\ObjectId($id)],
            ['$addToSet' =>
                [
                    "library" => [
                        "book"      => $request['bookId'],
                        "edition"   => $request['edition'],
                        "publisher" => $request['publisher']
                    ]
                ]
            ]
        );
    }

    public function addBookToWishlist($id, $request)
    {
        $this->collection->updateOne(["_id" => new \MongoDB\BSON\ObjectId($id)],
            ['$addToSet' =>
                [
                    "wishlist" => [
                        "book"      => $request['bookId'],
                    ]
                ]
            ]
        );
    }
}