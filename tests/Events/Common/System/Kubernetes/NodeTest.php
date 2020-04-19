<?php

namespace ZoiloMora\ElasticAPM\Tests\Events\Common\System\Kubernetes;

use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;
use ZoiloMora\ElasticAPM\Events\Common\System\Kubernetes\Node;

class NodeTest extends TestCase
{
    /**
     * @test
     */
    public function given_no_data_when_instantiating_then_return_object()
    {
        $object = new Node();

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Events\Common\System\Kubernetes\Node', $object);
    }

    /**
     * @test
     */
    public function given_no_data_when_try_to_discover_then_return_object()
    {
        $object = Node::discover();

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Events\Common\System\Kubernetes\Node', $object);
    }

    /**
     * @test
     */
    public function given_data_when_instantiating_then_can_get_properties()
    {
        $name = 'name';

        $object = new Node($name);

        self::assertEquals($name, $object->name());
    }

    /**
     * @test
     */
    public function given_a_node_when_serialize_then_right_serialization()
    {
        $name = 'name';

        $object = new Node($name);

        $expected = json_encode([
            'name' => $name,
        ]);

        self::assertEquals($expected, json_encode($object));
    }
}
