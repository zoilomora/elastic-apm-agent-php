<?php

namespace ZoiloMora\ElasticAPM\Events\Common\Service;

use ZoiloMora\ElasticAPM\Helper\Encoding;

final class Node implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $configuredName;

    /**
     * @param string|null $configuredName
     */
    public function __construct($configuredName = null)
    {
        $this->configuredName = $configuredName;
    }

    /**
     * @return string|null
     */
    public function configuredName()
    {
        return $this->configuredName;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'configured_name' => Encoding::keywordField($this->configuredName),
        ];
    }
}
