<?php
namespace Nominatim\Tests;

use PHPUnit\Framework\TestCase;
use Nominatim\Response;

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
