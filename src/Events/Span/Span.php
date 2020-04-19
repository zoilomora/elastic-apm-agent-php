<?php

namespace ZoiloMora\ElasticAPM\Events\Span;

use ZoiloMora\ElasticAPM\Events\Common\SpanSubtype;
use ZoiloMora\ElasticAPM\Events\Common\SpanType;
use ZoiloMora\ElasticAPM\Events\Common\TimestampEpoch;
use ZoiloMora\ElasticAPM\Events\Duration;
use ZoiloMora\ElasticAPM\Events\TraceableEvent;
use ZoiloMora\ElasticAPM\Helper\Encoding;
use ZoiloMora\ElasticAPM\Helper\Stopwatch\Stopwatch;

/**
 * An event captured by an agent occurring in a monitored service
 */
final class Span extends TraceableEvent
{
    use TimestampEpoch;
    use SpanType;
    use SpanSubtype;
    use Duration;

    /**
     * Hex encoded 64 random bits ID of the correlated transaction.
     *
     * @var string|null
     */
    private $transactionId;

    /**
     * Offset relative to the transaction's timestamp identifying the start of the span, in milliseconds
     *
     * @var double|null
     */
    private $start;

    /**
     * The specific kind of event within the sub-type represented by the span (e.g. query, connect)
     *
     * @var string|null
     */
    private $action;

    /**
     * @var Context|null
     */
    private $context;

    /**
     * Generic designation of a span in the scope of a transaction
     *
     * @var string
     */
    private $name;

    /**
     * List of stack frames with variable attributes (eg: lineno, filename, etc)
     *
     * @var array|null
     */
    private $stacktrace;

    /**
     * @param string $name
     * @param string $type
     * @param string $traceId
     * @param string $parentId
     * @param string|null $subtype
     * @param string|null $transactionId
     * @param string|null $action
     * @param Context|null $context
     * @param array|null $stacktrace
     *
     * @throws \Exception
     */
    public function __construct(
        $name,
        $type,
        $traceId,
        $parentId,
        $subtype = null,
        $transactionId = null,
        $action = null,
        Context $context = null,
        $stacktrace = null
    ) {
        parent::__construct($traceId, $parentId);

        $this->timestamp = $this->generateTimestamp();
        $this->type = $type;
        $this->subtype = $subtype;
        $this->transactionId = $transactionId;
        $this->action = $action;
        $this->context = $context;
        $this->name = $name;
        $this->stacktrace = $stacktrace;

        $this->stopwatch = new Stopwatch();
        $this->stopwatch->start($this->timestamp);
    }

    /**
     * @return string|null
     */
    public function transactionId()
    {
        return $this->transactionId;
    }

    /**
     * @return void
     *
     * @throws \ZoiloMora\ElasticAPM\Helper\Stopwatch\Exception\NotStartedException
     * @throws \ZoiloMora\ElasticAPM\Helper\Stopwatch\Exception\NotStoppedException
     */
    public function stop()
    {
        $this->stopClock();
    }

    /**
     * @return Context|null
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
            'span' => array_merge(
                parent::jsonSerialize(),
                [
                    'timestamp' => $this->timestamp,
                    'type' => $this->getEncodingType(),
                    'subtype' => $this->getEncodingSubtype(),
                    'transaction_id' => Encoding::keywordField($this->transactionId),
                    'start' => $this->start,
                    'action' => Encoding::keywordField($this->action),
                    'context' => $this->context,
                    'duration' => $this->duration,
                    'name' => Encoding::keywordField($this->name),
                    'stacktrace' => $this->stacktrace,
                ]
            )
        ];
    }
}
