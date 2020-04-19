<?php

namespace ZoiloMora\ElasticAPM\Tests\Events\Common\Request;

use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;
use ZoiloMora\ElasticAPM\Events\Common\Request\Socket;

class SocketTest extends TestCase
{
    protected function tearDown()
    {
        parent::tearDown();

        unset($_SERVER['HTTPS']);
        unset($_SERVER['REMOTE_ADDR']);
        unset($_SERVER['HTTP_X_FORWARDED_FOR']);
    }

    /**
     * @test
     */
    public function given_no_data_when_instantiating_then_return_object()
    {
        $object = new Socket();

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Events\Common\Request\Socket', $object);
    }

    /**
     * @test
     */
    public function given_data_when_instantiating_then_can_get_properties()
    {
        $encrypted = false;
        $remoteAddress = '127.0.0.1';

        $object = new Socket($encrypted, $remoteAddress);

        self::assertEquals($encrypted, $object->encrypted());
        self::assertEquals($remoteAddress, $object->remoteAddress());
    }

    /**
     * @test
     */
    public function given_http_environment_when_try_to_discover_then_return_object()
    {
        $object = Socket::discover();

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Events\Common\Request\Socket', $object);
    }

    /**
     * @test
     */
    public function given_http_environment_when_try_to_discover_then_return_object_not_encrypted()
    {
        $object = Socket::discover();

        self::assertNotTrue($object->encrypted());
    }

    /**
     * @test
     */
    public function given_https_environment_when_try_to_discover_then_return_object_encrypted()
    {
        $_SERVER['HTTPS'] = 'on';

        $object = Socket::discover();

        self::assertTrue($object->encrypted());
    }

    /**
     * @test
     */
    public function given_cli_environment_when_try_to_discover_then_return_object_without_remote_address()
    {
        $object = Socket::discover();

        self::assertNull($object->remoteAddress());
    }

    /**
     * @test
     */
    public function given_a_direct_request_when_try_to_discover_then_return_object_with_remote_address()
    {
        $remoteAddress = '127.0.0.1';

        $_SERVER['REMOTE_ADDR'] = $remoteAddress;

        $object = Socket::discover();

        self::assertEquals($remoteAddress, $object->remoteAddress());
    }

    /**
     * @test
     */
    public function given_a_redirected_request_when_try_to_discover_then_return_object_with_real_remote_address()
    {
        $realRemoteAddress = '1.2.3.4';
        $loadBalanceRemoteAddress = '127.0.0.1';

        $_SERVER['REMOTE_ADDR'] = $loadBalanceRemoteAddress;
        $_SERVER['HTTP_X_FORWARDED_FOR'] = $realRemoteAddress;

        $object = Socket::discover();

        self::assertEquals($realRemoteAddress, $object->remoteAddress());
    }

    /**
     * @test
     */
    public function given_a_socket_when_serialize_then_right_serialization()
    {
        $encrypted = false;
        $remoteAddress = '127.0.0.1';

        $object = new Socket($encrypted, $remoteAddress);

        $expected = json_encode([
            'encrypted' => $encrypted,
            'remote_address' => $remoteAddress,
        ]);

        self::assertEquals($expected, json_encode($object));
    }
}
