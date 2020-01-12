<?php
include __DIR__ . '/../src/autoload.php';

$client = new \Nominatim\Client();

try {
    $client
        ->setAddressDetails(1)
        ->setNameDetails(1)
        ->setExtraTags(1);
	$response = $client->search('Madison Square Garden, NY');
	if ($response->isOK())
    {
		echo $response->getLat() . ", " . $response->getLng();
		echo '<pre>';
		print_r($response->toArray());
	} else {
		echo 'Location not found.';
	}
} catch (InvalidArgumentException $e) {
	echo $e->getMessage();
} catch (Exception $e) {
	echo $e->getMessage();
}
