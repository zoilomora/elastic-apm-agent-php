<?php

namespace ZoiloMora\ElasticAPM\Utils;

/**
 * Provides assertion for backward compatibility
 */
final class Assert
{
    /**
     * @param mixed $exception
     *
     * @throws \InvalidArgumentException
     */
    public static function throwable($exception)
    {
        // PHP >= 7.0
        if (true === interface_exists('\Throwable') && is_subclass_of($exception, '\Throwable')) {
            return;
        }

        // PHP < 7.0
        if ($exception instanceof \Exception) {
            return;
        }

        throw new \InvalidArgumentException('An object of type \Throwable or \Exception is required.');
    }
}
