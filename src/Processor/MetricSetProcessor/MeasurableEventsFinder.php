<?php

namespace ZoiloMora\ElasticAPM\Processor\MetricSetProcessor;

use ZoiloMora\ElasticAPM\Events\Event;
use ZoiloMora\ElasticAPM\Events\Span\Span as SpanEvent;
use ZoiloMora\ElasticAPM\Events\Transaction\Transaction as TransactionEvent;

final class MeasurableEventsFinder
{
    /**
     * @param Event[] $events
     *
     * @return Event[]
     */
    public function execute(array $events)
    {
        return array_values(
            array_filter(
                $events,
                static function ($event) {
                    return true === $event instanceof TransactionEvent || true === $event instanceof SpanEvent;
                }
            )
        );
    }
}
