<?php

namespace ZoiloMora\ElasticAPM\Tests\Processor;

use ZoiloMora\ElasticAPM\Processor\MetricSetProcessor;
use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;

class MetricSetProcessorTest extends TestCase
{
    /**
     * @test
     */
    public function given_a_collection_of_events_when_processed_then_returns_metric_set_collection()
    {
        $events = [];

        $transaction = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\Transaction\Transaction');
        $span = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\Span\Span');

        $measurableEvents = [
            $transaction,
            $span,
        ];

        $measurableEventsFinder = $this->getMockWithoutConstructor(
            'ZoiloMora\ElasticAPM\Processor\MetricSetProcessor\MeasurableEventsFinder'
        );
        $measurableEventsFinder
            ->expects(self::once())
            ->method('execute')
            ->with($events)
            ->willReturn($measurableEvents);

        $metricSetSpan1 = $this->createSpan();
        $metricSetSpan2 = $this->createSpan();

        $fromEventsSpanBuilder = $this->getMockWithoutConstructor(
            'ZoiloMora\ElasticAPM\Processor\MetricSetProcessor\FromEventsSpanBuilder'
        );
        $fromEventsSpanBuilder
            ->expects(
                self::exactly(2)
            )
            ->method('execute')
            ->willReturnMap([
                $metricSetSpan1,
                $metricSetSpan2,
            ]);

        $metricSetSpans = [
            $metricSetSpan1,
            $metricSetSpan2,
        ];

        $transactionId = '5a4sdf564sd6546sd';

        $spansGroupedByTransactionId = [
            $transactionId => $metricSetSpans,
        ];

        $groupSpanByTransactionId = $this->getMockWithoutConstructor(
            'ZoiloMora\ElasticAPM\Processor\MetricSetProcessor\GroupSpanByTransactionId'
        );
        $groupSpanByTransactionId
            ->expects(self::once())
            ->method('execute')
            ->willReturn($spansGroupedByTransactionId);

        $byIdFinder = $this->getMockWithoutConstructor(
            'ZoiloMora\ElasticAPM\Processor\MetricSetProcessor\ByIdFinder'
        );
        $byIdFinder
            ->expects(self::once())
            ->method('execute')
            ->with($transactionId, $measurableEvents)
            ->willReturn($transaction);

        $groupBySpanTypes = $this->getMockWithoutConstructor(
            'ZoiloMora\ElasticAPM\Processor\MetricSetProcessor\GroupBySpanTypes'
        );
        $groupBySpanTypes
            ->expects(self::once())
            ->method('execute')
            ->with($transactionId, $metricSetSpans)
            ->willReturn($metricSetSpans);

        $expected = [
            $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\MetricSet\MetricSet'),
        ];

        $metricsSetBuilder = $this->getMockWithoutConstructor(
            'ZoiloMora\ElasticAPM\Processor\MetricSetProcessor\MetricsSetBuilder'
        );
        $metricsSetBuilder
            ->expects(self::once())
            ->method('execute')
            ->with($transaction, $metricSetSpans)
            ->willReturn($expected);

        $service = new MetricSetProcessor(
            $measurableEventsFinder,
            $fromEventsSpanBuilder,
            $groupSpanByTransactionId,
            $byIdFinder,
            $groupBySpanTypes,
            $metricsSetBuilder
        );
        $result = $service($events);

        self::assertEquals($expected, $result);
    }

    private function createSpan()
    {
        return new MetricSetProcessor\Span(
            'transaction-id',
            'type',
            'subtype',
            1,
            1
        );
    }
}
