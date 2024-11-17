<?php
declare(strict_types=1);

namespace Riverside\Nominatim;

/**
 * Class Response
 *
 * @package Riverside\Nominatim
 */
class Response
{
    /**
     * Request URL
     *
     * @var string
     */
    protected $request_url;

    /**
     * HTTP status code
     *
     * @var int
     */
    protected $response_code;

    /**
     * Response data
     *
     * @var array
     */
    protected $response_data;

    /**
     * Response constructor
     *
     * @param array $arr
     */
    public function __construct(array $arr)
    {
        $this->request_url = $arr['request_url'];
        $this->response_code = $arr['response_code'];
        $this->response_data = $arr['response_data'] ? json_decode($arr['response_data'], true) : [];
    }

    /**
     * Gets certain property
     *
     * @param int $index
     * @param string $key
     * @return mixed
     */
    public function get(int $index, string $key)
    {
        return isset($this->response_data[$index][$key]) ? $this->response_data[$index][$key] : '';
    }

    /**
     * Gets response data
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->response_data;
    }

    /**
     * Gets the full comma-separated address
     *
     * @param int $index
     * @return string
     */
    public function getAddress(int $index): string
    {
        return $this->get($index, 'display_name');
    }

    /**
     *  Gets the latitude of the centroid of the object
     *
     * @param int $index
     * @return string
     */
    public function getLat(int $index): string
    {
        return $this->get($index, 'lat');
    }

    /**
     *  Gets the longitude of the centroid of the object
     *
     * @param int $index
     * @return string
     */
    public function getLng(int $index): string
    {
        return $this->get($index, 'lon');
    }

    /**
     * Gets the reference to the Nominatim internal database ID
     *
     * @param int $index
     * @return int
     */
    public function getPlaceId(int $index): int
    {
        return (int) $this->get($index, 'place_id');
    }

    /**
     * Gets the reference to the OSM object
     *
     * @param int $index
     * @return int
     */
    public function getOsmId(int $index): int
    {
        return $this->get($index, 'osm_id');
    }

    /**
     * Gets the reference to the OSM object
     *
     * @param int $index
     * @return string
     */
    public function getOsmType(int $index): string
    {
        return $this->get($index, 'osm_type');
    }

    /**
     * Gets the response data as JSON string
     *
     * @return string
     */
    public function toJson(): string
    {
        return json_encode($this->response_data);
    }

    /**
     * Gets the response data as array
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->response_data;
    }

    /**
     * Gets requested URL
     *
     * @return string
     */
    public function getUrl(): string
    {
        return $this->request_url;
    }

    /**
     * Gets HTTP status code
     *
     * @return int
     */
    public function getHttpCode(): int
    {
        return $this->response_code;
    }

    /**
     * Gets the error from latest request, if any
     *
     * @return array|null
     */
    public function getError()
    {
        return isset($this->response_data['error']) ? $this->response_data['error'] : null;
    }

    /**
     * Gets the latest error code. If no error found will return 0.
     *
     * @return int
     */
    public function getErrorCode(): int
    {
        return isset($this->response_data['error']['code']) ? $this->response_data['error']['code'] : 0;
    }

    /**
     * Gets the latest error message. If no error found will return an empty string.
     *
     * @return string
     */
    public function getErrorMessage(): string
    {
        return isset($this->response_data['error']['message']) ? $this->response_data['error']['message'] : '';
    }

    /**
     * Checks if latest request is successful
     *
     * @return bool
     */
    public function isOK(): bool
    {
        return !isset($this->response_data['error']);
    }
}
