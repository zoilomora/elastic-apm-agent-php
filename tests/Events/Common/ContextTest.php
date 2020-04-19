<?php

namespace ZoiloMora\ElasticAPM\Tests\Events\Common;

use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;
use ZoiloMora\ElasticAPM\Events\Common\Context;

class ContextTest extends TestCase
{
    /**
     * @test
     */
    public function given_no_data_when_instantiating_then_return_object()
    {
        $object = new Context();

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Events\Common\Context', $object);
    }

    /**
     * @test
     */
    public function given_no_data_when_try_to_discover_then_return_object()
    {
        $object = Context::discover();

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Events\Common\Context', $object);
    }

    /**
     * @test
     */
    public function given_data_when_instantiating_then_can_get_properties()
    {
        $custom = ['custom'];
        $responseMock = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\Common\Context\Response');
        $requestMock = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\Common\Request');
        $tagsMock = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\Common\Tags');
        $userMock = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\Common\User');
        $messageMock = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\Common\Message');

        $object = new Context(
            $custom,
            $responseMock,
            $requestMock,
            $tagsMock,
            $userMock,
            $messageMock
        );

        self::assertEquals($custom, $object->custom());
        self::assertEquals($responseMock, $object->response());
        self::assertEquals($requestMock, $object->request());
        self::assertEquals($tagsMock, $object->tags());
        self::assertEquals($userMock, $object->user());
        self::assertEquals($messageMock, $object->message());
    }

    /**
     * @test
     */
    public function given_a_context_when_serialize_then_right_serialization()
    {
        $customValue = ['custom'];
        $responseValue = '';
        $requestValue = '';
        $tagsValue = '';
        $userValue = '';
        $messageValue = '';

        $responseMock = $this->getMockSerializable(
            'ZoiloMora\ElasticAPM\Events\Common\Context\Response',
            $responseValue
        );
        $requestMock = $this->getMockSerializable('ZoiloMora\ElasticAPM\Events\Common\Request', $requestValue);
        $tagsMock = $this->getMockSerializable('ZoiloMora\ElasticAPM\Events\Common\Tags', $tagsValue);
        $userMock = $this->getMockSerializable('ZoiloMora\ElasticAPM\Events\Common\User', $userValue);
        $messageMock = $this->getMockSerializable('ZoiloMora\ElasticAPM\Events\Common\Message', $messageValue);

        $object = new Context(
            $customValue,
            $responseMock,
            $requestMock,
            $tagsMock,
            $userMock,
            $messageMock
        );

        $expected = json_encode([
            'custom' => $customValue,
            'response' => $responseValue,
            'request' => $requestValue,
            'tags' => $tagsValue,
            'user' => $userValue,
            'message' => $messageValue,
        ]);

        self::assertEquals($expected, json_encode($object));
    }
}
