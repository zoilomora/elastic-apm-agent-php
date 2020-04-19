<?php

namespace ZoiloMora\ElasticAPM\Tests\Events\Span\Context;

use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;
use ZoiloMora\ElasticAPM\Events\Span\Context\Destination\Service;

class ServiceTest extends TestCase
{
    /**
     * @test
     */
    public function given_data_when_instantiating_then_return_can_get_properties()
    {
        $type = 'type';
        $name = 'name';
        $resource = 'resource';

        $object = new Service(
            $type,
            $name,
            $resource
        );

        self::assertEquals($type, $object->type());
        self::assertEquals($name, $object->name());
        self::assertEquals($resource, $object->resource());
    }

    /**
     * @test
     */
    public function given_a_service_count_when_serialize_then_right_serialization()
    {
        $type = 'type';
        $name = 'name';
        $resource = 'resource';

        $object = new Service(
            $type,
            $name,
            $resource
        );

        $expected = json_encode([
            'type' => $type,
            'name' => $name,
            'resource' => $resource,
        ]);

        self::assertEquals($expected, json_encode($object));
    }
}
