<?php

namespace ZoiloMora\ElasticAPM\Tests\Processor\MetricSetProcessor;

use ZoiloMora\ElasticAPM\Processor\MetricSetProcessor\GroupSpanByTransactionId;
use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;

class GroupSpanByTransactionIdTest extends TestCase
{
    /**
     * @test
     */
    public function given_a_collection_of_spans_when_grouping_by_transaction_id_then_it_returns_a_grouped_collection()
    {
        $transactionIdOne = '65432185';
        $transactionIdTwo = '89716546';

        $spansOne = [
            $this->createSpan($transactionIdOne),
            $this->createSpan($transactionIdOne),
        ];

        $spansTwo = [
            $this->createSpan($transactionIdTwo),
            $this->createSpan($transactionIdTwo),
        ];

        $service = new GroupSpanByTransactionId();
        $result = $service->execute(
            array_merge($spansOne, $spansTwo)
        );

        self::assertArrayHasKey($transactionIdOne, $result);
        self::assertArrayHasKey($transactionIdTwo, $result);
        self::assertSame($spansOne, $result[$transactionIdOne]);
        self::assertSame($spansTwo, $result[$transactionIdTwo]);
    }

    private function createSpan($transactionId)
    {
        $span = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\Span\Span');
        $span
            ->expects(self::once())
            ->method('transactionId')
            ->willReturn($transactionId);

        return $span;
    }
}
