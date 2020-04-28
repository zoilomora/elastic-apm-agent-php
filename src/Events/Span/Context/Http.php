<?php

namespace ZoiloMora\ElasticAPM\Events\Span\Context;

use ZoiloMora\ElasticAPM\Helper\Encoding;

/**
 * An object containing contextual data of the related http request.
 */
final class Http implements \JsonSerializable
{
    /**
     * The raw url of the correlating http request.
     *
     * @var string|null
     */
    private $url;

    /**
     * The status code of the http request.
     *
     * @var int|null
     */
    private $statusCode;

    /**
     * The method of the http request.
     *
     * @var string|null
     */
    private $method;

    /**
     * @param string|null $url
     * @param int|null $statusCode
     * @param string|null $method
     */
    public function __construct(
        $url = null,
        $statusCode = null,
        $method = null
    ) {
        $this->url = $url;
        $this->statusCode = $statusCode;
        $this->method = $method;
    }

    /**
     * @return string|null
     */
    public function url()
    {
        return $this->url;
    }

    /**
     * @return int|null
     */
    public function statusCode()
    {
        return $this->statusCode;
    }

    /**
     * @return string|null
     */
    public function method()
    {
        return $this->method;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'url' => $this->url,
            'status_code' => $this->statusCode,
            'method' => Encoding::keywordField($this->method),
        ];
    }
}
