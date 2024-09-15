<?php
include __DIR__ . '/../src/autoload.php';

$client = new \Riverside\Nominatim\Client();

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
} catch (InvalidArgumentException $e) {
	echo $e->getMessage();
} catch (Exception $e) {
	echo $e->getMessage();
}
