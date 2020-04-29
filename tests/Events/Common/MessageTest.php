<?php

namespace ZoiloMora\ElasticAPM\Tests\Events\Common;

use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;
use ZoiloMora\ElasticAPM\Events\Common\Message;

class MessageTest extends TestCase
{
    /**
     * @test
     */
    public function given_data_when_instantiating_then_can_get_properties()
    {
        $queueMock = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\Common\Message\Queue');
        $ageMock = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\Common\Message\Age');
        $body = 'body';
        $headers = [
            'key' => 'value'
        ];

        $object = new Message(
            $queueMock,
            $ageMock,
            $body,
            $headers
        );

        self::assertSame($queueMock, $object->queue());
        self::assertSame($ageMock, $object->age());
        self::assertSame($body, $object->body());
        self::assertSame($headers, $object->headers());
    }

    /**
     * @test
     */
    public function given_a_message_when_serialize_then_right_serialization()
    {
        $queueValue = 'queue';
        $ageValue = 'age';
        $body = 'body';
        $headers = [
            'key' => 'value'
        ];

        $queueMock = $this->getMockSerializable('ZoiloMora\ElasticAPM\Events\Common\Message\Queue', $queueValue);
        $ageMock = $this->getMockSerializable('ZoiloMora\ElasticAPM\Events\Common\Message\Age', $ageValue);

        $object = new Message(
            $queueMock,
            $ageMock,
            $body,
            $headers
        );

        $expected = json_encode([
            'queue' => $queueValue,
            'age' => $ageValue,
            'body' => $body,
            'headers' => $headers,
        ]);

        self::assertSame($expected, json_encode($object));
    }
}
