<?php
include __DIR__ . '/../src/autoload.php';

$client = new \Nominatim\Client();

try {
    $client
        ->setAddressDetails(1)
        ->setNameDetails(1)
        ->setExtraTags(1);
	$response = $client->reverse(48.8539373, 2.2825966);
	if ($response->isOK())
	{
		echo $response->getAddress();
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
