<?php

namespace ZoiloMora\ElasticAPM\Processor\MetricSetProcessor;

use ZoiloMora\ElasticAPM\Events\Event;
use ZoiloMora\ElasticAPM\Events\Span\Span;
use ZoiloMora\ElasticAPM\Events\Transaction\Transaction;

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
                    return true === $event instanceof Transaction || true === $event instanceof Span;
                }
            )
        );
    }
}
