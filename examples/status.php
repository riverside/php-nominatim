<?php
include __DIR__ . '/../src/autoload.php';

$client = new \Nominatim\Client();

try {
    $response = $client->status();
    if ($response->isOK())
    {
        echo '<pre>';
        print_r($response->toArray());
    } else {
        echo 'Status not found.';
    }
} catch (InvalidArgumentException $e) {
    echo $e->getMessage();
} catch (Exception $e) {
    echo $e->getMessage();
}
