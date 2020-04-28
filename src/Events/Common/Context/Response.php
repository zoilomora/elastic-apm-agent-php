<?php

namespace ZoiloMora\ElasticAPM\Events\Common\Context;

final class Response implements \JsonSerializable
{
    /**
     * A boolean indicating whether the response was finished or not
     *
     * @var bool|null
     */
    private $finished;

    /**
     * A mapping of HTTP headers of the response object
     *
     * @var array|null
     */
    private $headers;

    /**
     * @var bool|null
     */
    private $headersSent;

    /**
     * The HTTP status code of the response.
     *
     * @var int|null
     */
    private $statusCode;

    /**
     * @param bool|null $finished
     * @param array|null $headers
     * @param bool|null $headersSent
     * @param int|null $statusCode
     */
    public function __construct(
        $finished = null,
        array $headers = null,
        $headersSent = null,
        $statusCode = null
    ) {
        $this->finished = $finished;
        $this->headers = $headers;
        $this->headersSent = $headersSent;
        $this->statusCode = $statusCode;
    }

    /**
     * @return bool|null
     */
    public function finished()
    {
        return $this->finished;
    }

    /**
     * @return array|null
     */
    public function headers()
    {
        return $this->headers;
    }

    /**
     * @return bool|null
     */
    public function headersSent()
    {
        return $this->headersSent;
    }

    /**
     * @return int|null
     */
    public function statusCode()
    {
        return $this->statusCode;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'finished' => $this->finished,
            'headers' => $this->headers,
            'headers_sent' => $this->headersSent,
            'status_code' => $this->statusCode,
        ];
    }
}
