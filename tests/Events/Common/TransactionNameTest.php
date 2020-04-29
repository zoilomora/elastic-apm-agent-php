<?php

namespace ZoiloMora\ElasticAPM\Tests\Events\Common;

use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;
use ZoiloMora\ElasticAPM\Events\Common\TransactionName;

class TransactionNameTest extends TestCase
{
    use TransactionName;

    const EXPECTED = 'test';

    protected function setUp()
    {
        parent::setUp();

        $this->name = self::EXPECTED;
    }

    /**
     * @test
     */
    public function given_name_when_assigned_then_can_get_property()
    {
        self::assertSame(self::EXPECTED, $this->name());
    }

    /**
     * @test
     */
    public function given_name_when_assigned_then_can_get_encoding_property()
    {
        self::assertSame(self::EXPECTED, $this->getEncodingName());
    }
}
