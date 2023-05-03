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
        //
    }

    public function destroy($id)
    {
        //
    }

    public function addTag($id, $request)
    {
        $newTagRelation['book_id'] = $id;
        $newTagRelation['tag_id'] = $request['id'];
        $bookTag = new BookTag();
        $bookTag->save($newTagRelation);
    }

    public function tags($id)
    {
        $bookTag = new BookTag();
        echo jsonResponse($bookTag->findAll($id, 'book_id'));
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
        $instance = new Comment();
        $comments = $instance->findAll($id, 'book_id');
        $book['averageReview'] = $instance->selectAverage('review', 'book_id', $id);
        foreach ($comments as $comment){
            $book['comments'][] = only($comment, ['id', 'review', 'comment', 'userUsername']);
        }
        echo jsonResponse($book);
    }
}