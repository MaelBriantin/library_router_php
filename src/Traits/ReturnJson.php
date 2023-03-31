<?php

namespace Traits;
trait ReturnJson {
    public function returnJsonFormat ($result)
    {
        if (!env('DEBUG_MODE')) header('Content-Type: application/json; charset=utf-8');
        return json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
}