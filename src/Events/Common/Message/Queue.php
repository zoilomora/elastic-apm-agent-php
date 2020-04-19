<?php

namespace ZoiloMora\ElasticAPM\Events\Common\Message;

use ZoiloMora\ElasticAPM\Helper\Encoding;

/**
 * Queue
 */
final class Queue implements \JsonSerializable
{
    /**
     * Name of the message queue where the message is received.
     *
     * @var string|null
     */
    private $name;

    /**
     * @param string|null $name
     */
    public function __construct($name = null)
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'name' => Encoding::keywordField($this->name),
        ];
    }
}
