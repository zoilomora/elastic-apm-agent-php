<?php

namespace ZoiloMora\ElasticAPM\Helper;

final class Encoding
{
    /**
     * The maximum number of characters that are accepted in a keyword field.
     */
    const KEYWORD_MAX_LENGTH = 1024;

    /**
     * Limit the size of keyword fields.
     *
     * @param int|string|null $value
     *
     * @return string
     */
    public static function keywordField($value)
    {
        if (strlen($value) <= self::KEYWORD_MAX_LENGTH) {
            return $value;
        }

        $value = mb_substr(
            $value,
            0,
            self::KEYWORD_MAX_LENGTH - 1,
            'UTF-8'
        );

        return $value . '…';
    }
}
