<?php
include __DIR__ . '/../src/autoload.php';

$client = new \Nominatim\Client();

try {
	$response = $client->search('Madison Square Garden, NY');
	if ($response->isOK())
    {
		echo $response->getLat() . ", " . $response->getLng();
	} else {
		echo 'Location not found.';
	}
} catch (\Nominatim\Exception $e) {
	echo $e->getMessage();
} catch (Exception $e) {
	echo $e->getMessage();
}
