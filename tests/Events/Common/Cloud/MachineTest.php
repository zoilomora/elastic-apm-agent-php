<?php

namespace ZoiloMora\ElasticAPM\Tests\Events\Common\Cloud;

use ZoiloMora\ElasticAPM\Events\Common\Cloud\Machine;
use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;

class MachineTest extends TestCase
{
    /**
     * @test
     */
    public function given_data_when_instantiating_then_can_get_properties()
    {
        $type = 'type';

        $object = new Machine($type);

        self::assertSame($type, $object->type());
    }

    /**
     * @test
     */
    public function given_a_machine_when_serialize_then_right_serialization()
    {
        $type = 'type';

        $object = new Machine($type);

        $expected = json_encode([
            'type' => $type,
        ]);

        self::assertSame($expected, json_encode($object));
    }
}
