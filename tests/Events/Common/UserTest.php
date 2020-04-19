<?php

namespace ZoiloMora\ElasticAPM\Tests\Events\Common;

use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;
use ZoiloMora\ElasticAPM\Events\Common\User;

class UserTest extends TestCase
{
    /**
     * @test
     */
    public function given_no_data_when_instantiating_then_return_object()
    {
        $object = new User();

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Events\Common\User', $object);
    }

    /**
     * @test
     */
    public function given_valid_data_when_instantiating_then_return_object()
    {
        $id = 1234;
        $email = 'john@example.com';
        $username = 'john';

        $object = new User($id, $email, $username);

        self::assertEquals($id, $object->id());
        self::assertEquals($email, $object->email());
        self::assertEquals($username, $object->username());
    }

    /**
     * @test
     */
    public function given_invalid_type_id_when_instantiating_then_throw_exception()
    {
        self::setExpectedException(
            'InvalidArgumentException',
            '[id] must be one of these types: integer, string or null.'
        );

        new User([]);
    }

    /**
     * @test
     */
    public function given_invalid_type_email_when_instantiating_then_throw_exception()
    {
        self::setExpectedException('InvalidArgumentException', '[email] must be one of these types: string or null.');

        new User(null, []);
    }

    /**
     * @test
     */
    public function given_invalid_type_username_when_instantiating_then_throw_exception()
    {
        self::setExpectedException(
            'InvalidArgumentException',
            '[username] must be one of these types: string or null.'
        );

        new User(null, null, []);
    }

    /**
     * @test
     */
    public function given_a_user_when_serialize_then_right_serialization()
    {
        $id = 1234;
        $email = 'john@example.com';
        $username = 'john';

        $object = new User($id, $email, $username);

        $expected = json_encode([
            'id' => $id,
            'email' => $email,
            'username' => $username,
        ]);

        self::assertEquals($expected, json_encode($object));
    }
}
