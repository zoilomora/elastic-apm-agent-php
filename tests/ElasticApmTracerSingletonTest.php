<?php

namespace ZoiloMora\ElasticAPM\Tests;

use ZoiloMora\ElasticAPM\ElasticApmTracer;
use ZoiloMora\ElasticAPM\ElasticApmTracerSingleton;
use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;

class ElasticApmTracerSingletonTest extends TestCase
{
    protected function tearDown()
    {
        parent::tearDown();

        ElasticApmTracerSingletonMock::cleanup();
    }

    /**
     * @test
     */
    public function given_empty_singleton_when_get_instance_then_throw_exception()
    {
        self::setExpectedException('Exception', 'The instance has not yet been injected.');

        ElasticApmTracerSingleton::instance();
    }

    /**
     * @test
     */
    public function given_filled_singleton_when_set_instance_then_throw_exception()
    {
        ElasticApmTracerSingleton::inject(
            $this->getTracerMock()
        );

        self::setExpectedException('Exception', 'Already an injected object, it cannot be replaced.');

        ElasticApmTracerSingleton::inject(
            $this->getTracerMock()
        );
    }

    /**
     * @test
     */
    public function given_empty_singleton_when_set_instance_then_throw_exception()
    {
        $expected = $this->getTracerMock();

        ElasticApmTracerSingleton::inject($expected);

        $actual = ElasticApmTracerSingleton::instance();

        self::assertEquals($expected, $actual);
    }

    /**
     * @return ElasticApmTracer
     */
    private function getTracerMock()
    {
        return $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\ElasticApmTracer');
    }
}
