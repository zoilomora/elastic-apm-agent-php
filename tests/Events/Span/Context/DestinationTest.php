<?php

namespace ZoiloMora\ElasticAPM\Tests\Events\Span\Context;

use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;
use ZoiloMora\ElasticAPM\Events\Span\Context\Destination;

class DestinationTest extends TestCase
{
    /**
     * @test
     */
    public function given_data_when_instantiating_then_return_can_get_properties()
    {
        $address = '127.0.0.1';
        $port = '443';
        $service = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\Span\Context\Destination\Service');

        $object = new Destination($address, $port, $service);

        self::assertEquals($address, $object->address());
        self::assertEquals($port, $object->port());
        self::assertEquals($service, $object->service());
    }

    /**
     * @test
     */
    public function given_a_destination_count_when_serialize_then_right_serialization()
    {
        $address = '127.0.0.1';
        $port = '443';
        $serviceValue = 'service';

        $serviceMock = $this->getMockSerializable(
            'ZoiloMora\ElasticAPM\Events\Span\Context\Destination\Service',
            $serviceValue
        );

        $object = new Destination($address, $port, $serviceMock);

        $expected = json_encode([
            'address' => $address,
            'port' => $port,
            'service' => $serviceValue,
        ]);

        self::assertEquals($expected, json_encode($object));
    }
}
