<?php

spl_autoload_register('autoLoader');

function autoLoader($className)
{
    $file = str_replace('\\',DIRECTORY_SEPARATOR,$className);
    require_once __DIR__ . DIRECTORY_SEPARATOR . $file . '.php';
    //Make your own path, Might need to use Magics like ___DIR___
}