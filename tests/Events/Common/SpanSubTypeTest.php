<?php

namespace ZoiloMora\ElasticAPM\Tests\Events\Common;

use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;
use ZoiloMora\ElasticAPM\Events\Common\SpanSubtype;

class SpanSubTypeTest extends TestCase
{
    use SpanSubtype;

    const EXPECTED = 'test';

    protected function setUp()
    {
        parent::setUp();

        $this->subtype = self::EXPECTED;
    }

    /**
     * @test
     */
    public function given_subtype_when_assigned_then_can_get_property()
    {
        self::assertSame(self::EXPECTED, $this->subtype());
    }

    /**
     * @test
     */
    public function given_subtype_when_assigned_then_can_get_encoding_property()
    {
        self::assertSame(self::EXPECTED, $this->getEncodingSubtype());
    }
}
