<?php

namespace ZoiloMora\ElasticAPM\Tests\Reporter;

use ZoiloMora\ElasticAPM\Reporter\Reporter;

class ReporterMock implements Reporter
{
    /**
     * @var array
     */
    private $events = [];

    public function report(array $events)
    {
        $this->events = array_merge($this->events, $events);
    }

    /**
     * @return array
     */
    public function events()
    {
        return $this->events;
    }
}
