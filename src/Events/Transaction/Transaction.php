<?php

namespace ZoiloMora\ElasticAPM\Events\Transaction;

use ZoiloMora\ElasticAPM\Events\Common\Context;
use ZoiloMora\ElasticAPM\Events\Common\TimestampEpoch;
use ZoiloMora\ElasticAPM\Events\Common\TransactionName;
use ZoiloMora\ElasticAPM\Events\Common\TransactionType;
use ZoiloMora\ElasticAPM\Events\Duration;
use ZoiloMora\ElasticAPM\Events\TraceableEvent;
use ZoiloMora\ElasticAPM\Helper\Encoding;
use ZoiloMora\ElasticAPM\Helper\Stopwatch\Stopwatch;

/**
 * An event corresponding to an incoming request or similar task occurring in a monitored service
 */
final class Transaction extends TraceableEvent
{
    use TimestampEpoch;
    use TransactionName;
    use TransactionType;
    use Duration;

    /**
     * @var SpanCount
     */
    private $spanCount;

    /**
     * Any arbitrary contextual information regarding the event, captured by the agent, optionally provided by the user
     *
     * @var Context
     */
    private $context;

    /**
     * The result of the transaction.
     * For HTTP-related transactions, this should be the status code formatted like 'HTTP 2xx'.
     *
     * @var string|null
     */
    private $result;

    /**
     * @param string $name
     * @param string $type
     * @param Context $context
     * @param string|null $traceId
     * @param string|null $parentId
     *
     * @throws \Exception
     */
    public function __construct(
        $name,
        $type,
        Context $context,
        $traceId = null,
        $parentId = null
    ) {
        parent::__construct($traceId, $parentId);

        $this->timestamp = $this->generateTimestamp();
        $this->name = $name;
        $this->type = $type;
        $this->context = $context;

        $this->spanCount = new SpanCount(0, 0);
        $this->stopwatch = new Stopwatch();
        $this->stopwatch->start($this->timestamp);
    }

    /**
     * @param string|null $result
     *
     * @return void
     *
     * @throws \ZoiloMora\ElasticAPM\Helper\Stopwatch\Exception\NotStartedException
     * @throws \ZoiloMora\ElasticAPM\Helper\Stopwatch\Exception\NotStoppedException
     */
    public function stop($result = null)
    {
        $this->stopClock();

        $this->result = $result;
    }

    /**
     * @return Context
     */
    public function context()
    {
        return $this->context;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'transaction' => array_merge(
                parent::jsonSerialize(),
                [
                    'timestamp' => $this->timestamp,
                    'name' => $this->getEncodingName(),
                    'type' => $this->getEncodingType(),
                    'span_count' => $this->spanCount,
                    'context' => $this->context,
                    'duration' => $this->duration,
                    'result' => Encoding::keywordField($this->result),
                ]
            )
        ];
    }
}
