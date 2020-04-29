<?php

namespace ZoiloMora\ElasticAPM\Tests\Helper;

use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;
use ZoiloMora\ElasticAPM\Helper\Encoding;

class EncodingTest extends TestCase
{
    /**
     * @test
     */
    public function given_short_text_when_encoded_then_returns_it_the_same()
    {
        $expected = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.';
        $actual = Encoding::keywordField($expected);

        self::assertSame($expected, $actual);
    }

    /**
     * @test
     */
    public function given_long_text_when_encoded_then_returns_it_the_same()
    {
        $data = str_repeat(
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            19
        );

        $expected = substr($data, 0, Encoding::KEYWORD_MAX_LENGTH - 1) . '…';
        $actual = Encoding::keywordField($data);

        self::assertSame($expected, $actual);
    }
}
