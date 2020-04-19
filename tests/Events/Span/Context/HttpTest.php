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
        $method = 'POST';
        $response = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\Common\HttpResponse');

        $object = new Http($url, $method, $response);

        self::assertEquals($url, $object->url());
        self::assertEquals($method, $object->method());
        self::assertEquals($response, $object->response());
    }

    /**
     * @test
     */
    public function given_a_http_count_when_serialize_then_right_serialization()
    {
        $url = 'http://example.com/index.php';
        $method = 'POST';
        $responseValue = 'response';

        $responseMock = $this->getMockSerializable('ZoiloMora\ElasticAPM\Events\Common\HttpResponse', $responseValue);

        $object = new Http($url, $method, $responseMock);

        $expected = json_encode([
            'url' => $url,
            'method' => $method,
            'response' => $responseValue,
        ]);

        self::assertEquals($expected, json_encode($object));
    }
}
