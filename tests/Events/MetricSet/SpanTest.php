<?php

namespace ZoiloMora\ElasticAPM\Tests\Events\MetricSet;

use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;
use ZoiloMora\ElasticAPM\Events\MetricSet\Span;

class SpanTest extends TestCase
{
    /**
     * @test
     */
    public function given_valid_data_when_instantiating_then_return_object()
    {
        $type = 'db';
        $subtype = 'mongodb';

        $object = new Span($type, $subtype);

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Events\MetricSet\Span', $object);
    }

    /**
     * @test
     */
    public function given_invalid_type_name_when_instantiating_then_throw_exception()
    {
        self::setExpectedException('InvalidArgumentException', 'The [type] must be of type string.');

        new Span(null, null);
    }

    /**
     * @test
     */
    public function given_invalid_subtype_name_when_instantiating_then_throw_exception()
    {
        self::setExpectedException('InvalidArgumentException', 'The [subType] must be of type string or null.');

        new Span('db', 1);
    }

    /**
     * @test
     */
    public function given_a_span_when_serialize_then_right_serialization()
    {
        $type = 'db';
        $subtype = 'mongodb';

        $object = new Span($type, $subtype);

        $expected = json_encode([
            'type' => $type,
            'subtype' => $subtype,
        ]);

        $actual = json_encode($object);

        self::assertEquals($expected, $actual);
    }
}
