<?php

namespace ZoiloMora\ElasticAPM\Tests\Processor;

use ZoiloMora\ElasticAPM\Processor\Handler;
use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;

class HandlerTest extends TestCase
{
    /**
     * @test
     */
    public function given_invalid_processors_when_instantiate_handler_then_throw_exception()
    {
        self::setExpectedException('InvalidArgumentException', 'All elements must be of type Processor.');

        $processors = [
            'invalid',
        ];

        new Handler($processors);
    }
}
