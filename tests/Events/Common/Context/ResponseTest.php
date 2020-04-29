<?php

namespace ZoiloMora\ElasticAPM\Tests\Events\Common\Service;

use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;
use ZoiloMora\ElasticAPM\Events\Common\Context\Response;

class ResponseTest extends TestCase
{
    /**
     * @test
     */
    public function given_no_data_when_instantiating_then_return_object()
    {
        $object = new Response();

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Events\Common\Context\Response', $object);
    }

    /**
     * @test
     */
    public function given_data_when_instantiating_then_can_get_properties()
    {
        $finished = 'finished';
        $headers = [];
        $headersSent = true;
        $statusCode = 200;

        $object = new Response(
            $finished,
            $headers,
            $headersSent,
            $statusCode
        );

        self::assertSame($finished, $object->finished());
        self::assertSame($headers, $object->headers());
        self::assertSame($headersSent, $object->headersSent());
        self::assertSame($statusCode, $object->statusCode());
    }

    /**
     * @test
     */
    public function given_a_response_when_serialize_then_right_serialization()
    {
        $finished = 'finished';
        $headers = [];
        $headersSent = true;
        $statusCode = 200;

        $object = new Response(
            $finished,
            $headers,
            $headersSent,
            $statusCode
        );

        $expected = json_encode([
            'finished' => $finished,
            'headers' => $headers,
            'headers_sent' => $headersSent,
            'status_code' => $statusCode,
        ]);

        self::assertSame($expected, json_encode($object));
    }
}
