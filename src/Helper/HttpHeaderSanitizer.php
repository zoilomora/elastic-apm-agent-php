<?php

namespace ZoiloMora\ElasticAPM\Helper;

final class HttpHeaderSanitizer
{
    /**
     * @var array Default list of keys to sanitise
     *
     * @link https://github.com/elastic/apm/blob/master/docs/agents/agent-development.md#http-transactions
     */
    private static $wildcards = [
        'password',
        'passwd',
        'pwd',
        'secret',
        '*key',
        '*token*',
        '*session*',
        '*credit*',
        '*card*',
        'authorization',
        'set-cookie',
    ];

    /**
     * @param array $headers
     *
     * @return array
     */
    public static function sanitize(array $headers)
    {
        $result = [];

        foreach ($headers as $key => $value) {
            if (false === self::headerMath($key)) {
                $result[$key] = $value;
            }
        }

        return $result;
    }

    /**
     * @param string $header
     *
     * @return bool
     */
    private static function headerMath($header)
    {
        $header = strtolower($header);

        foreach (self::$wildcards as $wildcard) {
            if (true === self::wildcardMatch($wildcard, $header)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $pattern
     * @param string $subject
     *
     * @return bool
     */
    private static function wildcardMatch($pattern, $subject)
    {
        $pattern = strtr(
            $pattern,
            [
                '*' => '.*?',
                '?' => '.',
            ]
        );

        return (bool) preg_match("/$pattern/", $subject);
    }
}
