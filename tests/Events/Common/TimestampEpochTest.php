<?php

namespace ZoiloMora\ElasticAPM\Tests\Events\Common;

use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;
use ZoiloMora\ElasticAPM\Events\Common\TimestampEpoch;

class TimestampEpochTest extends TestCase
{
    use TimestampEpoch;

    const EXPECTED = 1586690561;

    protected function setUp()
    {
        parent::setUp();

        $this->timestamp = self::EXPECTED;
    }

    /**
     * @test
     */
    public function given_timestamp_when_assigned_then_can_get_property()
    {
        self::assertSame(self::EXPECTED, $this->timestamp());
    }

    /**
     * @test
     */
    public function given_not_data_when_generate_timestamp_then_return_timestamp_valid()
    {
        $timestamp = $this->generateTimestamp();

        self::assertSame('integer', gettype($timestamp));
    }
}
