<?php

namespace ZoiloMora\ElasticAPM\Tests\Processor\MetricSetProcessor;

use ZoiloMora\ElasticAPM\Processor\MetricSetProcessor\FromEventsSpanBuilder;
use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;

class FromEventsSpanBuilderTest extends TestCase
{
    /**
     * @test
     */
    public function given_a_transaction_when_generate_span_then_return_object()
    {
        $transactionId = '123456';
        $sum = 453.41;

        $transaction = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\Transaction\Transaction');
        $transaction
            ->expects(
                self::exactly(2)
            )
            ->method('id')
            ->willReturn($transactionId);


        $service = $this->getService($sum);
        $result = $service->execute($transaction, []);

        self::assertSame($transactionId, $result->transactionId());
        self::assertSame('app', $result->type());
        self::assertNull($result->subType());
        self::assertSame(1, $result->count());
        self::assertSame($sum, $result->sum());
    }

    /**
     * @test
     */
    public function given_a_span_when_generate_span_then_return_object()
    {
        $transactionId = '123456';
        $type = '';
        $subType = '';
        $sum = 127.91;

        $span = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\Span\Span');
        $span
            ->expects(self::once())
            ->method('id');
        $span
            ->expects(self::once())
            ->method('transactionId')
            ->willReturn($transactionId);
        $span
            ->expects(self::once())
            ->method('type')
            ->willReturn($type);
        $span
            ->expects(self::once())
            ->method('subtype')
            ->willReturn($subType);

        $service = $this->getService($sum);
        $result = $service->execute($span, []);

        self::assertSame($transactionId, $result->transactionId());
        self::assertSame($type, $result->type());
        self::assertSame($subType, $result->subType());
        self::assertSame(1, $result->count());
        self::assertSame($sum, $result->sum());
    }

    /**
     * @param double $sum
     *
     * @return FromEventsSpanBuilder
     */
    private function getService($sum)
    {
        $byParentIdFinderMock = self::getMock(
            'ZoiloMora\ElasticAPM\Processor\MetricSetProcessor\ByParentIdFinder'
        );
        $byParentIdFinderMock
            ->expects(self::once())
            ->method('execute')
            ->willReturn([]);

        $selfDurationCalculatorMock = self::getMock(
            'ZoiloMora\ElasticAPM\Processor\MetricSetProcessor\SelfDurationCalculator'
        );
        $selfDurationCalculatorMock
            ->expects(self::once())
            ->method('execute')
            ->willReturn($sum);

        return new FromEventsSpanBuilder($byParentIdFinderMock, $selfDurationCalculatorMock);
    }
}
