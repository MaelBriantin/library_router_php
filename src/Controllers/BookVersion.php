<?php

namespace Controllers;

class BookVersion extends \Models\BookVersion
{
    public function index()
    {
        echo jsonResponse($this->all());
        //dd('test');
    }

    public function show($id)
    {
        echo jsonResponse($this->find($id));
    }
}