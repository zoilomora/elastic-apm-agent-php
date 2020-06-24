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

    /**
     * @test
     */
    public function given_a_span_when_serialize_then_right_serialization()
    {
        $transactionId = 'transactionId';
        $type = 'type';
        $subType = 'subType';
        $count = 1;
        $sum = 1.1;

        $object = new Span(
            $transactionId,
            $type,
            $subType,
            $count,
            $sum
        );

        $expected = json_encode([
            'transaction_id' => $transactionId,
            'type' => $type,
            'sub_type' => $subType,
            'count' => $count,
            'sum' => $sum,
        ]);

        self::assertSame($expected, json_encode($object));
    }
}
