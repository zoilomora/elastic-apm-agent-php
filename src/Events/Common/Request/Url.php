<?php

namespace ZoiloMora\ElasticAPM\Events\Common\Request;

use ZoiloMora\ElasticAPM\Helper\Encoding;

/**
 * A complete Url, with scheme, host and path.
 */
final class Url implements \JsonSerializable
{
    /**
     * The raw, unparsed URL of the HTTP request line, e.g https://example.com:443/search?q=elasticsearch.
     * This URL may be absolute or relative.
     * For more details, see https://www.w3.org/Protocols/rfc2616/rfc2616-sec5.html#sec5.1.2.
     *
     * @var string|null
     */
    private $raw;

    /**
     * The protocol of the request, e.g. 'https:'.
     *
     * @var string|null
     */
    private $protocol;

    /**
     * The full, possibly agent-assembled URL of the request, e.g https://example.com:443/search?q=elasticsearch#top.
     *
     * @var string|null
     */
    private $full;

    /**
     * The hostname of the request, e.g. 'example.com'.
     *
     * @var string|null
     */
    private $hostname;

    /**
     * The port of the request, e.g. '443'
     *
     * @var string|int|null
     */
    private $port;

    /**
     * The path of the request, e.g. '/search'
     *
     * @var string|null
     */
    private $pathname;

    /**
     * The search describes the query string of the request. It is expected to have values delimited by ampersands.
     *
     * @var string|null
     */
    private $search;

    /**
     * The hash of the request URL, e.g. 'top'
     *
     * @var string|null
     */
    private $hash;

    /**
     * @param string|null $raw
     * @param string|null $protocol
     * @param string|null $full
     * @param string|null $hostname
     * @param string|int|null $port
     * @param string|null $pathname
     * @param string|null $search
     * @param string|null $hash
     */
    public function __construct(
        $raw = null,
        $protocol = null,
        $full = null,
        $hostname = null,
        $port = null,
        $pathname = null,
        $search = null,
        $hash = null
    ) {
        $this->raw = $raw;
        $this->protocol = $protocol;
        $this->full = $full;
        $this->hostname = $hostname;
        $this->port = $port;
        $this->pathname = $pathname;
        $this->search = $search;
        $this->hash = $hash;
    }

    /**
     * @return string|null
     */
    public function raw()
    {
        return $this->raw;
    }

    /**
     * @return string|null
     */
    public function protocol()
    {
        return $this->protocol;
    }

    /**
     * @return string|null
     */
    public function full()
    {
        return $this->full;
    }

    /**
     * @return string|null
     */
    public function hostname()
    {
        return $this->hostname;
    }

    /**
     * @return int|string|null
     */
    public function port()
    {
        return $this->port;
    }

    /**
     * @return string|null
     */
    public function pathname()
    {
        return $this->pathname;
    }

    /**
     * @return string|null
     */
    public function search()
    {
        return $this->search;
    }

    /**
     * @return string|null
     */
    public function hash()
    {
        return $this->hash;
    }

    /**
     * @return Url
     */
    public static function discover()
    {
        return new self(
            null,
            self::getProtocol(),
            self::getFull(),
            self::getHostname(),
            self::getPort(),
            self::getPathname(),
            self::getSearch()
        );
    }

    /**
     * @return string
     */
    private static function getProtocol()
    {
        return true === array_key_exists('HTTPS', $_SERVER)
            ? 'https'
            : 'http';
    }

    /**
     * @return string|null
     */
    private static function getFull()
    {
        if (null === self::getServerParams('HTTP_HOST')) {
            return null;
        }

        return sprintf(
            '%s://%s%s',
            self::getProtocol(),
            $_SERVER['HTTP_HOST'],
            $_SERVER['REQUEST_URI']
        );
    }

    /**
     * @return string|null
     */
    private static function getHostname()
    {
        return self::getServerParams('SERVER_NAME');
    }

    /**
     * @return string|null
     */
    private static function getPort()
    {
        return self::getServerParams('SERVER_PORT');
    }

    /**
     * @return string|null
     */
    private static function getPathname()
    {
        return self::getServerParams('SCRIPT_NAME');
    }

    /**
     * @return string|null
     */
    private static function getSearch()
    {
        $query = self::getServerParams('QUERY_STRING');
        if (null === $query) {
            return null;
        }

        return sprintf(
            '?%s',
            $query
        );
    }

    /**
     * @param string $key
     * @return string|null
     */
    private static function getServerParams($key)
    {
        if (false === array_key_exists($key, $_SERVER)) {
            return null;
        }

        return $_SERVER[$key];
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'raw' => Encoding::keywordField($this->raw),
            'protocol' => Encoding::keywordField($this->protocol),
            'full' => Encoding::keywordField($this->full),
            'hostname' => Encoding::keywordField($this->hostname),
            'port' => Encoding::keywordField($this->port),
            'pathname' => Encoding::keywordField($this->pathname),
            'search' => Encoding::keywordField($this->search),
            'hash' => Encoding::keywordField($this->hash),
        ];
    }
}
