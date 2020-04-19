<?php

namespace ZoiloMora\ElasticAPM\Events\Common\Message;

/**
 * Age
 */
final class Age implements \JsonSerializable
{
    /**
     * The age of the message in milliseconds.
     *
     * If the instrumented messaging framework provides a timestamp for the message, agents may use it.
     * Otherwise, the sending agent can add a timestamp in milliseconds since the Unix epoch to
     * the message's metadata to be retrieved by the receiving agent.
     *
     * If a timestamp is not available, agents should omit this field.
     *
     * @var int|null
     */
    private $ms;

    /**
     * @param int|null $ms
     */
    public function __construct($ms = null)
    {
        $this->ms = $ms;
    }

    /**
     * @return int|null
     */
    public function ms()
    {
        return $this->ms;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'ms' => $this->ms,
        ];
    }
}
