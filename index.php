<?php

use app\DataCache;
use app\DataProvider;
use app\cache\SimpleCachePool;
use app\logger\DummyLogger;
use app\logger\FileLogger;

require 'vendor/autoload.php';
require '_bootstrap.php';

$host = 'api.example.com';
$user = 'user';
$password = 'gtFNfsvY7Hj';

$cache = new SimpleCachePool();

//$logger = new DummyLogger();
$logger = new FileLogger();

$dataProvider = new DataProvider($host,$user,$password);
$dataProvider = new DataCache($dataProvider,$cache,$logger);

$data = ['key_1' => 'value1', 'key_2' => 'value2'];
//$data = ['key_3' => 'value3', 'key_4' => 'value4'];
//$data = ['key_5' => 'value5', 'key_6' => 'value6'];

echo "Get from source (5 sec)\n";
$results = $dataProvider->getResponse($data);
print_r($results);

echo "Get from cache \n";
$results = $dataProvider->getResponse($data);
print_r($results);

echo "Invalidate cache \n";
$cacheKey = $dataProvider->getCacheKey($data);
$dataProvider->invalidate($cacheKey);

echo "Get from source (5 sec)\n";
$results = $dataProvider->getResponse($data);

echo "Finally invalidate cache \n";
$dataProvider->invalidate($cacheKey);
print_r($results);