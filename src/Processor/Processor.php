<?php

namespace ZoiloMora\ElasticAPM\Processor;

interface Processor
{
    /**
     * @param array $events
     *
     * @return array
     */
    public function __invoke(array $events);
}
