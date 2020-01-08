<?php
include __DIR__ . '/../src/autoload.php';

$client = new \Nominatim\Client();

try {
	$response = $client->reverse(48.8539373, 2.2825966);
	if ($response->isOK())
	{
		echo $response->getAddress();
	} else {
		echo 'Address not found';
	}
} catch (\Nominatim\Exception $e) {
	echo $e->getMessage();
} catch (Exception $e) {
	echo $e->getMessage();
}
