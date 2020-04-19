<?php

namespace ZoiloMora\ElasticAPM\Events\Metadata;

use ZoiloMora\ElasticAPM\Configuration\CoreConfiguration;
use ZoiloMora\ElasticAPM\Events\Common\Service as ServiceBase;
use ZoiloMora\ElasticAPM\Events\Common\Service\Framework;
use ZoiloMora\ElasticAPM\Events\Common\Service\Language;
use ZoiloMora\ElasticAPM\Events\Common\Service\Node;
use ZoiloMora\ElasticAPM\Events\Common\Service\Runtime;

final class Service extends ServiceBase
{
    /**
     * @param string $name
     * @param Language $language
     * @param Runtime $runtime
     * @param Framework|null $framework
     * @param string|null $environment
     * @param string|null $version
     * @param Node|null $node
     */
    public function __construct(
        $name,
        Language $language,
        Runtime $runtime,
        Framework $framework = null,
        $environment = null,
        $version = null,
        Node $node = null
    ) {
        parent::__construct(null, $framework, $language, $name, $environment, $runtime, $version, $node);

        $this->assertLanguage();
        $this->assertRuntime();
    }

    /**
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    private function assertLanguage()
    {
        if (null === $this->language()->name()) {
            throw new \InvalidArgumentException('The [name] of the language is mandatory in the service.');
        }
    }

    /**
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    private function assertRuntime()
    {
        if (null === $this->runtime()->name()) {
            throw new \InvalidArgumentException('The [name] of the runtime is mandatory in the service.');
        }

        if (null === $this->runtime()->version()) {
            throw new \InvalidArgumentException('The [version] of the runtime is mandatory in the service.');
        }
    }

    /**
     * @param CoreConfiguration $coreConfiguration
     *
     * @return Service
     */
    public static function create(CoreConfiguration $coreConfiguration)
    {
        return new self(
            $coreConfiguration->appName(),
            Language::discover(),
            Runtime::discover(),
            Framework::create($coreConfiguration),
            $coreConfiguration->environment(),
            $coreConfiguration->appVersion()
        );
    }
}
