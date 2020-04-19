<?php

namespace ZoiloMora\ElasticAPM\Events\Common;

/**
 * HTTP response object, used by error, span and transction documents
 */
class HttpResponse implements \JsonSerializable
{
    /**
     * The status code of the http request.
     *
     * @var int|null
     */
    private $statusCode;

    /**
     * Total size of the payload.
     *
     * @var int|null
     */
    private $transferSize;

    /**
     * The encoded size of the payload.
     *
     * @var int|null
     */
    private $encodedBodySize;

    /**
     * The decoded size of the payload.
     *
     * @var int|null
     */
    private $decodedBodySize;

    /**
     * @var array|null
     */
    private $headers;

    /**
     * @param int|null $statusCode
     * @param int|null $transferSize
     * @param int|null $encodedBodySize
     * @param int|null $decodedBodySize
     * @param array|null $headers
     */
    public function __construct(
        $statusCode = null,
        $transferSize = null,
        $encodedBodySize = null,
        $decodedBodySize = null,
        array $headers = null
    ) {
        $this->statusCode = $statusCode;
        $this->transferSize = $transferSize;
        $this->encodedBodySize = $encodedBodySize;
        $this->decodedBodySize = $decodedBodySize;
        $this->headers = $headers;
    }

    /**
     * @return int|null
     */
    public function statusCode()
    {
        return $this->statusCode;
    }

    /**
     * @return int|null
     */
    public function transferSize()
    {
        return $this->transferSize;
    }

    /**
     * @return int|null
     */
    public function encodedBodySize()
    {
        return $this->encodedBodySize;
    }

    /**
     * @return int|null
     */
    public function decodedBodySize()
    {
        return $this->decodedBodySize;
    }

    /**
     * @return array|null
     */
    public function headers()
    {
        return $this->headers;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'status_code' => $this->statusCode,
            'transfer_size' => $this->transferSize,
            'encoded_body_size' => $this->encodedBodySize,
            'decoded_body_size' => $this->decodedBodySize,
            'headers' => $this->headers,
        ];
    }
}
