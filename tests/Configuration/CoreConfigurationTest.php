<?php

namespace ZoiloMora\ElasticAPM\Tests\Configuration;

use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;
use ZoiloMora\ElasticAPM\Configuration\CoreConfiguration;

class CoreConfigurationTest extends TestCase
{
    /**
     * @test
     */
    public function given_a_correct_configuration_array_when_instantiated_then_ok()
    {
        $coreConfiguration = CoreConfiguration::create([
            'appName' => 'Test',
        ]);

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Configuration\CoreConfiguration', $coreConfiguration);
    }

    /**
     * @test
     */
    public function given_a_empty_configuration_array_when_instantiated_then_fails()
    {
        self::setExpectedException('InvalidArgumentException', 'Missing appName value');

        CoreConfiguration::create([]);
    }

    /**
     * @test
     */
    public function given_a_instance_created_when_get_the_properties_then_the_types_is_correct()
    {
        $active = false;
        $appName = 'TestV1';
        $appVersion = '1.0';
        $frameworkName = 'Symfony';
        $frameworkVersion = '4.4';
        $environment = 'prod';
        $stacktraceLimit = 2;
        $metricSet = false;

        $coreConfiguration = CoreConfiguration::create([
            'active' => $active,
            'appName' => $appName,
            'appVersion' => $appVersion,
            'frameworkName' => $frameworkName,
            'frameworkVersion' => $frameworkVersion,
            'environment' => $environment,
            'stacktraceLimit' => $stacktraceLimit,
            'metricSet' => $metricSet,
        ]);

        self::assertSame($active, $coreConfiguration->active());
        self::assertSame($appName, $coreConfiguration->appName());
        self::assertSame($appVersion, $coreConfiguration->appVersion());
        self::assertSame($frameworkName, $coreConfiguration->frameworkName());
        self::assertSame($frameworkVersion, $coreConfiguration->frameworkVersion());
        self::assertSame($environment, $coreConfiguration->environment());
        self::assertSame($stacktraceLimit, $coreConfiguration->stacktraceLimit());
        self::assertSame($metricSet, $coreConfiguration->metricSet());
    }
}
