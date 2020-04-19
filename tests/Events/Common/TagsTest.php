<?php

namespace ZoiloMora\ElasticAPM\Tests\Events\Common;

use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;
use ZoiloMora\ElasticAPM\Events\Common\Tags;

class TagsTest extends TestCase
{
    /**
     * @test
     */
    public function given_empty_array_when_instantiating_then_return_object()
    {
        $object = Tags::from([]);

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Events\Common\Tags', $object);
    }

    /**
     * @test
     */
    public function given_valid_data_when_instantiating_then_return_object()
    {
        $object = Tags::from([
            'name' => 'test',
            'active' => true,
            'length' => 1.1,
            'year' => 1970,
            'data' => null,
        ]);

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Events\Common\Tags', $object);
    }

    /**
     * @test
     */
    public function given_characters_not_allowed_when_instantiating_then_throw_exception()
    {
        self::setExpectedException(
            'InvalidArgumentException',
            'The name must match the regular expression /^[^.*\"]*$/'
        );

        Tags::from([
            '"name"' => 'test',
        ]);
    }

    /**
     * @test
     */
    public function given_types_not_allowed_when_instantiating_then_throw_exception()
    {
        self::setExpectedException('InvalidArgumentException');

        Tags::from([
            'data' => [],
        ]);
    }
}
