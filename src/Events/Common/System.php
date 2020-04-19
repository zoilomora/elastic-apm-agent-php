<?php

namespace ZoiloMora\ElasticAPM\Events\Common;

use ZoiloMora\ElasticAPM\Events\Common\System\Container;
use ZoiloMora\ElasticAPM\Events\Common\System\Kubernetes;
use ZoiloMora\ElasticAPM\Helper\Encoding;

class System implements \JsonSerializable
{
    /**
     * Architecture of the system the agent is running on.
     *
     * @var string|null
     */
    private $architecture;

    /**
     * Hostname of the host the monitored service is running on.
     * It normally contains what the hostname command returns on the host machine.
     * Will be ignored if kubernetes information is set, otherwise should always be set.
     *
     * @var string|null
     */
    private $detectedHostname;

    /**
     * Name of the host the monitored service is running on.
     * It should only be set when configured by the user.
     * If empty, will be set to detected_hostname or derived from kubernetes information if provided.
     *
     * @var string|null
     */
    private $configuredHostname;

    /**
     * Name of the system platform the agent is running on.
     *
     * @var string|null
     */
    private $platform;

    /**
     * @var Container|null
     */
    private $container;

    /**
     * @var Kubernetes|null
     */
    private $kubernetes;

    /**
     * @param string|null $architecture
     * @param string|null $detectedHostname
     * @param string|null $configuredHostname
     * @param string|null $platform
     * @param Container|null $container
     * @param Kubernetes|null $kubernetes
     */
    public function __construct(
        $architecture = null,
        $detectedHostname = null,
        $configuredHostname = null,
        $platform = null,
        Container $container = null,
        Kubernetes $kubernetes = null
    ) {
        $this->architecture = $architecture;
        $this->detectedHostname = $detectedHostname;
        $this->configuredHostname = $configuredHostname;
        $this->platform = $platform;
        $this->container = $container;
        $this->kubernetes = $kubernetes;
    }

    /**
     * @return string|null
     */
    public function architecture()
    {
        return $this->architecture;
    }

    /**
     * @return string|null
     */
    public function detectedHostname()
    {
        return $this->detectedHostname;
    }

    /**
     * @return string|null
     */
    public function configuredHostname()
    {
        return $this->configuredHostname;
    }

    /**
     * @return string|null
     */
    public function platform()
    {
        return $this->platform;
    }

    /**
     * @return Container|null
     */
    public function container()
    {
        return $this->container;
    }

    /**
     * @return Kubernetes|null
     */
    public function kubernetes()
    {
        return $this->kubernetes;
    }

    /**
     * @return System
     */
    public static function discover()
    {
        return new self(
            php_uname('m'),
            php_uname('n'),
            null,
            php_uname('s'),
            Container::discover(),
            Kubernetes::discover()
        );
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'architecture' => Encoding::keywordField($this->architecture),
            'detected_hostname' => Encoding::keywordField($this->detectedHostname),
            'configured_hostname' => Encoding::keywordField($this->configuredHostname),
            'platform' => Encoding::keywordField($this->platform),
            'container' => $this->container,
            'kubernetes' => $this->kubernetes,
        ];
    }
}
