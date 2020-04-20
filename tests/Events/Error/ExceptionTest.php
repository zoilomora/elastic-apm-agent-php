<?php

namespace ZoiloMora\ElasticAPM\Tests\Events\Error;

use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;
use ZoiloMora\ElasticAPM\Events\Error\Exception;

class ExceptionTest extends TestCase
{
    /**
     * @test
     */
    public function given_empty_constructor_when_instantiating_then_throw_exception()
    {
        self::setExpectedException(
            'InvalidArgumentException',
            'At least one of the fields (message, type) must be a string.'
        );

        new Exception();
    }

    /**
     * @test
     */
    public function given_invalid_stacktrace_when_instantiating_then_throw_exception()
    {
        self::setExpectedException('InvalidArgumentException', 'All elements must be instances of ');

        new Exception(
            null,
            'message',
            null,
            null,
            [
                'hello',
            ]
        );
    }

    /**
     * @test
     */
    public function given_stacktrace_equal_to_null_when_instantiating_then_return_object()
    {
        $object = new Exception(
            null,
            'message',
            null,
            null,
            null
        );

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Events\Error\Exception', $object);
    }
}
