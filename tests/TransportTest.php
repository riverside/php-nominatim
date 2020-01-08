<?php
namespace Nominatim;

use PHPUnit\Framework\TestCase;

class TransportTest extends TestCase
{
    public function testAttributes()
    {
        $attributes = array(
            'connectTimeout',
            'httpCode',
            'response',
            'sslVerifyPeer',
            'timeout',
            'userAgent',
        );
        foreach ($attributes as $attribute) {
            $this->assertClassHasAttribute($attribute, Transport::class);
        }
    }
}
