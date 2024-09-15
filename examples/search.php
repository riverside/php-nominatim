<?php
include __DIR__ . '/../src/autoload.php';

$client = new \Riverside\Nominatim\Client();

try {
    $client
        ->setAddressDetails(1)
        ->setNameDetails(1)
        ->setExtraTags(1);
	$response = $client->search('Madison Square Garden, NY');
	if ($response->isOK())
    {
		echo $response->getLat(0) . ", " . $response->getLng(0);
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
