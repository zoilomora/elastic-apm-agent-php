<?php

namespace ZoiloMora\ElasticAPM\Events\Common\System;

use ZoiloMora\ElasticAPM\Events\Common\System\Kubernetes\Node;
use ZoiloMora\ElasticAPM\Events\Common\System\Kubernetes\Pod;
use ZoiloMora\ElasticAPM\Helper\Encoding;

/**
 * https://www.elastic.co/guide/en/apm/server/master/metadata-api.html#kubernetes-data
 */
final class Kubernetes implements \JsonSerializable
{
    /**
     * Kubernetes namespace
     *
     * @var string|null
     */
    private $namespace;

    /**
     * @var Pod|null
     */
    private $pod;

    /**
     * @var Node|null
     */
    private $node;

    /**
     * @param string|null $namespace
     * @param Pod|null $pod
     * @param Node|null $node
     */
    public function __construct($namespace = null, Pod $pod = null, Node $node = null)
    {
        $this->namespace = $namespace;
        $this->pod = $pod;
        $this->node = $node;
    }

    /**
     * @return Pod|null
     */
    public function pod()
    {
        return $this->pod;
    }

    /**
     * @return Node|null
     */
    public function node()
    {
        return $this->node;
    }

    /**
     * @return Kubernetes
     */
    public static function discover()
    {
        return new self(
            getenv('KUBERNETES_NAMESPACE') ?: null,
            Pod::discover(),
            Node::discover()
        );
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'namespace' => Encoding::keywordField($this->namespace),
            'pod' => $this->pod,
            'node' => $this->node,
        ];
    }
}
