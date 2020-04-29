<?php

namespace ZoiloMora\ElasticAPM\Tests\Events\Common\Service;

use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;
use ZoiloMora\ElasticAPM\Events\Common\Service\Node;

class NodeTest extends TestCase
{
    /**
     * @test
     */
    public function given_no_data_when_instantiating_then_return_object()
    {
        $object = new Node();

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Events\Common\Service\Node', $object);
    }

    /**
     * @test
     */
    public function given_data_when_instantiating_then_can_get_properties()
    {
        $configuredName = 'name';

        $object = new Node($configuredName);

        self::assertSame($configuredName, $object->configuredName());
    }

    /**
     * @test
     */
    public function given_a_node_when_serialize_then_right_serialization()
    {
        $configuredName = 'name';

        $object = new Node($configuredName);

        $expected = json_encode([
            'configured_name' => $configuredName,
        ]);

        self::assertSame($expected, json_encode($object));
    }
}
