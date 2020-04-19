<?php

namespace ZoiloMora\ElasticAPM\Tests\Events\Common;

use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;
use ZoiloMora\ElasticAPM\Events\Common\HttpResponse;

class HttpResponseTest extends TestCase
{
    /**
     * @test
     */
    public function given_no_data_when_instantiating_then_return_object()
    {
        $object = new HttpResponse();

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Events\Common\HttpResponse', $object);
    }

    /**
     * @test
     */
    public function given_data_when_instantiating_then_can_get_properties()
    {
        $statusCode = 200;
        $transferSize = 16;
        $encodedBodySize = 8;
        $decodedBodySize = 16;
        $headers = [
            'key' => 'value',
        ];

        $object = new HttpResponse(
            $statusCode,
            $transferSize,
            $encodedBodySize,
            $decodedBodySize,
            $headers
        );

        self::assertEquals($statusCode, $object->statusCode());
        self::assertEquals($transferSize, $object->transferSize());
        self::assertEquals($encodedBodySize, $object->encodedBodySize());
        self::assertEquals($decodedBodySize, $object->decodedBodySize());
        self::assertEquals($headers, $object->headers());
    }

    /**
     * @test
     */
    public function given_a_http_response_when_serialize_then_right_serialization()
    {
        $statusCode = 200;
        $transferSize = 16;
        $encodedBodySize = 8;
        $decodedBodySize = 16;
        $headers = [
            'key' => 'value',
        ];

        $object = new HttpResponse(
            $statusCode,
            $transferSize,
            $encodedBodySize,
            $decodedBodySize,
            $headers
        );

        $expected = json_encode([
            'status_code' => $statusCode,
            'transfer_size' => $transferSize,
            'encoded_body_size' => $encodedBodySize,
            'decoded_body_size' => $decodedBodySize,
            'headers' => $headers,
        ]);

        self::assertEquals($expected, json_encode($object));
    }
}
