<?php

namespace ZoiloMora\ElasticAPM\Events\Common\Cloud;

use ZoiloMora\ElasticAPM\Helper\Encoding;

final class Machine implements \JsonSerializable
{
    /**
     * Cloud instance/machine type
     *
     * @var string
     */
    private $type;

    /**
     * @param string $type
     */
    public function __construct($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function type()
    {
        return $this->type;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'type' => Encoding::keywordField($this->type),
        ];
    }
}
