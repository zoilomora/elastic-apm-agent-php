<?php

namespace ZoiloMora\ElasticAPM\Events\Common;

use ZoiloMora\ElasticAPM\Events\Common\Message\Age;
use ZoiloMora\ElasticAPM\Events\Common\Message\Queue;

/**
 * Details related to message receiving and publishing if the captured event integrates with a messaging system
 */
class Message implements \JsonSerializable
{
    /**
     * Name of the message queue where the message is received.
     *
     * @var Queue
     */
    private $queue;

    /**
     * @var Age|null
     */
    private $age;

    /**
     * messsage body, similar to an http request body
     *
     * @var string|null
     */
    private $body;

    /**
     * messsage headers, similar to http request headers
     *
     * @var array|null
     */
    private $headers;

    /**
     * @param Queue $queue
     * @param Age|null $age
     * @param string|null $body
     * @param array|null $headers
     */
    public function __construct(
        Queue $queue,
        Age $age = null,
        $body = null,
        array $headers = null
    ) {
        $this->queue = $queue;
        $this->age = $age;
        $this->body = $body;
        $this->headers = $headers;
    }

    /**
     * @return Queue
     */
    public function queue()
    {
        return $this->queue;
    }

    /**
     * @return Age|null
     */
    public function age()
    {
        return $this->age;
    }

    /**
     * @return string|null
     */
    public function body()
    {
        return $this->body;
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
            'queue' => $this->queue,
            'age' => $this->age,
            'body' => $this->body,
            'headers' => $this->headers,
        ];
    }
}
