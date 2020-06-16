<?php

namespace ZoiloMora\ElasticAPM\Events\Span\Context;

use ZoiloMora\ElasticAPM\Events\Common\Context\Response;
use ZoiloMora\ElasticAPM\Events\Common\HttpResponse;
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
     * Deprecated: Use span.context.http.response.status_code instead.
     *
     * @deprecated
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
     * @var HttpResponse|null
     */
    private $response;

    /**
     * @param string|null $url
     * @param int|null $statusCode
     * @param string|null $method
     * @param Response|null $response
     */
    public function __construct(
        $url = null,
        $statusCode = null,
        $method = null,
        $response = null
    ) {
        $this->url = $url;
        $this->statusCode = $statusCode;
        $this->method = $method;
        $this->response = $response;
    }

    /**
     * @return string|null
     */
    public function url()
    {
        return $this->url;
    }

    /**
     * @deprecated
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
     * @return HttpResponse|null
     */
    public function response()
    {
        return $this->response;
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
            'response' => $this->response,
        ];
    }
}
