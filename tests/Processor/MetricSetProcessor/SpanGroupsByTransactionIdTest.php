<?php

namespace ZoiloMora\ElasticAPM\Tests\Processor\MetricSetProcessor;

use ZoiloMora\ElasticAPM\Processor\MetricSetProcessor\SpanGroupsByTransactionId;
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

        $service = new SpanGroupsByTransactionId();
        $result = $service->execute(
            array_merge($spansOne, $spansTwo)
        );

        self::assertNotEmpty($result);
        self::assertContainsOnlyInstancesOf(
            'ZoiloMora\ElasticAPM\Processor\MetricSetProcessor\SpanGroup',
            $result
        );

        $spanGroupOne = $result[0];
        $spanGroupTwo = $result[1];

        self::assertSame($transactionIdOne, $spanGroupOne->transactionId());
        self::assertSame($transactionIdTwo, $spanGroupTwo->transactionId());
        self::assertSame($spansOne, $spanGroupOne->spans());
        self::assertSame($spansTwo, $spanGroupTwo->spans());
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
