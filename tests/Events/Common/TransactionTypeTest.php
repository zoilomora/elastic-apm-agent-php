<?php

namespace ZoiloMora\ElasticAPM\Tests\Events\Common;

use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;
use ZoiloMora\ElasticAPM\Events\Common\TransactionType;

class TransactionTypeTest extends TestCase
{
    use TransactionType;

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
        self::assertEquals(self::EXPECTED, $this->type());
    }

    /**
     * @test
     */
    public function given_type_when_assigned_then_can_get_encoding_property()
    {
        self::assertEquals(self::EXPECTED, $this->getEncodingType());
    }
}
