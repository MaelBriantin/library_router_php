<?php

namespace Traits;

trait RequestFormat
{
    function requestFormat ()
    {
        $data = file_get_contents("php://input");
        return json_decode($data, true);
    }
}