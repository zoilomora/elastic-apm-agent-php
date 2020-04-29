<?php

namespace ZoiloMora\ElasticAPM\Tests\Processor\MetricSetProcessor;

use ZoiloMora\ElasticAPM\Processor\MetricSetProcessor\Span;
use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;

class SpanTest extends TestCase
{
    /**
     * @test
     */
    public function given_data_when_instantiating_then_return_object()
    {
        $transactionId = '123456';
        $type = 'request';
        $subType = null;
        $count = 1;
        $sum = 0;

        $object = new Span(
            $transactionId,
            $type,
            $subType,
            $count,
            $sum
        );

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Processor\MetricSetProcessor\Span', $object);
    }

    /**
     * @test
     */
    public function given_data_when_instantiating_then_return_can_get_properties()
    {
        $transactionId = '123456';
        $type = 'request';
        $subType = null;
        $count = 1;
        $sum = 0;

        $object = new Span(
            $transactionId,
            $type,
            $subType,
            $count,
            $sum
        );

        self::assertSame($transactionId, $object->transactionId());
        self::assertSame($type, $object->type());
        self::assertSame($subType, $object->subType());
        self::assertSame($count, $object->count());
        self::assertSame($sum, $object->sum());
    }
}
