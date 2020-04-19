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

        self::assertEquals($transactionId, $object->transactionId());
        self::assertEquals($type, $object->type());
        self::assertEquals($subType, $object->subType());
        self::assertEquals($count, $object->count());
        self::assertEquals($sum, $object->sum());
    }
}
