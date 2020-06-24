<?php

namespace ZoiloMora\ElasticAPM\Tests\Processor\MetricSetProcessor;

use ZoiloMora\ElasticAPM\Processor\MetricSetProcessor\SpanGroup;
use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;

class SpanGroupTest extends TestCase
{
    /**
     * @test
     */
    public function given_data_when_instantiating_then_return_object()
    {
        $transactionId = '123456';
        $spans = [];

        $object = new SpanGroup(
            $transactionId,
            $spans
        );

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Processor\MetricSetProcessor\SpanGroup', $object);
    }

    /**
     * @test
     */
    public function given_transaction_id_of_type_int_when_instantiating_then_return_transaction_id_of_type_string()
    {
        $transactionId = 123456;
        $spans = [];

        $object = new SpanGroup(
            $transactionId,
            $spans
        );

        self::assertSame(
            'string',
            gettype($object->transactionId())
        );
    }

    /**
     * @test
     */
    public function given_data_when_instantiating_then_return_can_get_properties()
    {
        $transactionId = '123456';
        $spans = [];

        $object = new SpanGroup(
            $transactionId,
            $spans
        );

        self::assertSame($transactionId, $object->transactionId());
        self::assertSame($spans, $object->spans());
    }

    /**
     * @test
     */
    public function given_a_span_group_when_serialize_then_right_serialization()
    {
        $transactionId = '123456';
        $spans = [];

        $object = new SpanGroup(
            $transactionId,
            $spans
        );

        $expected = json_encode([
            'transaction_id' => $transactionId,
            'spans' => $spans,
        ]);

        self::assertSame($expected, json_encode($object));
    }
}
