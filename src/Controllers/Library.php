<?php

namespace Controllers;

use PDO;
use Core\Connection;
use Traits\ReturnJson;

class Library extends \Models\Library
{

    public function index()
    {
        echo jsonResponse($this->all());
    }

    public function show($id, $return = false)
    {
        //
    }

    public function update($object, $id)
    {
        //
    }


    public function create($object)
    {
        $this->save($object);
    }

    public function destroy($id)
    {
        //
    }
}