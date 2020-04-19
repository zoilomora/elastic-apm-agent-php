<?php

namespace ZoiloMora\ElasticAPM\Events\Common\Context;

use ZoiloMora\ElasticAPM\Events\Common\HttpResponse;

final class Response extends HttpResponse
{
    /**
     * A boolean indicating whether the response was finished or not
     *
     * @var bool|null
     */
    private $finished;

    /**
     * @var bool|null
     */
    private $headersSent;

    /**
     * @param int|null $statusCode
     * @param int|null $transferSize
     * @param int|null $encodedBodySize
     * @param int|null $decodedBodySize
     * @param array|null $headers
     * @param bool|null $finished
     * @param bool|null $headersSent
     */
    public function __construct(
        $statusCode = null,
        $transferSize = null,
        $encodedBodySize = null,
        $decodedBodySize = null,
        array $headers = null,
        $finished = null,
        $headersSent = null
    ) {
        parent::__construct($statusCode, $transferSize, $encodedBodySize, $decodedBodySize, $headers);

        $this->finished = $finished;
        $this->headersSent = $headersSent;
    }

    /**
     * @return bool|null
     */
    public function finished()
    {
        return $this->finished;
    }

    /**
     * @return bool|null
     */
    public function headersSent()
    {
        return $this->headersSent;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return array_merge(
            parent::jsonSerialize(),
            [
                'finished' => $this->finished,
                'headers_sent' => $this->headersSent,
            ]
        );
    }
}
