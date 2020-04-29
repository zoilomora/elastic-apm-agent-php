<?php

namespace ZoiloMora\ElasticAPM\Tests\Events\Common;

use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;
use ZoiloMora\ElasticAPM\Events\Common\SpanType;

class SpanTypeTest extends TestCase
{
    use SpanType;

    const EXPECTED = 'test';

    protected function setUp()
    {
        parent::setUp();

        $this->type = self::EXPECTED;
    }

    /**
     * @test
     */
    public function given_type_when_assigned_then_can_get_property()
    {
        self::assertSame(self::EXPECTED, $this->type());
    }

    /**
     * @test
     */
    public function given_type_when_assigned_then_can_get_encoding_property()
    {
        self::assertSame(self::EXPECTED, $this->getEncodingType());
    }
}
