<?php

namespace Controllers;

use Core\Connection;
use PDO;

class Tag extends \Models\Tag
{
    protected $connection;


    public function index ()
    {
        echo jsonResponse($this->all());
    }

    public function books ($id)
    {
        $bookTag = new \Models\BookTag();
        echo jsonResponse($bookTag->findAll($id, 'tag_id'));
    }
}