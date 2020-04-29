<?php

namespace ZoiloMora\ElasticAPM\Tests\Processor\MetricSetProcessor;

use ZoiloMora\ElasticAPM\Events\MetricSet\MetricSet;
use ZoiloMora\ElasticAPM\Processor\MetricSetProcessor\MetricsSetBuilder;
use ZoiloMora\ElasticAPM\Processor\MetricSetProcessor\Span;
use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;

class MetricsSetBuilderTest extends TestCase
{
    /**
     * @test
     */
    public function given_a_span_collection_when_built_then_returns_a_collection_with_metric_set()
    {
        $timestamp = 1587300867;

        $transactionName = 'name';
        $transactionType = 'type';
        $transactionDuration = 1234;

        $transaction = $this->createTransactionMock(
            $timestamp,
            $transactionName,
            $transactionType,
            $transactionDuration
        );

        $spanType = 'db';
        $spanSubType = 'mongodb';
        $spanCount = 1;
        $spanSum = 123;

        $spans = [
            $this->createSpanMock(
                $spanType,
                $spanSubType,
                $spanCount,
                $spanSum
            ),
        ];

        $service = new MetricsSetBuilder();
        $result = $service->execute($transaction, $spans);

        self::assertCount(2, $result);

        /** @var MetricSet $transactionMetricSet */
        $transactionMetricSet = $result[0];

        self::assertSame(
            json_encode([
                'metricset' => [
                    'timestamp' => $timestamp,
                    'samples' => [
                        'transaction.duration.count' => [
                            'value' => 1,
                        ],
                        'transaction.duration.sum.us' => [
                            'value' => $transactionDuration,
                        ],
                        'transaction.breakdown.count' => [
                            'value' => 1,
                        ],
                    ],
                    'transaction' => [
                        'name' => $transactionName,
                        'type' => $transactionType,
                    ],
                ],
            ]),
            json_encode($transactionMetricSet)
        );

        /** @var MetricSet $spanMetricSet */
        $spanMetricSet = $result[1];

        self::assertSame(
            json_encode([
                'metricset' => [
                    'timestamp' => $timestamp,
                    'samples' => [
                        'span.self_time.count' => [
                            'value' => $spanCount,
                        ],
                        'span.self_time.sum.us' => [
                            'value' => $spanSum,
                        ],
                    ],
                    'transaction' => [
                        'name' => $transactionName,
                        'type' => $transactionType,
                    ],
                    'span' => [
                        'type' => $spanType,
                        'subtype' => $spanSubType,
                    ],
                ],
            ]),
            json_encode($spanMetricSet)
        );
    }

    /**
     * @param int $timestamp
     * @param string $name
     * @param string $type
     * @param double $duration
     *
     * @return Span
     */
    private function createTransactionMock($timestamp, $name, $type, $duration)
    {
        $transactionMock = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\Transaction\Transaction');
        $transactionMock
            ->expects(self::any())
            ->method('timestamp')
            ->willReturn($timestamp);
        $transactionMock
            ->expects(self::any())
            ->method('name')
            ->willReturn($name);
        $transactionMock
            ->expects(self::any())
            ->method('type')
            ->willReturn($type);
        $transactionMock
            ->expects(self::once())
            ->method('duration')
            ->willReturn($duration);

        return $transactionMock;
    }

    /**
     * @param string $type
     * @param string|null $subType
     * @param int $count
     * @param double $sum
     *
     * @return Span
     */
    private function createSpanMock($type, $subType, $count, $sum)
    {
        $spanMock = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Processor\MetricSetProcessor\Span');
        $spanMock
            ->expects(self::once())
            ->method('type')
            ->willReturn($type);
        $spanMock
            ->expects(self::once())
            ->method('subType')
            ->willReturn($subType);
        $spanMock
            ->expects(self::once())
            ->method('count')
            ->willReturn($count);
        $spanMock
            ->expects(self::once())
            ->method('sum')
            ->willReturn($sum);

        return $spanMock;
    }
}
