<?php

namespace ZoiloMora\ElasticAPM\Processor\MetricSetProcessor;

use ZoiloMora\ElasticAPM\Events\Event;

final class FromEventsSpanBuilder
{
    /**
     * @var ByParentIdFinder
     */
    private $byParentIdFinder;

    /**
     * @var SelfDurationCalculator
     */
    private $selfDurationCalculator;

    /**
     * @param ByParentIdFinder $byParentIdFinder
     * @param SelfDurationCalculator $selfDurationCalculator
     */
    public function __construct(ByParentIdFinder $byParentIdFinder, SelfDurationCalculator $selfDurationCalculator)
    {
        $this->byParentIdFinder = $byParentIdFinder;
        $this->selfDurationCalculator = $selfDurationCalculator;
    }

    /**
     * @param \ZoiloMora\ElasticAPM\Events\Transaction\Transaction|\ZoiloMora\ElasticAPM\Events\Span\Span $event
     * @param Event[] $events
     *
     * @return Span
     */
    public function execute($event, array $events)
    {
        return new Span(
            $this->getTransactionId($event),
            $this->getType($event),
            $this->getSubType($event),
            1,
            $this->getSelfDuration($event, $events)
        );
    }

    /**
     * @param Event $event
     * @return string
     */
    private function getTransactionId($event)
    {
        return $event instanceof \ZoiloMora\ElasticAPM\Events\Span\Span
            ? $event->transactionId()
            : $event->id();
    }

    /**
     * @param Event $event
     * @return string
     */
    private function getType($event)
    {
        return $event instanceof \ZoiloMora\ElasticAPM\Events\Span\Span
            ? $event->type()
            : 'app';
    }

    /**
     * @param Event $event
     * @return string
     */
    private function getSubType($event)
    {
        return $event instanceof \ZoiloMora\ElasticAPM\Events\Span\Span
            ? $event->subtype()
            : null;
    }

    /**
     * @param \ZoiloMora\ElasticAPM\Events\Transaction\Transaction|\ZoiloMora\ElasticAPM\Events\Span\Span $event
     * @param Event[] $events
     *
     * @return double
     */
    private function getSelfDuration($event, array $events)
    {
        /** @var \ZoiloMora\ElasticAPM\Events\Transaction\Transaction[]|\ZoiloMora\ElasticAPM\Events\Span\Span[] $childrenEvents */
        $childrenEvents = $this->byParentIdFinder->execute(
            $event->id(),
            $events
        );

        return $this->selfDurationCalculator->execute($event, $childrenEvents);
    }
}
