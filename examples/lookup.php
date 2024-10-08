<?php
include __DIR__ . '/../src/autoload.php';

$client = new \Riverside\Nominatim\Client();

try {
	$client
        ->setAddressDetails(1)
        ->setNameDetails(1)
        ->setExtraTags(1);
	$response = $client->lookup('R146656,W104393803,N240109189');
	if ($response->isOK())
	{
		echo '<pre>';
		print_r($response->toArray());
	} else {
		echo 'Address not found';
	}
} catch (InvalidArgumentException $e) {
	echo $e->getMessage();
} catch (Exception $e) {
	echo $e->getMessage();
}
