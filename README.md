# php-nominatim
A PHP client for Nominatim, the search engine for OpenStreetMap data.

| Build | Stable | License |
| --- | --- | --- |
| [![Build Status](https://api.travis-ci.org/riverside/php-nominatim.svg)](https://travis-ci.org/riverside/php-nominatim) | [![Latest Stable Version](https://poser.pugx.org/riverside/php-nominatim/v/stable)](https://packagist.org/packages/riverside/php-nominatim) | [![License](https://poser.pugx.org/riverside/php-nominatim/license)](https://packagist.org/packages/riverside/php-nominatim) |

### Installation
- If Composer is already installed
```
composer require riverside/php-nominatim
```
- If Composer is not installed on your system yet, you may go ahead and install it using this command line:
```
$ curl -sS https://getcomposer.org/installer | php
```
Next, add the following require entry to the composer.json file in the root of your project.
```json
{
    "require" : {
        "riverside/php-nominatim" : "*"
    }
}
```
Finally, use Composer to install php-nominatim and its dependencies:
```
$ php composer.phar install
```

### Loading
```php
require __DIR__ . '/vendor/autoload.php';
```

### Search (geocoding)
```php
$client = new \Nominatim\Client();
try {
    $response = $client->search('Madison Square Garden, NY');
    if ($response->isOK()) {
        echo $response->getLat() . ", " . $response->getLng();
    } else {
        echo 'Location not found.';
    }
} catch (\Nominatim\Exception $e) {
    echo $e->getMessage();
} catch (Exception $e) {
    echo $e->getMessage();
}
```

### Reverse geocoding
```php
$client = new \Nominatim\Client();
try {
    $response = $client->reverse(48.8539373, 2.2825966);
    if ($response->isOK()) {
        echo $response->getAddress();
    } else {
        echo 'Address not found';
    }
} catch (\Nominatim\Exception $e) {
    echo $e->getMessage();
} catch (Exception $e) {
    echo $e->getMessage();
}
```

### Address lookup
```php
$client = new \Nominatim\Client();
try {
    $client->setAddressDetails(1);
    $response = $client->lookup('R146656,W104393803,N240109189');
    if ($response->isOK()) {
        echo '<pre>';
        print_r($response->toArray());
    } else {
        echo 'Address not found';
    }
} catch (\Nominatim\Exception $e) {
    echo $e->getMessage();
} catch (Exception $e) {
    echo $e->getMessage();
}
```

### Place details
```php
$client = new \Nominatim\Client();
try {
    $client->setAddressDetails(1);
    $response = $client->details(199375150);
    if ($response->isOK())
    {
        echo '<pre>';
        print_r($response->toArray());
    } else {
        echo 'Place not found';
    }
} catch (\Nominatim\Exception $e) {
    echo $e->getMessage();
} catch (Exception $e) {
    echo $e->getMessage();
}
```

### Links
- https://wiki.openstreetmap.org/wiki/Nominatim
- https://github.com/openstreetmap/Nominatim
- https://nominatim.openstreetmap.org/
- https://nominatim.org/
