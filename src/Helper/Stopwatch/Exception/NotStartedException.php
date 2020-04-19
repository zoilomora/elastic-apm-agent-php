<?php

namespace ZoiloMora\ElasticAPM\Helper\Stopwatch\Exception;

final class NotStartedException extends \Exception
{
    /**
     * @return NotStartedException
     */
    public static function create()
    {
        return new self('Cannot stop a stopwatch that did not start.');
    }
}
