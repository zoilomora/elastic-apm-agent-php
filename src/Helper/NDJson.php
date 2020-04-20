<?php

namespace ZoiloMora\ElasticAPM\Helper;

final class NDJson
{
    /**
     * @return string
     */
    public static function contentType()
    {
        return 'application/x-ndjson';
    }

    /**
     * @param array $events
     * @return string
     */
    public static function convert(array $events)
    {
        return array_reduce(
            $events,
            static function($carry, $item) {
                $carry .= json_encode($item) . PHP_EOL;

                return $carry;
            }
        );
    }
}
