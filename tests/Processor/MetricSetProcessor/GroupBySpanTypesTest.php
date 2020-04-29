<?php

namespace ZoiloMora\ElasticAPM\Tests\Processor\MetricSetProcessor;

use ZoiloMora\ElasticAPM\Processor\MetricSetProcessor\GroupBySpanTypes;
use ZoiloMora\ElasticAPM\Processor\MetricSetProcessor\Span;
use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;

class GroupBySpanTypesTest extends TestCase
{
    /**
     * @test
     */
    public function given_a_span_collection_when_grouped_by_type_then_return_a_grouped_span_collection()
    {
        $transactionId = '5434255';

        $spans = [
            $this->createSpanMock('db', 'redis', 765),
            $this->createSpanMock('db', 'mysql', 456),
            $this->createSpanMock('db', 'postgresql', 542),
            $this->createSpanMock('cache', 'file', 914),
            $this->createSpanMock('request', 'external', 345),
            $this->createSpanMock('db', 'mysql', 489),
            $this->createSpanMock('db', 'redis', 724),
        ];

        $service = new GroupBySpanTypes();
        $spans = $service->execute($transactionId, $spans);

        foreach ($spans as $span) {
            self::assertSame($transactionId, $span->transactionId());

            if ('db' === $span->type() && 'redis' === $span->subType()) {
                self::assertSame(2, $span->count());
                self::assertSame(1489, $span->sum());
            }

            if ('db' === $span->type() && 'mysql' === $span->subType()) {
                self::assertSame(2, $span->count());
                self::assertSame(945, $span->sum());
            }

            if ('db' === $span->type() && 'postgresql' === $span->subType()) {
                self::assertSame(1, $span->count());
                self::assertSame(542, $span->sum());
            }

            if ('cache' === $span->type() && 'file' === $span->subType()) {
                self::assertSame(1, $span->count());
                self::assertSame(914, $span->sum());
            }

            if ('request' === $span->type() && 'external' === $span->subType()) {
                self::assertSame(1, $span->count());
                self::assertSame(345, $span->sum());
            }
        }
    }

    /**
     * @param string $type
     * @param string|null $subType
     * @param double $sum
     *
     * @return Span
     */
    private function createSpanMock($type, $subType, $sum)
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
            ->method('sum')
            ->willReturn($sum);

        return $spanMock;
    }
}
