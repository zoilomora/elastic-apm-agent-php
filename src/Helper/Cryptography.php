<?php

namespace ZoiloMora\ElasticAPM\Helper;

final class Cryptography
{
    /**
     * @var string
     */
    private static $fakeRandomBitsInHex;

    /**
     * @param string $fakeRandomBitsInHex
     *
     * @return void
     */
    public static function fakeRandomBitsInHex($fakeRandomBitsInHex)
    {
        self::$fakeRandomBitsInHex = $fakeRandomBitsInHex;
    }

    /**
     * Generate random bits in hexadecimal representation
     *
     * @param int $bits
     *
     * @return string
     *
     * @throws \Exception
     */
    public static function generateRandomBitsInHex($bits)
    {
        if (null !== self::$fakeRandomBitsInHex) {
            return self::$fakeRandomBitsInHex;
        }

        $length = $bits / 8;
        if ($length < 1) {
            throw new \Exception('Length must be greater than 0.');
        }

        return bin2hex(
            random_bytes($length)
        );
    }
}
