<?php

namespace ZoiloMora\ElasticAPM\Helper\Stopwatch\Exception;

final class AlreadyRunningException extends \Exception
{
    /**
     * @return AlreadyRunningException
     */
    public static function create()
    {
        return new self('Cannot start a stopwatch that is already running.');
    }
}
