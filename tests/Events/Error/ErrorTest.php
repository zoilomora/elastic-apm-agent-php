<?php

namespace ZoiloMora\ElasticAPM\Tests\Events\Error;

use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;
use ZoiloMora\ElasticAPM\Events\Error\Error;

class ErrorTest extends TestCase
{
    /**
     * @test
     */
    public function given_valid_data_when_instantiating_then_return_object()
    {
        $traceId = 'trace-id';
        $parentId = 'parent-id';
        $exception = new \Exception();
        $context = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\Common\Context');
        $transactionId = 'transaction-id';

        $object = new Error(
            $traceId,
            $parentId,
            $exception,
            $context,
            $transactionId
        );

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Events\Error\Error', $object);
    }

    /**
     * @test
     */
    public function given_a_error_set_when_serialize_then_right_serialization()
    {
        $contextValue = '';

        $traceId = 'trace-id';
        $parentId = 'parent-id';
        $exception = new \Exception();
        $contextMock = $this->getMockSerializable('ZoiloMora\ElasticAPM\Events\Common\Context', $contextValue);
        $transactionId = 'transaction-id';

        $object = new Error(
            $traceId,
            $parentId,
            $exception,
            $contextMock,
            $transactionId
        );

        $actual = json_decode(
            json_encode($object),
            true
        );

        $error = $actual['error'];

        self::assertArrayHasKey('timestamp', $error);
        self::assertArrayHasKey('transaction_id', $error);
        self::assertArrayHasKey('context', $error);
        self::assertArrayHasKey('culprit', $error);
        self::assertArrayHasKey('exception', $error);
    }
}
