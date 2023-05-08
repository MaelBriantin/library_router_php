<?php

namespace Controllers;


use MongoDB\BSON\ObjectId;

class Book extends \Models\Book
{
    public function index()
    {
        echo jsonResponse(
            $this->collection
                ->find([], ['limit' => 10, 'skip' => 0, 'sort' => ['publishedYear' => -1]])
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

    public function searchElement($element, $request)
    {
        echo jsonResponse($this->collection->findOne([$element => $request[$element]]));
    }

    public function searchInArray($array, $request)
    {
        echo jsonResponse($this->collection->find([$array => ['$in' => $request[$array]]]));
    }

    public function author($request)
    {
        $author = $request['author'];
        $userInstance = new \Models\User();
        $result['name'] = $author;
        $result['booksAddedCount'] = $userInstance->collection->countDocuments([
                'wishlist' => ['$elemMatch' => ['book' => ['$in' => $this->collection->distinct('_id', ['author' => $author])]]],
                'library' => ['$elemMatch' => ['book' => ['$in' => $this->collection->distinct('_id', ['author' => $author])]]]
        ]);


        $averageRating = $this->collection->aggregate([
            ['$match' => ['author' => $author]],
            ['$group' => ['_id' => null, 'avgRating' => ['$avg' => '$reviews.review']]]
        ])->toArray();

        $result['averageRating'] = !empty($averageRating) ? $averageRating[0]['avgRating'] : 0;

        echo jsonResponse($result);
    }
}