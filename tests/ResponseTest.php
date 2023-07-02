<?php
namespace Nominatim\Tests;

use PHPUnit\Framework\TestCase;
use Nominatim\Response;

class ResponseTest extends TestCase
{
    protected $error = '{"error":{"code":400,"message":"Floating-point number expected for parameter \'lat\'"}}';

    protected $success = '{"place_id":113622144,"licence":"Data © OpenStreetMap contributors, ODbL 1.0. https://osm.org/copyright","osm_type":"way","osm_id":26776699,"lat":"43.217897747538196","lon":"27.9077954145579","display_name":"Neofit Rilski, жк Победа, Varna, 9004, Bulgaria","address":{"road":"Neofit Rilski","suburb":"жк Победа","city_district":"Varna","city":"Varna","county":"Varna","ISO3166-2-lvl6":"BG-03","postcode":"9004","country":"Bulgaria","country_code":"bg"},"boundingbox":["43.2177925","43.2180844","27.9055763","27.9086899"]}';

    public function testAttributes()
    {
        $attributes = array(
            'data',
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
        $response = new Response($this->error);

        $this->assertFalse($response->isOK());
        $this->assertIsArray($response->getError());
        $this->assertNotEmpty($response->getErrorMessage());
        $this->assertSame(400, $response->getErrorCode());
    }

    public function testSuccess()
    {
        $response = new Response($this->success);

        $this->assertTrue($response->isOK());
        $this->assertNull($response->getError());
        $this->assertEmpty($response->getErrorMessage());
        $this->assertSame(0, $response->getErrorCode());
    }

    public function testData()
    {
        $response = new Response($this->success);

        $this->assertSame('43.217897747538196', $response->getLat());
        $this->assertSame('27.9077954145579', $response->getLng());
        $this->assertSame('Neofit Rilski, жк Победа, Varna, 9004, Bulgaria', $response->getAddress());
        $this->assertSame('26776699', $response->getOsmId());
        $this->assertSame('way', $response->getOsmType());
        $this->assertSame('113622144', $response->getPlaceId());
    }

    public function testType()
    {
        $response = new Response($this->success);

        $this->assertIsArray($response->toArray());
        $this->assertJson($response->toJson());
    }
}
