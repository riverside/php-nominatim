<?php
declare(strict_types=1);

namespace Riverside\Nominatim;

/**
 * Class Client
 *
 * @package Riverside\Nominatim
 */
class Client
{
    /**
     * Preferred language order for showing search results, overrides the value specified in the "Accept-Language" HTTP header.
     *
     * @var string
     */
    protected $acceptLanguage = 'en-US';

    /**
     * Include a breakdown of the address into elements.
     *
     * @var int
     */
    protected $addressDetails = 0;

    /**
     * Output assorted developer debug information
     *
     * @var int
     */
    protected $debug = 0;

    /**
     * Email address is used to identify your requests
     *
     * @var string
     */
    protected $email = null;

    /**
     * Include additional information in the result if available, e.g. wikipedia link, opening hours.
     *
     * @var int
     */
    protected $extraTags = 0;

    /**
     * Output format
     *
     * @var string
     */
    protected $format = 'json';

    /**
     * Wrap JSON output in a callback function (JSONP)
     *
     * @var string
     */
    protected $jsonCallback = null;

    /**
     * Include a list of alternative names in the results.
     *
     * @var int
     */
    protected $nameDetails = 0;

    /**
     * List objects that have been deleted in OSM but are held back in Nominatim in case the deletion was accidental
     *
     * @return Response
     * @throws \Exception
     */
    public function deletable(): Response
    {
        $params = array(
            'format' => $this->format,
        );

        $params = http_build_query($params, '', '&');

        $transport = new Transport();
        $data = $transport->request('deletable?' . $params);

        return new Response($data);
    }

    /**
     * Show all details about a single place saved in the database.
     *
     * @param int $place_id
     * @param array|null $custom
     * @return Response
     * @throws \Exception
     */
    public function details(int $place_id, array $custom=null): Response
    {
        $params = array(
            'place_id'        => $place_id,
            'format'          => $this->format,
            'json_callback'   => $this->jsonCallback,
            'addressdetails'  => $this->addressDetails,
            'accept-language' => $this->acceptLanguage,
        );

        if ($custom)
        {
            $params = array_merge($params, $custom);
        }
        $params = http_build_query($params, '', '&');

        $transport = new Transport();
        $data = $transport->request('details?' . $params);

        return new Response($data);
    }

    /**
     * Query the address and other details of one or multiple OSM objects like node, way or relation.
     *
     * @param string $osm_ids
     * @param array|null $custom
     * @return Response
     * @throws \Exception
     */
    public function lookup(string $osm_ids, array $custom=null): Response
    {
        $params = array(
            'osm_ids'         => $osm_ids,
            'format'          => $this->format,
            'json_callback'   => $this->jsonCallback,
            'addressdetails'  => $this->addressDetails,
            'extratags'       => $this->extraTags,
            'namedetails'     => $this->nameDetails,
            'accept-language' => $this->acceptLanguage,
            'email'           => $this->email,
            'debug'           => $this->debug,
        );

        if ($custom)
        {
            $params = array_merge($params, $custom);
        }
        $params = http_build_query($params, '', '&');

        $transport = new Transport();
        $data = $transport->request('lookup?' . $params);

        return new Response($data);
    }

    /**
     * List of broken polygons detected by Nominatim
     *
     * @return Response
     * @throws \Exception
     */
    public function polygons(): Response
    {
        $params = array(
            'format' => $this->format,
        );

        $params = http_build_query($params, '', '&');

        $transport = new Transport();
        $data = $transport->request('polygons?' . $params);

        return new Response($data);
    }

    /**
     * Generates an address from a latitude and longitude.
     *
     * @param float $lat
     * @param float $lng
     * @param array|null $custom
     * @return Response
     * @throws \Exception
     */
    public function reverse(float $lat, float $lng, array $custom=null): Response
    {
        $params = array(
            'lat'             => $lat,
            'lon'             => $lng,
            'format'          => $this->format,
            'json_callback'   => $this->jsonCallback,
            'addressdetails'  => $this->addressDetails,
            'extratags'       => $this->extraTags,
            'namedetails'     => $this->nameDetails,
            'accept-language' => $this->acceptLanguage,
            'email'           => $this->email,
            'debug'           => $this->debug,
        );

        if ($custom)
        {
            $params = array_merge($params, $custom);
        }
        $params = http_build_query($params, '', '&');

        $transport = new Transport();
        $data = $transport->request('reverse?' . $params);

        return new Response($data);
    }

    /**
     * Look up a location by given address
     *
     * @param string $address
     * @param array|null $custom
     * @return Response
     * @throws \Exception
     */
    public function search(string $address, array $custom=null): Response
    {
        $params = array(
            'q'               => $address,
            'limit'           => 1,
            'format'          => $this->format,
            'json_callback'   => $this->jsonCallback,
            'addressdetails'  => $this->addressDetails,
            'extratags'       => $this->extraTags,
            'namedetails'     => $this->nameDetails,
            'accept-language' => $this->acceptLanguage,
            'email'           => $this->email,
            'debug'           => $this->debug,
        );

        if ($custom)
        {
            $params = array_merge($params, $custom);

            foreach (['amenity', 'street', 'city', 'county', 'state', 'country', 'postalcode'] as $key)
            {
                if (isset($params[$key]) && !empty($params[$key]))
                {
                    unset($params['q']);
                    break;
                }
            }
        }
        $params = http_build_query($params, '', '&');

        $transport = new Transport();
        $data = $transport->request('search?' . $params);

        return new Response($data);
    }

    /**
     * Sets the accepted language
     *
     * @param string $value
     * @return Client
     */
    public function setAcceptLanguage(string $value): Client
    {
        $this->acceptLanguage = $value;

        return $this;
    }

    /**
     * Sets the address details
     *
     * @param int $value
     * @return Client
     */
    public function setAddressDetails(int $value): Client
    {
        if (!in_array($value, array(1, 0)))
        {
            throw new \InvalidArgumentException("Invalid value for \$addressDetails.");
        }

        $this->addressDetails = $value;

        return $this;
    }

    /**
     * Sets the debug
     *
     * @param int $value
     * @return Client
     */
    public function setDebug(int $value): Client
    {
        if (!in_array($value, array(1, 0)))
        {
            throw new \InvalidArgumentException("Invalid value for \$debug.");
        }

        $this->debug = $value;

        return $this;
    }

    /**
     * Sets the email
     *
     * @param string $value
     * @return Client
     */
    public function setEmail(string $value): Client
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL))
        {
            throw new \InvalidArgumentException("Invalid value for \$email.");
        }

        $this->email = $value;

        return $this;
    }

    /**
     * Sets the extra tag
     *
     * @param int $value
     * @return Client
     */
    public function setExtraTags(int $value): Client
    {
        if (!in_array($value, array(1, 0)))
        {
            throw new \InvalidArgumentException("Invalid value for \$extraTags.");
        }

        $this->extraTags = $value;

        return $this;
    }

    /**
     * Sets the json callback
     *
     * @param string $value
     * @return Client
     */
    public function setJsonCallback(string $value): Client
    {
        $this->jsonCallback = $value;

        return $this;
    }

    /**
     * Sets the name details
     *
     * @param int $value
     * @return Client
     */
    public function setNameDetails(int $value): Client
    {
        if (!in_array($value, array(1, 0)))
        {
            throw new \InvalidArgumentException("Invalid value for \$nameDetails.");
        }

        $this->nameDetails = $value;

        return $this;
    }

    /**
     * Check if the service and database is running, and when the database was last updated.
     *
     * @return Response
     * @throws \Exception
     */
    public function status(): Response
    {
        $params = array(
            'format' => $this->format,
        );

        $params = http_build_query($params, '', '&');

        $transport = new Transport();
        $data = $transport->request('status?' . $params);

        return new Response($data);
    }
}
