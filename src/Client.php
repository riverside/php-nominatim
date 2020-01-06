<?php
namespace PhpNominatim;

class Client
{
    protected $acceptLanguage = 'en-US';

    protected $addressDetails = 0;

    protected $debug = 0;

    protected $email = null;

    protected $extraTags = 0;

    protected $format = 'json';

    protected $jsonCallback = null;

    protected $nameDetails = 0;

    public function details($place_id, $custom=array())
    {
        $params = array(
            'place_id'        => $place_id,
            'format'          => $this->format,
            'json_callback'   => $this->jsonCallback,
            'addressdetails'  => $this->addressDetails,
            'accept-language' => $this->acceptLanguage,
        );

        $params = array_merge($params, $custom);
        $params = http_build_query($params, null, '&');

        $transport = new Transport();
        $transport->request('details?' . $params);

        return new Response($transport->getResponse());
    }

    public function lookup($osm_ids, $custom=array())
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

        $params = array_merge($params, $custom);
        $params = http_build_query($params, null, '&');

        $transport = new Transport();
        $transport->request('lookup?' . $params);

        return new Response($transport->getResponse());
    }

    public function reverse($lat, $lng, $custom=array())
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

        $params = array_merge($params, $custom);
        $params = http_build_query($params, null, '&');

        $transport = new Transport();
        $transport->request('reverse?' . $params);

        return new Response($transport->getResponse());
    }

    public function search($address, $custom=array())
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

        $params = array_merge($params, $custom);
        $params = http_build_query($params, null, '&');

        $transport = new Transport();
        $transport->request('search?' . $params);

        return new Response($transport->getResponse());
    }

    public function setAcceptLanguage($value)
    {
        $this->acceptLanguage = $value;

        return $this;
    }

    public function setAddressDetails($value)
    {
        if (!in_array($value, array(1,0)))
        {
            throw new Exception("Invalid value for \$addressDetails.");
        }

        $this->addressDetails = $value;

        return $this;
    }

    public function setDebug($value)
    {
        if (!in_array($value, array(1,0)))
        {
            throw new Exception("Invalid value for \$debug.");
        }

        $this->debug = $value;

        return $this;
    }

    public function setEmail($value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL))
        {
            throw new Exception("Invalid value for \$email.");
        }

        $this->email = $value;

        return $this;
    }

    public function setExtraTags($value)
    {
        if (!in_array($value, array(1,0)))
        {
            throw new Exception("Invalid value for \$extraTags.");
        }

        $this->extraTags = $value;

        return $this;
    }

    public function setJsonCallback($value)
    {
        $this->jsonCallback = $value;

        return $this;
    }

    public function setNameDetails($value)
    {
        if (!in_array($value, array(1,0)))
        {
            throw new Exception("Invalid value for \$nameDetails.");
        }

        $this->nameDetails = $value;

        return $this;
    }
}
