<?php
declare(strict_types=1);

namespace Riverside\Nominatim;

/**
 * Class Transport
 *
 * @package Riverside\Nominatim
 */
class Transport
{
    /**
     * The number of seconds to wait while trying to connect. Use 0 to wait indefinitely.
     *
     * @var int
     */
    protected $connectTimeout = 10;

    /**
     * The last response code
     *
     * @var int
     */
    protected $httpCode;

    /**
     * The contents of the "Referer: " header to be used in a HTTP request.
     *
     * @var string
     */
    protected $referer = "";

    /**
     * The response
     *
     * @var mixed
     */
    protected $response;

    /**
     * false to stop cURL from verifying the peer's certificate
     *
     * @var bool
     */
    protected $sslVerifyPeer = false;

    /**
     * The maximum number of seconds to allow cURL functions to execute.
     *
     * @var int
     */
    protected $timeout = 15;

    /**
     * The contents of the "User-Agent: " header to be used in a HTTP request.
     *
     * @var string
     */
    protected $userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36';

    /**
     * Transport constructor.
     *
     * @throws \Exception
     */
    public function __construct()
    {
        if (!extension_loaded('curl'))
        {
            throw new \Exception('cURL extension is missing');
        }

        if (isset($_SERVER['HTTP_REFERER']))
        {
            $this->setReferer($_SERVER['HTTP_REFERER']);
        } elseif (getenv('HTTP_REFERER') !== false) {
            $this->setReferer(getenv('HTTP_REFERER'));
        }
    }

    /**
     * Perform a cURL session
     *
     * @param string $uri
     * @return array
     * @throws \Exception
     */
    public function request(string $uri): array
    {
        $ch = curl_init();
        if (!$ch)
        {
            throw new \Exception('Failed to initialize a cURL session');
        }
        $url = "https://nominatim.openstreetmap.org/" . $uri;
        curl_setopt($ch, CURLOPT_USERAGENT, $this->userAgent);
        curl_setopt($ch, CURLOPT_REFERER, $this->referer);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->connectTimeout);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->sslVerifyPeer);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $this->response = curl_exec($ch);
        $this->httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($this->httpCode != 200)
        {
            throw new \Exception("HTTP status code: {$this->httpCode}. Response: {$this->response}");
        }

        if (curl_errno($ch) == 28)
        {
            throw new \Exception('Timeout');
        }
        curl_close($ch);

        return [
            'request_url' => $url,
            'response_code' => $this->getHttpCode(),
            'response_data' => $this->getResponse(),
        ];
    }

    /**
     * Gets the last response code
     *
     * @return int
     */
    public function getHttpCode()
    {
        return $this->httpCode;
    }

    /**
     * Gets the response
     *
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Sets the connect timeout value
     *
     * @param int $value
     * @return Transport
     */
    public function setConnectTimeout(int $value): Transport
    {
        $this->connectTimeout = $value;

        return $this;
    }

    /**
     * Sets the referer value
     *
     * @param string $value
     * @return Transport
     */
    public function setReferer(string $value): Transport
    {
        $this->referer = $value;

        return $this;
    }

    /**
     * Sets the timeout value
     *
     * @param int $value
     * @return Transport
     */
    public function setTimeout(int $value): Transport
    {
        $this->timeout = $value;

        return $this;
    }

    /**
     * Sets the user-agent value
     *
     * @param string $value
     * @return Transport
     */
    public function setUserAgent(string $value): Transport
    {
        $this->userAgent = $value;

        return $this;
    }

    /**
     * Sets the ssl verify peer value
     *
     * @param bool $value
     * @return Transport
     */
    public function setSslVerifyPeer(bool $value): Transport
    {
        $this->sslVerifyPeer = $value;

        return $this;
    }
}
