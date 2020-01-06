<?php
namespace PhpNominatim;

use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    public function testSuccess()
    {
        $attributes = array(
            'data',
        );
        foreach ($attributes as $attribute) {
            $this->assertClassHasAttribute($attribute, Response::class);
        }
    }
}
