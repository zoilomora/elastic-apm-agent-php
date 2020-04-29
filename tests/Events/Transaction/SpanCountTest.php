<?php

namespace ZoiloMora\ElasticAPM\Tests\Events\Transaction;

use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;
use ZoiloMora\ElasticAPM\Events\Transaction\SpanCount;

class SpanCountTest extends TestCase
{
    /**
     * @test
     */
    public function given_data_when_instantiating_then_return_can_get_properties()
    {
        $started = 1;
        $dropped = 1;

        $object = new SpanCount($started, $dropped);

        self::assertSame($started, $object->started());
        self::assertSame($dropped, $object->dropped());
    }

    /**
     * @test
     */
    public function given_a_span_count_when_serialize_then_right_serialization()
    {
        $started = 1;
        $dropped = 1;

        $expected = json_encode([
            'started' => $started,
            'dropped' => $dropped,
        ]);

        $object = new SpanCount($started, $dropped);
        $actual = json_encode($object);

        self::assertSame($expected, $actual);
    }
}
