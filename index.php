<?php

use app\DataCache;
use app\DataProvider;
use app\cache\SimpleCachePool;

require 'vendor/autoload.php';

spl_autoload_register('autoLoader');

function autoLoader($className)
{
    $file = str_replace('\\',DIRECTORY_SEPARATOR,$className);
    require_once __DIR__ . DIRECTORY_SEPARATOR . $file . '.php';
    //Make your own path, Might need to use Magics like ___DIR___
}

$host = 'api.example.com';
$user = 'user';
$password = 'gtFNfsvY7Hj';

$cache = new SimpleCachePool();

$dataProvider = new DataProvider($host,$user,$password);
$dataProvider = new DataCache($dataProvider,$cache);

$data = ['key_1' => 'value1', 'key_2' => 'value2'];
//$data = ['key_3' => 'value3', 'key_4' => 'value4'];
//$data = ['key_5' => 'value5', 'key_6' => 'value6'];
$results = $dataProvider->getResponse($data);

print_r($results);