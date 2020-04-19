<?php

namespace ZoiloMora\ElasticAPM\Tests\Events\MetricSet;

use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;
use ZoiloMora\ElasticAPM\Events\MetricSet\Sample;

class SampleTest extends TestCase
{
    /**
     * @test
     */
    public function given_valid_data_when_instantiating_then_return_object()
    {
        $name = 'cpu';
        $value = 1.1;

        $object = new Sample($name, $value);

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Events\MetricSet\Sample', $object);
    }

    /**
     * @test
     */
    public function given_invalid_type_name_when_instantiating_then_throw_exception()
    {
        $name = 1.1;
        $value = 1.2;

        self::setExpectedException('InvalidArgumentException', 'The [name] must be of type string.');
        new Sample($name, $value);
    }

    /**
     * @test
     */
    public function given_invalid_characters_name_when_instantiating_then_throw_exception()
    {
        $name = '"ram"';
        $value = 1.1;

        self::setExpectedException(
            'InvalidArgumentException',
            'The [name] must match the regular expression /^[^*"]*$/'
        );
        new Sample($name, $value);
    }

    /**
     * @test
     */
    public function given_a_sample_when_serialize_then_right_serialization()
    {
        $name = 'cpu';
        $value = 1.1;

        $expected = json_encode([
            $name => [
                'value' => $value,
            ],
        ]);

        $object = new Sample($name, $value);
        $actual = json_encode($object);

        self::assertEquals($expected, $actual);
    }
}
