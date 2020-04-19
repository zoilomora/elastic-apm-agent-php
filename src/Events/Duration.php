<?php

namespace ZoiloMora\ElasticAPM\Events;

use ZoiloMora\ElasticAPM\Helper\Stopwatch\Stopwatch;

trait Duration
{
    /**
     * How long the transaction/span took to complete, in ms with 3 decimal points
     *
     * @var double|null
     */
    private $duration;

    /**
     * @var Stopwatch
     */
    private $stopwatch;

    /**
     * @return double|null
     */
    public function duration()
    {
        return $this->duration;
    }

    /**
     * @return void
     *
     * @throws \ZoiloMora\ElasticAPM\Helper\Stopwatch\Exception\NotStartedException
     * @throws \ZoiloMora\ElasticAPM\Helper\Stopwatch\Exception\NotStoppedException
     */
    private function stopClock()
    {
        $this->stopwatch->stop();
        $this->duration = $this->stopwatch->getDuration();
    }

    /**
     * @return bool
     */
    public function isFinished()
    {
        return null !== $this->duration;
    }
}
