<?php
namespace Nominatim;

class Response
{
    protected $data;

    public function __construct($data)
    {
        $data = json_decode($data, true);
        $this->data = isset($data[0]) ? $data[0] : $data;
    }

    public function getAddress()
    {
        return $this->data['display_name'];
    }

    public function getLat()
    {
        return $this->data['lat'];
    }

    public function getLng()
    {
        return $this->data['lon'];
    }

    public function toJson()
    {
        return json_encode($this->data);
    }

    public function toArray()
    {
        return $this->data;
    }

    public function getError()
    {
        return isset($this->data['error']) ? $this->data['error'] : null;
    }

    public function isOK()
    {
        return !isset($this->data['error']);
    }
}
