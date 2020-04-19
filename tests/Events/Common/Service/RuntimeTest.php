<?php

namespace ZoiloMora\ElasticAPM\Tests\Events\Common\Service;

use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;
use ZoiloMora\ElasticAPM\Events\Common\Service\Runtime;

class RuntimeTest extends TestCase
{
    /**
     * @test
     */
    public function given_no_data_when_instantiating_then_return_object()
    {
        $object = new Runtime();

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Events\Common\Service\Runtime', $object);
    }

    /**
     * @test
     */
    public function given_no_data_when_try_to_discover_then_return_object()
    {
        $object = Runtime::discover();

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Events\Common\Service\Runtime', $object);
    }

    /**
     * @test
     */
    public function given_data_when_instantiating_then_can_get_properties()
    {
        $name = 'name';
        $version = 'version';

        $object = new Runtime(
            $name,
            $version
        );

        self::assertEquals($name, $object->name());
        self::assertEquals($version, $object->version());
    }

    /**
     * @test
     */
    public function given_a_runtime_when_serialize_then_right_serialization()
    {
        $name = 'name';
        $version = 'version';

        $object = new Runtime(
            $name,
            $version
        );

        $expected = json_encode([
            'name' => $name,
            'version' => $version,
        ]);

        self::assertEquals($expected, json_encode($object));
    }
}
