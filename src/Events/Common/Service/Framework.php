<?php

namespace ZoiloMora\ElasticAPM\Events\Common\Service;

use ZoiloMora\ElasticAPM\Configuration\CoreConfiguration;
use ZoiloMora\ElasticAPM\Helper\Encoding;

final class Framework implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $name;

    /**
     * @var string|null
     */
    private $version;

    /**
     * @param string|null $name
     * @param string|null $version
     */
    public function __construct($name = null, $version = null)
    {
        $this->name = $name;
        $this->version = $version;
    }

    /**
     * @param CoreConfiguration $coreConfiguration
     *
     * @return Framework
     */
    public static function create(CoreConfiguration $coreConfiguration)
    {
        return new self(
            $coreConfiguration->frameworkName(),
            $coreConfiguration->frameworkVersion()
        );
    }

    /**
     * @return string|null
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function version()
    {
        return $this->version;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'name' => Encoding::keywordField($this->name),
            'version' => Encoding::keywordField($this->version),
        ];
    }
}
