<?php

namespace ZoiloMora\ElasticAPM\Helper;

final class Compressor
{
    /**
     * @param mixed $data
     *
     * @return string
     *
     * @throws \Exception
     */
    public static function gzip($data)
    {
        self::assert($data);

        return gzencode($data, -1, FORCE_GZIP);
    }

    /**
     * @param mixed $data
     *
     * @throws \Exception
     */
    private static function assert($data)
    {
        if (true === is_string($data) && 0 !== strlen($data)) {
            return;
        }

        throw new \Exception('Data is not valid. It must be of type string and contain at least one character.');
    }
}
