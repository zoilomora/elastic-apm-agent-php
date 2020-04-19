<?php

namespace ZoiloMora\ElasticAPM\Helper\Stopwatch\Exception;

final class NotStoppedException extends \Exception
{
    /**
     * @return NotStoppedException
     */
    public static function create()
    {
        return new self('Unable to get the duration of a running stopwatch.');
    }
}
