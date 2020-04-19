<?php

namespace ZoiloMora\ElasticAPM\Tests\Events\Metadata;

use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;
use ZoiloMora\ElasticAPM\Events\Metadata\Service;

class ServiceTest extends TestCase
{
    /**
     * @test
     */
    public function given_data_when_instantiating_then_return_object()
    {
        $language = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\Common\Service\Language');
        $language
            ->expects(self::once())
            ->method('name')
            ->willReturn('php')
        ;

        $runtime = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\Common\Service\Runtime');
        $runtime
            ->expects(self::once())
            ->method('name')
            ->willReturn('php')
        ;
        $runtime
            ->expects(self::once())
            ->method('version')
            ->willReturn('1')
        ;

        $object = new Service(
            'app',
            $language,
            $runtime
        );

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Events\Metadata\Service', $object);
    }

    /**
     * @test
     */
    public function given_no_language_name_when_instantiating_then_return_object()
    {
        $language = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\Common\Service\Language');
        $runtime = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\Common\Service\Runtime');

        self::setExpectedException(
            'InvalidArgumentException',
            'The [name] of the language is mandatory in the service.'
        );

        new Service(
            'app',
            $language,
            $runtime
        );
    }

    /**
     * @test
     */
    public function given_no_runtime_name_when_instantiating_then_return_object()
    {
        $language = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\Common\Service\Language');
        $language
            ->expects(self::once())
            ->method('name')
            ->willReturn('php')
        ;

        $runtime = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\Common\Service\Runtime');

        self::setExpectedException(
            'InvalidArgumentException',
            'The [name] of the runtime is mandatory in the service.'
        );

        new Service(
            'app',
            $language,
            $runtime
        );
    }

    /**
     * @test
     */
    public function given_no_runtime_version_when_instantiating_then_return_object()
    {
        $language = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\Common\Service\Language');
        $language
            ->expects(self::once())
            ->method('name')
            ->willReturn('php')
        ;

        $runtime = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\Common\Service\Runtime');
        $runtime
            ->expects(self::once())
            ->method('name')
            ->willReturn('php')
        ;

        self::setExpectedException(
            'InvalidArgumentException',
            'The [version] of the runtime is mandatory in the service.'
        );

        new Service(
            'app',
            $language,
            $runtime
        );
    }
}
