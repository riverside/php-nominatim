<?php
namespace Nominatim;

/**
 * Class Response
 *
 * @package Nominatim
 */
class Response
{
    /**
     * Response data
     *
     * @var array
     */
    protected $data;

    /**
     * Response constructor
     *
     * @param string $data
     */
    public function __construct(string $data)
    {
        $data = json_decode($data, true);
        $this->data = isset($data[0]) ? $data[0] : $data;
    }

    /**
     * Gets the full comma-separated address
     *
     * @return string
     */
    public function getAddress(): string
    {
        return $this->data['display_name'];
    }

    /**
     *  Gets the latitude of the centroid of the object
     *
     * @return string
     */
    public function getLat(): string
    {
        return $this->data['lat'];
    }

    /**
     *  Gets the longitude of the centroid of the object
     *
     * @return string
     */
    public function getLng(): string
    {
        return $this->data['lon'];
    }

    /**
     * Gets the reference to the Nominatim internal database ID
     *
     * @return string
     */
    public function getPlaceId(): string
    {
        return $this->data['place_id'];
    }

    /**
     * Gets the reference to the OSM object
     *
     * @return string
     */
    public function getOsmId(): string
    {
        return $this->data['osm_id'];
    }

    /**
     * Gets the reference to the OSM object
     *
     * @return string
     */
    public function getOsmType(): string
    {
        return $this->data['osm_type'];
    }

    /**
     * Gets the response data as JSON string
     *
     * @return string
     */
    public function toJson(): string
    {
        return json_encode($this->data);
    }

    /**
     * Gets the response data as array
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->data;
    }

    /**
     * Gets the error from latest request, if any
     *
     * @return array|null
     */
    public function getError()
    {
        return isset($this->data['error']) ? $this->data['error'] : null;
    }

    /**
     * Gets the latest error code. If no error found will return 0.
     *
     * @return int
     */
    public function getErrorCode(): int
    {
        return isset($this->data['error']['code']) ? $this->data['error']['code'] : 0;
    }

    /**
     * Gets the latest error message. If no error found will return an empty string.
     *
     * @return string
     */
    public function getErrorMessage(): string
    {
        return isset($this->data['error']['message']) ? $this->data['error']['message'] : '';
    }

    /**
     * Checks if latest request is successful
     *
     * @return bool
     */
    public function isOK(): bool
    {
        return !isset($this->data['error']);
    }
}
