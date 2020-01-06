# php-nominatim
[![Build Status](https://api.travis-ci.org/riverside/php-nominatim.svg)](https://travis-ci.org/riverside/php-nominatim) [![Latest Stable Version](https://poser.pugx.org/riverside/php-nominatim/v/stable)](https://packagist.org/packages/riverside/php-nominatim) [![License](https://poser.pugx.org/riverside/php-nominatim/license)](https://packagist.org/packages/riverside/php-nominatim)

PHP client for Nominatim, a search engine for OpenStreetMap data.

https://zinoui.com/
#### Loading
```php
require __DIR__ . '/vendor/autoload.php';
```

#### Search (geocoding)
```php
$client = new \PhpNominatim\Client();
try {
    $response = $client->search('Madison Square Garden, NY');
    if ($response->isOK()) {
		echo $response->getLat() . ", " . $response->getLng();
    } else {
		echo 'Location not found.';
    }
} catch (\PhpNominatim\Exception $e) {
	echo $e->getMessage();
} catch (Exception $e) {
	echo $e->getMessage();
}
```

#### Reverse geocoding
```php
$client = new \PhpNominatim\Client();
try {
	$response = $client->reverse(48.8539373, 2.2825966);
	if ($response->isOK()) {
		echo $response->getAddress();
	} else {
		echo 'Address not found';
	}
} catch (\PhpNominatim\Exception $e) {
	echo $e->getMessage();
} catch (Exception $e) {
	echo $e->getMessage();
}
```

#### Address lookup
```php
$client = new \PhpNominatim\Client();
try {
	$client->setAddressDetails(1);
	$response = $client->lookup('R146656,W104393803,N240109189');
	if ($response->isOK()) {
		echo '<pre>';
		print_r($response->toArray());
	} else {
		echo 'Address not found';
	}
} catch (\PhpNominatim\Exception $e) {
	echo $e->getMessage();
} catch (Exception $e) {
	echo $e->getMessage();
}
```