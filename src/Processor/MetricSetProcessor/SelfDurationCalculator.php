<?php

namespace ZoiloMora\ElasticAPM\Processor\MetricSetProcessor;

use ZoiloMora\ElasticAPM\Events\Span\Span as SpanEvent;
use ZoiloMora\ElasticAPM\Events\Transaction\Transaction as TransactionEvent;

final class SelfDurationCalculator
{
    /**
     * @param SpanEvent|TransactionEvent $event
     * @param SpanEvent[]|TransactionEvent[] $events
     *
     * @return double
     */
    public function execute($event, array $events)
    {
        $selfDuration = $event->duration();

        foreach ($events as $item) {
            if ($item instanceof TransactionEvent) {
                continue;
            }

            $selfDuration -= $item->duration();
        }

        return $selfDuration;
    }
}
