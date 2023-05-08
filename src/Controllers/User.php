<?php

namespace Controllers;

use Core\Connection;
use DateTime;
use MongoDB\BSON\ObjectId;
use MongoDB\Model\BSONDocument;

class User extends \Models\User
{
    public function index()
    {
        echo jsonResponse($this->collection->find([], ["limit" => 10])->toArray());
    }

    public function show($id)
    {
        $lastMonth = new DateTime('-1 month');

        $user = $this->collection
                ->findOne(['_id' => new ObjectId($id)]);
        $user['booksOwnedCount'] = $this->collection->countDocuments(['library.book' => ['$exists' => true]]);
        $user['booksReadingCount'] = $this->collection->countDocuments(['library.readingStatus' => 'en cours']);

        $user['lastMonthReadingBooksCount'] = $this->collection->countDocuments([
            'library.readingStatus' => 'lu',
            'library.readingEndDate' => ['$gte' => $lastMonth]
        ]);

        echo jsonResponse($user);
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
                        "book" => $request['bookId'],
                        "edition" => $request['edition'],
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
                        "book" => $request['bookId'],
                    ]
                ]
            ]
        );
    }

    public function postReview($id, $request)
    {
        $book = new \Models\Book();
        /** @var BSONDocument $existingReview */
        $existingReview = $book->collection->findOne(
            [
                "_id" => new \MongoDB\BSON\ObjectId($request['bookId']),
                "reviews.userId" => $id
            ]
        );

        if (!$existingReview) {
            $book->collection->updateOne(["_id" => new \MongoDB\BSON\ObjectId($request['bookId'])],
                ['$addToSet' =>
                    [
                        'reviews' => [
                            "userId" => $id,
                            "review" => $request['review'],
                            "comment" => $request['comment']
                        ]
                    ]]
            );
        }
        else {
            abort(400, 'You have already posted a review for this book, space cowboy.');
        }
    }

    public function updateReview($id, $request)
    {
        $book = new \Models\Book();
        //dd($request);

            $book->collection->updateOne(
                ["_id" => new \MongoDB\BSON\ObjectId($request['bookId']), "reviews.userId" => $id],
                [
                    '$set' => [
                        'reviews.$.review' => $request['review'],
                        'reviews.$.comment' => $request['comment'],
                    ]
                ]
            );
            //dd($result->getModifiedCount());
    }
}