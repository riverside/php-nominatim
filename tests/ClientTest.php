<?php
namespace Nominatim\Tests;

use PHPUnit\Framework\TestCase;
use Nominatim\Client;
use Nominatim\Response;

class ClientTest extends TestCase
{
    public function testAttributes()
    {
        $attributes = array(
            'acceptLanguage',
            'addressDetails',
            'debug',
            'email',
            'extraTags',
            'format',
			'jsonCallback',
			'nameDetails',
        );
        foreach ($attributes as $attribute) {
            $this->assertClassHasAttribute($attribute, Client::class);
        }
    }

    public function testDetails()
    {
        $client = new Client();
        try {
            $response = $client->details(199375150);

            $this->assertInstanceOf(Response::class, $response);
            $this->assertTrue($response->isOK());

        } catch (\Exception $e) {}
    }

    public function testLookup()
    {
        $client = new Client();
        try {
            $response = $client->lookup('R146656,W104393803,N240109189');

            $this->assertInstanceOf(Response::class, $response);

            if ($response->isOK())
            {
                $this->assertEquals('53.4794892', $response->getLat());
                $this->assertEquals('-2.2451148', $response->getLng());
                $this->assertEquals('Manchester, Greater Manchester, North West England, England, United Kingdom', $response->getAddress());
            }
        } catch (\Exception $e) {}
    }

    public function testReverse()
    {
        $client = new Client();
        try {
            $response = $client->reverse(48.8539373, 2.2825966);

            $this->assertInstanceOf(Response::class, $response);

            if ($response->isOK())
            {
                $this->assertEquals('Quartier de la Muette, 16th Arrondissement, Paris, Ile-de-France, Metropolitan France, 75016, France', $response->getAddress());
            }
        } catch (\Exception $e) {}
    }

    public function testSearch()
    {
        $client = new Client();
        try {
            $response = $client->search('Madison Square Garden, NY');

            $this->assertInstanceOf(Response::class, $response);

            if ($response->isOK())
            {
                $this->assertEquals('40.7505247', $response->getLat());
                $this->assertEquals('-73.99355027800776', $response->getLng());
            }
        } catch (\Exception $e) {}
    }

    public function testStatus()
    {
        $client = new Client();
        try {
            $response = $client->status();

            $this->assertInstanceOf(Response::class, $response);

            if ($response->isOK())
            {
                $result = $response->toArray();
                $this->assertEquals('OK', $result['message']);
            }
        } catch (\Exception $e) {}
    }

    public function testInvalidNameDetails()
    {
        $this->expectException(\InvalidArgumentException::class);

        $client = new Client();

        $client->setNameDetails('invalid');
    }

    public function testInvalidExtraTags()
    {
        $this->expectException(\InvalidArgumentException::class);

        $client = new Client();

        $client->setExtraTags('invalid');
    }

    public function testInvalidAddressDetails()
    {
        $this->expectException(\InvalidArgumentException::class);

        $client = new Client();

        $client->setAddressDetails('invalid');
    }

    public function testInvalidEmail()
    {
        $this->expectException(\InvalidArgumentException::class);

        $client = new Client();

        $client->setEmail('invalid');
    }

    public function testInvalidDebug()
    {
        $this->expectException(\InvalidArgumentException::class);

        $client = new Client();

        $client->setDebug('invalid');
    }
}
