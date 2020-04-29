<?php

namespace ZoiloMora\ElasticAPM\Tests\Helper\Stopwatch;

use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;
use ZoiloMora\ElasticAPM\Helper\Stopwatch\Stopwatch;

class StopwatchTest extends TestCase
{
    private $stopwatch;

    protected function setUp()
    {
        parent::setUp();

        $this->stopwatch = new Stopwatch();
    }

    /**
     * @test
     */
    public function given_an_instance_when_start_then_not_throw_exception()
    {
        $this->stopwatch->start();

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Helper\Stopwatch\Stopwatch', $this->stopwatch);
    }

    /**
     * @test
     */
    public function given_an_instance_when_start_with_specific_time_then_not_throw_exception()
    {
        $this->stopwatch->start(216.1);

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Helper\Stopwatch\Stopwatch', $this->stopwatch);
    }

    /**
     * @test
     */
    public function given_an_instance_when_start_and_stop_then_get_duration()
    {
        $this->stopwatch->start();
        $this->stopwatch->stop();

        $duration = $this->stopwatch->getDuration();

        self::assertSame('double', gettype($duration));
    }

    /**
     * @test
     */
    public function given_an_instance_no_started_when_stop_then_throw_exception()
    {
        self::setExpectedException('ZoiloMora\ElasticAPM\Helper\Stopwatch\Exception\NotStartedException');

        $this->stopwatch->stop();
    }

    /**
     * @test
     */
    public function given_an_instance_when_start_twice_then_throw_exception()
    {
        self::setExpectedException('ZoiloMora\ElasticAPM\Helper\Stopwatch\Exception\AlreadyRunningException');

        $this->stopwatch->start();
        $this->stopwatch->start();
    }

    /**
     * @test
     */
    public function given_an_instance_started_when_get_duration_then_throw_exception()
    {
        self::setExpectedException('ZoiloMora\ElasticAPM\Helper\Stopwatch\Exception\NotStoppedException');

        $this->stopwatch->start();
        $this->stopwatch->getDuration();
    }
}
