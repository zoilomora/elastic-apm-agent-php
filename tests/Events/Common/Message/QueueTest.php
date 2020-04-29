<?php

namespace ZoiloMora\ElasticAPM\Tests\Events\Common\Message;

use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;
use ZoiloMora\ElasticAPM\Events\Common\Message\Queue;

class QueueTest extends TestCase
{
    /**
     * @test
     */
    public function given_no_data_when_instantiating_then_return_object()
    {
        $object = new Queue();

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Events\Common\Message\Queue', $object);
    }

    /**
     * @test
     */
    public function given_data_when_instantiating_then_can_get_properties()
    {
        $name = 'queue';

        $object = new Queue($name);

        self::assertSame($name, $object->name());
    }

    /**
     * @test
     */
    public function given_a_queue_when_serialize_then_right_serialization()
    {
        $name = 'queue';

        $object = new Queue($name);

        $expected = json_encode([
            'name' => $name,
        ]);

        self::assertSame($expected, json_encode($object));
    }
}
