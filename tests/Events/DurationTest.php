<?php

namespace ZoiloMora\ElasticAPM\Tests\Events;

use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;
use ZoiloMora\ElasticAPM\Events\Duration;

class DurationTest extends TestCase
{
    use Duration;

    /**
     * @test
     */
    public function given_the_without_initializing_trait_when_ask_is_finished_then_answer_is_false()
    {
        self::assertEquals(false, $this->isFinished());
    }

    /**
     * @test
     */
    public function given_the_initialized_trait_when_it_ended_then_get_the_duration_is_ok()
    {
        $duration = 1.1;

        $stopwatchMock = self::getMockBuilder('ZoiloMora\ElasticAPM\Helper\Stopwatch\Stopwatch')
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $stopwatchMock
            ->expects(
                self::once()
            )
            ->method('stop')
        ;
        $stopwatchMock
            ->expects(
                self::once()
            )
            ->method('getDuration')
            ->willReturn($duration)
        ;
        $this->stopwatch = $stopwatchMock;

        $this->stopClock();

        self::assertEquals($duration, $this->duration());
        self::assertEquals(true, $this->isFinished());
    }
}
