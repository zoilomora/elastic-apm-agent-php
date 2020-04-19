<?php

namespace ZoiloMora\ElasticAPM\Events\Span\Context;

use ZoiloMora\ElasticAPM\Events\Span\Context\Destination\Service;
use ZoiloMora\ElasticAPM\Helper\Encoding;

/**
 * An object containing contextual data about the destination for spans
 */
final class Destination implements \JsonSerializable
{
    /**
     * Destination network address:
     * - Hostname (e.g. 'localhost')
     * - FQDN (e.g. 'elastic.co')
     * - IPv4 (e.g. '127.0.0.1')
     * - IPv6 (e.g. '::1')
     *
     * @var string|null
     */
    private $address;

    /**
     * Destination network port (e.g. 443)
     *
     * @var int|null
     */
    private $port;

    /**
     * Destination service context
     *
     * @var Service|null
     */
    private $service;

    /**
     * @param string|null $address
     * @param int|null $port
     * @param Service|null $service
     */
    public function __construct($address, $port, Service $service = null)
    {
        $this->address = $address;
        $this->port = $port;
        $this->service = $service;
    }

    /**
     * @return string|null
     */
    public function address()
    {
        return $this->address;
    }

    /**
     * @return int|null
     */
    public function port()
    {
        return $this->port;
    }

    /**
     * @return Service|null
     */
    public function service()
    {
        return $this->service;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'address' => Encoding::keywordField($this->address),
            'port' => $this->port,
            'service' => $this->service,
        ];
    }
}
