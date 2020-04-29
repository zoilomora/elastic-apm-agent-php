<?php

namespace ZoiloMora\ElasticAPM\Tests\Events\Common\Service;

use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;
use ZoiloMora\ElasticAPM\Events\Common\Service\Framework;

class FrameworkTest extends TestCase
{
    /**
     * @test
     */
    public function given_no_data_when_instantiating_then_return_object()
    {
        $object = new Framework();

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Events\Common\Service\Framework', $object);
    }

    /**
     * @test
     */
    public function given_data_when_instantiating_then_can_get_properties()
    {
        $name = 'name';
        $version = 'version';

        $object = new Framework(
            $name,
            $version
        );

        self::assertSame($name, $object->name());
        self::assertSame($version, $object->version());
    }

    /**
     * @test
     */
    public function given_core_configuration_when_instantiating_then_can_get_properties()
    {
        $name = 'name';
        $version = 'version';

        $coreConfigurationMock = self::getMockBuilder('ZoiloMora\ElasticAPM\Configuration\CoreConfiguration')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $coreConfigurationMock
            ->expects(self::once())
            ->method('frameworkName')
            ->willReturn($name)
        ;

        $coreConfigurationMock
            ->expects(self::once())
            ->method('frameworkVersion')
            ->willReturn($version)
        ;

        $object = Framework::create($coreConfigurationMock);

        self::assertSame($name, $object->name());
        self::assertSame($version, $object->version());
    }

    /**
     * @test
     */
    public function given_a_framework_when_serialize_then_right_serialization()
    {
        $name = 'name';
        $version = 'version';

        $object = new Framework(
            $name,
            $version
        );

        $expected = json_encode([
            'name' => $name,
            'version' => $version,
        ]);

        self::assertSame($expected, json_encode($object));
    }
}
