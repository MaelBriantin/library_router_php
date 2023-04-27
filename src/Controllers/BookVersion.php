<?php

namespace Controllers;

class BookVersion extends \Models\BookVersion
{
    public function index()
    {
        echo jsonResponse($this->all());
    }
}