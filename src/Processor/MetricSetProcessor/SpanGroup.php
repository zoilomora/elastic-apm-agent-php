<?php

namespace ZoiloMora\ElasticAPM\Processor\MetricSetProcessor;

final class SpanGroup implements \JsonSerializable
{
    /**
     * @var string
     */
    private $transactionId;

    /**
     * @var array
     */
    private $spans;

    /**
     * @param string $transactionId
     * @param array $spans
     */
    public function __construct($transactionId, array $spans)
    {
        $this->transactionId = (string) $transactionId;
        $this->spans = $spans;
    }

    /**
     * @return string
     */
    public function transactionId()
    {
        return $this->transactionId;
    }

    /**
     * @return array
     */
    public function spans()
    {
        return $this->spans;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'transaction_id' => $this->transactionId,
            'spans' => $this->spans,
        ];
    }
}
