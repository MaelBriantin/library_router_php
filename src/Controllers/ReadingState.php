<?php

namespace Controllers;

class ReadingState extends \Models\ReadingState
{
    public function index()
    {
        echo jsonResponse($this->all());
    }
}