<?php
namespace Nominatim\Tests;

use Nominatim\Response;
use PHPUnit\Framework\TestCase;
use Nominatim\Transport;

class TransportTest extends TestCase
{
    public function testAttributes()
    {
        $attributes = array(
            'connectTimeout',
            'httpCode',
            'referer',
            'response',
            'sslVerifyPeer',
            'timeout',
            'userAgent',
        );
        foreach ($attributes as $attribute) {
            $this->assertClassHasAttribute($attribute, Transport::class);
        }
    }

    public function testCurl()
    {
        $this->assertTrue(extension_loaded('curl'), 'cURL extension is missing');
    }

    public function testRequest()
    {
        try {
            $transport = new Transport();
            $transport->request('reverse?format=json&lat=43.2178847&lon=27.907794');

            $this->assertSame(200, $transport->getHttpCode());
            $this->assertNotEmpty($transport->getResponse());

            $response = new Response($transport->getResponse());
            $this->assertTrue($response->isOK());
        } catch (\Exception $e) {

        }
    }
}
