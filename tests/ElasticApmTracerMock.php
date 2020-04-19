<?php

namespace ZoiloMora\ElasticAPM\Tests;

final class ElasticApmTracerMock
{
    public static function cleanup()
    {
        $ref = new \ReflectionProperty('ZoiloMora\ElasticAPM\ElasticApmTracer', 'instance');
        $ref->setAccessible(true);
        $ref->setValue(null, null);
    }
}
