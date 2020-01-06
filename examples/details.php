<?php
include __DIR__ . '/../src/autoload.php';

$client = new \PhpNominatim\Client();

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
} catch (\PhpNominatim\Exception $e) {
	echo $e->getMessage();
} catch (Exception $e) {
	echo $e->getMessage();
}
