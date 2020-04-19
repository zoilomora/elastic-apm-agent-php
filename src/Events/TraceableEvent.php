<?php

namespace ZoiloMora\ElasticAPM\Events;

use ZoiloMora\ElasticAPM\Helper\Cryptography;
use ZoiloMora\ElasticAPM\Helper\DistributedTracing;
use ZoiloMora\ElasticAPM\Helper\Encoding;

/**
 * Traceable Event - Distributed Tracing
 */
abstract class TraceableEvent extends Event
{
    const TRACE_ID_BITS = 128;

    /**
     * Hex encoded 128 random bits ID of the correlated trace.
     *
     * @var string
     */
    protected $traceId;

    /**
     * Hex encoded 64 random bits ID of the parent transaction or span.
     * Only root transactions of a trace do not have a parent_id, otherwise it needs to be set.
     *
     * @var string|null
     */
    protected $parentId;

    /**
     * @param string|null $traceId
     * @param string|null $parentId
     *
     * @throws \Exception
     */
    public function __construct($traceId = null, $parentId = null)
    {
        parent::__construct();

        $this->processTrace($traceId, $parentId);
    }

    /**
     * @return string
     */
    public function traceId()
    {
        return $this->traceId;
    }

    /**
     * @return string|null
     */
    public function parentId()
    {
        return $this->parentId;
    }

    /**
     * Get the Distributed Tracing Value of this Event
     *
     * @return string
     */
    public function distributedTracing()
    {
        $distributedTracing = new DistributedTracing(
            $this->traceId,
            $this->parentId
        );

        return (string) $distributedTracing;
    }

    /**
     * @param mixed $traceId
     * @param mixed $parentId
     *
     * @return void
     *
     * @throws \Exception
     */
    private function processTrace($traceId, $parentId)
    {
        if (null !== $traceId) {
            if (false === is_string($traceId)) {
                throw new \InvalidArgumentException('[traceId] must be of string type.');
            }

            $this->traceId = $traceId;
        }

        if (null !== $parentId) {
            if (false === is_string($parentId)) {
                throw new \InvalidArgumentException('[parentId] must be of string type.');
            }

            $this->parentId = $parentId;
        }

        $distributedTracing = DistributedTracing::discoverDistributedTracing();
        if (null === $distributedTracing) {
            $this->traceId = null === $this->traceId
                ? Cryptography::generateRandomBitsInHex(self::TRACE_ID_BITS)
                : $this->traceId;

            return;
        }

        if (null === $this->traceId) {
            $this->traceId = $distributedTracing->traceId();
        }

        if (null === $this->parentId) {
            $this->parentId = $distributedTracing->parentId();
        }
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return array_merge(
            parent::jsonSerialize(),
            [
                'trace_id' => Encoding::keywordField($this->traceId),
                'parent_id' => Encoding::keywordField($this->parentId),
            ]
        );
    }
}
