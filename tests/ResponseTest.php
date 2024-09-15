<?php
declare(strict_types=1);

namespace Riverside\Nominatim\Tests;

use PHPUnit\Framework\TestCase;
use Riverside\Nominatim\Response;

class ResponseTest extends TestCase
{
    protected static function getError()
    {
        return [
            'request_url' => 'https://nominatim.openstreetmap.org/polygons?format=json',
            'response_code' => 400,
            'response_data' => '{"error":{"code":400,"message":"Floating-point number expected for parameter \'lat\'"}}',
        ];
    }

    protected static function getSuccess()
    {
        return [
            'request_url' => 'https://nominatim.openstreetmap.org/polygons?format=json',
            'response_code' => 200,
            'response_data' => '[{"place_id":113622144,"licence":"Data © OpenStreetMap contributors, ODbL 1.0. https://osm.org/copyright","osm_type":"way","osm_id":26776699,"lat":"43.217897747538196","lon":"27.9077954145579","display_name":"Neofit Rilski, жк Победа, Varna, 9004, Bulgaria","address":{"road":"Neofit Rilski","suburb":"жк Победа","city_district":"Varna","city":"Varna","county":"Varna","ISO3166-2-lvl6":"BG-03","postcode":"9004","country":"Bulgaria","country_code":"bg"},"boundingbox":["43.2177925","43.2180844","27.9055763","27.9086899"]}]',
        ];
    }

    public function testAttributes()
    {
        $attributes = array(
            'request_url',
            'response_code',
            'response_data',
        );
        foreach ($attributes as $attribute) {
            $this->assertClassHasAttribute($attribute, Response::class);
        }
    }

    public function testJson()
    {
        $this->assertTrue(extension_loaded('json'), 'JSON extension is missing');
    }

    public function testError()
    {
        $response = new Response(self::getError());

        $this->assertFalse($response->isOK());
        $this->assertIsArray($response->getError());
        $this->assertNotEmpty($response->getErrorMessage());
        $this->assertSame(400, $response->getErrorCode());
    }

    public function testSuccess()
    {
        $response = new Response(self::getSuccess());

        $this->assertTrue($response->isOK());
        $this->assertNull($response->getError());
        $this->assertEmpty($response->getErrorMessage());
        $this->assertSame(0, $response->getErrorCode());
    }

    public function testData()
    {
        $response = new Response(self::getSuccess());

        $this->assertSame('43.217897747538196', $response->getLat(0));
        $this->assertSame('27.9077954145579', $response->getLng(0));
        $this->assertSame('Neofit Rilski, жк Победа, Varna, 9004, Bulgaria', $response->getAddress(0));
        $this->assertSame(26776699, $response->getOsmId(0));
        $this->assertSame('way', $response->getOsmType(0));
        $this->assertSame(113622144, $response->getPlaceId(0));
    }

    public function testType()
    {
        $response = new Response(self::getSuccess());

        $this->assertIsArray($response->toArray());
        $this->assertJson($response->toJson());
    }
}
