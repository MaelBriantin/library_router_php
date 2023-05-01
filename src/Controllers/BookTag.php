<?php

namespace Controllers;

class BookTag extends \Models\BookTag
{
    public function index()
    {
        echo jsonResponse($this->all());
    }

    public function create()
    {
        //
    }
}