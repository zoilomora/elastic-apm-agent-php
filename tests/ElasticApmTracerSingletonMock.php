<?php

namespace ZoiloMora\ElasticAPM\Tests;

final class ElasticApmTracerSingletonMock
{
    public static function cleanup()
    {
        $ref = new \ReflectionProperty('ZoiloMora\ElasticAPM\ElasticApmTracerSingleton', 'instance');
        $ref->setAccessible(true);
        $ref->setValue(null, null);
    }
}
