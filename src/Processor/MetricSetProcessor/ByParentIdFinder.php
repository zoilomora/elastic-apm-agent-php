<?php

namespace ZoiloMora\ElasticAPM\Processor\MetricSetProcessor;

use ZoiloMora\ElasticAPM\Events\Event;
use ZoiloMora\ElasticAPM\Events\TraceableEvent;

final class ByParentIdFinder
{
    /**
     * @param string $parentId
     * @param Event[] $events
     *
     * @return Event[]
     */
    public function execute($parentId, array $events)
    {
        return array_values(
            array_filter(
                $events,
                static function(TraceableEvent $event) use ($parentId) {
                    return $event->parentId() === $parentId;
                }
            )
        );
    }
}
