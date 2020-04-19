<?php

namespace ZoiloMora\ElasticAPM\Tests\Events\Common\Message;

use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;
use ZoiloMora\ElasticAPM\Events\Common\Message\Age;

class AgeTest extends TestCase
{
    /**
     * @test
     */
    public function given_no_data_when_instantiating_then_return_object()
    {
        $object = new Age();

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Events\Common\Message\Age', $object);
    }

    /**
     * @test
     */
    public function given_data_when_instantiating_then_can_get_properties()
    {
        $ms = 1;

        $object = new Age($ms);

        self::assertEquals($ms, $object->ms());
    }

    /**
     * @test
     */
    public function given_a_age_when_serialize_then_right_serialization()
    {
        $ms = 1;

        $object = new Age($ms);

        $expected = json_encode([
            'ms' => $ms,
        ]);

        self::assertEquals($expected, json_encode($object));
    }
}
