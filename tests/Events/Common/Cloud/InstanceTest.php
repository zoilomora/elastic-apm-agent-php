<?php

namespace ZoiloMora\ElasticAPM\Tests\Events\Common\Cloud;

use ZoiloMora\ElasticAPM\Events\Common\Cloud\Instance;
use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;

class InstanceTest extends TestCase
{
    /**
     * @test
     */
    public function given_data_when_instantiating_then_can_get_properties()
    {
        $id = '2';
        $name = 'john';

        $object = new Instance(
            $id,
            $name
        );

        self::assertSame($id, $object->id());
        self::assertSame($name, $object->name());
    }

    /**
     * @test
     */
    public function given_a_instance_when_serialize_then_right_serialization()
    {
        $id = '2';
        $name = 'john';

        $object = new Instance(
            $id,
            $name
        );

        $expected = json_encode([
            'id' => $id,
            'name' => $name,
        ]);

        self::assertSame($expected, json_encode($object));
    }
}
