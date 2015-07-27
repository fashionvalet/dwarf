## Dwarf [WIP]

Dwarf is an agnostic wrapper for [Elasticsearch](https://github.com/elastic/elasticsearch-php) PHP official client. The package provides a more easier and flexible way to interact with the library.

**This package is still under active development.**

### Usage

```php
<?php
include __DIR__.'/../vendor/autoload.php';

use Fv\Dwarf\Document;
use Elasticsearch\ClientBuilder as Client;

//Create elasticsearch instance
$client = Client::create()
    ->setHosts(['127.0.0.1:9200'])
    ->build();

$dwarf = new Document($client);

$product = $dwarf->index('products')
    ->type('product')
    ->find(7837);

var_dump($product); //Retreive single product

$products = $dwarf->index('products')
    ->type('product')
    ->all();

var_dump($products); //Retrieve all available products
```

### TODO
* Elasticsearch indexer for creating and updating indexes
* Query builder for searching
