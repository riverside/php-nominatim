<?php
namespace Nominatim;

class Transport
{
    protected $connectTimeout = 10;

    protected $httpCode;

    protected $response;

    protected $sslVerifyPeer = false;

    protected $timeout = 15;

    protected $userAgent = 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36';

    public function request($uri)
    {
        $ch = curl_init();
        if (!$ch)
        {
            throw new Exception('Failed to initialize a cURL session');
        }
        curl_setopt($ch, CURLOPT_USERAGENT, $this->userAgent);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->connectTimeout);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->sslVerifyPeer);
        curl_setopt($ch, CURLOPT_URL,"https://nominatim.openstreetmap.org/" . $uri);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $this->response = curl_exec($ch);
        $this->httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($this->httpCode != 200)
        {
            throw new Exception('HTTP status code: ' . $this->httpCode);
        }

        if (curl_errno($ch) == 28)
        {
            throw new Exception('Timeout');
        }
        curl_close($ch);

        return $this;
    }

    public function getHttpCode()
    {
        return $this->httpCode;
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function setConnectTimeout($value)
    {
        $this->connectTimeout = (int) $value;

        return $this;
    }

    public function setTimeout($value)
    {
        $this->timeout = (int) $value;

        return $this;
    }

    public function setUserAgent($value)
    {
        $this->userAgent = $value;

        return $this;
    }

    public function setSslVerifyPeer($value)
    {
        $this->sslVerifyPeer = (bool) $value;

        return $this;
    }
}
