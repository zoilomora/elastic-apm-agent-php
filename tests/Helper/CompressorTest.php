<?php

namespace ZoiloMora\ElasticAPM\Tests\Helper;

use ZoiloMora\ElasticAPM\Helper\Compressor;
use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;

class CompressorTest extends TestCase
{
    /**
     * @test
     */
    public function given_invalid_data_when_compress_then_throw_exception()
    {
        self::setExpectedException(
            'Exception',
            'Data is not valid. It must be of type string and contain at least one character.'
        );

        Compressor::gzip(null);
    }

    /**
     * @test
     */
    public function given_valid_data_when_compress_then_return_compressed_data()
    {
        $data = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc tempor.';
        $expected = hex2bin(
            '1f8b080000000000000305c18b09c0300805c055de00259384ee108c142146f1b37fefa6052bc4b315db8e05520a4bb91e90dd642'
            . 'aae0eac2d2e49723ff0911a78fb128ad52dc60fdb289d9d45000000'
        );

        $compressedData = Compressor::gzip($data);

        self::assertEquals($expected, $compressedData);
    }
}
