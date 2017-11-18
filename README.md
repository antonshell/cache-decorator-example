# Cache Decorator Example

Here is an example of using decorator pattern for caching.

# Usage

1 . Clone repository. 

2 . Install dependencies with composer

```
composer install
```

3 . Then run

```
php index.php
```

# Explanation

Usecase: We have slow external api. We need to make a lot of similar requests.

There is ```app/DataProvider``` class, which make api requests.
There is ```app/DataCache``` class, which is decorator.

We can use DataProvider like that. Then all calls will request external api.

```
$dataProvider = new DataProvider($host,$user,$password);

$data = ['key_1' => 'value1', 'key_2' => 'value2'];
$results = $dataProvider->getResponse($data);
```

Or we can wrap it with cache decorator. Then duplicate requests will be cached.
Invalidation is not implemented yet.

```
$dataProvider = new DataProvider($host,$user,$password);

$cache = new SimpleCachePool();
$dataProvider = new DataCache($dataProvider,$cache);

$data = ['key_1' => 'value1', 'key_2' => 'value2'];
$results = $dataProvider->getResponse($data);
```

See ```index.php``` for more details.