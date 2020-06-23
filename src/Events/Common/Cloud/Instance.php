<?php

namespace ZoiloMora\ElasticAPM\Events\Common\Cloud;

use ZoiloMora\ElasticAPM\Helper\Encoding;

final class Instance implements \JsonSerializable
{
    /**
     * Cloud instance/machine ID
     *
     * @var string
     */
    private $id;

    /**
     * Cloud instance/machine name
     *
     * @var string
     */
    private $name;

    /**
     * @param string $id
     * @param string $name
     */
    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'id' => Encoding::keywordField($this->id),
            'name' => Encoding::keywordField($this->name),
        ];
    }
}
