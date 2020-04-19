<?php

namespace ZoiloMora\ElasticAPM\Tests\Helper;

use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;
use ZoiloMora\ElasticAPM\Helper\Cryptography;

class CryptographyTest extends TestCase
{
    protected function tearDown()
    {
        parent::tearDown();

        Cryptography::fakeRandomBitsInHex(null);
    }

    /**
     * @test
     */
    public function given_less_than_one_byte_when_generate_then_throw_exception()
    {
        self::setExpectedException('Exception', 'Length must be greater than 0');

        Cryptography::generateRandomBitsInHex(7);
    }

    /**
     * @test
     */
    public function given_normal_scenario_when_generate_two_numbers_then_are_different()
    {
        $value1 = Cryptography::generateRandomBitsInHex(8);
        $value2 = Cryptography::generateRandomBitsInHex(8);

        self::assertNotEquals($value1, $value2);
    }

    /**
     * @test
     */
    public function given_fake_data_when_generate_then_return_fake_data()
    {
        $fake = 'test';
        Cryptography::fakeRandomBitsInHex($fake);

        $value = Cryptography::generateRandomBitsInHex(16);

        self::assertEquals($fake, $value);
    }
}
