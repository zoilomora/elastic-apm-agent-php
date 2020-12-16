<?php

namespace ZoiloMora\ElasticAPM\Tests\Events\Metadata;

use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;
use ZoiloMora\ElasticAPM\Events\Metadata\Metadata;

class MetadataTest extends TestCase
{
    /**
     * @test
     */
    public function given_data_when_instantiating_then_can_get_properties()
    {
        $service = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\Metadata\Service');
        $process = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\Common\Process');
        $system = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\Common\System');
        $user = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\Common\User');
        $cloud = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\Common\Cloud');
        $labels = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\Common\Tags');

        $object = new Metadata(
            $service,
            $process,
            $system,
            $user,
            $cloud,
            $labels
        );

        self::assertSame($service, $object->service());
        self::assertSame($process, $object->process());
        self::assertSame($system, $object->system());
        self::assertSame($user, $object->user());
        self::assertSame($cloud, $object->cloud());
        self::assertSame($labels, $object->labels());
    }

    /**
     * @test
     */
    public function given_core_configuration_when_instantiating_then_can_get_properties()
    {
        $coreConfigurationMock = self::getMockBuilder('ZoiloMora\ElasticAPM\Configuration\CoreConfiguration')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $object = Metadata::create($coreConfigurationMock);

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Events\Metadata\Metadata', $object);
    }

    /**
     * @test
     */
    public function given_a_metadata_when_serialize_then_right_serialization()
    {
        $serviceValue = 'service';
        $processValue = 'process';
        $systemValue = 'system';
        $userValue = 'user';
        $cloudValue = 'user';
        $labelsValue = 'labels';

        $serviceMock = $this->getMockSerializable('ZoiloMora\ElasticAPM\Events\Metadata\Service', $serviceValue);
        $processMock = $this->getMockSerializable('ZoiloMora\ElasticAPM\Events\Common\Process', $processValue);
        $systemMock = $this->getMockSerializable('ZoiloMora\ElasticAPM\Events\Common\System', $systemValue);
        $userMock = $this->getMockSerializable('ZoiloMora\ElasticAPM\Events\Common\User', $userValue);
        $cloudMock = $this->getMockSerializable('ZoiloMora\ElasticAPM\Events\Common\Cloud', $cloudValue);
        $labelsMock = $this->getMockSerializable('ZoiloMora\ElasticAPM\Events\Common\Tags', $labelsValue);

        $object = new Metadata(
            $serviceMock,
            $processMock,
            $systemMock,
            $userMock,
            $cloudMock,
            $labelsMock
        );

        $expected = json_encode([
            'metadata' => [
                'service' => $serviceValue,
                'process' => $processValue,
                'system' => $systemValue,
                'user' => $userValue,
                'cloud' => $cloudValue,
                'labels' => $labelsValue,
            ],
        ]);

        self::assertSame($expected, json_encode($object));
    }
}
