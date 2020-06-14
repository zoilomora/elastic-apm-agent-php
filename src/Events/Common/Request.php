<?php

namespace ZoiloMora\ElasticAPM\Events\Common;

use ZoiloMora\ElasticAPM\Events\Common\Request\Socket;
use ZoiloMora\ElasticAPM\Events\Common\Request\Url;
use ZoiloMora\ElasticAPM\Helper\Encoding;
use ZoiloMora\ElasticAPM\Helper\HttpHeaderSanitizer;

/**
 * If a log record was generated as a result of a http request,
 * the http interface can be used to collect this information.
 */
class Request implements \JsonSerializable
{
    /**
     * Data should only contain the request body (not the query string).
     * It can either be a dictionary (for standard HTTP requests) or a raw request body.
     *
     * @var object|string|null
     */
    private $body;

    /**
     * The env variable is a compounded of environment information passed from the webserver.
     *
     * @var object|null
     */
    private $env;

    /**
     * Should include any headers sent by the requester. Cookies will be taken by headers if supplied.
     *
     * @var array|null
     */
    private $headers;

    /**
     * HTTP version.
     *
     * @var string|null
     */
    private $httpVersion;

    /**
     * HTTP method.
     *
     * @var string
     */
    private $method;

    /**
     * @var Socket|null
     */
    private $socket;

    /**
     * A complete Url, with scheme, host and path.
     *
     * @var Url
     */
    private $url;

    /**
     * A parsed key-value object of cookies
     *
     * @var array|null
     */
    private $cookies;

    /**
     * @param string $method
     * @param Url $url
     * @param object|string|null $body
     * @param object|null $env
     * @param array|null $headers
     * @param string|null $httpVersion
     * @param Socket|null $socket
     * @param array|null $cookies
     */
    public function __construct(
        $method,
        Url $url,
        $body = null,
        $env = null,
        array $headers = null,
        $httpVersion = null,
        Socket $socket = null,
        array $cookies = null
    ) {
        $this->body = $body;
        $this->env = $env;
        $this->headers = $headers;

        $this->httpVersion = $httpVersion;
        $this->method = $method;
        $this->socket = $socket;
        $this->url = $url;
        $this->cookies = $cookies;
    }

    /**
     * @return object|string|null
     */
    public function body()
    {
        return $this->body;
    }

    /**
     * @return object|null
     */
    public function env()
    {
        return $this->env;
    }

    /**
     * @return array|null
     */
    public function headers()
    {
        return $this->headers;
    }

    /**
     * @return string|null
     */
    public function httpVersion()
    {
        return $this->httpVersion;
    }

    /**
     * @return string
     */
    public function method()
    {
        return $this->method;
    }

    /**
     * @return Socket|null
     */
    public function socket()
    {
        return $this->socket;
    }

    /**
     * @return Url
     */
    public function url()
    {
        return $this->url;
    }

    /**
     * @return array|null
     */
    public function cookies()
    {
        return $this->cookies;
    }

    /**
     * @return Request|null
     */
    public static function discover()
    {
        if ('cli' === self::getMethod()) {
            return null;
        }

        return new self(
            self::getMethod(),
            Url::discover(),
            self::getBody(),
            null,
            self::getHeaders(),
            self::getHttpVersion(),
            Socket::discover()
        );
    }

    /**
     * @return string|null
     */
    private static function getBody()
    {
        $input = file_get_contents('php://input');

        return '' !== $input
            ? (string) $input
            : null;
    }

    /**
     * @return array|null
     */
    private static function getHeaders()
    {
        $headers = [];

        foreach ($_SERVER as $key => $value) {
            if ('HTTP_' !== substr($key, 0, 5)) {
                continue;
            }

            $header = str_replace(
                ' ',
                '-',
                ucwords(
                    str_replace(
                        '_',
                        ' ',
                        strtolower(
                            substr(
                                $key,
                                5
                            )
                        )
                    )
                )
            );

            $headers[$header] = $value;
        }

        $headers = HttpHeaderSanitizer::sanitize($headers);

        return 0 !== count($headers)
            ? $headers
            : null;
    }

    /**
     * @return string|null
     */
    private static function getHttpVersion()
    {
        if (false === array_key_exists('SERVER_PROTOCOL', $_SERVER)) {
            return null;
        }

        $position = strpos(
            $_SERVER['SERVER_PROTOCOL'],
            '/'
        );

        return substr(
            $_SERVER['SERVER_PROTOCOL'],
            $position + 1
        );
    }

    /**
     * @return string
     */
    private static function getMethod()
    {
        if (true === array_key_exists('REQUEST_METHOD', $_SERVER)) {
            return $_SERVER['REQUEST_METHOD'];
        }

        return 'cli';
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'body' => $this->body,
            'env' => $this->env,
            'headers' => $this->headers,
            'http_version' => Encoding::keywordField($this->httpVersion),
            'method' => Encoding::keywordField($this->method),
            'socket' => $this->socket,
            'url' => $this->url,
            'cookies' => $this->cookies,
        ];
    }
}
