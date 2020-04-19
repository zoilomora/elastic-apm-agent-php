<?php

namespace ZoiloMora\ElasticAPM\Processor\MetricSetProcessor;

use ZoiloMora\ElasticAPM\Events\Transaction\Transaction;

final class SelfDurationCalculator
{
    /**
     * @param Span|Transaction $event
     * @param \ZoiloMora\ElasticAPM\Events\Span\Span[]|Transaction[] $events
     *
     * @return double
     */
    public function execute($event, array $events)
    {
        $selfDuration = $event->duration();

        foreach ($events as $event) {
            if ($event instanceof Transaction) {
                continue;
            }

            $selfDuration -= $event->duration();
        }

        return $selfDuration;
    }
}
