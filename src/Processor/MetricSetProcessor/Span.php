<?php

namespace ZoiloMora\ElasticAPM\Processor\MetricSetProcessor;

final class Span implements \JsonSerializable
{
    /**
     * @var string
     */
    private $transactionId;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string|null
     */
    private $subType;

    /**
     * @var int
     */
    private $count;

    /**
     * @var double
     */
    private $sum;

    /**
     * @param string $transactionId
     * @param string $type
     * @param string|null $subType
     * @param int $count
     * @param double $sum
     */
    public function __construct($transactionId, $type, $subType, $count, $sum)
    {
        $this->transactionId = $transactionId;
        $this->type = $type;
        $this->subType = $subType;
        $this->count = $count;
        $this->sum = $sum;
    }

    /**
     * @return string
     */
    public function transactionId()
    {
        return $this->transactionId;
    }

    /**
     * @return string
     */
    public function type()
    {
        return $this->type;
    }

    /**
     * @return string|null
     */
    public function subType()
    {
        return $this->subType;
    }

    /**
     * @return int
     */
    public function count()
    {
        return $this->count;
    }

    /**
     * @return double
     */
    public function sum()
    {
        return $this->sum;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'transaction_id' => $this->transactionId,
            'type' => $this->type,
            'sub_type' => $this->subType,
            'count' => $this->count,
            'sum' => $this->sum,
        ];
    }
}
