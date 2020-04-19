<?php

namespace ZoiloMora\ElasticAPM\Tests\Events;

use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;
use ZoiloMora\ElasticAPM\Helper\Cryptography;
use ZoiloMora\ElasticAPM\Helper\DistributedTracing;

class TraceableEventTest extends TestCase
{
    protected function tearDown()
    {
        parent::tearDown();

        Cryptography::fakeRandomBitsInHex(null);
        DistributedTracing::fakeDistributedTracing(null);
    }

    /**
     * @test
     */
    public function given_empty_constructor_when_instance_a_traceable_event_then_returns_traceable_event()
    {
        $object = self::getMockForAbstractClass('ZoiloMora\ElasticAPM\Events\TraceableEvent');

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Events\TraceableEvent', $object);
    }

    /**
     * @test
     */
    public function given_empty_constructor_when_instance_a_traceable_event_then_trace_id_is_generated()
    {
        $fakeTraceId = Cryptography::generateRandomBitsInHex(8);
        Cryptography::fakeRandomBitsInHex($fakeTraceId);

        $object = self::getMockForAbstractClass('ZoiloMora\ElasticAPM\Events\TraceableEvent');
        $distributedTracing = $object->distributedTracing();

        self::assertEquals($fakeTraceId, $object->traceId());
        self::assertNull($object->parentId());
        self::assertEquals(
            'string',
            gettype($distributedTracing)
        );
    }

    /**
     * @test
     */
    public function given_data_when_instance_a_traceable_event_then_is_created_with_that_data()
    {
        $traceId = 'testTraceId';
        $parentId = 'testParentId';

        $object = self::getMockForAbstractClass(
            'ZoiloMora\ElasticAPM\Events\TraceableEvent',
            [
                $traceId,
                $parentId
            ]
        );

        $distributedTracing = $object->distributedTracing();

        self::assertEquals($traceId, $object->traceId());
        self::assertEquals($parentId, $object->parentId());
        self::assertEquals(
            'string',
            gettype($distributedTracing)
        );
    }

    /**
     * @test
     */
    public function given_incorrect_trace_id_when_instance_a_traceable_event_then_throw_exception()
    {
        $traceId = 1;

        self::setExpectedException('InvalidArgumentException', '[traceId] must be of string type.');

        self::getMockForAbstractClass(
            'ZoiloMora\ElasticAPM\Events\TraceableEvent',
            [
                $traceId,
            ]
        );
    }

    /**
     * @test
     */
    public function given_incorrect_parent_id_when_instance_a_traceable_event_then_throw_exception()
    {
        $traceId = 'testTraceId';
        $parentId = 2;

        self::setExpectedException('InvalidArgumentException', '[parentId] must be of string type.');

        self::getMockForAbstractClass(
            'ZoiloMora\ElasticAPM\Events\TraceableEvent',
            [
                $traceId,
                $parentId,
            ]
        );
    }

    /**
     * @test
     */
    public function given_distributed_trace_data_when_instance_a_traceable_event_then_is_created_with_that_data()
    {
        $traceId = 'testTraceId';
        $parentId = 'testParentId';

        $distributedTracing = self::getMockBuilder('ZoiloMora\ElasticAPM\Helper\DistributedTracing')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $distributedTracing
            ->expects(self::once())
            ->method('traceId')
            ->willReturn($traceId)
        ;
        $distributedTracing
            ->expects(self::once())
            ->method('parentId')
            ->willReturn($parentId)
        ;

        DistributedTracing::fakeDistributedTracing($distributedTracing);

        $object = self::getMockForAbstractClass('ZoiloMora\ElasticAPM\Events\TraceableEvent');

        $distributedTracing = $object->distributedTracing();

        self::assertEquals($traceId, $object->traceId());
        self::assertEquals($parentId, $object->parentId());
        self::assertEquals(
            'string',
            gettype($distributedTracing)
        );
    }

    /**
     * @test
     */
    public function given_a_traceable_event_when_serialize_then_right_serialization()
    {
        $fakeId = Cryptography::generateRandomBitsInHex(8);
        Cryptography::fakeRandomBitsInHex($fakeId);

        $traceId = 'testTraceId';
        $parentId = 'testParentId';

        $object = self::getMockForAbstractClass(
            'ZoiloMora\ElasticAPM\Events\TraceableEvent',
            [
                $traceId,
                $parentId
            ]
        );

        $expected = json_encode([
            'id' => $fakeId,
            'trace_id' => $traceId,
            'parent_id' => $parentId,
        ]);

        self::assertEquals($expected, json_encode($object));
    }
}
