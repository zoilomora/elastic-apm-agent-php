<?php

namespace ZoiloMora\ElasticAPM\Tests\Events\Span;

use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;
use ZoiloMora\ElasticAPM\Events\Span\Span;

class SpanTest extends TestCase
{
    /**
     * @test
     */
    public function given_minimum_data_when_instantiating_then_return_object()
    {
        $object = $this->generateSpan();

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Events\Span\Span', $object);
    }

    /**
     * @test
     */
    public function given_data_when_instantiating_then_return_can_get_properties()
    {
        $name = 'MongoDB Query';
        $type = 'db.mongodb.query';
        $traceId = 'trace-id';
        $parentId = 'parent-id';
        $transactionId = 'transaction-id';
        $context = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\Span\Context');

        $object = new Span(
            $name,
            $type,
            $traceId,
            $parentId,
            null,
            $transactionId,
            null,
            $context
        );

        self::assertEquals($transactionId, $object->transactionId());
        self::assertEquals($context, $object->context());
    }

    /**
     * @test
     */
    public function given_data_when_instantiating_then_return_transaction_started()
    {
        $object = $this->generateSpan();

        self::assertFalse($object->isFinished());
        $object->stop();
        self::assertTrue($object->isFinished());
    }

    /**
     * @test
     */
    public function given_a_span_when_finish_then_can_get_the_duration()
    {
        $object = $this->generateSpan();
        $object->stop();

        self::assertInternalType('double', $object->duration());
    }

    /**
     * @test
     */
    public function given_a_span_when_serialize_then_right_serialization()
    {
        $name = 'MongoDB Query';
        $type = 'db.mongodb.query';
        $subtype = '';
        $transactionId = '';
        $action = '';
        $contextValue = 'context';
        $stacktrace = '';

        $contextMock = $this->getMockSerializable('ZoiloMora\ElasticAPM\Events\Span\Context', $contextValue);

        $object = new Span(
            $name,
            $type,
            'trace-id',
            'parent-id',
            $subtype,
            $transactionId,
            $action,
            $contextMock,
            $stacktrace
        );

        $actual = json_decode(
            json_encode($object),
            true
        );

        $span = $actual['span'];

        self::assertArrayHasKey('timestamp', $span);
        self::assertArrayHasKey('type', $span);
        self::assertArrayHasKey('subtype', $span);
        self::assertArrayHasKey('transaction_id', $span);
        self::assertArrayHasKey('start', $span);
        self::assertArrayHasKey('action', $span);
        self::assertArrayHasKey('context', $span);
        self::assertArrayHasKey('duration', $span);
        self::assertArrayHasKey('name', $span);
        self::assertArrayHasKey('stacktrace', $span);

        self::assertEquals($name, $span['name']);
        self::assertEquals($type, $span['type']);
        self::assertEquals($subtype, $span['subtype']);
        self::assertEquals($transactionId, $span['transaction_id']);
        self::assertEquals($action, $span['action']);
        self::assertEquals($contextValue, $span['context']);
        self::assertEquals($stacktrace, $span['stacktrace']);
    }

    /**
     * @return Span
     *
     * @throws \Exception
     */
    private function generateSpan()
    {
        $name = 'MongoDB Query';
        $type = 'db.mongodb.query';
        $traceId = 'trace-id';
        $parentId = 'parent-id';

        return new Span(
            $name,
            $type,
            $traceId,
            $parentId
        );
    }
}
