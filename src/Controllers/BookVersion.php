<?php

namespace Controllers;

class BookVersion extends \Models\BookVersion
{
    public function index()
    {
        echo jsonResponse($this->all());
    }

    public function show($id)
    {
        echo jsonResponse($this->find($id));
    }

    public function findByPublisher($id)
    {
        echo jsonResponse($this->findAll($id, 'publisher_id'));
    }

    public function findByEdition($id)
    {
        echo jsonResponse($this->findAll($id, 'edition_id'));
    }
}