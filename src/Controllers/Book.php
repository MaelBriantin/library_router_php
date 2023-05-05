<?php

namespace Controllers;


use MongoDB\BSON\ObjectId;

class Book extends \Models\Book
{
    public function index()
    {
        echo jsonResponse(
            $this->collection
                ->find([], ['limit' => 10, 'skip' => 0])
                ->toArray()
        );
    }

    public function show($id)
    {
        echo jsonResponse(
            $this->collection
                ->findOne(['_id' => new ObjectId($id)])
        );
    }

    public function update($object, $id)
    {
        //
    }


    public function create($object)
    {
        $this->collection->insertOne($object);
    }

    public function destroy($id)
    {
        //
    }

    public function addTags($id, $request)
    {
        //
    }

    public function addTag($id, $request)
    {
        //dd($request);
        $this->collection->updateOne(["_id" => new \MongoDB\BSON\ObjectId($id)],
            ['$addToSet' =>
                [
                    "tags" =>
                        $request['tag'],

                ]
            ]
        );
    }

    public function removeTag($id, $request)
    {
        $this->collection->updateOne(["_id" => new \MongoDB\BSON\ObjectId($id)],
            ['$pull' =>
                [
                    "tags" =>
                        $request['tag'],

                ]
            ]
        );
    }

}