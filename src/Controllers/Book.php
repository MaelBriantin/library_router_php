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

    public function add_tag($tag_id)
    {

    }

    static function validator($request)
    {

    }

}