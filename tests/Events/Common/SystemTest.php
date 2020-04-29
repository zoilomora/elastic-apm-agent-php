<?php

namespace ZoiloMora\ElasticAPM\Tests\Events\Common;

use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;
use ZoiloMora\ElasticAPM\Events\Common\System;

class SystemTest extends TestCase
{
    /**
     * @test
     */
    public function given_no_data_when_instantiating_then_return_object()
    {
        $object = new System();

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Events\Common\System', $object);
    }

    /**
     * @test
     */
    public function given_no_data_when_try_to_discover_then_return_object()
    {
        $object = System::discover();

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Events\Common\System', $object);
    }

    /**
     * @test
     */
    public function given_data_when_instantiating_then_can_get_properties()
    {
        $architecture = 'arch';
        $detectedHostname = 'test';
        $configuredHostname = 'test.com';
        $platform = 'x86';

        $container = self::getMockBuilder('ZoiloMora\ElasticAPM\Events\Common\System\Container')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $kubernetes = self::getMockBuilder('ZoiloMora\ElasticAPM\Events\Common\System\Kubernetes')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $object = new System(
            $architecture,
            $detectedHostname,
            $configuredHostname,
            $platform,
            $container,
            $kubernetes
        );

        self::assertSame($architecture, $object->architecture());
        self::assertSame($detectedHostname, $object->detectedHostname());
        self::assertSame($configuredHostname, $object->configuredHostname());
        self::assertSame($platform, $object->platform());
        self::assertSame($container, $object->container());
        self::assertSame($kubernetes, $object->kubernetes());
    }

    /**
     * @test
     */
    public function given_a_system_when_serialize_then_right_serialization()
    {
        $architecture = 'arch';
        $detectedHostname = 'test';
        $configuredHostname = 'test.com';
        $platform = 'x86';
        $valueContainer = 'container';
        $valueKubernetes = 'kubernetes';

        $containerMock = $this->getMockSerializable(
            'ZoiloMora\ElasticAPM\Events\Common\System\Container',
            $valueContainer
        );

        $kubernetesMock = $this->getMockSerializable(
            'ZoiloMora\ElasticAPM\Events\Common\System\Kubernetes',
            $valueKubernetes
        );

        $object = new System(
            $architecture,
            $detectedHostname,
            $configuredHostname,
            $platform,
            $containerMock,
            $kubernetesMock
        );

        $expected = json_encode([
            'architecture' => $architecture,
            'detected_hostname' => $detectedHostname,
            'configured_hostname' => $configuredHostname,
            'platform' => $platform,
            'container' => $valueContainer,
            'kubernetes' => $valueKubernetes,
        ]);

        self::assertSame($expected, json_encode($object));
    }
}
