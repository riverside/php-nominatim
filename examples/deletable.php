<?php
include __DIR__ . '/../src/autoload.php';

$client = new \Riverside\Nominatim\Client();

try {
    $response = $client->deletable();
    if ($response->isOK())
    {
        echo '<pre>';
        print_r($response->toArray());
    } else {
        echo 'Deletable object(s) not found';
    }
} catch (Exception $e) {
    echo $e->getMessage();
}
