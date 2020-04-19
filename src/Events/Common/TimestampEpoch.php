<?php

namespace ZoiloMora\ElasticAPM\Events\Common;

/**
 * Timestamp Epoch
 * Object with 'timestamp' property.
 */
trait TimestampEpoch
{
    /**
     * Recorded time of the event, UTC based and formatted as microseconds since Unix epoch
     *
     * @var int|null
     */
    private $timestamp;

    /**
     * @return int|null
     */
    public function timestamp()
    {
        return $this->timestamp;
    }

    /**
     * @return int
     */
    private function generateTimestamp()
    {
        return (int) (microtime(true) * 1000000);
    }
}
