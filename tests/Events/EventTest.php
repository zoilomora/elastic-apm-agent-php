<?php

namespace ZoiloMora\ElasticAPM\Tests\Events;

use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;
use ZoiloMora\ElasticAPM\Helper\Cryptography;

class EventTest extends TestCase
{
    protected function tearDown()
    {
        parent::tearDown();

        Cryptography::fakeRandomBitsInHex(null);
    }

    /**
     * @test
     */
    public function given_a_event_when_get_the_id_then_generated_correctly()
    {
        $fakeId = Cryptography::generateRandomBitsInHex(8);
        Cryptography::fakeRandomBitsInHex($fakeId);

        $object = self::getMockForAbstractClass('ZoiloMora\ElasticAPM\Events\Event');

        self::assertSame($fakeId, $object->id());
    }

    /**
     * @test
     */
    public function given_a_event_when_serialize_then_right_serialization()
    {
        $fakeId = Cryptography::generateRandomBitsInHex(8);
        Cryptography::fakeRandomBitsInHex($fakeId);

        $object = self::getMockForAbstractClass('ZoiloMora\ElasticAPM\Events\Event');

        $expected = json_encode([
            'id' => $fakeId,
        ]);

        self::assertSame($expected, json_encode($object));
    }
}
