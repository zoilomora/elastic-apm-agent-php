<?php

namespace ZoiloMora\ElasticAPM\Events\Error;

use ZoiloMora\ElasticAPM\Events\Common\Context;
use ZoiloMora\ElasticAPM\Events\Common\TimestampEpoch;
use ZoiloMora\ElasticAPM\Events\TraceableEvent;
use ZoiloMora\ElasticAPM\Helper\Encoding;

/**
 * An error or a logged error message captured by an agent occurring in a monitored service
 */
final class Error extends TraceableEvent
{
    use TimestampEpoch;

    /**
     * Hex encoded 64 random bits ID of the correlated transaction.
     *
     * @var string|null
     */
    private $transactionId;

    /**
     * @var Context|null
     */
    private $context;

    /**
     * Function call which was the primary perpetrator of this event.
     *
     * @var string|null
     */
    private $culprit;

    /**
     * Information about the originally thrown error.
     *
     * @var Exception|null
     */
    private $exception;

    /**
     * @param string $traceId
     * @param string $parentId
     * @param \Exception $exception
     * @param Context $context
     * @param string $transactionId
     *
     * @throws \Exception
     */
    public function __construct(
        $traceId,
        $parentId,
        \Exception $exception,
        Context $context = null,
        $transactionId = null
    ) {
        parent::__construct($traceId, $parentId);

        $this->timestamp = $this->generateTimestamp();
        $this->transactionId = $transactionId;
        $this->context = $context;

        $this->culprit = sprintf(
            '%s:%d',
            $exception->getFile(),
            $exception->getLine()
        );

        $this->exception = Exception::fromException($exception);
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'error' => array_merge(
                parent::jsonSerialize(),
                [
                    'timestamp' => $this->timestamp,
                    'transaction_id' => Encoding::keywordField($this->transactionId),
                    'context' => $this->context,
                    'culprit' => Encoding::keywordField($this->culprit),
                    'exception' => $this->exception,
                ]
            )
        ];
    }
}
