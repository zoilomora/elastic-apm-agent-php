<?php

namespace ZoiloMora\ElasticAPM\Tests\Processor\MetricSetProcessor;

use ZoiloMora\ElasticAPM\Events\Event;
use ZoiloMora\ElasticAPM\Processor\MetricSetProcessor\SelfDurationCalculator;
use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;

class SelfDurationCalculatorTest extends TestCase
{
    /**
     * @test
     */
    public function given_an_event_and_their_children_when_calculate_duration_then_return_duration()
    {
        $mainDuration = 541;
        $firstChildDuration = 123;
        $secondChildDuration = 12;

        $event = $this->createTransactionEvent($mainDuration);
        $events = [
            $this->createSpanEvent($firstChildDuration),
            $this->createTransactionEvent(142.3),
            $this->createSpanEvent($secondChildDuration),
        ];

        $service = new SelfDurationCalculator();
        $result = $service->execute($event, $events);

        $expected = $mainDuration - $firstChildDuration - $secondChildDuration;

        self::assertSame($expected, $result);
    }

    /**
     * @param double $duration
     *
     * @return Event
     */
    private function createTransactionEvent($duration)
    {
        return $this->createEvent(
            'ZoiloMora\ElasticAPM\Events\Transaction\Transaction',
            self::any(),
            $duration
        );
    }

    /**
     * @param double $duration
     *
     * @return Event
     */
    private function createSpanEvent($duration)
    {
        return $this->createEvent(
            'ZoiloMora\ElasticAPM\Events\Span\Span',
            self::once(),
            $duration
        );
    }

    /**
     * @param string $class
     * @param $expects
     * @param double $duration
     *
     * @return Event
     */
    private function createEvent($class, $expects, $duration)
    {
        $event = $this->getMockWithoutConstructor($class);

        $event
            ->expects($expects)
            ->method('duration')
            ->willReturn($duration);

        return $event;
    }
}
