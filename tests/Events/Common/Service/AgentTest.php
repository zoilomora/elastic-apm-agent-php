<?php

namespace ZoiloMora\ElasticAPM\Tests\Events\Common\Service;

use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;
use ZoiloMora\ElasticAPM\Events\Common\Service\Agent;

class AgentTest extends TestCase
{
    /**
     * @test
     */
    public function given_no_data_when_try_to_discover_then_return_object()
    {
        $object = Agent::discover();

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Events\Common\Service\Agent', $object);
    }

    /**
     * @test
     */
    public function given_data_when_instantiating_then_can_get_properties()
    {
        $object = Agent::discover();

        self::assertEquals(Agent::NAME, $object->name());
        self::assertEquals(Agent::VERSION, $object->version());
        self::assertNull($object->ephemeralId());
    }

    /**
     * @test
     */
    public function given_a_agent_when_serialize_then_right_serialization()
    {
        $object = Agent::discover();

        $expected = json_encode([
            'name' => Agent::NAME,
            'version' => Agent::VERSION,
            'ephemeral_id' => null,
        ]);

        self::assertEquals($expected, json_encode($object));
    }
}
