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
        $headersSent = 'headersSent';

        $object = new Response(
            null,
            null,
            null,
            null,
            null,
            $finished,
            $headersSent
        );

        self::assertEquals($finished, $object->finished());
        self::assertEquals($headersSent, $object->headersSent());
    }

    /**
     * @test
     */
    public function given_a_response_when_serialize_then_right_serialization()
    {
        $finished = 'finished';
        $headersSent = 'headersSent';

        $object = new Response(
            null,
            null,
            null,
            null,
            null,
            $finished,
            $headersSent
        );

        $actual = json_decode(
            json_encode($object),
            true
        );

        self::assertArrayHasKey('finished', $actual);
        self::assertArrayHasKey('headers_sent', $actual);

        self::assertEquals($finished, $actual['finished']);
        self::assertEquals($headersSent, $actual['headers_sent']);
    }
}
