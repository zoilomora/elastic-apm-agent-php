<?php

namespace ZoiloMora\ElasticAPM\Configuration;

final class CoreConfiguration
{
    /**
     * @var bool
     */
    private $active;

    /**
     * @var string
     */
    private $appName;

    /**
     * @var string
     */
    private $appVersion;

    /**
     * @var string
     */
    private $frameworkName;

    /**
     * @var string
     */
    private $frameworkVersion;

    /**
     * @var string
     */
    private $environment;

    /**
     * @var int
     */
    private $stacktraceLimit;

    /**
     * @var bool
     */
    private $metricSet;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        if (false === array_key_exists('appName', $config)) {
            throw new \InvalidArgumentException('Missing appName value');
        }

        $config = array_merge(
            $this->getDefaultConfig(),
            $config
        );

        $this->active = (bool) $config['active'];
        $this->appName = (string) $config['appName'];
        $this->appVersion = (string) $config['appVersion'];
        $this->frameworkName = (string) $config['frameworkName'];
        $this->frameworkVersion = (string) $config['frameworkVersion'];
        $this->environment = (string) $config['environment'];
        $this->stacktraceLimit = (int) $config['stacktraceLimit'];
        $this->metricSet = (bool) $config['metricSet'];
    }

    /**
     * @param array $config
     *
     * @return CoreConfiguration
     */
    public static function create(array $config)
    {
        return new self($config);
    }

    /**
     * @return array
     */
    private function getDefaultConfig()
    {
        return [
            'active' => true,
            'appVersion' => '',
            'frameworkName' => null,
            'frameworkVersion' => null,
            'environment' => 'dev',
            'stacktraceLimit' => 0,
            'metricSet' => true,
        ];
    }

    /**
     * @return bool
     */
    public function active()
    {
        return $this->active;
    }

    /**
     * @return string
     */
    public function appName()
    {
        return $this->appName;
    }

    /**
     * @return string
     */
    public function appVersion()
    {
        return $this->appVersion;
    }

    /**
     * @return string
     */
    public function frameworkName()
    {
        return $this->frameworkName;
    }

    /**
     * @return string
     */
    public function frameworkVersion()
    {
        return $this->frameworkVersion;
    }

    /**
     * @return string
     */
    public function environment()
    {
        return $this->environment;
    }

    /**
     * @return int
     */
    public function stacktraceLimit()
    {
        return $this->stacktraceLimit;
    }

    /**
     * @return bool
     */
    public function metricSet()
    {
        return $this->metricSet;
    }
}
