<?php

namespace ZoiloMora\ElasticAPM;

final class ElasticApmTracerSingleton
{
    /**
     * @var ElasticApmTracer
     */
    private static $instance = null;

    /**
     * @param ElasticApmTracer $instance
     *
     * @throws \Exception
     */
    public static function inject(ElasticApmTracer $instance)
    {
        if (null !== self::$instance) {
            throw new \Exception('Already an injected object, it cannot be replaced.');
        }

        self::$instance = $instance;
    }

    /**
     * @return ElasticApmTracer
     *
     * @throws \Exception
     */
    public static function instance()
    {
        if (null === self::$instance) {
            throw new \Exception('The instance has not yet been injected.');
        }

        return self::$instance;
    }
}
