<?php

namespace ZoiloMora\ElasticAPM\Tests\Helper;

use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;
use ZoiloMora\ElasticAPM\Helper\DistributedTracing;

class DistributedTracingTest extends TestCase
{
    const HEADER = 'HTTP_ELASTIC_APM_TRACEPARENT';

    protected function tearDown()
    {
        parent::tearDown();

        DistributedTracing::fakeDistributedTracing(null);
        unset($_SERVER[self::HEADER]);
    }

    /**
     * @test
     */
    public function given_fake_data_when_generate_then_return_fake_data()
    {
        $fake = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Helper\DistributedTracing');

        DistributedTracing::fakeDistributedTracing($fake);

        $object = DistributedTracing::discoverDistributedTracing();

        self::assertEquals($fake, $object);
    }

    /**
     * @test
     */
    public function given_without_data_when_discover_then_return_null()
    {
        $object = DistributedTracing::discoverDistributedTracing();

        self::assertNull($object);
    }

    /**
     * @test
     */
    public function given_invalid_data_when_discover_then_throw_exception()
    {
        $_SERVER[self::HEADER] = 'invalid_value';

        self::setExpectedException('Exception', 'Invalid distributed trace header.');
        DistributedTracing::discoverDistributedTracing();
    }

    /**
     * @test
     */
    public function given_valid_data_when_discover_then_return_distributed_tracing()
    {
        $traceId = '00000000000000000000000000000000';
        $parentId = '0000000000000000';
        $traceFlags = '00';

        $_SERVER[self::HEADER] = implode('-', ['00', $traceId, $parentId, $traceFlags]);

        $object = DistributedTracing::discoverDistributedTracing();

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Helper\DistributedTracing', $object);
        self::assertEquals($traceId, $object->traceId());
        self::assertEquals($parentId, $object->parentId());
        self::assertEquals($traceFlags, $object->traceFlags());
    }
}
