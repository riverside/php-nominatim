<?php
namespace PhpNominatim;

use PHPUnit\Framework\TestCase;

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
}
