<?php

namespace ZoiloMora\ElasticAPM\Tests\Events\Common\System\Kubernetes;

use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;
use ZoiloMora\ElasticAPM\Events\Common\System\Kubernetes\Pod;

class PodTest extends TestCase
{
    /**
     * @test
     */
    public function given_no_data_when_instantiating_then_return_object()
    {
        $object = new Pod();

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Events\Common\System\Kubernetes\Pod', $object);
    }

    /**
     * @test
     */
    public function given_no_data_when_try_to_discover_then_return_object()
    {
        $object = Pod::discover();

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Events\Common\System\Kubernetes\Pod', $object);
    }

    /**
     * @test
     */
    public function given_data_when_instantiating_then_can_get_properties()
    {
        $name = 'name';
        $uid = 'uid';

        $object = new Pod($name, $uid);

        self::assertSame($name, $object->name());
        self::assertSame($uid, $object->uid());
    }

    /**
     * @test
     */
    public function given_a_pod_when_serialize_then_right_serialization()
    {
        $name = 'name';
        $uid = 'uid';

        $object = new Pod($name, $uid);

        $expected = json_encode([
            'name' => $name,
            'uid' => $uid,
        ]);

        self::assertSame($expected, json_encode($object));
    }
}
