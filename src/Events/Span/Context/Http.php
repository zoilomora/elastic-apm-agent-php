<?php

namespace ZoiloMora\ElasticAPM\Events\Span\Context;

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
     * @var string|null
     */
    private $method;

    /**
     * @var HttpResponse|null
     */
    private $response;

    /**
     * @param string|null $url
     * @param string|null $method
     * @param HttpResponse|null $response
     */
    public function __construct(
        $url = null,
        $method = null,
        HttpResponse $response = null
    ) {
        $this->url = $url;
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
            'method' => Encoding::keywordField($this->method),
            'response' => $this->response,
        ];
    }
}
