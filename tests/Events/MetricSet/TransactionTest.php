<?php

namespace ZoiloMora\ElasticAPM\Tests\Events\MetricSet;

use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;
use ZoiloMora\ElasticAPM\Events\MetricSet\Transaction;

class TransactionTest extends TestCase
{
    /**
     * @test
     */
    public function given_valid_data_when_instantiating_then_return_object()
    {
        $name = 'GET /users/:id';
        $type = 'request';

        $object = new Transaction($name, $type);

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Events\MetricSet\Transaction', $object);
    }

    /**
     * @test
     */
    public function given_invalid_type_name_when_instantiating_then_throw_exception()
    {
        self::setExpectedException('InvalidArgumentException', 'The [name] must be of type string.');

        new Transaction(null, null);
    }

    /**
     * @test
     */
    public function given_invalid_type_type_when_instantiating_then_throw_exception()
    {
        self::setExpectedException('InvalidArgumentException', 'The [type] must be of type string.');

        new Transaction('GET /users/:id', null);
    }

    /**
     * @test
     */
    public function given_a_transaction_when_serialize_then_right_serialization()
    {
        $name = 'GET /users/:id';
        $type = 'request';

        $object = new Transaction($name, $type);

        $expected = json_encode([
            'name' => $name,
            'type' => $type,
        ]);

        $actual = json_encode($object);

        self::assertSame($expected, $actual);
    }
}
