<?php

namespace ZoiloMora\ElasticAPM\Tests\Events\MetricSet;

use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;
use ZoiloMora\ElasticAPM\Events\MetricSet\Samples;

class SamplesTest extends TestCase
{
    /**
     * @test
     */
    public function given_empty_array_when_instantiating_then_throw_exception()
    {
        self::setExpectedException('InvalidArgumentException', 'There must be at least one element.');

        Samples::from([]);
    }

    /**
     * @test
     */
    public function given_invalid_array_element_when_instantiating_then_throw_exception()
    {
        self::setExpectedException('InvalidArgumentException', 'All elements must be of type Sample.');

        Samples::from([1]);
    }

    /**
     * @test
     */
    public function given_valid_array_when_instantiating_then_return_object()
    {
        $sampleMock = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\MetricSet\Sample');

        $object = Samples::from([
            $sampleMock,
        ]);

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Events\MetricSet\Samples', $object);
    }

    /**
     * @test
     */
    public function given_a_samples_when_serialize_then_right_serialization()
    {
        $type = 'type';
        $subtype = 'subtype';

        $sampleValue = [
            'type' => $type,
            'subtype' => $subtype,
        ];

        $sampleMock = $this->getMockSerializable('ZoiloMora\ElasticAPM\Events\MetricSet\Sample', $sampleValue);

        $object = Samples::from([
            $sampleMock,
        ]);

        $expected = json_encode($sampleValue);
        $actual = json_encode($object);

        self::assertSame($expected, $actual);
    }
}
