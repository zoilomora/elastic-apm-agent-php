<?php

namespace ZoiloMora\ElasticAPM\Tests\Events\Span\Context;

use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;
use ZoiloMora\ElasticAPM\Events\Span\Context\Db;

class DbTest extends TestCase
{
    /**
     * @test
     */
    public function given_no_data_when_instantiating_then_return_object()
    {
        $object = new Db();

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Events\Span\Context\Db', $object);
    }

    /**
     * @test
     */
    public function given_data_when_instantiating_then_return_can_get_properties()
    {
        $instance = 'instance';
        $link = 'link';
        $statement = 'statement';
        $type = 'type';
        $user = 'user';
        $rowsAffected = 'rowsAffected';

        $object = new Db(
            $instance,
            $link,
            $statement,
            $type,
            $user,
            $rowsAffected
        );

        self::assertSame($instance, $object->instance());
        self::assertSame($link, $object->link());
        self::assertSame($statement, $object->statement());
        self::assertSame($type, $object->type());
        self::assertSame($user, $object->user());
        self::assertSame($rowsAffected, $object->rowsAffected());
    }

    /**
     * @test
     */
    public function given_a_db_count_when_serialize_then_right_serialization()
    {
        $instance = 'instance';
        $link = 'link';
        $statement = 'statement';
        $type = 'type';
        $user = 'user';
        $rowsAffected = 'rowsAffected';

        $object = new Db(
            $instance,
            $link,
            $statement,
            $type,
            $user,
            $rowsAffected
        );

        $expected = json_encode([
            'instance' => $instance,
            'link' => $link,
            'statement' => $statement,
            'type' => $type,
            'user' => $user,
            'rows_affected' => $rowsAffected,
        ]);

        self::assertSame($expected, json_encode($object));
    }
}
