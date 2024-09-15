<?php
declare(strict_types=1);

namespace Riverside\Nominatim\Tests;

use PHPUnit\Framework\TestCase;
use Riverside\Nominatim\Client;
use Riverside\Nominatim\Response;

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
                $this->assertEquals('53.4794892', $response->getLat(0));
                $this->assertEquals('-2.2451148', $response->getLng(0));
                $this->assertEquals('Manchester, Greater Manchester, North West England, England, United Kingdom', $response->getAddress(0));
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
                $this->assertEquals('Quartier de la Muette, 16th Arrondissement, Paris, Ile-de-France, Metropolitan France, 75016, France', $response->getAddress(0));
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
                $this->assertEquals('40.7505247', $response->getLat(0));
                $this->assertEquals('-73.99355027800776', $response->getLng(0));
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

    public function testInvalidTypeNameDetails()
    {
        $this->expectException(\TypeError::class);

        $client = new Client();

        $client->setNameDetails('invalid');
    }

    public function testInvalidArgumentNameDetails()
    {
        $this->expectException(\InvalidArgumentException::class);

        $client = new Client();

        $client->setNameDetails(123);
    }

    public function testInvalidTypeExtraTags()
    {
        $this->expectException(\TypeError::class);

        $client = new Client();

        $client->setExtraTags('invalid');
    }

    public function testInvalidArgumentExtraTags()
    {
        $this->expectException(\InvalidArgumentException::class);

        $client = new Client();

        $client->setExtraTags(123);
    }

    public function testInvalidTypeAddressDetails()
    {
        $this->expectException(\TypeError::class);

        $client = new Client();

        $client->setAddressDetails('invalid');
    }

    public function testInvalidArgumentAddressDetails()
    {
        $this->expectException(\InvalidArgumentException::class);

        $client = new Client();

        $client->setAddressDetails(123);
    }

    public function testInvalidEmail()
    {
        $this->expectException(\InvalidArgumentException::class);

        $client = new Client();

        $client->setEmail('invalid');
    }

    public function testInvalidTypeDebug()
    {
        $this->expectException(\TypeError::class);

        $client = new Client();

        $client->setDebug('invalid');
    }

    public function testInvalidArgumentDebug()
    {
        $this->expectException(\InvalidArgumentException::class);

        $client = new Client();

        $client->setDebug(123);
    }
}
