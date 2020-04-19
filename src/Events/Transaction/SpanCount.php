<?php

namespace ZoiloMora\ElasticAPM\Events\Transaction;

final class SpanCount implements \JsonSerializable
{
    /**
     * Number of correlated spans that are recorded.
     *
     * @var int
     */
    private $started;

    /**
     * Number of spans that have been dropped by the agent recording the transaction.
     *
     * @var int|null
     */
    private $dropped;

    /**
     * @param int $started
     * @param int|null $dropped
     */
    public function __construct($started, $dropped = null)
    {
        $this->started = $started;
        $this->dropped = $dropped;
    }

    /**
     * @return int
     */
    public function started()
    {
        return $this->started;
    }

    /**
     * @return int|null
     */
    public function dropped()
    {
        return $this->dropped;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'started' => $this->started,
            'dropped' => $this->dropped,
        ];
    }
}
