<?php

namespace ZoiloMora\ElasticAPM\Reporter;

interface Reporter
{
    /**
     * @param array $events
     *
     * @return void
     */
    public function report(array $events);
}
