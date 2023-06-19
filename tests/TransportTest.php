<?php
namespace Nominatim\Tests;

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
}
