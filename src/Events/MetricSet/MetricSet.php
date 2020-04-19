<?php

namespace ZoiloMora\ElasticAPM\Events\MetricSet;

use ZoiloMora\ElasticAPM\Events\Common\Tags;
use ZoiloMora\ElasticAPM\Events\Common\TimestampEpoch;

final class MetricSet implements \JsonSerializable
{
    use TimestampEpoch;

    /**
     * @var Transaction
     */
    private $transaction;

    /**
     * @var Span|null
     */
    private $span;

    /**
     * Sampled application metrics collected from the agent.
     *
     * @var Samples
     */
    private $samples;

    /**
     * @var Tags|null
     */
    private $tags;

    /**
     * @param int $timestamp
     * @param Samples $samples
     * @param Transaction $transaction
     * @param Span|null $span
     * @param Tags|null $tags
     */
    public function __construct(
        $timestamp,
        Samples $samples,
        Transaction $transaction,
        Span $span = null,
        Tags $tags = null
    ) {
        $this->timestamp = (int) $timestamp;
        $this->samples = $samples;
        $this->transaction = $transaction;
        $this->span = $span;
        $this->tags = $tags;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        $payload = [
            'timestamp' => $this->timestamp,
            'samples' => $this->samples,
            'transaction' => $this->transaction,
        ];

        if (null !== $this->span) {
            $payload['span'] = $this->span;
        }

        if (null !== $this->tags) {
            $payload['tags'] = $this->tags;
        }

        return [
            'metricset' => $payload,
        ];
    }
}
