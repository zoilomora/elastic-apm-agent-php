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

        self::assertEquals($active, $coreConfiguration->active());
        self::assertEquals($appName, $coreConfiguration->appName());
        self::assertEquals($appVersion, $coreConfiguration->appVersion());
        self::assertEquals($frameworkName, $coreConfiguration->frameworkName());
        self::assertEquals($frameworkVersion, $coreConfiguration->frameworkVersion());
        self::assertEquals($environment, $coreConfiguration->environment());
        self::assertEquals($stacktraceLimit, $coreConfiguration->stacktraceLimit());
        self::assertEquals($metricSet, $coreConfiguration->metricSet());
    }
}
