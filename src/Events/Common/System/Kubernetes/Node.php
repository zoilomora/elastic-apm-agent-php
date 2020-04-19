<?php

namespace ZoiloMora\ElasticAPM\Events\Common\System\Kubernetes;

use ZoiloMora\ElasticAPM\Helper\Encoding;

final class Node implements \JsonSerializable
{
    /**
     * Kubernetes node name
     *
     * @var string|null
     */
    private $name;

    /**
     * @param string|null $name
     */
    public function __construct($name = null)
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @return Node
     */
    public static function discover()
    {
        return new self(
            getenv('KUBERNETES_NODE_NAME') ?: null
        );
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'name' => Encoding::keywordField($this->name),
        ];
    }
}
