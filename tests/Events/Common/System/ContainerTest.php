<?php

namespace ZoiloMora\ElasticAPM\Tests\Events\Common\System;

use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;
use ZoiloMora\ElasticAPM\Events\Common\System\Container;

class ContainerTest extends TestCase
{
    /**
     * @test
     */
    public function given_data_when_instantiating_then_can_get_properties()
    {
        $id = 'id';

        $object = new Container($id);

        self::assertSame($id, $object->id());
    }

    /**
     * @test
     */
    public function given_invalid_data_when_instantiating_then_throw_exception()
    {
        self::setExpectedException('InvalidArgumentException', '[id] must be one of these types: string or null.');

        new Container(1);
    }

    /**
     * @test
     */
    public function given_a_message_when_serialize_then_right_serialization()
    {
        $id = 'id';

        $object = new Container($id);

        $expected = json_encode([
            'id' => $id,
        ]);

        self::assertSame($expected, json_encode($object));
    }

    /**
     * @test
     */
    public function given_a_container_with_null_id_when_serialize_then_right_serialization()
    {
        $object = new Container(null);

        $actual = json_encode($object);

        self::assertSame('null', $actual);
    }
}
