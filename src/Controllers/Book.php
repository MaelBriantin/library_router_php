<?php

namespace Controllers;


use Models\Comment;
use PDO;
use Core\Connection;

class Book extends \Models\Book
{

    public function index()
    {
        echo jsonResponse($this->all());
    }

    public function show($id)
    {
        $book = $this->find($id);
        $instance = new \Models\BookTag();
        $tags = $instance->findAll($id, 'book_id');
        foreach ($tags as $tag){
            $book['tags'][] = $tag['tagName'];
        }
        echo jsonResponse($book);
    }

    public function update($object)
    {
        //
    }


    public function create($object)
    {
        $this->save($this->validate($object));
    }

    public function destroy($id)
    {
        //
    }

    public function addTag($id, $request)
    {
        $newTagRelation['book_id'] = $id;
        $newTagRelation['tag_id'] = $request['tagId'];
        $bookTag = new BookTag();
        $bookTag->save($newTagRelation);
    }

    public function tags($id)
    {
        $bookTag = new BookTag();
        echo jsonResponse(only(['tagName', 'id'], $bookTag->findAll($id, 'book_id'), true));
    }

    public function removeTag($id, $request)
    {
        $bookTag = new BookTag();
        $bookTag->delete(['book_id', '=', $id], ['tag_id', '=', $request['tag_id']]);
    }

    public function addComment($id, $request)
    {
        $newComment['book_id'] = $id;
        $newComment['user_id'] = $request['user_id'] ?? null;
        $newComment['comment'] = $request['comment'] ?? abort(400, 'missing required element');
        $newComment['review'] = $request['review'] ?? abort(400, 'missing required element');
        $comment = new Comment();
        $comment->save($newComment);
        $this->comments($id);
    }

    public function comments($id)
    {
        $book = $this->find($id);
        $commentInstance = new Comment();
        $comments = $commentInstance->findAll($id, 'book_id');
        $averageReview = $commentInstance->selectAverage('review', ['book_id', '=', $id]);
        $book['averageReview'] = round($averageReview, 1);
        $book['comments'] = only(['id', 'review', 'comment', 'userUsername'], $comments, true);
        echo jsonResponse($book);
    }

    public function search($search, $request)
    {
        $element = "'%$request[$search]%'";
        $query =
            $this->select($this->fillable)
            .$this->from($this->table)
            .$this->where($search, 'like', $element);
        //dd($query);
        $result = $this->customQuery($query);
        dd($result->fetch());
    }

    public function infos($id)
    {
        $result = $this->find($id);
        $tags = new \Models\BookTag();
        $result['tags'] = only(['id', 'tagName'], $tags->findAll($id, 'book_id'), true);
        $comments = new Comment();
        $reviews = $comments->findAll($id, 'book_id');
        $averageReview = $comments->selectAverage('review', ['book_id', '=', $id]);
        $result['averageReview'] = round($averageReview, 1);
        $result['reviews'] = only(['id', 'review', 'comment', 'userUsername'], $reviews, true);
        echo jsonResponse($result);
    }
}