<?php

namespace ZoiloMora\ElasticAPM\Tests\Events\Span\Context;

use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;
use ZoiloMora\ElasticAPM\Events\Span\Context\Http;

class HttpTest extends TestCase
{
    /**
     * @test
     */
    public function given_no_data_when_instantiating_then_return_object()
    {
        $object = new Http();

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Events\Span\Context\Http', $object);
    }

    /**
     * @test
     */
    public function given_data_when_instantiating_then_return_can_get_properties()
    {
        $url = 'http://example.com/index.php';
        $statusCode = 200;
        $method = 'POST';

        $object = new Http($url, $statusCode, $method);

        self::assertEquals($url, $object->url());
        self::assertEquals($statusCode, $object->statusCode());
        self::assertEquals($method, $object->method());
    }

    /**
     * @test
     */
    public function given_a_http_count_when_serialize_then_right_serialization()
    {
        $url = 'http://example.com/index.php';
        $statusCode = 200;
        $method = 'POST';

        $object = new Http($url, $statusCode, $method);

        $expected = json_encode([
            'url' => $url,
            'status_code' => $statusCode,
            'method' => $method,
        ]);

        self::assertEquals($expected, json_encode($object));
    }
}
