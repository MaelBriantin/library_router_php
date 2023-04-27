<?php

namespace Controllers;

class Author extends \Models\Author
{
    public function index()
    {
        echo jsonResponse($this->all());
    }

    public function show($id)
    {
        echo jsonResponse($this->find($id));
    }

    public function destroy($id)
    {

    }

    public function books($id): void
    {
        $author = $this->find($id);
        $books = new Book();
        $author['books'] = $books->findAll($id, 'author_id');
        echo jsonResponse($author);
    }
}