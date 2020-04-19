<?php

namespace ZoiloMora\ElasticAPM\Tests\Events\Common\System;

use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;
use ZoiloMora\ElasticAPM\Events\Common\System\Kubernetes;

class KubernetesTest extends TestCase
{
    /**
     * @test
     */
    public function given_no_data_when_instantiating_then_return_object()
    {
        $object = new Kubernetes();

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Events\Common\System\Kubernetes', $object);
    }

    /**
     * @test
     */
    public function given_data_when_instantiating_then_can_get_properties()
    {
        $namespace = 'namespace';
        $pod = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\Common\System\Kubernetes\Pod');
        $node = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\Common\System\Kubernetes\Node');

        $object = new Kubernetes(
            $namespace,
            $pod,
            $node
        );

        self::assertEquals($pod, $object->pod());
        self::assertEquals($node, $object->node());
    }

    /**
     * @test
     */
    public function given_a_kubernetes_when_serialize_then_right_serialization()
    {
        $podValue = 'pod';
        $nodeValue = 'node';

        $namespace = 'namespace';
        $pod = $this->getMockSerializable('ZoiloMora\ElasticAPM\Events\Common\System\Kubernetes\Pod', $podValue);
        $node = $this->getMockSerializable('ZoiloMora\ElasticAPM\Events\Common\System\Kubernetes\Node', $nodeValue);

        $object = new Kubernetes(
            $namespace,
            $pod,
            $node
        );

        $expected = json_encode([
            'namespace' => $namespace,
            'pod' => $podValue,
            'node' => $nodeValue,
        ]);

        self::assertEquals($expected, json_encode($object));
    }
}
