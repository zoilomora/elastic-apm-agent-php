<?php

namespace ZoiloMora\ElasticAPM\Tests\Processor\MetricSetProcessor;

use ZoiloMora\ElasticAPM\Processor\MetricSetProcessor\MeasurableEventsFinder;
use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;

class MeasurableEventsFinderTest extends TestCase
{
    /**
     * @test
     */
    public function given_collection_of_events_when_search_measurable_events_then_return_only_measurable_events()
    {
        $transaction = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\Transaction\Transaction');
        $span = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\Span\Span');
        $error = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\Error\Error');

        $events = [
            $transaction,
            $span,
            $error,
            $transaction,
            $span,
            $error,
        ];

        $service = new MeasurableEventsFinder();

        $expected = [
            $transaction,
            $span,
            $transaction,
            $span,
        ];

        $actual = $service->execute($events);

        self::assertSame($expected, $actual);
    }
}
