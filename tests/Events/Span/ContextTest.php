<?php

namespace ZoiloMora\ElasticAPM\Tests\Events\Span;

use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;
use ZoiloMora\ElasticAPM\Events\Span\Context;

class ContextTest extends TestCase
{
    /**
     * @test
     */
    public function given_data_when_instantiating_then_return_can_get_properties()
    {
        $destination = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\Span\Context\Destination');
        $db = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\Span\Context\Db');
        $http = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\Span\Context\Http');
        $tags = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\Common\Tags');
        $message = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\Common\Message');

        $object = new Context(
            $destination,
            $db,
            $http,
            $tags,
            $message
        );

        self::assertSame($destination, $object->destination());
        self::assertSame($db, $object->db());
        self::assertSame($http, $object->http());
        self::assertSame($tags, $object->tags());
        self::assertSame($message, $object->message());
    }

    /**
     * @test
     */
    public function given_db_when_instantiating_then_return_object()
    {
        $db = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\Span\Context\Db');

        $object = Context::fromDb($db);

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Events\Span\Context', $object);
    }

    /**
     * @test
     */
    public function given_http_when_instantiating_then_return_object()
    {
        $http = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\Span\Context\Http');

        $object = Context::fromHttp($http);

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Events\Span\Context', $object);
    }

    /**
     * @test
     */
    public function given_message_when_instantiating_then_return_object()
    {
        $message = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\Common\Message');

        $object = Context::fromMessage($message);

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Events\Span\Context', $object);
    }

    /**
     * @test
     */
    public function given_a_context_when_serialize_then_right_serialization()
    {
        $destinationValue = 'destination';
        $dbValue = 'db';
        $httpValue = 'http';
        $tagsValue = 'tags';
        $messageValue = 'message';

        $destinationMock = $this->getMockSerializable(
            'ZoiloMora\ElasticAPM\Events\Span\Context\Destination',
            $destinationValue
        );
        $dbMock = $this->getMockSerializable('ZoiloMora\ElasticAPM\Events\Span\Context\Db', $dbValue);
        $httpMock = $this->getMockSerializable('ZoiloMora\ElasticAPM\Events\Span\Context\Http', $httpValue);
        $tagsMock = $this->getMockSerializable('ZoiloMora\ElasticAPM\Events\Common\Tags', $tagsValue);
        $messageMock = $this->getMockSerializable('ZoiloMora\ElasticAPM\Events\Common\Message', $messageValue);

        $object = new Context(
            $destinationMock,
            $dbMock,
            $httpMock,
            $tagsMock,
            $messageMock
        );

        $expected = json_encode([
            'destination' => $destinationValue,
            'db' => $dbValue,
            'http' => $httpValue,
            'tags' => $tagsValue,
            'message' => $messageValue,
        ]);

        self::assertSame($expected, json_encode($object));
    }
}
