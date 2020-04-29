<?php

namespace ZoiloMora\ElasticAPM\Tests\Helper;

use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;
use ZoiloMora\ElasticAPM\Helper\NDJson;

class NDJsonTest extends TestCase
{
    /**
     * @test
     */
    public function given_a_context_when_get_content_type_then_return_ok()
    {
        self::assertSame('application/x-ndjson', NDJson::contentType());
    }

    /**
     * @test
     */
    public function given_array_data_when_convert_to_ndjson_then_correct_format_is_returned()
    {
        $data = [
            [
                'value' => 1,
            ],
            [
                'value' => 2,
            ],
        ];

        $expected = '{"value":1}' . PHP_EOL . '{"value":2}' . PHP_EOL;
        $actual = NDJson::convert($data);

        self::assertSame($expected, $actual);
    }
}
