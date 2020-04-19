<?php

namespace ZoiloMora\ElasticAPM\Processor\MetricSetProcessor;

use ZoiloMora\ElasticAPM\Events\Event;

final class ByIdFinder
{
    /**
     * @param string $id
     * @param Event[] $events
     *
     * @return Event|null
     */
    public function execute($id, array $events)
    {
        foreach ($events as $event) {
            if ($event->id() === $id) {
                return $event;
            }
        }

        return null;
    }
}
