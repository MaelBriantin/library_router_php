<?php

function debugMode ()
{
    if (env('DEBUG_MODE'))
    {
        $debug = [
            ini_set('display_errors', 1),
            ini_set('display_startup_errors', 1),
            //error_reporting(E_ALL),
        ];
        echo "<pre style='color: red'><b>DEBUG_MODE</b></pre>";
        foreach ($debug as $item) {
            echo $item;
        }
        return false;
    }
    return true;
}

debugMode();