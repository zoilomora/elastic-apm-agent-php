<?php

namespace ZoiloMora\ElasticAPM\Events\Span\Context\Destination;

use ZoiloMora\ElasticAPM\Helper\Encoding;

final class Service implements \JsonSerializable
{
    /**
     * Type of the destination service (e.g. 'db', 'elasticsearch').
     * Should typically be the same as span.type.
     *
     * @var string
     */
    private $type;

    /**
     * Identifier for the destination service (e.g. 'http://elastic.co', 'elasticsearch', 'rabbitmq')
     *
     * @var string
     */
    private $name;

    /**
     * Identifier for the destination service resource being operated on
     * (e.g. 'http://elastic.co:80', 'elasticsearch', 'rabbitmq/queue_name')
     *
     * @var string
     */
    private $resource;

    /**
     * @param string $type
     * @param string $name
     * @param string $resource
     */
    public function __construct($type, $name, $resource)
    {
        $this->type = $type;
        $this->name = $name;
        $this->resource = $resource;
    }

    /**
     * @return string
     */
    public function type()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function resource()
    {
        return $this->resource;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'type' => Encoding::keywordField($this->type),
            'name' => Encoding::keywordField($this->name),
            'resource' => Encoding::keywordField($this->resource),
        ];
    }
}
