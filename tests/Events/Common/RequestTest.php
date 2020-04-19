<?php

namespace ZoiloMora\ElasticAPM\Tests\Events\Common;

use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;
use ZoiloMora\ElasticAPM\Events\Common\Request;

class RequestTest extends TestCase
{
    const HEADER = 'REQUEST_METHOD';

    protected function tearDown()
    {
        parent::tearDown();

        unset($_SERVER['REQUEST_METHOD']);
        unset($_SERVER['HTTP_USER_AGENT']);
        unset($_SERVER['SERVER_PROTOCOL']);
    }

    /**
     * @test
     */
    public function given_no_data_when_instantiating_then_return_object()
    {
        $url = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\Common\Request\Url');

        $object = new Request('POST', $url);

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Events\Common\Request', $object);
    }

    /**
     * @test
     */
    public function given_cli_environment_when_try_to_discover_then_return_null()
    {
        self::assertNull(
            Request::discover()
        );
    }

    /**
     * @test
     */
    public function given_web_environment_when_try_to_discover_then_return_object()
    {
        $_SERVER[self::HEADER] = 'POST';

        $object = Request::discover();

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Events\Common\Request', $object);
    }

    /**
     * @test
     */
    public function given_web_environment_with_http_headers_when_try_to_discover_then_return_object()
    {
        $method = 'POST';
        $userAgent = 'test';

        $_SERVER['REQUEST_METHOD'] = $method;
        $_SERVER['HTTP_USER_AGENT'] = $userAgent;

        $object = Request::discover();

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Events\Common\Request', $object);
        self::assertEquals(['User-Agent' => $userAgent], $object->headers());
    }

    /**
     * @test
     */
    public function given_web_environment_with_server_protocol_when_try_to_discover_then_return_object()
    {
        $method = 'POST';
        $serverProtocol = '1.0';

        $_SERVER['REQUEST_METHOD'] = $method;
        $_SERVER['SERVER_PROTOCOL'] = 'HTTP/' . $serverProtocol;

        $object = Request::discover();

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Events\Common\Request', $object);
        self::assertEquals($serverProtocol, $object->httpVersion());
    }

    /**
     * @test
     */
    public function given_data_when_instantiating_then_can_get_properties()
    {
        $method = 'POST';
        $url = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\Common\Request\Url');
        $body = 'body';
        $env = 'prod';
        $headers = ['headers'];
        $httpVersion = '1.1';
        $socket = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\Common\Request\Socket');
        $cookies = ['cookies'];

        $object = new Request(
            $method,
            $url,
            $body,
            $env,
            $headers,
            $httpVersion,
            $socket,
            $cookies
        );

        self::assertEquals($method, $object->method());
        self::assertEquals($url, $object->url());
        self::assertEquals($body, $object->body());
        self::assertEquals($env, $object->env());
        self::assertEquals($headers, $object->headers());
        self::assertEquals($httpVersion, $object->httpVersion());
        self::assertEquals($socket, $object->socket());
        self::assertEquals($cookies, $object->cookies());
    }

    /**
     * @test
     */
    public function given_a_request_when_serialize_then_right_serialization()
    {
        $urlValue = 'url';
        $socketValue = 'socket';

        $method = 'POST';
        $urlMock = $this->getMockSerializable('ZoiloMora\ElasticAPM\Events\Common\Request\Url', $urlValue);
        $body = 'body';
        $env = 'prod';
        $headers = ['headers'];
        $httpVersion = '1.1';
        $socketMock = $this->getMockSerializable('ZoiloMora\ElasticAPM\Events\Common\Request\Socket', $socketValue);
        $cookies = ['cookies'];

        $object = new Request(
            $method,
            $urlMock,
            $body,
            $env,
            $headers,
            $httpVersion,
            $socketMock,
            $cookies
        );

        $expected = json_encode([
            'body' => $body,
            'env' => $env,
            'headers' => $headers,
            'http_version' => $httpVersion,
            'method' => $method,
            'socket' => $socketValue,
            'url' => $urlValue,
            'cookies' => $cookies,
        ]);

        self::assertEquals($expected, json_encode($object));
    }
}
