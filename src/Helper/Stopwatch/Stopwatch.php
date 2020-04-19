<?php

namespace ZoiloMora\ElasticAPM\Helper\Stopwatch;

use ZoiloMora\ElasticAPM\Helper\Stopwatch\Exception\AlreadyRunningException;
use ZoiloMora\ElasticAPM\Helper\Stopwatch\Exception\NotStartedException;
use ZoiloMora\ElasticAPM\Helper\Stopwatch\Exception\NotStoppedException;

final class Stopwatch
{
    /**
     * @var double|null
     */
    private $startedOn;

    /**
     * @var double|null
     */
    private $stoppedOn;

    public function __construct()
    {
        $this->startedOn = null;
        $this->startedOn = null;
    }

    /**
     * @param double|null $startedOn
     *
     * @return void
     *
     * @throws AlreadyRunningException
     */
    public function start($startedOn = null)
    {
        if (null !== $this->startedOn) {
            throw AlreadyRunningException::create();
        }

        if (null !== $startedOn) {
            $this->startedOn = $startedOn;

            return;
        }

        $this->startedOn = $this->now();
    }

    /**
     * @return void
     *
     * @throws NotStartedException
     */
    public function stop()
    {
        if (null === $this->startedOn) {
            throw NotStartedException::create();
        }

        $this->stoppedOn = $this->now();
    }

    /**
     * Get current datetime in MicroSeconds
     *
     * @return int
     */
    private function now()
    {
        return (int) (microtime(true) * 1000000);
    }

    /**
     * Get the Duration in MilliSeconds
     *
     * @return double
     *
     * @throws NotStoppedException
     */
    public function getDuration()
    {
        if (null === $this->stoppedOn) {
            throw NotStoppedException::create();
        }

        return ($this->stoppedOn - $this->startedOn) / 1000;
    }
}
