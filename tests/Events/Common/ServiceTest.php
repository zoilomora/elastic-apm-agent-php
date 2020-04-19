<?php

namespace ZoiloMora\ElasticAPM\Tests\Events\Common;

use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;
use ZoiloMora\ElasticAPM\Events\Common\Service;

class ServiceTest extends TestCase
{
    /**
     * @test
     */
    public function given_no_data_when_instantiating_then_return_object()
    {
        $object = new Service();

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Events\Common\Service', $object);
    }

    /**
     * @test
     */
    public function given_data_when_instantiating_then_can_get_properties()
    {
        $agent = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\Common\Service\Agent');
        $framework = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\Common\Service\Framework');
        $language = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\Common\Service\Language');
        $name = 'name';
        $environment = 'environment';
        $runtime = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\Common\Service\Runtime');
        $version = 'version';
        $node = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\Common\Service\Node');

        $object = new Service(
            $agent,
            $framework,
            $language,
            $name,
            $environment,
            $runtime,
            $version,
            $node
        );

        self::assertEquals($agent, $object->agent());
        self::assertEquals($framework, $object->framework());
        self::assertEquals($language, $object->language());
        self::assertEquals($name, $object->name());
        self::assertEquals($environment, $object->environment());
        self::assertEquals($runtime, $object->runtime());
        self::assertEquals($version, $object->version());
        self::assertEquals($node, $object->node());
    }

    /**
     * @test
     */
    public function given_a_service_when_serialize_then_right_serialization()
    {
        $agentValue = 'agent';
        $frameworkValue = 'framework';
        $languageValue = 'language';
        $name = 'name';
        $environment = 'environment';
        $runtimeValue = 'runtime';
        $version = 'version';
        $nodeValue = 'node';

        $agentMock = $this->getMockSerializable(
            'ZoiloMora\ElasticAPM\Events\Common\Service\Agent',
            $agentValue
        );
        $frameworkMock = $this->getMockSerializable(
            'ZoiloMora\ElasticAPM\Events\Common\Service\Framework',
            $frameworkValue
        );
        $languageMock = $this->getMockSerializable(
            'ZoiloMora\ElasticAPM\Events\Common\Service\Language',
            $languageValue
        );
        $runtimeMock = $this->getMockSerializable(
            'ZoiloMora\ElasticAPM\Events\Common\Service\Runtime',
            $runtimeValue
        );
        $nodeMock = $this->getMockSerializable(
            'ZoiloMora\ElasticAPM\Events\Common\Service\Node',
            $nodeValue
        );

        $object = new Service(
            $agentMock,
            $frameworkMock,
            $languageMock,
            $name,
            $environment,
            $runtimeMock,
            $version,
            $nodeMock
        );

        $expected = json_encode([
            'agent' => $agentValue,
            'framework' => $frameworkValue,
            'language' => $languageValue,
            'name' => $name,
            'environment' => $environment,
            'runtime' => $runtimeValue,
            'version' => $version,
            'node' => $nodeValue,
        ]);

        self::assertEquals($expected, json_encode($object));
    }
}
